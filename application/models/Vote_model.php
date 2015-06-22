<?php

class Vote_model extends CI_Model
{
    const TABLE_NAME = 'votes';

    private $_id;
    private $_user;
    private $_user_id;
    private $_blogpost;
    private $_blogpost_id;
    private $_flag;
    private $_created_at;
    private $_updated_at;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('UserFactory');
        $this->load->library('BlogpostFactory');
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

    public function blogpost_id()
    {
        return $this->_blogpost_id;
    }

    public function set_blogpost_id($value)
    {
        $this->_blogpost_id = intval($value);
    }

    public function flag()
    {
        return $this->_flag;
    }

    public function set_flag($value)
    {
        $this->_flag = (boolean) $value;
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

    public function blogpost()
    {
        if (isset($this->_blogpost_id)) {
            if (is_null($this->_blogpost) || ($this->_blogpost->id() != $this->_blogpost_id)) {
                $this->_blogpost = $this->userfactory->find_by_id($this->_blogpost_id);
                if ($this->_blogpost === false) {
                    $this->_blogpost = null;
                }
            }
        }
        return $this->_blogpost;
    }

    public function save()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'user_id' => $this->_user_id,
            'blogpost_id' => $this->_blogpost_id,
            'flag' => $this->_flag,
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
