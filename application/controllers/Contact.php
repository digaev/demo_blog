<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller
{
    const EMAIL = 'contact@example.com';

    private $_form = [
        'name'    => ['name' => 'name',    'label' => 'Name',    'rules' => 'trim|required|max_length[255]'],
        'email'   => ['name' => 'email',   'label' => 'Email',   'rules' => 'trim|required|max_length[255]|valid_email'],
        'subject' => ['name' => 'subject', 'label' => 'Subject', 'rules' => 'trim|required|max_length[255]'],
        'message' => ['name' => 'message', 'label' => 'Message', 'rules' => 'trim|required|max_length[32768]'],
    ];

	public function index()
    {
        $data['title'] = 'Contact';
        $data['form'] = $this->_form;

        if ($this->input->post()) {
            $this->load->library('form_validation');

            foreach ($this->_form as $field_name => $field) {
                $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }

            if ($this->form_validation->run() === true) {
                $this->load->library('email');

                $this->email->clear();

                $this->email->from($this->input->post('email'), $this->input->post('name'));
                $this->email->to(self::EMAIL);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('message'));

                $data['email_sent'] = $this->email->send();
            }
        }

		$this->load->view('templates/header.php', $data);
		$this->load->view('contact.php', $data);
		$this->load->view('templates/footer.php', $data);
	}
}
