<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Friend_request_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function send_request($sender_id, $receiver_id)
    {
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending'
        );
        $this->db->insert('friend_requests', $data);
        return $this->db->insert_id();
    }

    public function get_received_requests($user_id)
    {
        $this->db->where('receiver_id', $user_id);
        $this->db->where('status', 'pending');
        $query = $this->db->get('friend_requests');
        return $query->result_array();
    }

    public function accept_request($request_id)
    {
        $this->db->set('status', 'accepted');
        $this->db->where('request_id', $request_id);
        $this->db->update('friend_requests');
    }

    public function decline_request($request_id)
    {
        $this->db->set('status', 'declined');
        $this->db->where('request_id', $request_id);
        $this->db->update('friend_requests');
    }

    public function cancel_request($request_id)
    {
        $this->db->set('status', 'cancelled');
        $this->db->where('request_id', $request_id);
        $this->db->update('friend_requests');
    }


    public function get_request_with_names($request_id)
    {
        $this->db->select('friend_requests.*, sender.name as sender_name, sender.profile_picture as sender_profile_picture, receiver.name as receiver_name');
        $this->db->from('friend_requests');
        $this->db->join('users as sender', 'friend_requests.sender_id = sender.user_id', 'left');
        $this->db->join('users as receiver', 'friend_requests.receiver_id = receiver.user_id', 'left');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_friends($user_id)
    {
        $this->db->select('users.*, friend_requests.status');
        $this->db->from('friend_requests');
        $this->db->join('users', '(friend_requests.sender_id = users.user_id OR friend_requests.receiver_id = users.user_id)', 'inner');
        $this->db->where('friend_requests.status', 'accepted');
        $this->db->group_start();
        $this->db->where('friend_requests.sender_id', $user_id);
        $this->db->or_where('friend_requests.receiver_id', $user_id);
        $this->db->group_end();
        $this->db->where('users.user_id !=', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_users_excluding_requests($user_id)
    {
        $this->db->select('*', 'profile_picture');
        $this->db->from('users');
        $this->db->where('user_id !=', $user_id);
        $this->db->where_not_in('user_id', "SELECT sender_id FROM friend_requests WHERE receiver_id = $user_id AND status = 'pending'", false);
        $this->db->where_not_in('user_id', "SELECT receiver_id FROM friend_requests WHERE sender_id = $user_id AND status = 'pending'", false);
        $this->db->where_not_in('user_id', "SELECT CASE 
                                                WHEN sender_id = $user_id THEN receiver_id 
                                                ELSE sender_id 
                                               END AS friend_id 
                                               FROM friend_requests 
                                               WHERE (sender_id = $user_id OR receiver_id = $user_id) 
                                               AND status = 'accepted'", false);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function unfriend($user_id, $receiver_id)
    {
        $this->db->set('status', 'declined');
        $this->db->where('(sender_id = ' . $user_id . ' AND receiver_id = ' . $receiver_id . ') OR (sender_id = ' . $receiver_id . ' AND receiver_id = ' . $user_id . ')');
        $this->db->update('friend_requests');
    }

    public function get_sent_requests($user_id)
    {
        $this->db->select('friend_requests.*, users.name as receiver_name, users.profile_picture as receiver_profile_picture');
        $this->db->from('friend_requests');
        $this->db->join('users', 'friend_requests.receiver_id = users.user_id', 'left');
        $this->db->where('sender_id', $user_id);
        $this->db->where('status', 'pending');
        $query = $this->db->get();
        return $query->result_array();
    }
}
