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
}
