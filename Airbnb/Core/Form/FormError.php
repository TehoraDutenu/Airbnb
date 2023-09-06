<?php

namespace Core\Form;

class FormError
{
    public function __construct(private string $message, private string $field = '')
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
