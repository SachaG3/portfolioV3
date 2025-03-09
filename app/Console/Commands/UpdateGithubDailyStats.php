<?php

namespace App\Console\Commands;

use App\Models\GithubStat;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateGithubDailyStats extends Command
{
    protected $signature = 'github:update-daily-stats {--days=7}';
    protected $description = 'Récupère tous les commits pour chaque dépôt une seule fois et calcule en local les statistiques cumulatives (commits et repos) jusqu\'à chaque jour de la plage (--days). Seuls les commits dont l\'auteur est "SachaG3" ou "reglate" sont pris en compte.';

    public function handle()
    {
        $username = "SachaG3";
        $allowedAuthors = ['SachaG3', 'reglate'];

        $client = new Client();
        $headers = [
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
            'Accept' => 'application/json',
            'User-Agent' => 'Portfolio',
        ];

        $page = 1;
        $repos = [];
        try {
            do {
                $response = $client->request('GET', "https://api.github.com/user/repos", [
                    'headers' => $headers,
                    'query' => [
                        'per_page' => 100,
                        'page' => $page,
                    ],
                ]);
                $data = json_decode($response->getBody()->getContents(), true);
                $repos = array_merge($repos, $data);
                $page++;
            } while (count($data) > 0);
        } catch (Exception $e) {
            $this->error("Erreur lors de la récupération des dépôts : " . $e->getMessage());
            return;
        }

        $allCommitsByRepo = [];
        foreach ($repos as $repo) {
            $repoId = $repo['id'];
            $allCommitsByRepo[$repoId] = [];
            $pageCommits = 1;
            try {
                do {
                    $commitsResponse = $client->request(
                        'GET',
                        "https://api.github.com/repos/{$repo['owner']['login']}/{$repo['name']}/commits",
                        [
                            'headers' => $headers,
                            'query' => [
                                'per_page' => 100,
                                'page' => $pageCommits,
                            ],
                        ]
                    );
                    $commits = json_decode($commitsResponse->getBody()->getContents(), true);
                    if (!is_array($commits)) {
                        break;
                    }
                    foreach ($commits as $commit) {
                        // Déterminer l'auteur via 'author' ou, en l'absence, via 'commit.author'
                        $commitAuthor = null;
                        if (isset($commit['author']) && $commit['author']) {
                            $commitAuthor = $commit['author']['login'];
                        } elseif (isset($commit['commit']['author']['name'])) {
                            $commitAuthor = $commit['commit']['author']['name'];
                        }
                        // On ne conserve le commit que si l'auteur est dans la liste autorisée
                        if (in_array($commitAuthor, $allowedAuthors)) {
                            if (isset($commit['commit']['committer']['date'])) {
                                $commitDate = Carbon::parse($commit['commit']['committer']['date']);
                                $allCommitsByRepo[$repoId][] = $commitDate;
                            }
                        }
                    }
                    $pageCommits++;
                } while (count($commits) > 0);
            } catch (Exception $e) {
                $this->error("Erreur pour le dépôt {$repo['name']} lors de la récupération des commits : " . $e->getMessage());
                continue;
            }
        }

        $days = (int)$this->option('days');
        $endDate = Carbon::yesterday();
        $startDate = (clone $endDate)->subDays($days - 1);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayEnd = $date->copy()->endOfDay();
            $cumulativeCommits = 0;
            $cumulativeRepos = 0;
            foreach ($allCommitsByRepo as $repoId => $commitDates) {
                $commitCount = 0;
                foreach ($commitDates as $commitDate) {
                    if ($commitDate->lte($dayEnd)) {
                        $commitCount++;
                    }
                }
                if ($commitCount > 0) {
                    $cumulativeRepos++;
                    $cumulativeCommits += $commitCount;
                }
            }

            $stat = GithubStat::where('username', $username)
                ->whereDate('created_at', $date->toDateString())
                ->first();

            if ($stat) {
                $stat->update([
                    'total_commits' => $cumulativeCommits,
                    'num_of_repos' => $cumulativeRepos,
                ]);
            } else {
                $stat = GithubStat::create([
                    'username' => $username,
                    'num_of_repos' => $cumulativeRepos,
                    'total_commits' => $cumulativeCommits,
                ]);
                $stat->created_at = $date->copy()->startOfDay();
                $stat->save();
            }

            $this->info("Statistiques cumulatives jusqu'au {$date->toDateString()} : Repos = {$cumulativeRepos}, Commits = {$cumulativeCommits}");
        }

        $this->info('Mise à jour des statistiques cumulatives terminée.');
    }
}
