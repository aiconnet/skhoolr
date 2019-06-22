<?php

class Subjectoption_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get subject option by id
     */
    function get_student_subject_option($id)
    {
        return $this->db->get_where('subjectoptions', array('id' => $id))->row_array();
    }

    function save_subject_options($student, $theclass, $stream, $year, $subject, $subjectcode)
    {
        $query = "insert into subjectoptions values('$student','$theclass','$stream','$year', '$subject', '$subjectcode')";
        $this->db->query($query);
    }


    /*
     * function to add new student
     */
    function add_option($params)
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
     * Get all students subject option count
     */
    function get_all_subject_option_count()
    {
        $this->db->from('subjectoptions');
        return $this->db->count_all_results();
    }


    function get_all_subjectoption_count_in_stream()
    {
        //$names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        //$semester = $this->input->post('term');

        //$this->db->where('marks.student', $names);
        $this->db->where('students.theclass', $theclass);
        $this->db->where('students.stream', $stream);
        // $this->db->where('marks.term', $semester);
        $this->db->where('students.theyear', $theyear);

        $this->db->from('subjectoptions');
        return $this->db->count_all_results();
    }

    /*
    * Find student id number
    */

    function find_student_id_number($id)
    {
        return $this->db->get_where('students', array('id' => $id))->row_array();
    }

    /*
     * Get all students subject options
     */
    function get_all_subject_options($params = array())
    {
        $this->db->order_by('id', 'desc');
        // if (isset($params) && !empty($params)) {
        //     $this->db->limit($params['limit'], $params['offset']);
        // }
        return $this->db->get('subject_options')->result_array();
    }

    /*
     * function to add new student subject_option
     */
    function add_student_subject_option($params)
    {
        $this->db->insert('subject_options', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update student subject option
     */
    function update_subject_option($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('subject_options', $params);
    }

    /*
     * function to delete student subject option
     */
    function delete_student_subject_option($id)
    {
        return $this->db->delete('subject_options', array('id' => $id));
    }


    function get_subject_option($id)
    {
         $this->db->select('*');
         $this->db->from('subject_options');
         $this->db->where('id', $id);
         return $this->db->get()->row_array();

        // return $this->db->get_where('subject_options', array('id'=>$id))->row_array();
    }

    function get_student($id)
    {
        return $this->db->get_where('students', array('id' => $id))->row_array();
    }


}
