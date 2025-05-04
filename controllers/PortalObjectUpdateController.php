<?php
require_once "BasePortalTwigController.php";

class PortalObjectUpdateController extends BasePortalTwigController {
    public $template = "portal_object_update.twig";

    public function get(array $context) // добавили параметр
    {
        $id = $this->params['id']; // взяли id

        $sql =<<<EOL
SELECT * FROM portal_characters WHERE id = :id
EOL;
        
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        $data = $query->fetch();

        $context['objectUpdate'] = $data;

        parent::get($context);
    }

    public function post(array $context) {
        $id = $this->params['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];

        $sqlSelect = "SELECT image FROM portal_characters WHERE id = :id";
        $querySelect = $this->pdo->prepare($sqlSelect);
        $querySelect->bindValue(":id", $id);
        $querySelect->execute();

        $image_url = $querySelect->fetchColumn();;
        
        if (!empty($_FILES['image']['tmp_name'])) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            move_uploaded_file($tmp_name, "../public/media/$name");
            $image_url = "/media/$name";
        }

        $sql = <<<EOL
UPDATE portal_characters 
SET 
    title = :title,
    description = :description,
    type = :type,
    info = :info,
    image = :image_url
WHERE id = :id
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":title", $title);
        $query->bindValue(":description", $description);
        $query->bindValue(":type", $type);
        $query->bindValue(":info", $info);
        $query->bindValue(":image_url", $image_url);
        $query->bindValue(":id", $id);
        $query->execute();
        
        $context['message'] = 'Данные успешно обновлены';
        $context['id'] = $id;

        $this->get($context);
    }
}