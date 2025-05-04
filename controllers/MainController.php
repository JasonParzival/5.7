<?php
require_once "BasePortalTwigController.php";

class MainController extends BasePortalTwigController {
    public $template = "main.twig";
    public $title = "Главная";
    
    public function getContext(): array
    {
        $context = parent::getContext();
        
        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM portal_characters WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        }
        else {
            $query = $this->pdo->query("SELECT * FROM portal_characters");
        }
        
        $context['portal_characters'] = $query->fetchAll();

        return $context;
    }
}