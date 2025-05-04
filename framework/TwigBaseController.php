<?php
require_once "BaseController.php"; // обязательно импортим BaseController

class TwigBaseController extends BaseController {
    public $title = ""; // название страницы
    public $template = ""; // шаблон страницы
    public $temp = "";
    public $caption = "";
    public $urlhelp = "";
    public $nav = [ // добавил список словариков
        [
            "title" => "Главная",
            "url" => "/",
        ],
        [
            "title" => "Уитли",
            "url" => "/portal-character/1",
        ],
        [
            "title" => "ГЛэДОС",
            "url" => "/portal-character/2",
        ]
    ];

    public $newnav = [
        [
            "title" => "Картинка",
            "url" => "image",
        ],
        [
            "title" => "Описание",
            "url" => "info",
        ]
    ];
    protected \Twig\Environment $twig; // ссылка на экземпляр twig, для рендернига
    
    public function setTwig($twig) {
        $this->twig = $twig;
    }
    
    // переопределяем функцию контекста
    public function getContext() : array
    {
        $context = parent::getContext(); // вызываем родительский метод
        $context['title'] = $this->title; 
        $context['nav'] = $this->nav;
        $context['newnav'] = $this->newnav;
        $context['temp'] = $this->temp;
        $context['urlhelp'] = $this->urlhelp;
        $context['caption'] = $this->caption;

        return $context;
    }
    
    public function get(array $context) { // добавил аргумент в get
        echo $this->twig->render($this->template, $context); // а тут поменяем getContext на просто $context
    }
}