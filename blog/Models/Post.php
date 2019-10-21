<?php

namespace Blog\Models;

class Post
{

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $categories_ids = [];
    public $tags;
    public $crdate;
    public $updated_date;

    public static function find ($id, $link)
    {
        $stmt = $link->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $result = $stmt->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC)[0];

        $post = new self();
        $post->id = $result['id'];
        $post->title = $result['title'];
        $post->content = $result['content'];
        $post->user_id = $result['user_id'];
        $post->tags = $result['tags'];
        $post->crdate = $result['crdate'];
        $post->updated_date = $result['updated_date'];

        return $post;
    }

    public function getTags ()
    {
        $tags = str_replace('%%', ',', $this->tags);
        $tags = str_replace('%', '', $tags);

        return $tags;
    }

    public function save ($link)
    {
        $stmt = $link->prepare("UPDATE posts SET title = ?, content = ?, tags = ? WHERE id = ?");
        $stmt->bind_param('sssi', $this->title, $this->content, $this->tags, $this->id);
        $stmt->execute();
    }
}
