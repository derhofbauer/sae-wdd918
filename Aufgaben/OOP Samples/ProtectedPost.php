<?php

class ProtectedPost extends Post {

    private $password = "defaultPassword";
    protected $someprotectedproperty;

    private function __construct() {
        parent::__construct();
    }

    private function checkPassword() {

    }

    public function getPassword () {
        return $this->password;
    }

    public function parentGetPassword () {
        return parent::getPassword();
    }

}

$protectedPost = new ProtectedPost(2, "Protected Post", "Protected Content");

echo $protectedPost->id; // 2
echo $protectedPost->password; // ERROR

echo $protectedPost->getPassword(); // ERROR
echo $protectedPost->getProtectedProperty(); // 

echo $protectedPost->getPassword(); // defaultPassword

?>