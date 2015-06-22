<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserFactory
{
    private $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->model('User_model');
    }

    /*
     * Query all users
     *
     * @return object  CodeIgniter's query builder object
     */
    public function all()
    {
        return $this->_ci->db->select('*')->from(User_model::TABLE_NAME);
    }

    /*
     * Search user by conditions
     *
     * @param   $conditions     array       An associative array of search conditions
     *
     * @return  FALSE           If no items found
     * @return  array           An array of User_model (if multiple records was found)
     * @return  object          An instance of User_model (if only one record was found)
     */
    public function find_by($conditions)
    {
        $query = $this->_ci->db->get_where(User_model::TABLE_NAME, $conditions);
        if ($query->num_rows() > 0) {
            $users = [];
            foreach ($query->result() as $row) {
                $users[] = $this->_create_from_row($row);
            }
            return count($users) == 1 ? $users[0] : $users;
        }
        return false;
    }

    /*
     * Search user by id
     *
     * @param   $id             int         An id of user
     *
     * @return  FALSE           If no items found
     * @return  array           An array of User_model (if multiple records was found)
     * @return  object          An instance of User_model (if only one record was found)
     */
    public function find_by_id($id)
    {
        return $this->find_by(['id' => $id]);
    }

    /*
     * Case-insensitive search user by email
     *
     * @param   $value          string
     *
     * @return  FALSE           If no user found
     * @return  object          An instance of User_model
     */
    public function find_by_email_i($value)
    {
        $sql = 'SELECT * FROM "' . User_model::TABLE_NAME . '" WHERE LOWER(email) = LOWER(?)';
        $query = $this->_ci->db->query($sql, [strval($value)]);
        return $query->num_rows() > 0 ? $this->_create_from_row($query->first_row()) : false;
    }

    /*
     * Case-insensitive search user by username
     *
     * @param   $value          string
     *
     * @return  FALSE           If no user found
     * @return  object          An instance of User_model
     */
    public function find_by_username_i($value)
    {
        $sql = 'SELECT * FROM "' . User_model::TABLE_NAME . '" WHERE LOWER(username) = LOWER(?)';
        $query = $this->_ci->db->query($sql, [strval($value)]);
        return $query->num_rows() > 0 ? $this->_create_from_row($query->first_row()) : false;
    }

    /*
     * Checks the pair username and password.
     *
     * @param   $username       string       A username
     * @param   $password       string       A pure password(unencrypted)
     *
     * @return  FALSE       If no user found
     * @return  object      An instance of User_model
     */
    public function authenticate($username, $password)
    {
        $sql = 'SELECT * FROM "' . User_model::TABLE_NAME . '" WHERE LOWER(username) = LOWER(?) AND password = ?';
        $query = $this->_ci->db->query($sql, [strval($username), md5($password)]);
        return $query->num_rows() > 0 ? $this->_create_from_row($query->first_row()) : false;
    }

    /*
     * @param   $row          object
     *
     * @return  object        An instance of User_model
     */
    private function _create_from_row($row)
    {
        $user = new User_model();
        $user->set_id($row->id);
        $user->set_username($row->username);
        $user->set_password($row->password, true);
        $user->set_created_at($row->created_at);
        $user->set_updated_at($row->updated_at);
        return $user;
    }
}
