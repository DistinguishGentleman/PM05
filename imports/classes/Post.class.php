<?php

class Post extends Data {
    public object $user;

    public int $post_id;
    public int $user_id;

    public string $user_login;
    public string $created_at;
    public string $_title;
    public string $_preview;
    public string $_content;

    public string $title_validate = '';
    public string $preview_validate = '';
    public string $content_validate = '';

    public int $comments_count;

    public function __construct(object $user) {
        $this->user = $user;
    }

    public function validate() {
        return parent::validateData($this);
    }

    public function load(array $data) {
        parent::loadData($this, $data);
    }

    public function save() {
        $content = parent::rn_to_br($this->_content);

        if (!empty($this->post_id)) {
            $query = "UPDATE `post` SET 
                     `_title` = '$this->_title', 
                     `_preview` = '$this->_preview', 
                     `_content` = '$content' 
                     WHERE `post`.`post_id` = $this->post_id";
        } else {
            $query = "INSERT INTO `post` 
                     (`user_id`, `_title`, `_preview`, `_content`) 
                     VALUES ('{$this->user->user_id}', '$this->_title', '$this->_preview', '$content')";
        }

        $res = $this->user->mysql->db_query($query);
        
        if (!$this->post_id) {
            $this->post_id = $this->user->mysql->insert_id;
        }

        return $res;
    }

    public function findOne($post_id) {
        $query = "SELECT p.*, COUNT(comment_id) AS comments_count, u._login AS user_login
                 FROM post p
                 LEFT JOIN comment c ON p.post_id = c.post_id
                 JOIN user u ON p.user_id = u.user_id
                 WHERE p.post_id = $post_id";

        $post_data = $this->user->mysql->db_query($query);
        $this->load($post_data[0]);
    }

    public function post_datetime() {
        return parent::datetime_format($this->created_at);
    }

    public function posts_list($limit = null) {
        $query = "SELECT post.*, COUNT(comment_id) AS comments_count 
                 FROM `post` 
                 LEFT JOIN comment ON post.post_id = comment.post_id 
                 GROUP BY post.post_id
                 ORDER BY created_at DESC";

        if (isset($limit)) {
            $query .= " LIMIT $limit";
        }

        $res = $this->user->mysql->db_query($query);
        $output_arr = [];

        foreach ($res as $post) {
            $user = new User($this->user->request, $this->user->mysql);
            $user_data = $user->mysql->db_query("SELECT * FROM `user` WHERE user_id = {$post['user_id']}")[0];
            $user->load($user_data);

            $post_obj = new static($user);
            $post_obj->load($post);
            $post_obj->user_login = $user->_login;
            $output_arr[] = $post_obj;
        }

        return $output_arr;
    }

    public function post_feed() {
        return $this->posts_list(10);
    }

    public function delete() {
        return $this->user->mysql->db_query("DELETE FROM `post` WHERE `post`.`post_id` = $this->post_id");
    }
}

?>