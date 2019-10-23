<?php

namespace Core;

class Bootstrap
{

    public function __construct ()
    {
        if (isset($_GET['path'])) {
            $path = "/" . $_GET['path'];
        } else {
            $path = '/';
        }

        var_dump($path);
    }

}
