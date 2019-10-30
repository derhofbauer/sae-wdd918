<?php

namespace Core;

class View
{

    protected $includesJS = [];
    protected $includesCSS = [
        'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' // standard css file, wird immer geladen!
    ];
    protected $baseUrl;

    public function __construct ()
    {
        $appConfig = require_once __DIR__ . '/../config/app.php';

        $this->baseUrl = $appConfig['baseUrl'];
    }

    public function render (string $templatePath, array $params = [], string $defaultLayout = "app")
    {
        if (!empty($templatePath)) {
            extract($params);
            require_once __DIR__ . "/../app/Views/Layouts/${defaultLayout}.php";
        }
    }

    public function addJs (string $filename)
    {
        if (!empty($filename) && !in_array($filename, $this->includesJS)) {
            $this->includesJS[] = $filename;
        }
    }

    public function addCss (string $filename)
    {
        if (!empty($filename) && !in_array($filename, $this->includesCSS)) {
            $this->includesCSS[] = $filename;
        }
    }

    public function getJsMarkup ()
    {
        $markup = [];
        foreach ($this->includesJS as $jsFile) {
           $markup[] = "<script src=\"$jsFile\"></script>";
        }
        return implode('', $markup);
    }

    public function getCssMarkup ()
    {
        $markup = [];
        foreach ($this->includesCSS as $cssFile) {
            $markup[] = "<link rel=\"stylesheet\" href=\"$cssFile\">";
        }
        return implode('', $markup);
    }
}
