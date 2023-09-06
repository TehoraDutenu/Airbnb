<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\ToyRepository;
use App\Model\Repository\UserRepository;
use App\Model\Repository\BrandRepository;

class AppRepoManager
{
    // - On importe le trait
    use RepositoryManagerTrait;

    private UserRepository $userRepository;
    private ToyRepository $toyRepository;
    private BrandRepository $brandRepository;

    // - Getters
    public function getUserRepo(): UserRepository
    {
        return $this->userRepository;
    }

    public function getToyRepo(): ToyRepository
    {
        return $this->toyRepository;
    }

    public function getBrandRepo(): BrandRepository
    {
        return $this->brandRepository;
    }

    // - Constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->userRepository = new UserRepository($config);
        $this->toyRepository = new ToyRepository($config);
        $this->brandRepository = new BrandRepository($config);
    }
}
