<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GitHubInfoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SkillController::class, 'showSkills']);
Route::get('/api/github-info', [GitHubInfoController::class, 'fetchGitHubInfo']);

Route::get('/api/modal-data', [App\Http\Controllers\ModalController::class, 'getModalData']);
Route::resource('projects', ProjectController::class);
Route::get('/api/project/{id}', [ProjectController::class, 'getProjectData']);


Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');


Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
Route::post('/skills/{skill}/update', [SkillController::class, 'update'])->name('skills.update');
Route::put('/icons/{icon}', [SkillController::class, 'updateIcon'])->name('icons.update');


Route::post('/contact', [ContactController::class, 'store'])->name('mail');


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['single.user.auth'])->group(function () {
    Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
    Route::get('/bentoCreator', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/createBento', [ProjectController::class, 'store'])->name('projects.store');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
