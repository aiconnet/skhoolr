<?php

class Subject_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get subject by id
     */
    function get_subject($id)
    {
        return $this->db->get_where('subjects', array('id' => $id))->row_array();
    }

    function get_subject_code($subjectcode)
    {
        $this->db->where('subjectcode', $subjectcode);
        $query = $this->db->get('subjects')->row_array();
        return $query;
        //return $this->db->get_where('subjects', array('subjectcode' => $subjectcode))->row_array();
    }

    /*
     * Get all subjects count
     */
    function get_all_subjects_count()
    {
        $this->db->from('subjects');
        return $this->db->count_all_results();
    }

    /*
     * Get all subjects
     */
    function get_all_subjects($params = array())
    {
        $this->db->order_by('id', 'asc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('subjects')->result_array();
    }

    function get_subjects_code($params = array())
    {
        $this->db->order_by('id', 'asc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('subjects')->result_array();
    }


    /*
     * Get all subjects with no repition
     */
    function get_subjects_for_drop_down($params = array())
    {
        $this->db->order_by('id', 'asc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('subjectlist')->result_array();
    }

    /*
     * function to add new subject
     */
    function add_subject($params)
    {
        $this->db->insert('subjects', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update subject
     */
    function update_subject($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('subjects', $params);
    }

    function get_teacher($id)
    {
        return $this->db->get_where('marks', array('id' => $id))->row_array();
    }

    /*
     * function to delete subject
     */
    function delete_subject($id)
    {
        return $this->db->delete('subjects', array('id' => $id));
    }
}
