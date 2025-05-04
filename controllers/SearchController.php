<?php
require_once "BasePortalTwigController.php";

class SearchController extends BasePortalTwigController {
    public $template = "search.twig";
    
    public function getContext(): array
    {
        $context = parent::getContext();

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $info = isset($_GET['info']) ? $_GET['info'] : '';

        if($type == ''){
            $sql = <<<EOL
SELECT id, title
FROM portal_characters
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
        AND (:info = '' OR info like CONCAT('%', :info, '%'))
EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("info", $info);
        } else {
            $sql = <<<EOL
SELECT id, title
FROM portal_characters
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
        AND (type = :type)
        AND (:info = '' OR info like CONCAT('%', :info, '%'))
EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("type", $type);
            $query->bindValue("info", $info);
        }

        
        $query->execute(); 

        $context['title_objects'] = $query->fetchAll();

        return $context;
    }
}