<?php

namespace App\Http\Controllers;

class ModalController extends Controller
{
    public function getModalData()
    {
        // Remplacez ceci par votre logique pour récupérer les données depuis la base de données
        $data = [
            'title' => 'Gîte de la chouette',
            'description' => 'Ce projet est une application web conçue pour mettre en avant les techniques modernes de développement web.',
            'website' => 'https://www.gitemaisons.fr/',
            'technologies' => [
                ['name' => 'WordPress', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/wordpress/wordpress-plain.svg'],
                ['name' => 'Divi', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
                ['name' => 'cPanel', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
                ['name' => 'HTML', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
                ['name' => 'CSS', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg'],
            ],
            'image' => '/img/test.png',
            'participants' => [
                ['name' => 'SachaG3', 'avatar' => 'https://avatars.githubusercontent.com/u/113612623?v=4'],
                ['name' => 'Participant 2', 'avatar' => 'https://via.placeholder.com/50'],
                ['name' => 'Participant 3', 'avatar' => 'https://via.placeholder.com/50'],
            ],
            'font' => 'Roboto',
            'colors' => [
                ['hex' => '#FE9808'],
                ['hex' => '#6DB1B9'],
                ['hex' => '#262626'],
            ],
        ];

        return response()->json($data);
    }
}

