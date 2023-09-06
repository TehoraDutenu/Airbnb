<?php

namespace App\Controller;

use Core\View\View;

class PageController
{
    public function index()
    {
        // - Préparer les données à envoyer à la vue
        $view_data = [
            'title_tag' => 'Accueil',
            'list_title' => 'Bienvenue',
            'toy_list' => [
                'poupée',
                'ballon',
                'toupie',
                'pistolet'
            ]
        ];

        $view = new View('pages/home');
        $view->title = 'Accueil';

        $view->render($view_data);
    }
}
