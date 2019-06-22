<?php


class Teacher_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get teacher by id
     */
    function get_teacher($id)
    {
        return $this->db->get_where('teachers', array('id' => $id))->row_array();
    }

    /*
     * Get all teachers
     */
    function get_all_teachers()
    {
        $this->db->order_by('id', 'asc');
        return $this->db->get('teachers')->result_array();
    }

    /*
     * function to add new teacher
     */
    function add_teacher($params)
    {
        $this->db->insert('teachers', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update teacher
     */
    function update_teacher($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('teachers', $params);
    }

    /*
     * function to delete teacher
     */
    function delete_teacher($id)
    {
        return $this->db->delete('teachers', array('id' => $id));
    }
}
