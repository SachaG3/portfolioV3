<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillIcon;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function index()
    {
        $skills = Skill::with('icons')->get();
        return view('skills.index', compact('skills'));
    }

    public function update(Request $request, Skill $skill)
    {
        $skill->update(['name' => $request->name]);

        // Mise à jour des icônes. Ici, on simplifie en supposant une icône par compétence.
        if ($request->has('icon_name') && $request->has('svg')) {
            $skill->icons()->update([
                'name' => $request->icon_name,
                'svg' => $request->svg,
            ]);
        }

        return back()->with('success', 'Compétence mise à jour avec succès.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'svg_names.*' => 'required|string|max:255', // Validez les noms des SVG
            'svgs.*' => 'required|string', // Validation pour le contenu SVG
        ]);

        $skill = Skill::create(['name' => $request->name]);

        foreach ($request->svgs as $index => $svg) {
            if (!empty($svg) && !empty($request->svg_names[$index])) {
                $skill->icons()->create([
                    'name' => $request->svg_names[$index], // Sauvegarde le nom de l'icône
                    'svg' => $svg // Sauvegarde le contenu SVG
                ]);
            }
        }

        return redirect()->route('skills.create')->with('success', 'Compétence créée avec succès !');
    }

    public function create()
    {
        return view('skills.create');
    }


    public function updateIcon(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'svg' => 'required|string',
        ]);

        $icon = SkillIcon::findOrFail($id);
        $icon->name = $request->name;
        $icon->svg = $request->svg;
        $icon->save();

        return redirect()->back()->with('success', 'Icon updated successfully.');
    }
}
