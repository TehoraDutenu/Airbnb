<?php 
namespace Core\Database;

interface DatabaseConfigInterface
{
    public function getHost(): string;
    public function getName(): string;
    public function getUser(): string;
    public function getPass(): string;
}