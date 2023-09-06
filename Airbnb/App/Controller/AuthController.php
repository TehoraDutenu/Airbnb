<?php

namespace App\Controller;

use Core\View\View;
use App\Model\Users;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

// - Identifiants :
// - Admin : doe@doe.com, Password : doe
// - Subscriber : toto@toto.com, Password : toto

class AuthController extends Controller
{
    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';

    public function login()
    {
        // - Créer une instance de View pour la vue de connexion
        // - false en 2nd param pour is_complete = false -> pas de footer ni header
        $view = new View('auth/login', false);

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        // - Render = méthode de View pour afficher la vue
        $view->render($view_data);
    }

    // - Réceptionner les données du formulaire de connexion
    public function loginPost(ServerRequest $request)
    {
        // - Récupérer les données du form dans une variable
        $post_data = $request->getParsedBody();

        // - Créer une instance de FormResult
        $form_result = new FormResult();

        // - Créer une instance de users
        $user = new Users();

        // - Vérifier que les champs sont remplis
        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));

            // - S'ils le sont on confronte les valeurs saisies avec les données de la BDD
        } else {
            // - Redéfinir des variables
            $email = $post_data['email'];
            $password = self::hash($post_data['password']);

            // - Appel du repository pour vérifier que l'utilisateur existe
            $user = AppRepoManager::getRm()->getUserRepo()->checkAuth($email, $password);

            // - Retourner un message d'erreur si ça ne matche pas
            if (is_null($user)) {
                $form_result->addError(new FormError('Email ou mot de passe incorrect'));
            }
        }

        // - En cas d'erreurs, on renvoie vers la page connexion
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }

        // - Si tout s'est bien passé, on enregistre l'user en session et on redirige vers Accueil
        // - Effacer le mot de passe
        $user->password = '';
        Session::set(Session::USER, $user);
        // - Rediriger
        self::redirect('/');
    }

    // - Méthode de déconnexion
    public function logout()
    {
        // - Détruire la session
        Session::remove(Session::USER);
        self::redirect('/');
    }

    // - Méthode hash du mot de passe
    public static function hash(string $password): string
    {
        return hash('sha512', self::AUTH_SALT . $password . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }

    private static function hasRole(int $role): bool
    {
        // - On récupère les infos de l'utilisateur en session
        $user = Session::get(Session::USER);

        if (!($user instanceof Users)) {
            return false;
        }
        return $user->role === $role;
    }

    public static function isSuscriber(): bool
    {
        return self::hasRole(Users::ROLE_SUBSCRIBER);
    }

    public static function isAdmin(): bool
    {
        return self::hasRole(Users::ROLE_ADMINISTRATOR);
    }
}
