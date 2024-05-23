<?php

use App\Http\Controllers\GitHubInfoController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SkillController::class, 'showSkills']);
Route::get('/api/github-info', [GitHubInfoController::class, 'fetchGitHubInfo']);
//Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
//Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');


//Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
//Route::post('/skills/{skill}/update', [SkillController::class, 'update'])->name('skills.update');
//Route::put('/icons/{icon}', [SkillController::class, 'updateIcon'])->name('icons.update');
//Route::post('/contact', [ContactController::class, 'store'])->name('mail');
