<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment_model extends CI_Model
{
    public function add_comment($post_id, $user_id, $comment_text)
    {
        $data = array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment_text' => $comment_text
        );
        $this->db->insert('comments', $data);
        return $this->db->insert_id(); 
    }
    public function get_comments_by_post($post_id)
    {
        $this->db->select('comments.*, users.name as commented_user_name');
        $this->db->from('comments');
        $this->db->join('users', 'comments.user_id = users.user_id', 'left');
        $this->db->where('comments.post_id', $post_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function delete_comment($comment_id)
    {
        $this->db->where('comment_id', $comment_id);
        $this->db->delete('comments');
        return $this->db->affected_rows() > 0;
    }
}
