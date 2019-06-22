<?php

class Realclass_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get realclass by id
     */
    function get_realclass($id)
    {
        return $this->db->get_where('realclasses', array('id' => $id))->row_array();
    }

    /*
     * Get all realclasses
     */
    function get_all_realclasses()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('realclasses')->result_array();
    }

    /*
     * function to add new realclass
     */
    function add_realclass($params)
    {
        $this->db->insert('realclasses', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update realclass
     */
    function update_realclass($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('realclasses', $params);
    }

    /*
     * function to delete realclass
     */
    function delete_realclass($id)
    {
        return $this->db->delete('realclasses', array('id' => $id));
    }
}
