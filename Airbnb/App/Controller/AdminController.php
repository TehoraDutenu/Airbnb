<?php

namespace App\Controller;

use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use App\Controller\AuthController;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

class AdminController extends Controller
{
    public function index(): void
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        // - Récupérer la liste des utilisateurs
        $view_data = [
            'title_tag' => 'Dashboard',
            'h1_tag' => 'Liste des utilisateurs',
            'users' => AppRepoManager::getRm()->getuserRepo()->findAll()
        ];

        $view = new View('users/list');
        $view->render($view_data);
    }

    public function update(int $id): void
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'user' => AppRepoManager::getRm()->getUserRepo()->findById($id)
        ];

        $view = new View('users/update');
        $view->render($view_data);
    }

    public function updateUser(ServerRequest $request): void
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        Session::remove(Session::FORM_RESULT, $form_result);

        // - Redéfinir les variables sécurisées
        $email = htmlspecialchars(trim(strtolower($post_data['email'])));
        $role = intval($post_data['role']);
        $id = intval($post_data['id']);

        // - Ajouter une erreur en cas de champ non rempli
        if (empty($post_data['email']) || empty($post_data['role'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/update/' . $id);
        } else {
            // - Appeler le repository pour la mise à jour
            $user = AppRepoManager::getRm()->getUserRepo()->updateUserById($email, $role, $id);

            // - Vérifier s'il y a des erreurs, auquel cas on renverra vers la page de formulaire
            if ($user) {
                $form_result->addError(new FormError('Erreur lors de la mise à jour'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/admin/update/' . $id);
            }

            // - Rediriger vers la page admin.
            Session::remove(Session::FORM_RESULT, $form_result);
            self::redirect('/admin');
        }
    }

    public function deleteUser(int $id): void
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $form_result = new FormResult();

        // - Appeler le repository pour supprimer l'utilisateur
        $user = AppRepoManager::getRm()->getUserRepo()->deleteUser($id);

        // - Retourner un message en cas d'erreurs
        if (!$user) {
            $form_result->addError(new FormError('Erreur lors de la suppression'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin');
        } else {
            // - Sinon vers la page admin
            Session::remove(Session::FORM_RESULT, $form_result);
            self::redirect('/admin');
        }
    }

    public function addUser(): void
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'title_tag' => 'Ajouter un utilisateur',
            'h1_tag' => 'Ajouter un utilisateur'
        ];

        $view = new View('users/add');
        $view->render($view_data);
    }

    public function add(ServerRequest $request)
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        if (empty($post_data['email']) || empty($post_data['password']) || empty($post_data['role'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/addUser');
        } else {
            // - Récupérer les données du formulaire
            $email = htmlspecialchars(trim(strtolower($post_data['email'])));
            $password = htmlspecialchars(trim($post_data['password']));
            $pass_hash = AuthController::hash($password);
            $role = intval($post_data['role']);

            // - Créer un nouvel utilisateur
            $user = AppRepoManager::getRm()->getUserRepo()->createUser($email, $pass_hash, $role);
        }

        // - Message d'erreur si l'utilisateur n'est pas créé
        if (!$user) {
            $form_result->addError(new FormError("Cet utilisateur existe déjà"));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/addUser');
        } else {
            //sinon on redirige vers la page admin
            Session::remove(Session::FORM_RESULT);
            self::redirect('/admin');
        }
    }

    public function addToy()
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        // - Construire le tableau de données
        $view_data = [
            'title_tag' => 'Ajouter un jouet',
            'h1_tag' => 'Ajouter un jouet',
            'form_result' => Session::get(Session::FORM_RESULT),
            'marques' => AppRepoManager::getRm()->getBrandRepo()->findAll()
        ];

        // - Instancier
        $view = new View('toy/add');
        $view->render($view_data);
    }

    public function createToy(ServerRequest $request)
    {
        // - Vérifier le rôle
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $image_data = $_FILES['image'];
        $form_result = new FormResult();

        // - Restreindre les types de fichiers que l'on souhaite reçevoir
        if (
            $image_data['type'] !== 'image/jpeg' &&
            $image_data['type'] !== 'image/jpg' &&
            $image_data['type'] !== 'image/png' &&
            $image_data['type'] !== 'image/webp'
        ) {
            $form_result->addError(new FormError("Le format d'image n'est pas valide"));
        } else if (
            // - Vérifier que les autres champs sont remplis
            empty($post_data['name']) ||
            empty($post_data['description']) ||
            empty($post_data['price']) ||
            empty($post_data['brand_id'])
        ) {
            $form_result->addError((new FormError("Veuillez remplir tous les champs")));
        } else {
            // - Faire le traitement
            // - Redéclarer variables sécurisées
            $title = htmlspecialchars(trim($post_data['name']));
            $description = htmlspecialchars(trim($post_data['description']));
            $price = floatval($post_data['price']);
            $brand_id = intval($post_data['brand_id']);

            // - Traiter l'image
            // - Chemin de la source (sur le serveur)
            $imgTmpPath = $image_data['tmp_name'];
            // - Redéfinir un nom unique pour l'image
            $filename = uniqid() . '_' . $image_data['name'];
            $slug = explode('.', strtolower(str_replace(' ', '-', $filename)))[0];

            // - Chemin de destination
            $imgPathPublic = PATH_ROOT . '/public/img/' . $filename;

            // - Reconstruire un tableau de données
            $data = [
                'name' => $title,
                'description' => $description,
                'brand_id' => $brand_id,
                'price' => $price,
                'image' => $filename,
                'slug' => $slug
            ];

            // - Déplacer le fichier tmp dans son dossier de destination
            if (move_uploaded_file($imgTmpPath, $imgPathPublic)) {
                // - Appeler du repository pour insérer dans la bdd
                AppRepoManager::getRm()->getToyRepo()->insert($data);
            } else {
                $form_result->addError(new FormError("Erreur lors de l'upload de l'image"));
            }
        }
        // - S'il y a des erreurs
        if ($form_result->hasError()) {
            // - Stocker les erreurs dans la session
            Session::set(Session::FORM_RESULT, $form_result);
            // - Rediriger vers la page d'ajout de jouet
        }
        // - Sinon rediriger vers la paage admin
        Session::remove(Session::FORM_RESULT);
        self::redirect('/');
    }

    // - Modifier un jouet
    public function editToy(int $id)
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'title_tag' => 'Modifier le jouet',
            'h1_tag' => 'Modifier le jouet',
            'form_result' => Session::get(Session::FORM_RESULT),
            'toy' => AppRepoManager::getRm()->getToyRepo()->findById($id),
            'marques' => AppRepoManager::getRm()->getBrandRepo()->findAll()
        ];

        $view = new View('toy/update');
        $view->render($view_data);
    }

    public function updateToy(ServerRequest $request)
    {

        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        // - Déclarer les variables de $post_data
        $id = intval($post_data['id']);
        $title = htmlspecialchars(trim($post_data['name']));
        $description = trim($post_data['description']);
        $price = floatval($post_data['price']);
        $brand_id = intval($post_data['brand_id']);

        // - Savoir si on a uploadé une image
        if (empty($_FILES['image']['tmp_name'])) {

            // - Reconstruire un tableau de données sans les infos de l'image
            $data = [
                'name' => $title,
                'description' => $description,
                'price' => $price,
                'brand_id' => $brand_id,
                'id' => $id
            ];
            // - Appeller le repository
            AppRepoManager::getRm()->getToyRepo()->update($data);
        } else {
            // - Reconstuire le tableau avec les données de l'image
            $image_data = $_FILES['image'];
            // - Récupérer le dossier source
            $imgTmpPath = $image_data['tmp_name'];
            // - Reconstruire le nom du fichier unique
            $filename = uniqid() . '_' . $image_data['name'];
            // - Récupérer le slug
            $slug = explode('.', strtolower(str_replace(' ', '-', $filename)))[0];
            // - Reconstruire le chemin de destination
            $imgPathPublic = PATH_ROOT . '/public/img/' . $filename;

            // - Reconstruire le tableau avec les infos de l'image
            $data = [
                'name' => $title,
                'description' => $description,
                'price' => $price,
                'brand_id' => $brand_id,
                'image' => $filename,
                'slug' => $slug,
                'id' => $id
            ];
            // - Appeler le repository pour mettre à jour le jouet après avoir vérifier que l'on a move le fichier
            if (move_uploaded_file($imgTmpPath, $imgPathPublic)) {
                // - Appeler le repository
                AppRepoManager::getRm()->getToyRepo()->update($data);
            } else {
                // - Afficher un message d'erreur
            }
        }

        // - Si on a des erreurs
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/editToy/' . $id);
        }
        // - Rediriger vers la page admin
        Session::remove(Session::FORM_RESULT);
        self::redirect('/');
    }

    public function deleteToy(int $id)
    {
        // - Vérifier le statut (Admin/Subscriber)
        if (!AuthController::isAdmin()) self::redirect('/');

        $form_result = new FormResult();

        // - Appeler le repository pour supprimer le jouet
        $toy = AppRepoManager::getRm()->getToyRepo()->deleteToy($id);

        // - Retourner un message en cas d'erreurs
        if (!$toy) {
            $form_result->addError(new FormError('Erreur lors de la suppression'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/');
        } else {
            // - Sinon vers la page admin
            Session::remove(Session::FORM_RESULT, $form_result);
            self::redirect('/');
        }
    }
}
