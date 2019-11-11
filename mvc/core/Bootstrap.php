<?php

namespace Core;

class Bootstrap
{

    public function __construct ()
    {
        /**
         * Routen laden
         */
        $routes = require_once __DIR__ . '/../app/routes.php';

        /**
         * $_GET['path'] so umformen, dass immer ein führendes Slash dran steht unten am Ende keines.
         * Wenn kein Pfad übergeben wurde, so ist unsere Standarroute "/".
         */
        if (isset($_GET['path'])) {
            $path = "/" . $_GET['path'];

            /**
             * `rtrim()` entfernt eine Liste an Zeichen vom Ende eines Strings.
             */
            $path = rtrim($path, '/');
        } else {
            $path = '/';
        }

        /**
         * Variablen initialisieren, damit wir sie später befüllen können
         */
        $controller = '';
        $action = '';
        $params = [];

        /**
         * Prüfen, ob die angefragte Route in unserer routes.php vorkommt oder nicht
         */
        if (array_key_exists($path, $routes)) {
            /**
             * Route existiert 1:1 so in unserem Routes Array, weil sie keinen Parameter akzeptiert
             */

            /**
             * Abfragen des zugehörigen "Controller.action" Strings zur angefragten Route
             */
            $controllerAndAction = $routes[$path];

            /**
             * Aufspalten des oben angefragten "Controller.action" Strings in Controller und Action
             */
            $controller = explode('.', $controllerAndAction)[0];
            $action = explode('.', $controllerAndAction)[1];

        } else {
            /**
             * Wir müssen schauen, ob die Route möglicherweise einen Parameter beinhaltet
             *
             * Dazu gehen wir alle Routen durch.
             */
            foreach ($routes as $route => $controllerAndAction) {

                /**
                 * wenn eine Route einen Doppelpunkt beinhaltet, gibt es einen Parameter und
                 * wir formen sie in eine Regular Expression um. Wenn Sie keinen Doppelpunkt
                 * beinhaltet, dann wurde sie im oben stehenden `if` bereits abgedeckt und
                 * braucht nicht umgeformt zu werden.
                 */
                if (strpos($route, ':') !== false) {

                    /**
                     * Route mit Parameter in Regular Expression umformen:
                     * - Slashes escapen (/ => \/) und String Anfang und Ende definieren
                     * - :param mit einer Capture Group ersätzen
                     */
                    $regex = str_replace('/', '\/', "^" . $route . '$');
                    $regex = preg_replace('/:[a-zA-Z]+/', '([^\/]+)', $regex);

                    /**
                     * Wird die einzelnen Treffer der Regular Expression beinhalten
                     *
                     * s. https://www.php.net/manual/en/function.preg-match-all.php
                     */
                    $matches = [];

                    /**
                     * Hier prüfen wir, ob der angefragte Pfad auf die Route im aktuellen Schleifendurchlauf zutrifft.
                     */
                    if (preg_match_all("/$regex/", $path, $matches) === 1) {

                        /**
                         * "Controller.action" kommt diesmal aus der `foreach`-Schleife. Wir spalten es hier daher nur
                         * wieder genauso wie oben auf.
                         */
                        $controller = explode('.', $controllerAndAction)[0];
                        $action = explode('.', $controllerAndAction)[1];

                        /**
                         * ersten Treffer der Regular Expression weg werfen, weil das der Gesamttreffer ist
                         *
                         * s. https://www.php.net/manual/en/function.preg-match-all.php
                         * s. https://www.php.net/manual/en/function.array-shift.php
                         */
                        array_shift($matches);

                        /**
                         * jeder weitere Treffer wird so umgeformt, dass wir ein Array haben in dem die Werte der
                         * :params in der Reihenfolge ihres Vorkommens in der URL angeordnet sind.
                         *
                         * `array_map()` führt dabei eine Funktion auf jedes Element in dem angegebenen Array aus.
                         *
                         * s. https://www.php.net/manual/en/function.array-map.php
                         */
                        $matches = array_map(function ($item) {

                            /**
                             * `preg_match_all()` erzeugt ein sehr seltsames mehrdimensionales Array, wir wollen aber
                             * immer nur ein bestimmes Element in der zweiten Ebene des Arrays.
                             */
                            return $item[0];

                        }, $matches);

                        $params = $matches;

                        /**
                         * Zu diesem Zeitpunkt wurde ein Treffer in den Routen gefunden und Controller, Action und
                         * Parameter aufgelöst. `break` beendet nun die aktuelle Schleife, weil wir nur einen Treffer
                         * brauchen.
                         *
                         *  s. https://www.php.net/manual/en/control-structures.break.php
                         */
                        break;
                    }
                }
            }
        }

        /**
         * Wenn kein Controller gefunden wurde, zeigen wir das an. Eigentlich sollten wir hier eine 404 Seite laden.
         */
        if ($controller === '') {
            echo "Hier müsste eigentlich eine 404 Seite hin kommen";
        } else {
            /**
             * Wenn oben ein Controller gefunden wurde, dann erstellen wir nun den vollständigen Namen der Klasse
             * mit dem Namespace.
             */
            $classAndNamespace = "App\Controllers\\$controller";

            /**
             * Instanzieren (erzeugen) eines Controller Objects
             */
            $controller = new $classAndNamespace();

            /**
             * Aufrufen der Methode $action aus dem Objekt $controller mit den Funktionsparametern $params
             *
             * s. https://www.php.net/manual/en/function.call-user-func-array.php
             */
            call_user_func_array([$controller, $action], $params);
        }
    }

}
