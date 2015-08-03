<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kavinga
 * Date: 10/27/13
 * Time: 8:53 AM
 * To change this template use File | Settings | File Templates.
 */
class My_Model extends CI_Model
{
    protected $_table;
    protected $_key;

    function __construct()
    {
        parent::__construct();
    }


    function load($id)
    {
        $query = $this->db->get_where($this->_table, array($this->_key => $id));
        $data = $query->first_row();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    function getData($key = '*')
    {
        if (isset($this->$key)) {
            return $this->$key;
        } else {
            return null;
        }
    }

    function getValue($key)
    {
        return $this->getData($key);
    }

    function openId($id)
    {
        return $this->load($id);
    }

    function get($fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {

        $this->db->select($fields);
        $this->db->from($this->_table);
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = !$one ? $query->result($array) : $query->row();
        return $result;
    }

    function add($data)
    {
        $this->db->insert($this->_table, $data);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }

        return FALSE;
    }

    function edit($data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($this->_table, $data);

        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        }

        return FALSE;
    }

    function delete($fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($this->_table);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }

        return FALSE;
    }

    function count($table)
    {
        return $this->db->count_all($this->_table);
    }

    function getCollection(){
        return $this->db->get($this->_table)->result(get_class($this));
    }
}