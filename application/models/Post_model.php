<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_post($data)
    {
        $this->db->insert('post', $data);
        return $this->db->insert_id();
    }
    public function get_post_with_user_details($post_id)
    {
        $this->db->select('post.*, users.name as user_name');
        $this->db->from('post');
        $this->db->join('users', 'post.user_id = users.user_id', 'left');
        $this->db->where('post.post_id', $post_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_posts_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get('post');
        return $query->result_array();
    }

    public function delete_post($post_id)
    {
        $this->db->where('post_id', $post_id);
        $this->db->delete('post');
    }

    public function get_friends_posts($user_id)
    {
        $friends = $this->Friend_request_model->get_friends($user_id);


        $friend_ids = array_column($friends, 'user_id');


        $key = array_search($user_id, $friend_ids);
        if ($key !== false) {
            unset($friend_ids[$key]);
        }
        if (empty($friend_ids)) {
            return array();
        }

        $this->db->select('post.*, users.name as user_name, users.profile_picture as friends_post_pro, post.caption as friends_caption, post.image_url as friends_imageurl');
        $this->db->from('post');
        $this->db->join('users', 'post.user_id = users.user_id', 'left');
        $this->db->where_in('post.user_id', $friend_ids);
        $this->db->order_by('post.created_at', 'desc');
        $query = $this->db->get();
        return $query->result_array();
        foreach ($posts as &$post) {
            $post_id = $post['post_id'];
            $comments = $this->Comment_model->get_comments_by_post($post_id);
            $post['comments'] = $comments;
        }

        return $posts;
    }
}
