<?php

class Blogpost_model extends CI_Model
{
    const TABLE_NAME = 'blogposts';

    private $_id;
    private $_user;
    private $_user_id;
    private $_title;
    private $_body;
    private $_created_at;
    private $_updated_at;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('UserFactory');
        $this->load->library('VoteFactory');
    }

    public function id()
    {
        return $this->_id;
    }

    public function set_id($value)
    {
        $this->_id = intval($value);
    }

    public function user_id()
    {
        return $this->_user_id;
    }

    public function set_user_id($value)
    {
        $this->_user_id = intval($value);
    }

    public function title()
    {
        return $this->_title;
    }

    public function set_title($value)
    {
        $this->_title = strval($value);
    }

    public function body()
    {
        return $this->_body;
    }

    public function set_body($value)
    {
        $this->_body = strval($value);
    }

    public function created_at($convert_to_time = true)
    {
        return $convert_to_time === true ? strtotime($this->_created_at) : $this->_created_at;
    }

    /*
     * @param   $value      string      A date in format 'Y-m-d H:i:s'
     *
     * This value is ignored in insert/update queries, instead, an actual time is used.
     */
    public function set_created_at($value)
    {
        $this->_created_at = strval($value);
    }

    public function updated_at($convert_to_time = true)
    {
        return $convert_to_time === true ? strtotime($this->_updated_at) : $this->_updated_at;
    }

    /*
     * @param   $value      string      A date in format 'Y-m-d H:i:s'
     *
     * This value is ignored in insert/update queries, instead, an actual time is used.
     */
    public function set_updated_at($value)
    {
        $this->_updated_at = strval($value);
    }

    /*
     *
     * @return      NULL            If no user found
     * @return      User_model      On success
     */
    public function user()
    {
        if (isset($this->_user_id)) {
            if (is_null($this->_user) || ($this->_user->id() != $this->_user_id)) {
                $this->_user = $this->userfactory->find_by_id($this->_user_id);
                if ($this->_user === false) {
                    $this->_user = null;
                }
            }
        }
        return $this->_user;
    }

    /*
     *
     * @return  FALSE       On fails
     * @return  integer     The total count of likes
     */
    public function likes()
    {
        if (empty($this->_id)) {
            return false;
        }
        return $this->votefactory->all()->where(['blogpost_id' => $this->_id, 'flag' => true])->count_all_results();
    }

    /*
     *
     * @return  FALSE       On fails
     * @return  integer     The total count of dislikes
     */
    public function dislikes()
    {
        if (empty($this->_id)) {
            return false;
        }
        return $this->votefactory->all()->where(['blogpost_id' => $this->_id, 'flag' => false])->count_all_results();
    }

    public function save()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'user_id' => $this->_user_id,
            'title' => $this->_title,
            'body' => $this->_body,
            'updated_at' => $now
        ];

        if ($this->_id > 0) {
            if ($this->db->where('id', $this->_id)->update(self::TABLE_NAME, $data)) {
                $this->_updated_at = $now;
                return true;
            }
        } else {
            $data['created_at'] = $now;
            if ($this->db->insert(self::TABLE_NAME, $data)) {
                $this->_id = $this->db->insert_id();
                $this->_created_at = $now;
                $this->_updated_at = $now;
                return true;
            }
        }
        return false;
    }
}
