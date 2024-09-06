<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function create_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    public function get_user_by_email($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->row_array();
    }
    public function get_user_by_id($user_id)
    {
        $query = $this->db->get_where('users', array('user_id' => $user_id));
        return $query->row_array();
    }
    public function get_users_excluding_requests($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id !=', $user_id);
        $this->db->where_not_in('user_id', "SELECT sender_id FROM friend_requests WHERE receiver_id = $user_id AND status = 'pending'", false);
        $this->db->where_not_in('user_id', "SELECT receiver_id FROM friend_requests WHERE sender_id = $user_id AND status = 'pending'", false);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function update_user($user_id, $data)
{
    $this->db->where('user_id', $user_id);
    $this->db->update('users', $data);
    return $this->db->affected_rows() > 0;
}

public function check_email_exists($email) {
    $this->db->where('email', $email);
    $query = $this->db->get('users');
    return $query->num_rows() > 0;
}

}
