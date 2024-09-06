<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('Register_View');
    }

    public function register_user()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Register_View');
        } else {

            $email = $this->input->post('email');
            $email_exists = $this->User_model->check_email_exists($email);
            if ($email_exists) {
                $data['error'] = 'Email already exists';
                $this->load->view('Register_View', $data);
            } else {

                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $email,
                    'password' => $this->input->post('password')
                );
                $user_id = $this->User_model->create_user($data);
                if ($user_id) {
                    $this->session->set_flashdata('success', 'Account created successfully');
                    redirect('');
                } else {
                    $data['error'] = 'Registration failed';
                    $this->load->view('Register_View', $data);
                }
            }
        }
    }



    public function edit_profile()
    {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('index.php/Login');
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('bio', 'Bio', 'required');
        $this->form_validation->set_rules('profile_picture', 'Profile_Picture', 'required');

        if ($this->form_validation->run() === FALSE) {

            $user = $this->User_model->get_user_by_id($user_id);
            $data['user'] = $user;
            $this->load->view('Update_View', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'bio' => $this->input->post('bio'),
                'profile_picture' => $this->input->post('profile_picture')

            );
            $success = $this->User_model->update_user($user_id, $data);
            if ($success) {
                $this->session->set_flashdata('success', 'Profile updated successfully');
                redirect('index.php/Login/profile');
            } else {
                $data['error'] = 'Failed to update profile';
                $this->load->view('index.php/Login/profile', $data);
            }
        }
    }
}
