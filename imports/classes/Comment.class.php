<?php

class Comment extends Data {
    public int $comment_id;
    public int|null $parent_id;

    public string $_text;
    public string $text_validate = '';

    public string $created_at;

    public object $post;

    public function __construct(object $post) {
        $this->post = $post;
    }

    public function validate() {
        return parent::validateData($this);
    }

    public function load(array $data) {
        parent::loadData($this, $data);
    }

    public function save() {
        $text = parent::rn_to_br($this->_text);
        $user_id = $this->post->user->user_id;
        $post_id = $this->post->post_id;

        if (isset($this->parent_id)) {
            $query = "INSERT INTO `comment` 
                     (`_text`, `user_id`, `post_id`, `parent_id`) 
                     VALUES ('$text', $user_id, $post_id, $this->parent_id)";
        } else {
            $query = "INSERT INTO `comment` 
                     (`_text`, `user_id`, `post_id`) 
                     VALUES ('$text', $user_id, $post_id)";
        }

        return $this->post->user->mysql->db_query($query);
    }

    public function comment_datetime() {
        return parent::datetime_format($this->created_at);
    }

    public function all_comments($mode = 'standard') {
        if ($mode == 'replies') {
            $query = "SELECT * FROM `comment` 
                      WHERE parent_id = {$this->comment_id} 
                      ORDER BY created_at DESC";
        } else {
            $query = "SELECT * FROM `comment` 
                      WHERE post_id = {$this->post->post_id} 
                      AND parent_id IS NULL 
                      ORDER BY created_at DESC";
        }

        $res = $this->post->user->mysql->db_query($query);
        $output = [];

        foreach ($res as $comment) {
            $user = new User($this->post->user->request, $this->post->user->mysql);
            $user_data = $user->mysql->db_query("SELECT * FROM `user` WHERE user_id = {$comment['user_id']}")[0];
            $user->load($user_data);

            $post = new Post($user);
            $post_data = $post->user->mysql->db_query("SELECT * FROM `post` WHERE post_id = {$comment['post_id']}");
            $post->load($post_data);

            $object = new static($post);
            $object->load($comment);
            $output[] = $object;
        }

        return $output;
    }

    public function findOne($comment_id) {
        $post_data = $this->post->user->mysql->db_query(
            "SELECT * FROM `comment` WHERE `comment`.`comment_id` = $comment_id"
        );
        $this->load($post_data[0]);
    }

    public function delete() {
        return $this->post->user->mysql->db_query(
            "DELETE FROM `comment` WHERE `comment`.`comment_id` = $this->comment_id"
        );
    }
}


?>