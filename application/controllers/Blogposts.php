<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogposts extends CI_Controller
{
    const POSTS_PER_PAGE = 2;

    private $_new_form = [
        'title' => ['name' => 'title', 'label' => 'Title', 'rules' => 'required|max_length[255]'],
        'body' => ['name' => 'body', 'label' => 'Body', 'rules' => 'required|max_length[65536]']
    ];

    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('UserFactory');
        $this->load->library('BlogpostFactory');
        $this->load->library('VoteFactory');
        $this->load->library('HttpError');
    }

	public function index($page = 1)
    {
        $data['title'] = 'Home';
        $data['blogposts'] = $this->blogpostfactory->recent(self::POSTS_PER_PAGE * ($page - 1), self::POSTS_PER_PAGE);

        $this->load->library('pagination');
        $this->pagination->initialize([
            'base_url' => base_url(),
            'total_rows' => $this->blogpostfactory->all()->count_all_results(),
            'per_page' => self::POSTS_PER_PAGE,
            'use_page_numbers' => true,
            'prefix' => 'page/',
            'full_tag_open' => '<ul class="pagination">',
            'full_tag_close' => '</ul>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a>',
            'cur_tag_close' => '</a></li>',
            'next_tag_open' => '<li>',
            'next_tagl_close' => '</li>',
            'prev_tag_open' => '<li>',
            'prev_tagl_close' => '</li>',
            'first_tag_open' => '<li>',
            'first_tagl_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tagl_close' => '</li>'
        ]);

		$this->load->view('templates/header', $data);
		$this->load->view('blogposts/index', $data);
		$this->load->view('templates/footer', $data);
    }

    public function create()
    {
        if ($this->session->is_logged !== true) {
            $this->httperror->show(401);
            return;
        }

        $data['title'] = 'New article';
        $data['form'] = $this->_new_form;

        if ($this->input->post()) {
            foreach ($this->_new_form as $field_name => $field) {
                $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }

            if ($this->form_validation->run() === true) {
                $blogpost = new Blogpost_model();
                $blogpost->set_user_id($this->session->user_id);
                $blogpost->set_title($this->input->post('title'));
                $blogpost->set_body($this->input->post('body'));
                if ($blogpost->save()) {
                    redirect(base_url('blogposts/' . $blogpost->id()));
                    return;
                } else {
                    throw new Exception('Unable to save new blog');
                }
            }
        }

		$this->load->view('templates/header', $data);
		$this->load->view('blogposts/create', $data);
		$this->load->view('templates/footer', $data);
    }

    public function show($id)
    {
        $blogpost = $this->blogpostfactory->find_by_id($id);
        if ($blogpost === false) {
            $this->httperror->show(404);
            return;
        }

        $data['title'] = $blogpost->title();
        $data['blogpost'] = $blogpost;

		$this->load->view('templates/header', $data);
		$this->load->view('blogposts/show', $data);
		$this->load->view('templates/footer', $data);
    }

    public function like()
    {
        if ($this->session->is_logged !== true) {
            $this->httperror->show(401);
            return;
        }

        $this->form_validation->set_rules('blogpost_id', '', 'required|integer');
        if ($this->form_validation->run() !== true) {
            $this->httperror->show(400);
            return;
        }

        $blogpost_id = $this->input->post('blogpost_id');
        if (is_null($blogpost_id)) {
            $this->httperror->show(405);
            return;
        }

        $blogpost = $this->blogpostfactory->find_by_id($blogpost_id);
        if ($blogpost === false) {
            $this->httperror->show(400);
            return;
        }

        if ($this->votefactory->like($this->session->user_id, $blogpost_id) === false) {
            throw new Exception('Error vote for blogpost');
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'blogpost_id' => $blogpost->id(),
            'likes' => $blogpost->likes()
        ]));
    }
}
