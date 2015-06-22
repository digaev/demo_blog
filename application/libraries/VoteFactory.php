<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VoteFactory
{
    private $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->model('Vote_model');
    }

    /*
     * Query all items
     *
     * @return object  CodeIgniter's query builder object
     */
    public function all()
    {
        return $this->_ci->db->select('*')->from(Vote_model::TABLE_NAME);
    }

    /*
     * Search item by conditions
     *
     * @param   $conditions     array       An associative array of search conditions
     *
     * @return  FALSE           If no items found
     * @return  array           An array of Vote_model (if multiple records was found)
     * @return  object          An instance of Vote_model (if only one record was found)
     */
    public function find_by($conditions)
    {
        $query = $this->_ci->db->get_where(Vote_model::TABLE_NAME, $conditions);
        if ($query->num_rows() > 0) {
            $items = [];
            foreach ($query->result() as $row) {
                $items[] = $this->_create_from_row($row);
            }
            return count($items) == 1 ? $items[0] : $items;
        }
        return false;
    }

    /*
     * Search item by id
     *
     * @param   $id             int         An id of user
     *
     * @return  FALSE           If no items found
     * @return  array           An array of Vote_model (if multiple records was found)
     * @return  object          An instance of Vote_model (if only one record was found)
     */
    public function find_by_id($id)
    {
        return $this->find_by(['id' => $id]);
    }

    /*
     *
     * @return      FALSE       On fails
     * @return      object      An instance of Vote_model
     */
    public function like($user_id, $blogpost_id)
    {
        $user_id = intval($user_id);
        $blogpost_id = intval($blogpost_id);
        if ($user_id !== 0 && $blogpost_id !== 0) {
            $vote = $this->find_by(['user_id' => $user_id, 'blogpost_id' => $blogpost_id, 'flag' => true]);
            if ($vote === false) {
                $vote = new Vote_model();
                $vote->set_user_id($user_id);
                $vote->set_blogpost_id($blogpost_id);
                $vote->set_flag(true);
                if (!$vote->save()) {
                    return false;
                }
            }
            return $vote;
        }
        return false;
    }

    /*
     * @param   $row          object
     *
     * @return  object        An instance of Vote_model
     */
    private function _create_from_row($row)
    {
        $item = new Vote_model();
        $item->set_id($row->id);
        $item->set_blogpost_id($row->blogpost_id);
        $item->set_flag($row->flag);
        $item->set_created_at($row->created_at);
        $item->set_updated_at($row->updated_at);
        return $item;
    }
}
