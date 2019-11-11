<?php

namespace Core;

class View
{

    /**
     * Array für einzubindende JS Files
     */
    protected $includesJS = [];

    /**
     * Array für einzubindende CSS Files
     *
     * Files in diesem Array, werden immer geladen
     */
    protected $includesCSS = [
        'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'
    ];

    /**
     * $baseUrl aus der config
     */
    protected $baseUrl;

    public function __construct ()
    {
        $this->baseUrl = config('app.baseUrl');
    }

    public function render (string $templatePath, array $params = [], string $defaultLayout = "app")
    {
        /**
         * Wenn der $templatePath nicht leer ist, extrahieren wir aus dem $params Array einzelne Variablen und laden
         * das Layout. Das Layout selbst lädt dann das Template, welches in $templatePath angegeben ist.
         *
         * s. https://www.php.net/manual/en/function.extract.php
         */
        if (!empty($templatePath)) {
            extract($params);
            require_once __DIR__ . "/../app/Views/Layouts/${defaultLayout}.php";
        }
    }

    public function addJs (string $filename)
    {
        /**
         * Wenn $filename nicht leer ist und noch nicht in $this->includeJS vorkommt, fügen wir ihn hinzu.
         */
        if (!empty($filename) && !in_array($filename, $this->includesJS)) {
            $this->includesJS[] = $filename;
        }
    }

    public function addCss (string $filename)
    {
        /**
         * s. $this->addJs()
         */
        if (!empty($filename) && !in_array($filename, $this->includesCSS)) {
            $this->includesCSS[] = $filename;
        }
    }

    public function getJsMarkup ()
    {
        /**
         * Array initialisieren
         */
        $markup = [];

        /**
         * `<script>`-Tag aus allen JS files erzeugen und in den $markup Array hinzufügen
         */
        foreach ($this->includesJS as $jsFile) {
           $markup[] = "<script src=\"$jsFile\"></script>";
        }

        /**
         * Alle Werte im $markup Array zu einem String zusammenfügen und zurückgeben
         */
        return implode('', $markup);
    }

    public function getCssMarkup ()
    {
        /**
         * s. $this->getJsMarkup()
         */
        $markup = [];
        foreach ($this->includesCSS as $cssFile) {
            $markup[] = "<link rel=\"stylesheet\" href=\"$cssFile\">";
        }
        return implode('', $markup);
    }
}
