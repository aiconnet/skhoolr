<?php

class Mark_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->load->dbforge();
    }
    /*
     * Get mark by id
     */
    function get_mark($id)
    {
        return $this->db->get_where('marks', array('id' => $id))->row_array();
    }

    /*
     * Get all marks count
     */
    function get_all_marks_count()
    {
        $this->db->from('marks');
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
        return $this->db->get('marks')->result_array();
    }

    /*
     * function to add new mark
     */
    function add_mark($params)
    {
        $q =  $this->db->select($params)->from('marks')->get();
        if ($q->num_rows() == 0) {
            //insert goes here
            $this->db->insert('marks', $params);
            return $this->db->insert_id();
        }
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
        $q =  $this->db->select($params)->from('marks')->get();
        if ($q->num_rows() == 0) {
            //insert goes here
            $this->db->insert_batch('marks', $params);
            return $this->db->insert_id();
        }
    }


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

        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);

        return $this->db->get('marks')->result_array();
    }

    function get_student_marks_bot($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
    }

    function get_student_marks_full($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
    }

    //BEST EIGHT MARKS
    function get_student_best_eight_marks_bot_only($params = array())
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

        $this->db->order_by('mark1', 'desc');
        $this->db->limit(8);

        //return $this->db->get('full_marks')->result_array();
        return $this->db->get('marks')->result_array();
    }


    function get_student_best_eight_marks_eot_only($params = array())
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
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);

        $this->db->order_by('mark1', 'desc');
        $this->db->limit(8);

        //return $this->db->get('full_marks')->result_array();
        return $this->db->get('markseot')->result_array();
    }

    function get_student_best_eight_marks_full($params = array())
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
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);

        $this->db->order_by('average_mark', 'desc');
        $this->db->limit(8);

        return $this->db->get('full_marks')->result_array();
    }

    /*
    * Get best eight marks End of term only
    */
    function best_eight_total_mark()
    {

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select('mark1');
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);
        //$this->db->from('markseot');
        $this->db->order_by('mark1', 'desc');
        $this->db->limit(8);
        //$this->db->get();
        $result = $this->db->get('markseot')->result_array();
        //return $this->db->get('markseot')->result_array();
        return $result->mark1;
    }


    //GET MARKS SECTION
    function get_student_marks_eot_only($params = array())
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
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);

        //return $this->db->get('full_marks')->result_array();
        return $this->db->get('markseot')->result_array();
    }

    //NUMBER OF SUBJECTS OFFERED
    function get_num_of_subjects_student_offers($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);

        return $this->db->get('markseot')->num_rows();
    }

    //STUDENT ACTUAL MARKS
    function get_student_actual_marks()
    {

        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        //$names = $this->input->post('names');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //$this->db->select_sum('mark1');
        $query = $this->db->get('marks');
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $result = $this->db->get('marks')->row();
        return $result->mark1;
    }
    function get_student_actual_marks_eot_only()
    { }

    function get_student_actual_marks_full()
    { }

    /*
     * function to update mark
     */
    function update_mark($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('marks', $params);
    }

    function update_mark_eot($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('marks', $params);
    }
    function update_mark_full($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('marks', $params);
    }

    /*
     * function to delete mark
     */
    function delete_mark($id)
    {
        return $this->db->delete('marks', array('id' => $id));
    }
    function delete_mark_eot($id)
    {
        return $this->db->delete('marks', array('id' => $id));
    }
    function delete_mark_full($id)
    {
        return $this->db->delete('marks', array('id' => $id));
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
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $result = $this->db->get('marks')->row();
        return $result->mark1;
    }

    /*
    * Get total marks End of term only
    */
    function get_total_marks_eot_only()
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
    * Get total marks full term only
    */
    function get_total_marks_full()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select_sum('average_mark');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $result = $this->db->get('full_marks')->row();
        return $result->average_mark;
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
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $query = $this->db->get('marks')->row();
        return $query->mark1;
        // Produces: SELECT AVG(age) as age FROM members
    }

    function get_average_marks_eot_only()
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
        // Produces: SELECT AVG(age) as age FROM marks
    }

    function get_average_marks_full()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select_avg('average_mark');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks')->row();
        return $query->average_mark;
    }


    function get_student_full_marks($params = array())
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

    /*
    * Get number of students in a stream
    */

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
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $query = $this->db->get('marks');
        return $query->num_rows();
    }

    function number_of_subjects_offered_eot_only()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->select('subject');
        $this->db->distinct();
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);
        $query = $this->db->get('markseot');
        return $query->num_rows();
    }

    function number_of_subjects_offered_full()
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

    /* Finding student positions */
    //BOT VIEW
    function rank_students($params = array())
    {

        if ($this->db->table_exists('TotalMarksTbl')) {
            if ($this->db->table_exists('rankingssTbl')) {
                $this->db->where('rankingsTbl.student', $names);
                $this->db->where('rankingsTbl.hisclass', $theclass);
                $this->db->where('rankingsTbl.stream', $stream);
                // $this->db->where('rankingsTbl.term', $semester);
                $this->db->where('rankingsTbl.theyear', $theyear);
                $result = $this->db->get('rankingsTbl')->row();
                return $result->rank;
            } else {

                $sql2 = "CREATE VIEW rankingsTbl
                as SELECT student, hisclass, stream, theyear, total,
                RANK() OVER(ORDER BY total DESC) as 'rank' FROM TotalMarksTbl
                WHERE `hisclass ` ='$theclass' and `stream `= '$stream'
                GROUP BY student,hisclass,stream, theyear";

                return $this->db->query($sql2);

                $this->db->where('rankingsTbl.student', $names);
                $this->db->where('rankingsTbl.hisclass', $theclass);
                $this->db->where('rankingsTbl.stream', $stream);
                // $this->db->where('rankingsTbl.term', $semester);
                $this->db->where('rankingsTbl.theyear', $theyear);
                $result = $this->db->get('rankingsTbl')->row();
                return $result->rank;
            }
        } else {

            $names = $this->input->post('student');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $sql = "CREATE VIEW TotalMarksTbl
            AS SELECT student, hisclass, stream, theyear,
            SUM(mark1) AS total FROM marks GROUP BY student, hisclass, stream, theyear";

            return $this->db->query($sql);

            $sql2 = "CREATE VIEW rankingsTbl
            as SELECT student, hisclass, stream, theyear, total,
            RANK() OVER(ORDER BY total DESC) as 'rank' FROM TotalMarksTbl
            WHERE `hisclass ` ='$theclass' and `stream `= '$stream'
            GROUP BY student,hisclass,stream, theyear";

            return $this->db->query($sql2);

            $this->db->where('rankingsTbl.student', $names);
            $this->db->where('rankingsTbl.hisclass', $theclass);
            $this->db->where('rankingsTbl.stream', $stream);
            // $this->db->where('rankingsTbl.term', $semester);
            $this->db->where('rankingsTbl.theyear', $theyear);
            $result = $this->db->get('rankingsTbl')->row();
            return $result->rank;
        }
    }

    //Create view (Table) BOT
    function create_view_bot()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);

        //Unique name for table
        $unique_tbl_name = 'rankingstbl_bot' . $lastch_class . $stream . $lastch_term . $theyear;

        // if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {

        //echo "Table { $unique_tbl_name} does not exist";
        $sql2 = "CREATE TABLE   $unique_tbl_name AS SELECT student, hisclass, stream, term, theyear, SUM(mark1),
            RANK() OVER(ORDER BY SUM(mark1) DESC) as student_rank FROM marks
            WHERE `hisclass` ='$theclass' and `stream`= '$stream'
            GROUP BY student, hisclass, stream, term, theyear";

        return $this->db->query($sql2);
    }


    //Create view (Table) BOT
    function create_view_eot()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);
        //Unique name for table
        $unique_tbl_name = 'rankingstbl_eot' . $lastch_class . $stream . $lastch_term . $theyear;
        // if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
        //echo "Table { $unique_tbl_name} does not exist";
        $sql2 = "CREATE TABLE   $unique_tbl_name AS SELECT student, hisclass, stream, term, theyear, SUM(mark1),
            RANK() OVER(ORDER BY SUM(mark1) DESC) as student_rank FROM markseot
            WHERE `hisclass` ='$theclass' and `stream`= '$stream'
            GROUP BY student, hisclass, stream, term, theyear";

        return $this->db->query($sql2);
    }

    //Create view (Table) FULL
    function create_view_full()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);
        //Unique name for table
        $unique_tbl_name = 'rankingstbl_full' . $lastch_class . $stream . $lastch_term . $theyear;
        // if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
        //echo "Table { $unique_tbl_name} does not exist";
        $sql2 = "CREATE TABLE   $unique_tbl_name AS SELECT student, hisclass, stream, term, theyear, SUM(mark1),
            RANK() OVER(ORDER BY SUM(average_mark) DESC) as student_rank FROM full_marks
            WHERE `hisclass` ='$theclass' and `stream`= '$stream'
            GROUP BY student, hisclass, stream, term, theyear";

        return $this->db->query($sql2);
    }

    //Create view (Table) EOT
    function create_view()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);

        //Unique name for table
        $unique_tbl_name = 'rankingstbl' . $lastch_class . $stream . $lastch_term . $theyear;

        // if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {

        //echo "Table { $unique_tbl_name} does not exist";
        $sql2 = "CREATE TABLE   $unique_tbl_name AS SELECT student, hisclass, stream, term, theyear, SUM(mark1),
            RANK() OVER(ORDER BY SUM(mark1) DESC) as student_rank FROM markseot
            WHERE `hisclass` ='$theclass' and `stream`= '$stream'
            GROUP BY student,hisclass,stream, term, theyear";

        return $this->db->query($sql2);
    }

    //find student's position (BOT)
    function position_by_total_bot($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limi t'], $params['offset']);
        }
        // Find positions
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);

        //Unique name for table
        $unique_tbl_name = 'rankingstbl_bot' . $lastch_class . $stream . $lastch_term . $theyear;

        // $query = $this->db->query("SELECT student,hisclass,stream,term,theyear,student_rank
        //   FROM rankingstbl WHERE `student`= '$names' AND `hisclass`= '$theclass' AND `stream`= '$stream' AND
        //   `term`= '$semeste r' AND `theyear`= '$theyear'");

        //Seek student position
        $this->db->where($unique_tbl_name . '.' . 'student', $names);
        $this->db->where($unique_tbl_name . '.' . 'hisclass', $theclass);
        $this->db->where($unique_tbl_name . '.' . 'stream', $stream);
        $this->db->where($unique_tbl_name . '.' . 'term', $semester);
        $this->db->where($unique_tbl_name . '.' . 'theyear', $theyear);
        $query = $this->db->get($unique_tbl_name)->row();
        return $query->student_rank;
    }


    //find student's position(EOT)

    function position_by_total_eot($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limi t'], $params['offset']);
        }
        // Find positions
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);

        //Unique name for table
        $unique_tbl_name = 'rankingstbl_eot' . $lastch_class . $stream . $lastch_term . $theyear;

        // $query = $this->db->query("SELECT student,hisclass,stream,term,theyear,student_rank
        //   FROM rankingstbl WHERE `student`= '$names' AND `hisclass`= '$theclass' AND `stream`= '$stream' AND
        //   `term`= '$semeste r' AND `theyear`= '$theyear'");

        //Seek student position
        $this->db->where($unique_tbl_name . '.' . 'student', $names);
        $this->db->where($unique_tbl_name . '.' . 'hisclass', $theclass);
        $this->db->where($unique_tbl_name . '.' . 'stream', $stream);
        $this->db->where($unique_tbl_name . '.' . 'term', $semester);
        $this->db->where($unique_tbl_name . '.' . 'theyear', $theyear);
        $query = $this->db->get($unique_tbl_name)->row();
        return $query->student_rank;
    }

    //find student's position(EOT)

    function position_by_total_full($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limi t'], $params['offset']);
        }
        // Find positions
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        //last character of a string
        $lastch_class = substr($theclass, -1);
        $lastch_term = substr($semester, -1);

        //Unique name for table
        $unique_tbl_name = 'rankingstbl_full' . $lastch_class . $stream . $lastch_term . $theyear;

        // $query = $this->db->query("SELECT student,hisclass,stream,term,theyear,student_rank
        //   FROM rankingstbl WHERE `student`= '$names' AND `hisclass`= '$theclass' AND `stream`= '$stream' AND
        //   `term`= '$semeste r' AND `theyear`= '$theyear'");

        //Seek student position
        $this->db->where($unique_tbl_name . '.' . 'student', $names);
        $this->db->where($unique_tbl_name . '.' . 'hisclass', $theclass);
        $this->db->where($unique_tbl_name . '.' . 'stream', $stream);
        $this->db->where($unique_tbl_name . '.' . 'term', $semester);
        $this->db->where($unique_tbl_name . '.' . 'theyear', $theyear);
        $query = $this->db->get($unique_tbl_name)->row();
        return $query->student_rank;
    }


    function rank_students_3($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        // Find positions
        $names = $this->input->post('student');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $this->db->where('rankingsTbl.student', $names);
        $this->db->where('rankingsTbl.hisclass', $theclass);
        $this->db->where('rankingsTbl.stream', $stream);
        // $this->db->where ('rankingsT b l.te rm', $semester);
        $this->db->where('rankingsTbl.theyear', $theyear);
        $result = $this->db->get('rankingsTbl')->row();
        return $result->rank;
    }


    function rank_students_2($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['lim it'], $params['offs et']);
        }
        // Find positions
        $names = $this->input->post('stude nt');
        $theclass = $this->input->post('thecla ss');
        $theyear = $this->input->post('theye ar');
        $stream = $this->input->post('stre am');
        $semester = $this->input->post('te rm');


        $sql = "SELECT student, hisclass, stream, theyear, total,
           RANK() OVER(ORDER BY total DESC) AS  'ra nk' FROM TotalMarksTbl
           WHERE `hisclass` ='$theclass' AND `stream`=  '$stream'
           GROUP BY student,hisclass,stream, theyear";

        // $sql = $this->db->query("SELECT student, hisclass, stream, theyear, total,
        //    RANK() OVER(ORDER BY total DESC) AS  'ra nk' FROM TotalMarksTbl
        //    WHERE `hisclass` ='$thecla ss' AND `stream`=  '$stre am'
        //    GROUP BY student,hisclass,stream, theyear");

        $query = $this->db->query($sql)->row();
        return $query->rank;


        // $this->db->select("student,
        //     hisclass,
        //     stream,
        //     theyear,
        //     total,
        //     RANK() OVER(ORDER BY total DESC) as  'ra nk'");
        // //$this->db->select ('RANK() OVER(ORDER BY total DESC)  as rank');
        // // $this->db-> where('ful l _marks. student', $names);
        // $this->db-> where('TotalM a rksTbl.h isclass', $theclass);
        // $this->db-> where('TotalM a rksTbl .stream', $stream);
        // // $this->db-> where('ful l _mar ks.term', $semester);
        // $this->db-> where('TotalM a rksTbl. theyear', $theyear);
        // $this->db->ord er_by ('to tal' , 'desc');
        // $this->db->gro up_by(' student');
        // $this->db->gro up_by('h isclass');
        // $this->db->gro up_by( 'stream');
        // $this->db->gro up_by(' theyear');
        // $query = $this->db ->get('TotalM arksTbl')->row();
        // // $query = $this->db ->get('TotalM arksTbl')->result_array();
        // return $query->rank;
        // return $q uery->'RANK() OVER(ORDER BY  total DESC)';

        //return $this ->db->get( 'full_marks')->result_array();
        // return $this- >db->get( 'To talMarksTbl')->result_array();
    }

    function rank_students_eot()
    {
        // Find positions
        $names = $this->input->post('student');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester  =  $this->input->post('term');

        $sql = $this->db->query("SELECT student, hisclass, stream, theyear, total,
        RANK() OVER(ORDER BY total DESC) FROM TotalMarksTbl_eot
        WHERE `hisclass`=$theclass AND `stream`= $stream
        GROUP BY student,hisclass,stream, theyear");
        return $this->db->query($sql);
    }

    function rank_students_full()
    {
        // Find positions
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $sql = $this->db->query("SELECT student, hisclass, stream, theyear, total,
        RANK() OVER(ORDER BY total DESC) FROM TotalMarksTbl_full
        WHERE `hisclass`=$theclass AND `stream`= $stream
        GROUP BY student,hisclass,stream, theyear");
        return $this->db->query($sql);
    }

    function delete_view()
    {
        return $this->db->delete('TotalMarksTbl');
    }

    function delete_view_eot()
    {
        return $this->db->delete('TotalMarksTbl_eot');
    }

    function delete_view_full()
    {
        return $this->db->delete('TotalMarksTbl_full');
    }
}
