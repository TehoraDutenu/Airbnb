<?php

namespace Core;

use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\BienController;
use App\Controller\PageController;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{

    // - Déclarer des constantes pour la connexion à la base de données
    private const DB_HOST = 'database';
    private const DB_NAME = 'site_airbnb';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';

    private static ?self $instance = null;
    private Router $router;

    // - Créer une instance de démarrage
    public static function getApp(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    // - Instancier Router
    public function getRouter(): Router
    {
        return $this->router;
    }

    private function __construct()
    {
        // - Créer une instance de Router
        $this->router = Router::create();
    }

    // - Activer le router
    public function start(): void
    {
        //on démarre la session
        session_start();
        //on enregistre les routes
        $this->registerRoutes();
        //on démarre le router
        $this->startRouter();
    }

    // - Enregistrer les routes
    private function registerRoutes(): void
    {
        // - Déclarer des patterns pour tester les valeurs des arguments 
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d+-)?[a-z]+(-[a-z-\d]+)*');

        // - Créer la route pour la page d'accueil avec le controller
        $this->router->get('/', [PageController::class, 'index']);
        // - Créer la route pour la page de connexion de l'utilisateur
        $this->router->get('/connexion', [AuthController::class, 'login']);
        // - Créer la route pour la connexion de l'utilisateur
        $this->router->post('/login', [AuthController::class, 'loginPost']);
        // - Route pour la déconnexion
        $this->router->get('/logout', [AuthController::class, 'logout']);

        // - Créer la route pour la page d'inscription d'un utilisateur
        $this->router->get('/inscription', [AuthController::class, 'subscribePage']);
        // - Créer la route pour l'inscription d'un utilisateur
        $this->router->post('/register', [AuthController::class, 'addUser']);
        // - Créer la route pour la page d'inscription d'un bien
        $this->router->get('/proposer', [BienController::class, 'proposer']);
        // - Créer la route pour l'inscription d'un bien
        $this->router->post('/registerBien', [BienController::class, 'createBien']);
        // - Créer route pour les détails d'un bien
        $this->router->get('/details/{id}', [BienController::class, 'seeDetails']);
    }

    // - Démarrer le router
    private function startRouter(): void
    {
        try {
            $this->router->dispatch();
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        } catch (InvalidCallableException $e) {
            echo $e->getMessage();
        }
    }

    // - Déclarer les 4 méthodes issues de l'interface
    public function getHost(): string
    {
        return self::DB_HOST;
    }

    public function getName(): string
    {
        return self::DB_NAME;
    }

    public function getUser(): string
    {
        return self::DB_USER;
    }

    public function getPass(): string
    {
        return self::DB_PASS;
    }
}
