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

class AuthController extends Controller
{
    // - Codage du password
    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';

    // - Saisir les identifiants de connexion
    public function login()
    {
        $view = new View('auth/login', false);

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];

        $view->render($view_data);
    }

    // - Récupérer les données de connexion
    public function loginPost(ServerRequest $request)
    {
        // - Récupérer les données du formulaire
        $post_data = $request->getParsedBody();

        // - Créer une instance de FormResult
        $form_result = new FormResult();

        // - Créer un instance de Utilisateur
        $utilisateur = new Utilisateur();

        // - Vérifier que les champs sont remplis
        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            // - Sinon on compare les données du formulaire et celles de la BDD
            $email = $post_data['email'];
            $password = self::hash($post_data['password']);

            $utilisateur = AppRepoManager::getRm()->getUtilisateurRepo()->checkAuth($email, $password);
            /*             var_dump($utilisateur);
            die();
 */
            // - Message d'erreur
            if (is_null($utilisateur)) {
                $form_result->addError(new FormError('Email ou mot de passe incorrect'));
            }
        }

        // - En cas d'erreur de connexion
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }
        // - Sinon on ouvre la session utilisateur et on redirige après avoir effacé le password
        $utilisateur->password = '';
        Session::set(Session::USER, $utilisateur);
        self::redirect('/');
    }

    // - Encoder le password
    public static function hash(string $password): string
    {
        return hash('sha256', self::AUTH_SALT . $password . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }
}
