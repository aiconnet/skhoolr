<?php

class Subjectoptions_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get subject option by id
     */

    function get_subjectoption($id)
    {
    return $this->db->get_where('subject_options', array('id' => $id))->row_array();
    }

    // function saverecords($fname, $lname, $stream, $year)
    // {
    //     $query = "insert into students values('$fname','$lname','$stream','$year')";
    //     $this->db->query($query);
    // }

    /*
     * Get subject option count for all
     */

    function get_all_subjectoption_count()
    {
        $this->db->from('subject_options');
        return $this->db->count_all_results();
    }


    function get_all_subjectoptions_count_in_stream()
    {
        //$names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        //$semester = $this->input->post('term');

        //$this->db->where('marks.student', $names);
        $this->db->where('subject_options.theclass', $theclass);
        $this->db->where('subject_options.stream', $stream);
        // $this->db->where('marks.term', $semester);
        $this->db->where('subject_options.theyear', $theyear);

        $this->db->from('subject_options');
        return $this->db->count_all_results();
    }

    /*
     * Get all subject options
     */

    function get_all_subjectoptions($params = array())
    {
        $this->db->order_by('id', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('subject_options')->result_array();
    }

    /*
     * function to add new subject option for a student
     */
    function add_subjectoption($params)
    {
        // $q =  $this->db->select($params)->from('students')->get();
        // if ($q->num_rows() == 0) {
        //     $this->db->insert('students', $params);
        //     return $this->db->insert_id();
        // }

        $this->db->insert('subject_options', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update student
     */
    // function update_student($id, $params)
    // {
    //     $this->db->where('id', $id);
    //     return $this->db->update('students', $params);
    // }

    function update_subjectoption($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('subject_options', $params);
    }

    // Delete subject option

    function delete_subjectoption($id)
    {
        return $this->db->delete('subject_options', array('id' => $id));
    }
}
