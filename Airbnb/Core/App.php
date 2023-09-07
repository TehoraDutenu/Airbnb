<?php

namespace Core;

/* use App\Controller\ToyController;
 */

use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\PageController;

/* use App\Controller\AdminController; */
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{
    // - Déclarer des constantes pour la connexion à la BDD
    private const DB_HOST = 'database';
    private const DB_NAME = 'site_airbnb';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';

    // - Propriété qui contient l'instance de notre classe
    private static ?self $instance = null;

    // - Propriété qui contient l'instance de Router (MiladRahimi)
    private Router $router;

    // - Créer une méthode qui qui sera appelée au démarrage de l'appli dans index.php
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
        // - Router::create(), méthode statique de la classe Router pour créer une instance Router
        $this->router = Router::create();
    }

    // - Trois méthodes à définir après l'instanciation de Router
    // - 1. Méthode start (activation)
    public function start(): void
    {
        // - Démarrer session
        session_start();

        // - Enregistrer les routes
        $this->registerRoutes();

        // - Démarre le routeur
        $this->startRouter();
    }

    // - 2. Méthode registerRoutes (enregistrement)
    private function registerRoutes(): void
    {
        // - Créer la route pour la page d'accueil 
        // $this->router->get('/', function () {
        // echo 'Utiliser le controller pour envoyer la vue';
        // });

        // - Déclarer les patterns pour tester les valeurs des arguments
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d+-)?[a-z]+(-[a-z-\d]+)*');
        // - Créer la route pour la page d'accueil avec controller
        $this->router->get('/', [PageController::class, 'index']);
        /*
        // - Route pour les détails de jouets
        $this->router->get('/jouet/{id}', [ToyController::class, 'toyById']);
        // - Route pour les jouets par marque
        $this->router->get('/brands/{id}', [ToyController::class, 'toysByBrand']); */
        // - Route pour la vue connexion
        $this->router->get('/connexion', [AuthController::class, 'login']);
        // - Route pour envoyer le formulaire d'authentification (loginPost est la méthode)
        $this->router->post('/login', [AuthController::class, 'loginPost']);
        /*
        // - Route pour logout
        $this->router->get('/logout', [AuthController::class, 'logout']);
        // - Route pour page admin
        $this->router->get('/admin/users', [AdminController::class, 'index']);
        // - Route pour modifier un utilisateur
        $this->router->get('/admin/update/{id}', [AdminController::class, 'update']);
        $this->router->post('/update', [AdminController::class, 'updateUser']);
        // - Route pour supprimer un utilisateur
        $this->router->get('/admin/delete/{id}', [AdminController::class, 'deleteUser']);
        // - Route pour ajouter un utilisateur
        $this->router->get('/admin/addUser', [AdminController::class, 'addUser']);
        $this->router->get('/admin/addToy', [AdminController::class, 'addToy']);
        $this->router->post('/add', [AdminController::class, 'add']);
        // - Route pour créer un jouet
        $this->router->post('/createToy', [AdminController::class, 'createToy']);
        // - Route pour modifier un jouet
        $this->router->get('/admin/editToy/{id}', [AdminController::class, 'editToy']);
        // - Route pour update
        $this->router->post('/updateToy', [AdminController::class, 'updateToy']);
        // - Route pour supprimer un jouet
        $this->router->get('/admin/deleteToy/{id}', [AdminController::class, 'deleteToy']);
 */
    }

    // - 3. Méthode startRouter(démarrer)
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

    // - /!\ OBLIGATOIRE : déclarer les méthodes issues de l'interface
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
