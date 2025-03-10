<?php

namespace App\Http\Controllers;

use App\Models\GithubStat;
use App\Models\Project;
use App\Models\Skill;

class HomeController extends Controller
{
    public function index()
    {

        $latestStats = GithubStat::orderBy('created_at', 'desc')->first();
        $projects = Project::with(['cards', 'technologies'])->get();
        $skills = Skill::with('icons')->get();
        return view('index', compact('skills', 'projects', 'latestStats'));
    }

    public function getStats()
    {
        $stats = GithubStat::where('username', 'SachaG3')
            ->orderBy('created_at', 'asc')
            ->get();

        $labels = $stats->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        })->toArray();

        $commits = $stats->pluck('total_commits')->toArray();
        $repos = $stats->pluck('num_of_repos')->toArray();


        return response()->json([
            'labels' => $labels,
            'commits' => $commits,
            'repos' => $repos,
        ]);
    }

    public function github()
    {
        $stats = GithubStat::where('username', 'SachaG3')
            ->orderBy('created_at', 'asc')
            ->get();

        $labels = $stats->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        })->toArray();

        $commits = $stats->pluck('total_commits')->toArray();
        $repos = $stats->pluck('num_of_repos')->toArray();


        function movingAverage(array $data, int $windowSize): array
        {
            $result = [];
            $n = count($data);
            for ($i = 0; $i < $n; $i++) {
                $start = max(0, $i - floor($windowSize / 2));
                $end = min($n, $i + floor($windowSize / 2) + 1);
                $sum = 0;
                for ($j = $start; $j < $end; $j++) {
                    $sum += $data[$j];
                }
                $avg = ceil($sum / ($end - $start));
                $result[] = $avg;
            }
            return $result;
        }

        function downsampleArray(array $data, int $maxPoints): array
        {
            $n = count($data);
            if ($n <= $maxPoints) {
                return $data;
            }
            $sampled = [];
            $step = $n / $maxPoints;
            for ($i = 0; $i < $maxPoints; $i++) {
                $sampled[] = $data[floor($i * $step)];
            }
            return $sampled;
        }

        function downsampleLabels(array $labels, int $maxPoints): array
        {
            return downsampleArray($labels, $maxPoints);
        }

        $windowSize = 3;
        $maxPoints = 10;

        $smoothCommits = movingAverage($commits, $windowSize);
        $smoothRepos = movingAverage($repos, $windowSize);

        $sampledLabels = downsampleLabels($labels, $maxPoints);
        $sampledCommits = downsampleArray($smoothCommits, $maxPoints);
        $sampledRepos = downsampleArray($smoothRepos, $maxPoints);

        $todayLabel = date('Y-m-d');
        $desiredLastDate = $todayLabel;
        if (!in_array($todayLabel, $labels)) {
            $desiredLastDate = date('Y-m-d', strtotime('yesterday'));
        }
        $idx = array_search($desiredLastDate, $labels);
        if ($idx !== false) {
            $lastIndex = count($sampledLabels) - 1;
            $sampledLabels[$lastIndex] = $labels[$idx];
            $sampledCommits[$lastIndex] = $commits[$idx];
            $sampledRepos[$lastIndex] = $repos[$idx];
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $sampledLabels,
                'datasets' => [
                    [
                        'label' => 'Nombre Commits',
                        'data' => $sampledCommits,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1,
                        'fill' => true,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Nombre de Repository',
                        'data' => $sampledRepos,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 1,
                        'fill' => true,
                        'tension' => 0.4
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'scales' => [
                    'x' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Date'
                        ]
                    ],
                    'y' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Nombre'
                        ],
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        $chartConfigJson = json_encode($chartConfig);
        $url = "https://quickchart.io/chart?format=png&c=" . urlencode($chartConfigJson);

        return view('sections.statGitforGit', compact('url'));
    }


}
