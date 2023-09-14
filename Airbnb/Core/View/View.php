<?php

namespace Core\View;

use App\Controller\AuthController;

class View
{
    // - Définir le chemin absolu vers le dossier contenant les vues
    public const PATH_VIEW = PATH_ROOT . 'views' . DS;

    // - Récupèrer le chemin de notre dossier _templates
    public const PATH_PARTIALS = self::PATH_VIEW . '_templates' . DS;
    //on déclare une propriété titre
    public string $title = 'Titre par défaut';

    // - Déclarer le constructeur
    public function __construct(
        private string $name,
        private bool $is_complete = true
    ) {
    }

    // - Créer une méthode pour récupérer le chemin de la vue
    private function getRequirePath(): string
    {
        $arr_name = explode('/', $this->name);
        $category = $arr_name[0];
        $name = $arr_name[1];
        $name_prefix = $this->is_complete ? '' : '_';

        return self::PATH_VIEW . $category . DS . $name_prefix . $name . '.html.php';
    }

    // - Créer notre méthode de rendu
    public function render(?array $view_data = []): void
    {
        // - Vérifier que l'utilisateur est en session, sinon le rediriger vers la page de connexion
        $auth = AuthController::class;
        if (!empty($view_data)) {
            extract($view_data);
        }
        // - Mettre en cache du résultat
        ob_start();
        // - Importer le template _header
        if ($this->is_complete) {
            require self::PATH_PARTIALS . '_header.html.php';
        }
        // - Inclure le fichier de la vue
        require $this->getRequirePath();

        // - Importer le template _footer
        if ($this->is_complete) {
            require self::PATH_PARTIALS . '_footer.html.php';
        }

        // - Libérer le cache
        ob_end_flush();
    }
}
