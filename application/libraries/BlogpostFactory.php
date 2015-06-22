<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BlogpostFactory
{
    private $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->model('Blogpost_model');
    }

    public function all()
    {
        return $this->_ci->db->select('*')->from(Blogpost_model::TABLE_NAME);
    }

    /*
     *
     * @return  Array   An array of Blogpost_model
     */
    public function recent($offset = 0, $limit = 10)
    {
        $blogs = [];
        $query = $this->all()->order_by('created_at', 'DESC')->offset($offset)->limit($limit)->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $blogs[] = $this->_create_from_row($row);
            }
        }
        return $blogs;
    }

    public function find_by($conditions)
    {
        $query = $this->_ci->db->get_where(Blogpost_model::TABLE_NAME, $conditions);
        if ($query->num_rows() > 0) {
            $blogs = [];
            foreach ($query->result() as $row) {
                $blogs[] = $this->_create_from_row($row);
            }
            return count($blogs) == 1 ? $blogs[0] : $blogs;
        }
        return false;
    }

    public function find_by_id($id)
    {
        return $this->find_by(['id' => $id]);
    }

    private function _create_from_row($row)
    {
        $blog = new Blogpost_model();
        $blog->set_id($row->id);
        $blog->set_user_id($row->user_id);
        $blog->set_title($row->title);
        $blog->set_body($row->body);
        $blog->set_created_at($row->created_at);
        $blog->set_updated_at($row->updated_at);
        return $blog;
    }
}
