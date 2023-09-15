<?php

namespace App\Controller;

use App\Model\Bien;
use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

class BienController extends Controller
{
    public function index()
    {
        $view_data = [
            'title_tag' => 'Liste des biens',
            'h1_tag' => 'Nos biens',
            'biens' => AppRepoManager::getRm()->getBienRepo()->findAll() ?? []
        ];

        $view = new View('/');
        $view->render($view_data);
    }

    public function bienById(int $id)
    {
        $bien_result = AppRepoManager::getRm()->getBienRepo()->findById();
        if (is_null($bien_result)) {
            $this->redirect('/');
        }

        $view_data = [
            'title_tag' => $bien_result->label,
            'bien' => $bien_result
        ];

        $view = new View('biens/details');
        $view->render($view_data);
    }


    public function proposer()
    {
        $typebienRepository = AppRepoManager::getRm()->getTypebienRepo();
        $typesDeBien = $typebienRepository->getTypeByLabel();

        $equipementRepo = AppRepoManager::getRm()->getEquipementRepo();
        $equipements = $equipementRepo->findAll();


        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'bien' => null,
            'typebien' => $typesDeBien,
            'equipements' => $equipements
        ];
        // - Créer une instance de View pour afficher la vue de proposer
        $view = new View('biens/proposer', false);
        $view->render($view_data);
    }


    private static function areAnimals(int $are_animals): bool
    {
        //on récupère les infos de l'utilisateur en session
        $bien = Session::get(Session::USER);
        if (!($bien instanceof Bien)) {
            return false;
        }
        return $bien->are_animals === $are_animals;
    }

    public static function animalYes(): bool
    {
        return self::areanimals(Bien::ANIMALS_YES);
    }

    public static function animalNO(): bool
    {
        return self::areanimals(Bien::ANIMALS_NO);
    }

    public function createBien(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        // - Vérifier que les champs sont remplis
        if (empty($post_data['utilisateur_id']) || empty($post_data['label']) || empty($post_data['description']) || empty($post_data['adresse']) || empty($post_data['typebien_id']) || empty($post_data['taille']) || empty($post_data['nbre_pieces']) || empty($post_data['nbre_couchages']) || empty($post_data['are_animals']) || empty($post_data['prix_nuitee'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/proposer');
        }

        // - Restreindre les fichiers photo que l'on veut recevoir
        if (isset($_FILES['photo'])) {
            $uploadsDirectory = 'img/photos_bien';

            foreach ($_FILES['photo']['tmp_name'] as $key => $tmp_name) {
                $image_type = $_FILES['photo']['type'][$key];

                if (
                    $image_type !== 'image/jpeg' &&
                    $image_type !== 'image/png' &&
                    $image_type !== 'image/jpg' &&
                    $image_type !== 'image/webp'
                ) {
                    $form_result->addError(new FormError('Le format de l\'image n\'est pas valide'));
                    continue;
                }

                // - Renommer le fichier avec un nom unique
                $filename = uniqid() . '_' . $_FILES['photo']['name'][$key];

                // - Le chemin de destination
                $uploadFile = $uploadsDirectory . '/' . $filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'][$key], $uploadFile)) {
                    // Gérez les images téléchargées ici, par exemple, ajoutez-les à la base de données
                    $photo = AppRepoManager::getRm()->getPhotoRepo()->insertPhoto();
                } else {
                    // - Gérer des erreurs de téléchargement
                    $form_result->addError(new FormError('Erreur lors du téléchargement de l\'image.'));
                }
            }
        }

        // Si aucune erreur n'est survenue jusqu'à présent, créez un nouveau bien
        if (!$form_result->hasError()) {
            $utilisateur_id = intval($post_data['utilisateur_id']);
            $label = htmlspecialchars(trim(strtolower($post_data['label'])));
            $description = htmlspecialchars(trim(strtolower($post_data['description'])));
            $adresse = htmlspecialchars(trim(strtolower($post_data['adresse'])));
            $typebien_id = intval($post_data['typebien_id']);
            $taille = intval($post_data['taille']);
            $nbre_pieces = intval($post_data['nbre_pieces']);
            $nbre_couchages = intval($post_data['nbre_couchages']);
            $are_animals = boolval($post_data['are_animals']);
            $prix_nuitee = intval($post_data['prix_nuitee']);

            // Créez un nouveau bien
            $bien = AppRepoManager::getRm()->getBienRepo()->insertBien($utilisateur_id, $label, $description, $adresse, $typebien_id, $taille, $nbre_pieces, $nbre_couchages, $are_animals, $prix_nuitee);

            if ($bien) {
                // - Rediriger vers l'accueil si tout s'est bien passé
                Session::remove(Session::FORM_RESULT);
                self::redirect('/');
            } else {
                // - En cas d'échec de la création du bien
                $form_result->addError(new FormError('Un problème est survenu lors de la création du bien.'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/proposer');
            }
        }
    }

    public function seeDetails()
    {


        $view_data = [
            'title_tag' => 'Détails',
            'h1_tag' => 'Détails du bien',
            'biens' => AppRepoManager::getRm()->getBienRepo()->findAll() ?? []
        ];

        // - Créer une instance de View pour afficher la vue de proposer
        $view = new View('biens/details', false);
        $view->render($view_data);
    }
}
