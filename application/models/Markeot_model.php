<?php

class Markeot_model extends CI_Model
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
        return $this->db->get_where('markseot', array('id' => $id))->row_array();
    }

    /*
     * Get all marks count
     */
    function get_all_marks_count()
    {
        $this->db->from('markseot');
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
        return $this->db->get('markseot')->result_array();
    }

    /*
     * function to add new mark
     */
    function add_mark($params)
    {
        $this->db->insert('markseot', $params);
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
        $this->db->insert_batch('markseot', $params);
        return $this->db->insert_id();
    }


    /*function get_student_marks($params = array()){
        {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $this->db->select('*');
		$this->db->from('marks');
		$this->db->where(array('marks.student' => $names,'marks.hisclass' => $theclass,
		'marks.stream' => $stream,'marks.term' => $semester,'marks.theyear' => $theyear));

		return $this->db->get()->result_array();

    }*/


    function get_student_marks($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$query = $this->db->get('marks');
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);

        return $this->db->get('markseot')->result_array();
    }
    
    
        function get_student_marks_eot($params = array()){
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$query = $this->db->get('marks');
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);

        return $this->db->get('markseot')->result_array();
    }
    
   /* function get_student_marks_eot($params = array()){
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');
        
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        
        $this->db->select('marks.subject, marks.mark1, markseot.mark1, marks.subjectteacher');
        $this->db->from('marks');
        $this->db->join('markseot','markseot.student=marks.student','inner' AND 'markseot.theclass=marks.theclass','inner' 
        && 'markseot.theyear=marks.theyear','inner' && 'markseot.stream = marks.stream','inner' && 'markseot.term=marks.term','inner');
        $query=$this->db->get()->result_array();
        
    }*/
    
   
    function get_student_actual_marks()
    {

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        //$names = $this->input->post('names');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$this->db->select_sum('mark1');
        $query = $this->db->get('markseot');
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $result = $this->db->get('markseot')->row();
        return $result->mark1;
    }

    /* function get_student_marks($params=array()){
         if(isset($params) && !empty($params)){
            $this->db->limit($params['limit'], $params['offset']);
        }
          $this->db->select("*");
          $this->db->from('marks');
          $query = $this->db->get();
          return $query->result();

    }*/

    /* public function get_student_marks($params=array()) {
        $condition = "studentid =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('marks');
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
        return $this->db->update('markseot', $params);
    }

    /*
     * function to delete mark
     */
    function delete_mark($id)
    {
        return $this->db->delete('markseot', array('id' => $id));
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
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);
        $result = $this->db->get('markseot')->row();
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
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);
        $query = $this->db->get('markseot')->row();
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

        $this->db->select('subject_options');
        $this->db->distinct();
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);
        $query = $this->db->get('markseot');
        return $query->num_rows();
    }

    /*
    *  Create temporal table for positioning students
    */

    function create_temporal_table($table)
    {
        $table = "student_positions";
        $sql = "CREATE TABLE " . $table . " (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      student VARCHAR(30) NOT NULL,
      studentid VARCHAR(30) NOT NULL,
      subject VARCHAR(30) NOT NULL,
      marks VARCHAR(50),
      position VARCHAR(50),
      theclass VARCHAR(50),
      stream VARCHAR(50),
      term VARCHAR(50),
      theyear VARCHAR(50),
      reg_date TIMESTAMP
      )";
        $query = $this->db->query($sql);
        return $query;
    }
}
