<?php

namespace App\Console\Commands;

use App\Models\GithubStat;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchGitHubInfo extends Command
{
    protected $signature = 'github:fetch-info';
    protected $description = 'Récupère les dépôts et commits GitHub et les enregistre en base de données';

    public function handle()
    {
        $username = "SachaG3";
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

        $reposWithCommits = 0;
        $totalCommits = 0;

        foreach ($repos as $repo) {
            $pageCommits = 1;
            $repoCommitsCount = 0;
            try {
                do {
                    $commitsResponse = $client->request('GET', "https://api.github.com/repos/{$repo['owner']['login']}/{$repo['name']}/commits", [
                        'headers' => $headers,
                        'query' => [
                            'author' => $username,
                            'per_page' => 100,
                            'page' => $pageCommits,
                        ],
                    ]);
                    $commits = json_decode($commitsResponse->getBody()->getContents(), true);
                    $repoCommitsCount += count($commits);
                    $pageCommits++;
                } while (count($commits) > 0);
            } catch (Exception $e) {
                $this->error("Erreur pour le dépôt {$repo['name']} : " . $e->getMessage());
                continue;
            }

            if ($repoCommitsCount > 0) {
                $reposWithCommits++;
                $totalCommits += $repoCommitsCount;
            }
        }

        GithubStat::create([
            'username' => $username,
            'num_of_repos' => $reposWithCommits,
            'total_commits' => $totalCommits,
        ]);

        $this->info('Les informations GitHub ont été récupérées et enregistrées avec succès.');
    }
}
