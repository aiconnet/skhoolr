<?php

class Mark_model extends CI_Model
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
        $this->db->insert('marks', $params);
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
        $this->db->insert_batch('marks', $params);
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

        return $this->db->get('marks')->result_array();
    }

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

        //$query = $this->db->get('marks');
        $this->db->where('markseot.student', $names);
        $this->db->where('markseot.hisclass', $theclass);
        $this->db->where('markseot.stream', $stream);
        $this->db->where('markseot.term', $semester);
        $this->db->where('markseot.theyear', $theyear);

        //$this->db->order_by('mark1', 'desc');
        //$this->db->limit(8);

        return $this->db->get('markseot')->num_rows();
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
        $query = $this->db->get('marks');
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $result = $this->db->get('marks')->row();
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
        return $this->db->update('marks', $params);
    }

    /*
     * function to delete mark
     */
    function delete_mark($id)
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

    function best_eight_total_mark_3()
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
        //$this->db->from('markseot');
        $this->db->order_by('mark1', 'desc');
        $this->db->limit(8);
        //$this->db->get();
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

        $this->db->select_avg('mark2');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks')->row();
        return $query->mark2;
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
        $this->db->where('marks.student', $names);
        $this->db->where('marks.hisclass', $theclass);
        $this->db->where('marks.stream', $stream);
        $this->db->where('marks.term', $semester);
        $this->db->where('marks.theyear', $theyear);
        $query = $this->db->get('marks');
        return $query->num_rows();
    }

    /*
    * Finding position in stream by total
    */

    /*function position_by_total_2(){

            $connection = mysqli_connect("localhost","frankhos_sklr3po","Matthew24:13","frankhos_sklr3po");

            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $sql = "SELECT student,total,(CASE WHEN @l=total THEN @r ELSE @r:=@row + 1 END) as rank, @l:=total,@row:=@row + 1
            FROM (SELECT student, SUM(average_mark) AS total FROM full_marks s
            WHERE hisclass=$theclass AND stream=$stream AND s.theyear=$theyear AND s.term=$semester GROUP BY student ORDER BY total DESC) totals,
            (SELECT @r:=0, @row:=0, @l:=NULL) rank";


            $query = mysqli_query($connection, $sql);
                while($row = (mysqli_fetch_assoc($query))):
                    if ($row['theclass'] == $theclass && $row['stream'] == $stream && $row['theyear'] == $theyear && $row['term'] == $semester ){
                        //$position_in_stream= $row['rank'];
                        $position_in_stream= rank;
                    }
             endwhile;
    }*/
    function position_in_stream()
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

    function position_in_classstream($params = array())
    {
        $names = $this->input->post('student');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        if ($this->db->table_exists('TotalMarksTbl')) {
            // Find positions
            $sql = $this->db->query("SELECT student,hisclass, stream, theyear,total, RANK() OVER(ORDER BY total DESC) FROM totalmark
         WHERE `hisclass`=$theclass AND `stream`= $stream GROUP BY student,hisclass,stream, theyear");

            return $this->db->query($sql);
        } else {
            //Create view
            $TotalsView = $this->db->query("CREATE VIEW TotalMarksTbl AS SELECT student, hisclass, stream, theyear,
        SUM(mark1) AS total FROM markseot GROUP BY student,hisclass,stream,theyear");

            return $this->db->query($TotalsView);
            $sql = $this->db->query("SELECT student,hisclass, stream, theyear,total, RANK() OVER(ORDER BY total DESC) FROM totalmark
         WHERE `hisclass`=$theclass AND `stream`= $stream GROUP BY student,hisclass,stream, theyear");

            return $this->db->query($sql);
        }

        function position_by_total($params = array())
        {
            $names = $this->input->post('student');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            /* $query = $this->db->select("student,total,(CASE WHEN @l=total THEN @r ELSE @r:=@row + 1 END) as rank, @l:=total,@row:=@row + 1
            FROM (SELECT student, SUM(average_mark) AS total FROM full_marks s WHERE s.student='$names' &&  s.hisclass = '$theclass' AND s.stream = '$stream' AND s.theyear='$theyear' AND s.term ='$semester'
            GROUP BY student ORDER BY total DESC) totals,
           (SELECT @r:=0, @row:=0, @l:=NULL) rank");

           $this->db->get();*/

            /* $this->db->select_avg('mark2');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks')->row();
        return $query->mark2;*/

            /* $query=$this->db->query("select * from crud");
	return $query->result();*/

            //CREATE A VIEW FOR TOTAL MARKS
            /*$TotalsView = $this->db->query("CREATE VIEW TotalMarks AS SELECT student, hisclass, stream, theyear,
        SUM(mark1) AS total FROM markseot WHERE `hisclass`= $theclass AND
        stream=$stream GROUP by student");*/

            if ($this->db->table_exists('TotalMarksTbl')) {
                // Find positions
                $sql = $this->db->query("SELECT student,hisclass, stream, theyear,total, RANK() OVER(ORDER BY total DESC) FROM totalmark
         WHERE `hisclass`=$theclass AND `stream`= $stream GROUP BY student,hisclass,stream, theyear");
                return $this->db->query($sql);
            } else {
                //Create view
                $TotalsView = $this->db->query("CREATE VIEW TotalMarksTbl AS SELECT student, hisclass, stream, theyear,
        SUM(mark1) AS total FROM markseot GROUP BY student,hisclass,stream,theyear");

                return $this->db->query($TotalsView);
                $sql = $this->db->query("SELECT student,hisclass, stream, theyear,total, RANK() OVER(ORDER BY total DESC) FROM totalmark
         WHERE `hisclass`=$theclass AND `stream`= $stream GROUP BY student,hisclass,stream, theyear");
                return $this->db->query($sql);
            }



            /*$TotalsView = $this->db->query("CREATE VIEW TotalMarksTbl AS SELECT student, hisclass, stream, theyear,
        SUM(mark1) AS total FROM(SELECT mark1 FROM markseot DESC LIMIT 8 GROUP BY student,hisclass,stream,theyear");*/


            /*$this->db->where($TotalsView.'.''hisclass', $theclass);
        $this->db->where($TotalsView.'.''stream', $stream);

        $this->db->query('SELECT student, total,  RANK()  OVER(ORDER BY total) as rank');
        $query = $this->db->get($TotalsView)->row();
        return $query->rank;*/

            //FIND POSITIONS BY TOTAL
            /* $sql = "SELECT student, total,  RANK()  OVER(ORDER BY total) as rank
        FROM  $TotalsView1 WHERE `hisclass`= $theclass AND
        `stream`=$stream GROUP by student";*/



            /* $sql = $this->db->query( 'SELECT student, total, RANK()  OVER(ORDER BY total) as rank);
        FROM  $TotalsView');*/


            //CREATE A VIEW FOR TOTAL MARKS
            /*$TotalsTbl = "CREATE VIEW TotalMarks as
        SELECT
        student, hisclass, stream, theyear, SUM(mark1) as total
        FROM markseot GROUP by student
        ORDER BY total DESC";*/

            //FIND POSITIONS BY TOTAL
            /* $sql = "SELECT student, total,  RANK()  OVER(ORDER BY SUM(mark1)) as rank
        FROM  $TotalsTbl";*/

            /*$sql= "SELECT student, SUM(mark1) as total,  RANK()  OVER(ORDER BY SUM(mark1)) as rank
        FROM  markseot WHERE";*/

            //$this->db->get('markseot');
            return $query = $this->db->query($sql);



            $sql = "SELECT student,total,(CASE WHEN @l=total THEN @r ELSE @r:=@row + 1 END) as rank, @l:=total,@row:=@row + 1
            FROM (SELECT student, SUM(average_mark) AS total FROM full_marks s WHERE s.student='$names' &&  s.hisclass = '$theclass' AND s.stream = '$stream' AND s.theyear='$theyear' AND s.term ='$semester'
            GROUP BY student ORDER BY total DESC) totals,
           (SELECT @r:=0, @row:=0, @l:=NULL) rank";

            $this->db->get('markseot');

            return $query = $this->db->query($sql);





            /* $sql = "SELECT student,SUM('average_mark'),(CASE WHEN @l=SUM('average_mark') THEN @r ELSE @r:=@row + 1 END) as rank, @l:=total,@row:=@row + 1
            FROM (SELECT student, SUM('average_mark') AS total FROM full_marks s WHERE s.student='$names' &&  s.hisclass = '$theclass' AND s.stream = '$stream' AND s.theyear='$theyear' AND s.term ='$semester'
            GROUP BY student ORDER BY SUM(average_mark) DESC) totals,
           (SELECT @r:=0, @row:=0, @l:=NULL) rank";*/

            // return $query = $this->db->query($sql)->result_array();

            //return $query = $this->db->query($sql);

            //return $this->db->query($sql)->result_array();

            // return  $query->result_array();

            /* $query = $this->db->select("SELECT student,total,(CASE WHEN @l=total THEN @r ELSE @r:=@row + 1 END) as rank, @l:=total,@row:=@row + 1");
           $this->db->from('SELECT student, SUM(average_mark) AS total FROM full_marks s');

           $this->db->where('full_marks.student', $names);
            $this->db->where('full_marks.hisclass', $theclass);
            $this->db->where('full_marks.stream', $stream);
            $this->db->where('full_marks.term', $semester);
            $this->db->where('full_marks.theyear', $theyear);

            $this->db->group_by("student");
            $this->db->order_by('total', 'desc');
            $query=$this->db->get();*/

            //$query = $this->db->query($sql);
            //return  $query->result_array();
            //$result = $query->result_array();
            //return $result->rank;

            // $query = $this->db->select("*");
            //$this->db->from('table_name');
            //$query=$this->db->get();
        }
    }

    function position_by_total_1()
    {
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        /* $this->db->select_avg('mark2');
        $this->db->where('full_marks.student', $names);
        $this->db->where('full_marks.hisclass', $theclass);
        $this->db->where('full_marks.stream', $stream);
        $this->db->where('full_marks.term', $semester);
        $this->db->where('full_marks.theyear', $theyear);
        $query = $this->db->get('full_marks')->row();*/
        //$query = $this->db->query('select sum(`like`) as atotal from `like` where sfid = '.$short);
        //$query = $this->db->query('SELECT names, SUM(average_mark) FROM full_marks  WHERE theclass=$class AND stream=$stream GROUP BY names');
        // $query = $this->db->query('SELECT names, SUM(mark2) FROM full_marks  WHERE theclass=$class AND stream=$stream GROUP BY names');

        // $query = $this->db->query('SELECT names, SUM(mark2) RANK() OVER(ORDER BY SUM(mark2)) Ranking FROM full_marks WHERE theclass=$class AND stream=$stream  AND theyear = $theyear
        // GROUP BY names');

        /* $query = $this->db->query('SELECT names, SUM(Mark2) as ts, hisclass, stream, rank() over (order by ts desc) as rank
        FROM full_marks
        WHERE hisclass = $class AND stream=$stream AND theyear = $theyear
        ORDER BY ts DESC');*/

        $query = $this->db->query(' SELECT names, Mark2
    RANK() OVER (
        ORDER BY Mark2
    ) my_rank
FROM
    full_marks;');

        $this->db->query($query);
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
//}
