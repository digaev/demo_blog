<?php

class User_model extends CI_Model
{
    const TABLE_NAME = 'users';

    private $_id;
    private $_email;
    private $_username;
    private $_password;
    private $_created_at;
    private $_updated_at;

    public function id()
    {
        return $this->_id;
    }

    public function set_id($value)
    {
        $this->_id = intval($value);
    }

    public function email()
    {
        return $this->_email;
    }

    public function set_email($value)
    {
        $this->_email = strval($value);
    }

    public function username()
    {
        return $this->_username;
    }

    public function set_username($value)
    {
        $this->_username = strval($value);
    }

    public function password()
    {
        return $this->_password;
    }

    public function set_password($value, $is_hash = false)
    {
        if (!$is_hash) {
            $value = md5($value);
        }
        $this->_password = strval($value);
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

    public function save()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'email' => $this->_email,
            'username' => $this->_username,
            'password' => $this->_password,
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
