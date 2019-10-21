<?php

class ArrayHelpers {

    static public $someFancyRegex = "/11slasdlhgsad/"; // <-- nicht valide!

    static public function arraySomething (array $array) {
        return someFunction($array);
    }

}

echo ArrayHelpers::arraySomething([1, 2, 3]);
echo ArrayHelpers::$someFancyRegex;

?>