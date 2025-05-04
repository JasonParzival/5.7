<?php
require_once "BasePortalTwigController.php";

class ObjectController extends BasePortalTwigController {
    public $template = "";
    public $temp = "";

    public function get(array $context) {
        $show = $_GET['show'] ?? '';
        switch($show) {
            case 'image':
                $this->template = "base_image.twig";
                $this->temp = "Картинка";
                break;
            case 'info':
                $this->template = "base_info.twig";
                $this->temp = "Описание";
                break;
            default:
                $this->template = "main_window_object.twig";
                $this->temp = "";
        }
        parent::get($context);
    }

    public function getContext(): array
    {
        $context = parent::getContext();   

        $query = $this->pdo->prepare("SELECT * FROM portal_characters WHERE id= :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute(); 
        
        $context['title_objects'] = $query->fetch();

        return $context;
    }
}