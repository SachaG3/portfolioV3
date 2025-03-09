<?php

namespace App\Console\Commands;

use App\Models\GithubStat;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchGitHubInfo extends Command
{
    protected $signature = 'github:fetch-info';
    protected $description = 'Calcule et met à jour les statistiques cumulatives (commits et repos) jusqu\'à aujourd\'hui en se basant sur la méthode cumulée (incluant les anciens commits).';

    public function handle()
    {
        $username = "SachaG3";
        // Définir les auteurs autorisés (votre compte actuel et l'ancien)
        $allowedAuthors = ['SachaG3', 'reglate'];

        $client = new Client();
        $headers = [
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
            'Accept' => 'application/json',
            'User-Agent' => 'Portfolio',
        ];

        // 1. Récupération de tous les dépôts de l'utilisateur (une seule fois)
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

        // 2. Récupérer TOUS les commits pour chaque dépôt (une seule fois) pour les auteurs autorisés
        // Stocker la date de chaque commit (en objet Carbon)
        $allCommitsByRepo = []; // clé = id du dépôt, valeur = tableau de dates (Carbon)
        foreach ($repos as $repo) {
            $repoId = $repo['id'];
            $allCommitsByRepo[$repoId] = [];
            $pageCommits = 1;
            try {
                do {
                    $commitsResponse = $client->request('GET', "https://api.github.com/repos/{$repo['owner']['login']}/{$repo['name']}/commits", [
                        'headers' => $headers,
                        'query' => [
                            'per_page' => 100,
                            'page' => $pageCommits,
                        ],
                    ]);
                    $commits = json_decode($commitsResponse->getBody()->getContents(), true);
                    if (!is_array($commits)) {
                        break;
                    }
                    foreach ($commits as $commit) {
                        // Déterminer l'auteur via 'author' ou via 'commit.author.name' si absent
                        $commitAuthor = null;
                        if (isset($commit['author']) && $commit['author']) {
                            $commitAuthor = $commit['author']['login'];
                        } elseif (isset($commit['commit']['author']['name'])) {
                            $commitAuthor = $commit['commit']['author']['name'];
                        }
                        // Ne conserver que les commits des auteurs autorisés
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

        // 3. Calcul des statistiques cumulatives pour aujourd'hui
        $today = Carbon::today();
        $dayEnd = $today->copy()->endOfDay();

        $cumulativeCommits = 0;
        $cumulativeRepos = 0;
        foreach ($allCommitsByRepo as $repoId => $commitDates) {
            $repoCommitCount = 0;
            foreach ($commitDates as $commitDate) {
                if ($commitDate->lte($dayEnd)) {
                    $repoCommitCount++;
                }
            }
            if ($repoCommitCount > 0) {
                $cumulativeRepos++;
                $cumulativeCommits += $repoCommitCount;
            }
        }

        // 4. Mise à jour (ou création) de la statistique pour aujourd'hui
        $existingStat = GithubStat::where('username', $username)
            ->whereDate('created_at', $today->toDateString())
            ->first();

        if ($existingStat) {
            $existingStat->update([
                'num_of_repos' => $cumulativeRepos,
                'total_commits' => $cumulativeCommits,
            ]);
        } else {
            $stat = GithubStat::create([
                'username' => $username,
                'num_of_repos' => $cumulativeRepos,
                'total_commits' => $cumulativeCommits,
                'created_at' => $today->toDateTimeString(),
            ]);
        }

        $this->info("Statistiques cumulatives jusqu'à aujourd'hui : Repos = {$cumulativeRepos}, Commits = {$cumulativeCommits}");
    }
}
