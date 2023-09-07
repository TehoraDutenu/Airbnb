<?php

namespace App\Controller;

use Core\View\View;

class PageController
{
    public function index()
    {
        // - Données
        $view_data = [
            'title_tag' => 'Airbnb',
            'list_title' => 'Bienvenue sur Airbnb',
            'bien_list' => [
                'maison',
                'chateau',
                'chambre',
                'Appartement'
            ]
        ];
        $view = new View('pages/home');
        $view->title = 'Accueil';
        $view->render($view_data);
    }
}
