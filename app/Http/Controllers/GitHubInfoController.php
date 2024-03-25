<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class GitHubInfoController extends Controller
{
    public function fetchGitHubInfo()
    {
        $username = "SachaG3";
        $client = new Client();
        $headers = [
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
            'Accept' => 'application/json',
        ];

        // Fetch user repositories
        $reposResponse = $client->request('GET', "https://api.github.com/users/{$username}/repos", [
            'headers' => $headers,
        ]);
        $repos = json_decode($reposResponse->getBody()->getContents(), true);
        $numOfRepos = count($repos);

        $totalCommits = 0;
        foreach ($repos as $repo) {
            $commitsResponse = $client->request('GET', "https://api.github.com/repos/{$username}/{$repo['name']}/commits?author=${username}", [
                'headers' => $headers,
            ]);
            $commits = json_decode($commitsResponse->getBody()->getContents(), true);
            $totalCommits += count($commits);
        }
        return response()->json([
            'username' => $username,
            'numOfRepos' => $numOfRepos,
            'totalCommits' => $totalCommits
        ]);

    }
}

