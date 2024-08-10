<?php

namespace App\Http\Controllers;

use App\Models\AvailableTechnology;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('bentoCreator.index', compact('projects'));
    }

    public function store(Request $request)
    {
        Log::info('Request received:', $request->all());

        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lien' => 'nullable|string',
            'cards.*.type' => 'required|string',
            'cards.*.image' => 'nullable|image|mimes:jpeg,png,webp,jpg,gif,svg|max:200048',
            'cards.*.contenu' => 'nullable|string',
            'technologies.*.nom' => 'nullable|array',
            'new_technology_nom' => 'nullable|array',
            'new_technology_icone' => 'nullable|array',
            'participants.*.nom' => 'required|string',
            'participants.*.avatar' => 'nullable|string',
            'colors.*.code' => 'required|string',
            'colors.*.description' => 'nullable|string',
            'project_images.*.file' => 'required|image|mimes:jpeg,png,webp,jpg,gif,svg|max:200048',
            'galleries.*.titre' => 'required|string',
            'gallery_images.*.url' => 'required|string',
        ]);

        $project = Project::create([
            'titre' => $validatedData['titre'],
            'description' => $validatedData['description'],
            'lien' => $validatedData['lien']
        ]);

        if ($request->has('card')) {
            $cardData = $request->input('card');
            $cardData['project_id'] = $project->id;

            $file = $request->file('card.image');
            $filename = $file->getClientOriginalName();
            $directory = 'cards/' . $project->id;

            // Ensure the directory exists
            Storage::disk('public')->makeDirectory($directory);

            // Move the file to the public directory
            $path = $file->move(public_path($directory), $filename);

            // Save the file URL in the database
            $cardData['image'] = '/' . $directory . '/' . $filename;

            Log::info('File stored successfully:', ['path' => $path]);


            $project->cards()->create($cardData);
        }

        // Adding new technologies
        if (!empty($request->new_technology_nom)) {
            foreach ($request->new_technology_nom as $index => $newTechName) {
                if ($newTechName) {
                    $newTechIcon = $request->new_technology_icone[$index] ?? null;
                    $technology = AvailableTechnology::firstOrCreate(
                        ['nom' => $newTechName],
                        ['icone' => $newTechIcon]
                    );
                    $project->technologies()->create([
                        'nom' => $technology->nom,
                        'icone' => $technology->icone,
                    ]);
                }
            }
        }

        if (!empty($request->technologies)) {
            foreach ($request->technologies as $technologyData) {
                if (!empty($technologyData['nom']) && is_array($technologyData['nom'])) {
                    foreach ($technologyData['nom'] as $existingTechName) {
                        $existingTechnology = AvailableTechnology::where('nom', $existingTechName)->first();
                        if ($existingTechnology) {
                            $project->technologies()->create([
                                'nom' => $existingTechnology->nom,
                                'icone' => $existingTechnology->icone,
                                'project_id' => $project->id,
                            ]);
                        }
                    }
                }
            }
        }


        if (!empty($request->participants)) {
            foreach ($request->participants as $participantData) {
                $project->participants()->create($participantData);
            }
        }

        if (!empty($request->colors)) {
            foreach ($request->colors as $colorData) {
                $project->colors()->create($colorData);
            }
        }
        foreach ($request->file('project_images') as $fileArray) {
            foreach ($fileArray as $file) {
                Log::info('File upload attempt:', ['file' => $file]);
                if ($file->isValid()) {
                    $filename = $file->getClientOriginalName();
                    $directory = 'project_images/' . $project->id;

                    // Ensure the directory exists
                    Storage::disk('public')->makeDirectory($directory);

                    // Move the file to the public directory
                    $path = $file->move(public_path($directory), $filename);

                    // Save the file URL in the database
                    $project->images()->create(['url' => '/' . $directory . '/' . $filename]);

                    Log::info('File stored successfully:', ['path' => $path]);
                } else {
                    Log::error('File upload error', ['error' => $file->getError()]);
                    return redirect()->back()->withErrors(['file' => 'The uploaded file is not valid.']);
                }
            }
        }

        if (!empty($request->galleries)) {
            foreach ($request->galleries as $galleryData) {
                $gallery = $project->galleries()->create(['titre' => $galleryData['titre']]);
                if (!empty($galleryData['images'])) {
                    foreach ($galleryData['images'] as $imageData) {
                        $gallery->images()->create(['url' => $imageData['url']]);
                    }
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }


    public function create()
    {
        return view('bentoCreator.index');
    }

    public function view()
    {
        $projects = Project::with(['cards', 'technologies'])->get();
        return view('projects.index', compact('projects'));
    }

    public function getProjectData($id)
    {
        $project = Project::with(['cards', 'technologies', 'participants', 'colors', 'images', 'galleries.images'])->findOrFail($id);

        return response()->json([
            'title' => $project->titre,
            'lien' => $project->lien,
            'description' => $project->description,
            'website' => $project->website, // Assuming there is a website field in the projects table
            'technologies' => $project->technologies->map(function ($tech) {
                return [
                    'name' => $tech->nom,
                    'icon' => $tech->icone
                ];
            }),
            'image' => $project->images->first()->url ?? '',
            'participants' => $project->participants->map(function ($participant) {
                return [
                    'name' => $participant->nom,
                    'avatar' => $participant->avatar
                ];
            }),
            'font' => 'Roboto', // Assuming font is Roboto
            'colors' => $project->colors->map(function ($color) {
                return [
                    'hex' => $color->code
                ];
            }),
            'gallery' => $project->galleries->map(function ($gallery) {
                return [
                    'title' => $gallery->titre,
                    'images' => $gallery->images->map(function ($image) {
                        return [
                            'url' => $image->url
                        ];
                    })
                ];
            })
        ]);
    }
}
