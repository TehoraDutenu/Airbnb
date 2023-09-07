<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\UtilisateurRepository;

class AppRepoManager
{
    // - On importe le trait
    use RepositoryManagerTrait;

    private UtilisateurRepository $utilisateurRepository;

    // - Getters
    public function getUserRepo(): UtilisateurRepository
    {
        return $this->utilisateurRepository;
    }

    /*     public function getToyRepo(): ToyRepository
    {
        return $this->toyRepository;
    }

    public function getBrandRepo(): BrandRepository
    {
        return $this->brandRepository;
    }
 */
    // - Constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->utilisateurRepository = new UtilisateurRepository($config);
    }
}
