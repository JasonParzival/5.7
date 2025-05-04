<?php
require_once "BasePortalTwigController.php";

class PortalObjectTypesController extends BasePortalTwigController {
    public $template = "portal_object_types.twig";

    public function get(array $context) // добавили параметр
    {
        echo $_SERVER['REQUEST_METHOD'];
        
        parent::get($context); // пробросили параметр
    }

    public function post(array $context) {
        // получаем значения полей с формы
        $name = $_POST['name'];
        /*$description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];*/

        $tmp_name = $_FILES['image']['tmp_name'];
        $namefile =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$namefile");
        $image_url = "/media/$namefile"; // формируем ссылку без адреса сервера

        $sql = <<<EOL
INSERT INTO portal_types(name, image)
VALUES(:name, :image_url) -- передаем переменную в запрос
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("name", $name);
        $query->bindValue("image_url", $image_url);
        /*$query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url); // подвязываем значение ссылки к переменной  image_url*/
        $query->execute();
        
        // а дальше как обычно
        //$context['message'] = 'Вы успешно создали объект';
        //$context['id'] = $this->pdo->lastInsertId();

        $this->get($context);
    }
}