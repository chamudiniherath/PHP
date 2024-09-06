<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->model('Post_model');
        $this->load->model('Friend_request_model');
        $this->load->model('Comment_model');
    }
    public function index()
    {
        $this->load->view('Login_View');
    }

    public function login_user()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Login_View');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->User_model->get_user_by_email($email);
            if ($user && $password === $user['password']) {
                $this->session->set_userdata('user_id', $user['user_id']);
                redirect('index.php/Login/dashboard');
            } else {
                $data['error'] = 'Invalid email or password';
                $this->load->view('Login_View', $data);
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        redirect('index.php/Login');
    }

    public function dashboard()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $logged_in_user = $this->User_model->get_user_by_id($user_id);
        $posts = $this->Post_model->get_posts_by_user($user_id);
        $received_requests = $this->Friend_request_model->get_received_requests($user_id);
        $other_users = $this->Friend_request_model->get_users_excluding_requests($user_id);
        $friends = $this->Friend_request_model->get_friends($user_id);
        $sent_requests = $this->Friend_request_model->get_sent_requests($user_id);
        $friends_posts = $this->Post_model->get_friends_posts($user_id);

        foreach ($friends_posts as &$post) {
            $post_id = $post['post_id'];
            $comments = $this->Comment_model->get_comments_by_post($post_id);
            $post['comments'] = $comments;
        }

        foreach ($received_requests as &$request) {
            $sender_id = $request['sender_id'];
            $sender = $this->User_model->get_user_by_id($sender_id);
            $request['sender_name'] = $sender['name'];
            $request['sender_profile_picture'] = $sender['profile_picture'];
        }

        $data['posts'] = $posts;
        $data['logged_in_user'] = $logged_in_user;
        $data['received_requests'] = $received_requests;
        $data['other_users'] = $other_users;
        $data['friends'] = $friends;
        $data['sent_requests'] = $sent_requests;
        $data['friends_posts'] = $friends_posts;
        $this->load->view('Dashboard_View', $data);
    }
    public function profile()

    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $user = $this->User_model->get_user_by_id($user_id);
        $posts = $this->Post_model->get_posts_by_user($user_id);
        $this->load->model('Comment_model');
        foreach ($posts as &$post) {
            $post['comments'] = $this->Comment_model->get_comments_by_post($post['post_id']);
        }
        $friends = $this->Friend_request_model->get_friends($user_id);
        $friendCount = count($friends);
        $data['user'] = $user;
        $data['posts'] = $posts;
        $data['friendCount'] = $friendCount;
        $this->load->view('Profile_View', $data);
    }
    public function delete_post($post_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->load->model('Post_model');
        $this->Post_model->delete_post($post_id);
        redirect('index.php/Login/profile');
    }

    public function send_friend_request($receiver_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->Friend_request_model->send_request($user_id, $receiver_id);
        redirect('index.php/Login/dashboard');
    }


    public function receive_friend_requests()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $requests = $this->User_model->get_received_friend_requests($user_id);
    }

    public function accept_friend_request($request_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->Friend_request_model->accept_request($request_id);
        redirect('index.php/Login/dashboard');
    }


    public function decline_request($request_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->Friend_request_model->decline_request($request_id);
        redirect('index.php/Login/dashboard');
    }

    public function unfriend($receiver_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->Friend_request_model->unfriend($user_id, $receiver_id);

        redirect('index.php/Login/dashboard');
    }

    public function sent_friend_requests()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $sent_requests = $this->Friend_request_model->get_sent_requests($user_id);
        $data['sent_requests'] = $sent_requests;
        $this->load->view('sent_requests_view', $data);
    }

    public function cancel_request($request_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->Friend_request_model->cancel_request($request_id);
        redirect('index.php/Login/dashboard');
    }



    public function delete_comment($comment_id)
    {
        $this->load->model('Comment_model');
        $deleted = $this->Comment_model->delete_comment($comment_id);
        if ($deleted) {
            redirect('index.php/Login/profile');
        } else {
            echo "Failed to delete comment.";
        }
    }
    public function add_comment()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->form_validation->set_rules('comment_text', 'Comment', 'required');
        $this->form_validation->set_rules('post_id', 'Post ID', 'required|integer');
        if ($this->form_validation->run() === FALSE) {
            redirect('index.php/Login/dashboard');
        } else {
            $post_id = $this->input->post('post_id');
            $comment_text = $this->input->post('comment_text');
            $this->load->model('Comment_model');
            $comment_id = $this->Comment_model->add_comment($post_id, $user_id, $comment_text);
            if ($comment_id) {
                redirect('index.php/Login/dashboard');
            } else {
                echo "Failed to add comment.";
            }
        }
    }
}
