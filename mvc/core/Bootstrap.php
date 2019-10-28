<?php

namespace Core;

class Bootstrap
{

    public function __construct ()
    {
        $routes = require_once __DIR__ . '/../app/routes.php';

        if (isset($_GET['path'])) {
            $path = "/" . $_GET['path'];
            $path = rtrim($path, '/'); // trim Slashes vom Ende von $path
        } else {
            $path = '/';
        }

        // Standardwerte definieren
        $controller = '';
        $action = '';
        $params = [];

        if (array_key_exists($path, $routes)) { // Route existiert 1:1 so in unserem Routes Array
            $controllerAndAction = $routes[$path];
            $controller = explode('.', $controllerAndAction)[0];
            $action = explode('.', $controllerAndAction)[1];
        } else { // Wir müssen schauen, ob die Route möglicherweise einen Parameter beinhaltet
            foreach ($routes as $route => $controllerAndAction) { // wir gehen hier alle routes durch
                if (strpos($route, ':') !== false) { // wenn eine Route einen : beinhaltet, gibt es einen Parameter und wir formen sie in eine Regular Expression um
                    $regex = str_replace('/', '\/', "^" . $route . '$'); // / => \/ und String Anfang und Ende werden in der Expression definiert
                    $regex = preg_replace('/:[a-zA-Z]+/', '([^\/]+)', $regex); // :param wird mit einer Capture Group ersetzt

                    $matches = []; // Wird die einzelnen Treffer der Regular Expression beinhalten

                    if (preg_match_all("/$regex/", $path, $matches) === 1) {
                        $controller = explode('.', $controllerAndAction)[0];
                        $action = explode('.', $controllerAndAction)[1];

                        array_shift($matches); // ersten Treffer der Regular Expression weg werfen, weil das der Gesamttreffer ist
                        $matches = array_map(function($item) { // jeder weitere Treffer wird so umgeformt, dass wir ein Array haben in dem die Werte der :params in der Reihenfolge der Erscheinung in der Url stehen
                            return $item[0];
                        }, $matches);

                        $params = $matches;
                        break;
                    }
                }
            }
        }

        if ($controller === '') { // Wenn kein Controller gefunden wurde, zeigen wir das na
            echo "Hier müsste eigentlich eine 404 Seite hin kommen";
        } else {
            $classAndNamespace = "App\Controllers\\$controller"; // Namespace und Klassenname werden zu einem String zusammengebaut

            $controller = new $classAndNamespace(); // aus dem Namespace&Klassenname String wird ein neues Objekt erzeugt
            call_user_func_array([$controller, $action], $params); // es wird die Methode $action aus dem Objekt $controller mit den Parametern $params aufgerufen; s. https://www.php.net/manual/en/function.call-user-func-array.php
        }
    }

}
