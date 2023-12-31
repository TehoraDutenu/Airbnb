<?php

namespace App\Controller;

use Core\Repository\AppRepoManager;
use Core\View\View;

class PageController
{
    public function index()
    {
        // - Préparer les datas
        $view_data = [
            'title_tag' => 'Accueil',
            'list_title' => 'Bienvenue sur Airbnb',
            'bien_list' => [
                'Maison',
                'Appartement',
                'Chambre d\'hôte',
                'Hébergement maritime',
                'Hébergement insolite'
            ],
            'biens' => AppRepoManager::getRm()->getBienRepo()->findAll()
        ];
        $view = new View('pages/home');
        $view->title = 'Bienvenue';
        $view->render($view_data);
    }
}
