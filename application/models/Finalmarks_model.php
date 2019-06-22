<?php

class Finalmark_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get mark by id
     */
    function get_mark($id)
    {
        return $this->db->get_where('full_marks', array('id' => $id))->row_array();
    }

    /*
     * Get all marks count
     */
    function get_all_marks_count()
    {
        $this->db->from('full_marks');
        return $this->db->count_all_results();
    }

    /*
     * Get all marks
     */
    function get_all_marks($params = array())
    {
        $this->db->order_by('id', 'desc');
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('full_marks')->result_array();
    }

    /*
     * function to add new mark
     */
    function add_mark($params)
    {
        $this->db->insert('full_marks', $params);
        return $this->db->insert_id();
    }

    function addhsc_mark($params)
    {
        $this->db->insert('hscmarks', $params);
        return $this->db->insert_id();
    }


    /*
     * function to add new marks in groups of 10
     */
    function add_stream_mark($params)
    {
        $this->db->insert_batch('full_marks', $params);
        return $this->db->insert_id();
    }


    /*function get_student_marks($params = array()){
        {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        
        $this->db->select('*');
		$this->db->from('full_marks');
		$this->db->where(array('full_marks.student' => $names,'full_marks.hisclass' => $theclass,
		'full_marks.stream' => $stream,'full_marks.term' => $semester,'full_marks.theyear' => $theyear));
	
		return $this->db->get()->result_array();

    }*/


    function get_student_final_marks($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$query = $this->db->get('full_marks');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);

        return $this->db->get('full_marks')->result_array();
    }

    function get_student_actual_marks()
    {

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        //$names = $this->input->post('names');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$this->db->select_sum('mark1');
        $query = $this->db->get('full_marks');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $result = $this->db->get('full_marks')->row();
        return $result->average_mark;
    }

    /* function get_student_marks($params=array()){
         if(isset($params) && !empty($params)){
            $this->db->limit($params['limit'], $params['offset']);
        }
          $this->db->select("*");
          $this->db->from('full_marks');
          $query = $this->db->get();
          return $query->result();

    }*/

    /* public function get_student_marks($params=array()) {
        $condition = "studentid =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('full_marks');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get()->result_array();;

        if ($query->num_rows() > 1) {
        return $query->result();
        } else {
        return false;
        }
    }*/

    /*
     * function to update mark
     */
    function update_mark($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('full_marks', $params);
    }

    /*
     * function to delete mark
     */
    function delete_mark($id)
    {
        return $this->db->delete('full_marks', array('id' => $id));
    }

    /*
    * Get total marks
    */
    function get_total_marks()
    {

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select_sum('mark1');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $result = $this->db->get('full_marks')->row();
        return $result->mark1;
    }

    /*
    *Get average marks
    */

    function get_average_marks()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select_avg('mark1');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks')->row();
        return $query->mark1;
        // Produces: SELECT AVG(age) as age FROM members
    }

    /*
    * Get number of subjects offered by student
    */

    function number_of_subjects_offered()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select('subject');
        $this->db->distinct();
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks');
        return $query->num_rows();
    }

   
}
?>
