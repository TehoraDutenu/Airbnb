<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\BienRepository;
use App\Model\Repository\EquipementBienRepository;
use App\Model\Repository\EquipementRepository;
use App\Model\Repository\PhotoRepository;
use App\Model\Repository\TypebienRepository;
use App\Model\Repository\UserRepository;

class AppRepoManager
{
    private UserRepository $userRepository;
    private BienRepository $bienRepository;
    private TypebienRepository $typebienRepository;
    private EquipementRepository $equipementRepository;
    private PhotoRepository $photoRepository;
    private EquipementBienRepository $equipementBienRepository;

    // - Importer le trait
    use RepositoryManagerTrait;

    // - Créer les getters
    public function getUserRepo(): UserRepository
    {
        return $this->userRepository;
    }

    public function getBienRepo(): BienRepository
    {
        return $this->bienRepository;
    }

    public function getTypebienRepo(): TypebienRepository
    {
        return $this->typebienRepository;
    }

    public function getEquipementRepo(): EquipementRepository
    {
        return $this->equipementRepository;
    }

    public function getPhotoRepo(): PhotoRepository
    {
        return $this->photoRepository;
    }

    public function getEquipementBienRepo(): EquipementBienRepository
    {
        return $this->equipementBienRepository;
    }

    // - Déclarer le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->userRepository = new UserRepository($config);
        $this->bienRepository = new BienRepository($config);
        $this->typebienRepository = new TypebienRepository($config);
        $this->equipementRepository = new EquipementRepository($config);
        $this->photoRepository = new PhotoRepository($config);
        $this->equipementBienRepository = new EquipementBienRepository($config);
    }
}
