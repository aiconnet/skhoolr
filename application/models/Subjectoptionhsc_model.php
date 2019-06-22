<?php

class Subjectoptionhsc_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get subject option by id
     */
    function get_student_subject_option_hsc($id)
    {
        return $this->db->get_where('subject_options_hsc', array('id' => $id))->row_array();
    }

    function save_subject_options_hsc($student, $theclass, $stream, $year, $subject, $subjectcode, $paper)
    {
        $query = "INSERT INTO subjectoptions_hsc VALUES('$student','$theclass','$stream','$year', '$subject', '$subjectcode', $paper)";
        $this->db->query($query);
    }

    /*
     * Get all students subject option count
     */
    function get_all_subject_option_count_hsc()
    {
        $this->db->from('subjectoptions_hsc');
        return $this->db->count_all_results();
    }


    function get_all_subjectoption_count_in_stream_hsc()
    {
        //$names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        //$semester = $this->input->post('term');
        //$this->db->where('marks.student', $names);
        $this->db->where('subject_options_hsc.theclass', $theclass);
        $this->db->where('subject_options_hsc.stream', $stream);
        // $this->db->where('marks.term', $semester);
        $this->db->where('subject_options_hsc.theyear', $theyear);
        $this->db->from('subject_options_hsc');
        return $this->db->count_all_results();
    }

    /*
    * Find student id number
    */
    function find_student_id_number_hsc($id)
    {
        return $this->db->get_where('students', array('id' => $id))->row_array();
    }

    /*
     * Get all students subject options
     */
    function get_all_subject_options_hsc($params = array())
    {
        $this->db->order_by('id', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('subject_options_hsc')->result_array();
    }

    /*
     * function to add new student subject_option
     */
    function add_student_subject_option_hsc($params)
    {
        $this->db->insert('subject_options_hsc', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update student subject option
     */
    function update_student_subject_option_hsc($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('subject_options_hsc', $params);
    }

    /*
     * function to delete student subject option
     */
    function delete_student_subject_option_hsc($id)
    {
        return $this->db->delete('subject_options_hsc', array('id' => $id));
    }
}
