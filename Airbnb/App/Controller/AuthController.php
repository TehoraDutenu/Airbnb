<?php

namespace App\Controller;


use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use App\Model\Utilisateur;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

// - Identifiants:
// - utilisateur standard : admin@admin.php - mdp : admin
// - utilisateur hôte : doe@doe.com - mdp : doe

class AuthController extends Controller
{
    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';
    public const LOGOUT_SUCCESS_MESSAGE = 'Vous avez été déconnecté avec succès.';

    public function login()
    {
        // - Créer une instance de View pour afficher la vue de connexion
        $view = new View('auth/login', false);

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }

    // - Réceptionner les données du formulaire de connexion
    public function loginPost(ServerRequest $request)
    {
        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        $utilisateur = new Utilisateur();

        // - Vérifier que les champs sont remplis
        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            //sinon on confronte les valeurs saisies avec les données en BDD
            //on redefinit des variables
            $email = $post_data['email'];
            $password = self::hash($post_data['password']);

            // - Vérifier que l'utilisateur existe
            $utilisateur = AppRepoManager::getRm()->getUserRepo()->checkAuth($email, $password);

            // - Sinon message d'erreur
            if (is_null($utilisateur)) {
                $form_result->addError(new FormError('Email ou mot de passe incorrect'));
            }
        }

        // - En cas d'erreur, rediriger vers la page de connexion
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }

        // - Enregistrer l'utilisateur, effacer le mot de passe et rediriger vers l'accueil
        $utilisateur->password = '';
        Session::set(Session::USER, $utilisateur);
        //  self::redirect('/');

        // - Ajouter un message de confirmation
        Session::set(Session::SUCCESS_MESSAGE, 'Vous êtes connecté avec succès.');
        Session::set(Session::USER, $utilisateur);
        self::redirect('/');
    }

    // - Déconnexion
    public function logout()
    {
        // - Ajouter un message de confirmation
        Session::set(Session::SUCCESS_MESSAGE, AuthController::LOGOUT_SUCCESS_MESSAGE);
        // - Détruire la session
        Session::remove(Session::USER);
        self::redirect('/');
    }

    // - Hasher le mot de passe
    public static function hash(string $password): string
    {
        return hash('sha512', self::AUTH_SALT . $password . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }

    private static function hasRole(int $is_host): bool
    {
        // - Récupèrer les infos de l'utilisateur en session
        $utilisateur = Session::get(Session::USER);
        if (!($utilisateur instanceof Utilisateur)) {
            return false;
        }
        return $utilisateur->is_host === $is_host;
    }

    public static function hostUser(): bool
    {
        return self::hasRole(Utilisateur::ROLE_HOST);
    }

    public static function standardUser(): bool
    {
        return self::hasRole(Utilisateur::ROLE_STANDARD);
    }

    public function subscribePage()
    {
        // - Créer une instance de View pour afficher la vue de connexion
        $view = new View('auth/inscription', false);

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        $view->render($view_data);
    }


    public function addUser(ServerRequest $request)
    {

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        // - Vérifier que les champs sont remplis
        if (empty($post_data['prenom']) || empty($post_data['nom']) || empty($post_data['email']) || empty($post_data['telephone']) || empty($post_data['adresse']) || empty($post_data['password']) || empty($post_data['verif-password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/inscription');

            // - Vérifier si les mots de passe correspondent
            if ($post_data['password'] !== $post_data['verif-password']) {
                $form_result->addError(new FormError('Les mots de passe ne correspondent pas'));
            }
        } else {
            // - Récupérer les données du formulaire
            $prenom = htmlspecialchars(trim(strtolower($post_data['prenom'])));
            $nom = htmlspecialchars(trim(strtolower($post_data['nom'])));
            $email = htmlspecialchars(trim(strtolower($post_data['email'])));
            $telephone = htmlspecialchars(trim(strtolower($post_data['telephone'])));
            $adresse = htmlspecialchars(trim(strtolower($post_data['adresse'])));
            $password = htmlspecialchars(trim($post_data['password']));
            $pass_hash = AuthController::hash($password);

            // - Créer un nouvel utilisateur
            $user = AppRepoManager::getRm()->getUserRepo()->subscribe($prenom, $nom, $email, $telephone, $adresse, $pass_hash);

            // - Si l'utilisateur n'est pas créé on renvoie un message d'erreur
            if (!$user) {
                $form_result->addError(new FormError('Un problème est survenu durant l\'inscription'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/inscription');
            } else {
                // - On redirige vers l'accueil
                Session::remove(Session::FORM_RESULT);
                self::redirect('/');
            }
        }
    }
}
