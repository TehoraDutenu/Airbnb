<?php

namespace Core\Form;

use Core\Form\FormError;

class FormResult
{
    private string $success_message;
    private array $form_errors = [];

    // - Constructeur avec paramètre par défaut
    public function __construct(string $success_message = '')
    {
        $this->success_message = $success_message;
    }

    // - Créer le Getter
    public function getSuccessMessage(): string
    {
        return $this->success_message;
    }

    public function getErrors(): array
    {
        return $this->form_errors;
    }

    // - Vérifier s'il y a des erreurs
    public function hasError(): bool
    {
        return !empty($this->form_errors);
    }

    public function addError(FormError $error)
    {
        $this->form_errors[] = $error;
    }
}
