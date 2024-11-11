<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\GithubStat;

class FetchGitHubInfo extends Command
{
    protected $signature = 'github:fetch-info';
    protected $description = 'Fetch GitHub repository and commit data and save it to the database';

    public function handle()
    {
        $username = "SachaG3";
        $client = new Client();
        $headers = [
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
            'Accept' => 'application/json',
        ];

        // Fetch user repositories
        $reposResponse = $client->request('GET', "https://api.github.com/user/repos", [
            'headers' => $headers,
        ]);


        $repos = json_decode($reposResponse->getBody()->getContents(), true);
        $numOfRepos = count($repos);

        $totalCommits = 0;
        foreach ($repos as $repo) {
            $commitsResponse = $client->request('GET', "https://api.github.com/repos/{$repo['owner']['login']}/{$repo['name']}/commits?author={$username}", [
                'headers' => $headers,
            ]);
            $commits = json_decode($commitsResponse->getBody()->getContents(), true);
            $totalCommits += count($commits);
        }

        // Enregistrer les données dans la base de données
        GithubStat::create([
            'username' => $username,
            'num_of_repos' => $numOfRepos,
            'total_commits' => $totalCommits,
        ]);

        $this->info('GitHub information fetched and saved successfully.');
    }
}
