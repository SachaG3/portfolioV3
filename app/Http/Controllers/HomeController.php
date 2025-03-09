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
}
