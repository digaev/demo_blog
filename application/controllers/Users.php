<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    private $_signin_form = [
        'username' => ['name' => 'username', 'label' => 'Username', 'rules' => 'required|max_length[255]'],
        'password' => ['name' => 'password', 'label' => 'Password', 'rules' => 'required']
    ];

    private $_signup_form = [
        'username' => ['name' => 'username', 'label' => 'Username', 'rules' => 'required|trim|xss_clean|max_length[255]|callback_validate_username'],
        'email'    => ['name' => 'email', 'label' => 'Email', 'rules' => 'required|trim|xss_clean|max_length[255]|valid_email|callback_validate_email'],
        'password' => ['name' => 'password', 'label' => 'Password', 'rules' => 'required|matches[password_confirmation]'],
        'password_confirmation' => ['name' => 'password_confirmation', 'label' => 'Password confirmation', 'rules' => 'required'],
        'terms'    => ['name' => 'terms', 'label' => 'I accept terms and conditions', 'rules' => 'callback_validate_terms']
    ];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->library('UserFactory');
        $this->load->library('HttpError');
    }

    public function signin()
    {
        if ($this->session->is_logged === true) {
            redirect(base_url());
            return;
        }

        $data['title'] = 'Sign in';
        $data['form'] = $this->_signin_form;

        if ($this->input->post()) {
            $this->load->library('form_validation');

            foreach ($this->_signin_form as $field_name => $field) {
                $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }

            if ($this->form_validation->run() === true) {
                $user = $this->userfactory->authenticate($this->input->post('username'), $this->input->post('password'));
                if ($user !== false) {
                    $this->_create_session($user);
                    redirect(base_url());
                    return;
                } else {
                    $data['authentication_failed'] = true;
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('users/signin', $data);
        $this->load->view('templates/footer', $data);
    }

    public function signup()
    {
        if ($this->session->is_logged === true) {
            redirect(base_url());
            return;
        }

        $data['title'] = 'Sign up';
        $data['form'] = $this->_signup_form;

        if ($this->input->post()) {
            $this->load->library('form_validation');

            foreach ($this->_signup_form as $field_name => $field) {
                $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }

            if ($this->form_validation->run() === true) {
                $user = new User_model();
                $user->set_email($this->input->post('email'));
                $user->set_username($this->input->post('username'));
                $user->set_password($this->input->post('password'));

                if ($user->save()) {
                    $this->_create_session($user);
                    redirect(base_url());
                    return;
                } else {
                    throw new Exception("Error saving user!");
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('users/signup', $data);
        $this->load->view('templates/footer', $data);
    }

    public function signout()
    {
        if ($this->session->is_logged === true) {
            $this->_destroy_session();
        }
        redirect(base_url());
    }

    public function validate_username($value)
    {
        $user = $this->userfactory->find_by_username_i($value);
        if ($user !== false) {
            $this->form_validation->set_message('validate_username', 'This Username is already taken');
            return false;
        }
        return true;
    }

    public function validate_email($value)
    {
        $user = $this->userfactory->find_by_email_i($value);
        if ($user !== false) {
            $this->form_validation->set_message('validate_email', 'This Email is already taken');
            return false;
        }
        return true;
    }

    public function validate_terms($value)
    {
        if (empty($value)) {
            $this->form_validation->set_message('validate_terms', 'You must accept our terms');
            return false;
        }
        return true;
    }

    private function _create_session($user)
    {
        $this->session->set_userdata([
            'is_logged' => true,
            'user_id' => $user->id(),
            'user_username' => $user->username()
        ]);
    }

    private function _destroy_session()
    {
        $keys = ['is_logged'];
        foreach ($this->session->userdata() as $k => $v) {
            if (strpos($k, 'user_') === 0) {
                $keys[] = $k;
            }
        }
        $this->session->unset_userdata($keys);
    }
}
