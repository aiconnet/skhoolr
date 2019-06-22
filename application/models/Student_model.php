<?php

class Student_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get student by id
     */
    function get_student($id)
    {
        return $this->db->get_where('students', array('id' => $id))->row_array();
    }

    function saverecords($fname, $lname, $stream, $year)
    {
        $query = "insert into students values('$fname','$lname','$stream','$year')";
        $this->db->query($query);
    }

    /*
     * Get all students count
     */
    function get_all_students_count()
    {
        $this->db->from('students');
        return $this->db->count_all_results();
    }


    function get_all_students_count_in_stream()
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

        $this->db->from('students');
        return $this->db->count_all_results();
    }

    /*
     * Get all students
     */
    function get_all_students($params = array())
    {
        $this->db->order_by('id', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('students')->result_array();
    }

    /*
     * function to add new student
     */
    function add_student($params)
    {
        // $q =  $this->db->select($params)->from('students')->get();
        // if ($q->num_rows() == 0) {
        //     $this->db->insert('students', $params);
        //     return $this->db->insert_id();
        // }

        $this->db->insert('students', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update student
     */
    function update_student($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('students', $params);
    }


    /*
     * function to update student
     */
    function upload_photo($id, $params)
    {
        //$this->db->where('id', $id);
        //return $this->db->update('students', $params);
    }

    /*
     * function to delete student
     */
    function delete_student($id)
    {
        return $this->db->delete('students', array('id' => $id));
    }
}
