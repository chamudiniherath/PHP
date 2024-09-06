<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Post_model');
    }

    public function create()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->form_validation->set_rules('image_url', 'Image URL', 'required');
        $this->form_validation->set_rules('caption', 'Caption', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('post_create_view');
        } else {
            $data = array(
                'user_id' => $user_id,
                'image_url' => $this->input->post('image_url'),
                'caption' => $this->input->post('caption')
            );
            $post_id = $this->Post_model->create_post($data);
            if ($post_id) {
                redirect('index.php/Login/profile');
            } else {
                $data['error'] = 'Post creation failed';
                $this->load->view('post_create_view', $data);
            }
        }
    }

    public function delete($post_id)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('index.php/Login');
        }
        $post = $this->Post_model->get_post_with_user_details($post_id);
        if (!$post || $post['user_id'] !== $user_id) {
            redirect('index.php/error');
        }
        $this->Post_model->delete_post($post_id);
        redirect('index.php/Login/profile');
    }
}
