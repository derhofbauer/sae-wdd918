<?php

namespace App\Models;

// $post = new \App\Models\Post();
// $postController = new \App\Controllers\Post();

class Post {

    public $id = 1;
    public $title = "some title";
    public $author_id = 1;
    public $content;
    public $categories;

    public function __construct($id, $title, $content) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;

        echo "__construct";
    }

    public function getAuthor() {

    }

    public function getCategories () {

    }

    public function getMetaLine () {
        // author | date | categories
        $author = $this->getAuthor();
        $categories = $this->getCategories();
        return "$author | $categories";
    }

    public function __destruct() {
        echo "__destruct";
    }

    public function getPassword () {
        return "Parent:" + $this->password;
    }

    public function getProtectedProperty () {
        return $this->someprotectedproperty;
    }

    public function save() {

    }

}

$post = new Post(1, "Some Post", "Fancy Content"); // __construct

echo $post->id; // 1
echo $post->getMetaLine(); // Arthur Dent | Some category
echo $post->author_id; // 1

$post->content = "different content";
$post->save();

// __destruct
?>