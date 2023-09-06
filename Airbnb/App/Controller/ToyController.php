<?php

namespace App\Controller;

use App\Model\Toys;
use Core\View\View;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;

class ToyController extends Controller
{
    public function index()
    {
        // - Reconstruire le tableau de données
        $view_data = [
            'title_tag' => 'Liste des jouets',
            'h1_tag' => 'Nos jouets',
            'toys' => AppRepoManager::getRm()->getToyRepo()->findAll()
        ];
        $view = new View('toy/list');
        $view->render($view_data);
    }

    public function toyById(int $id)
    {
        $toy_result = AppRepoManager::getRm()->getToyRepo()->findByIdWithBrand($id);

        // - Rediriger vers la liste de jouets si le jouet n'existe pas 
        if (is_null($toy_result)) {

            // - TODO: vue spécifique qui indique que le jouet n'existe pas

            $this->redirect('/');
        }
        // - Construire le tableau de données
        $view_data = [
            'title_tag' => $toy_result->name,
            'toy' => $toy_result
        ];

        $view = new View('toy/detail');
        $view->render($view_data);
    }

    public function toysByBrand(int $id)
    {
        // - Créer le tableau de données
        $view_data = [
            'title_tag' => 'Liste des jouets par marque',
            'h1_tag' => 'Nos jouets par marque',
            'toys' => AppRepoManager::getRm()->getToyRepo()->findToysByBrand($id)
        ];

        // - Instancier la vue
        $view = new View('toy/list');

        // - Rendre la vue
        $view->render($view_data);
    }
}
