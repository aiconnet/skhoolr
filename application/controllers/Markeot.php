<?php

class Markeot extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Markeot_model');
    }

    /*
     * Listing of marks
     */
    function index()
    {
        // $params['limit'] = RECORDS_PER_PAGE;
        // $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        // $config = $this->config->item('pagination');
        // $config['base_url'] = site_url('mark/index?');
        // $config['total_rows'] = $this->Markeot_model->get_all_marks_count();
        // $this->pagination->initialize($config);

        $data['marks'] = $this->Markeot_model->get_all_marks($params = array());

        $data['view'] = 'markeot/index';
        $this->load->view('admin/layout', $data);
    }

    /*
     * Adding a new mark
     */
    function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('student', 'Student', 'required|max_length[255]');
        $this->form_validation->set_rules('hisclass', 'Hisclass', 'required|max_length[255]');
        $this->form_validation->set_rules('stream', 'Stream', 'required|max_length[255]');
        $this->form_validation->set_rules('theyear', 'Theyear', 'required|max_length[255]');
        $this->form_validation->set_rules('subject', 'Subject', 'required|max_length[255]');
        $this->form_validation->set_rules('subjectcode', 'Subjectcode', 'max_length[255]');
        $this->form_validation->set_rules('mark1', 'Mark1', 'integer');
        $this->form_validation->set_rules('comment', 'Comment', 'required|max_length[255]');

        if ($this->form_validation->run()) {
            $params = array(
                'studentid' => $this->input->post('studentid'),
                'student' => $this->input->post('student'),
                'hisclass' => $this->input->post('hisclass'),
                'stream' => $this->input->post('stream'),
                'theyear' => $this->input->post('theyear'),
                'subject' => $this->input->post('subject'),
                'subjectcode' => $this->input->post('subjectcode'),
                'mark1' => $this->input->post('mark1'),
                'comment' => $this->input->post('comment'),
                'term' => $this->input->post('term'),
                'subjectteacher' => $this->input->post('subjectteacher'),
            );

            $this->load->model('Teacher_model');
            $data['teachers'] = $this->Teacher_model->get_all_teachers();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $mark_id = $this->Markeot_model->add_mark($params);
            redirect('markeot/index');
        } else {
            $this->load->model('Teacher_model');
            $data['teachers'] = $this->Teacher_model->get_all_teachers();

            $this->load->model('Student_model');
            $data['all_students'] = $this->Student_model->get_all_students();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Semester_model');
            $data['semesters'] = $this->Semester_model->get_all_semesters();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $this->load->model('Subject_model');
            $data['subjects'] = $this->Subject_model->get_all_subjects();

            $data['view'] = 'markeot/add';
            $this->load->view('admin/layout', $data);
        }
    }



    /*
     * Adding a new mark
     */
    function addhsc()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('student', 'Student', 'required|max_length[255]');
        $this->form_validation->set_rules('hisclass', 'Hisclass', 'required|max_length[255]');
        $this->form_validation->set_rules('stream', 'Stream', 'required|max_length[255]');
        $this->form_validation->set_rules('theyear', 'Theyear', 'required|max_length[255]');
        $this->form_validation->set_rules('subject', 'Subject', 'required|max_length[255]');
        $this->form_validation->set_rules('subjectcode', 'Subjectcode', 'max_length[255]');
        $this->form_validation->set_rules('mark1', 'Mark1', 'integer');
        $this->form_validation->set_rules('comment', 'Comment', 'required|max_length[255]');

        if ($this->form_validation->run()) {
            $params = array(
                'studentid' => $this->input->post('studentid'),
                'student' => $this->input->post('student'),
                'hisclass' => $this->input->post('hisclass'),
                'stream' => $this->input->post('stream'),
                'theyear' => $this->input->post('theyear'),
                'subject' => $this->input->post('subject'),
                'subjectcode' => $this->input->post('subjectcode'),
                'paper' => $this->input->post('paper'),
                'mark1' => $this->input->post('mark1'),
                'comment' => $this->input->post('comment'),
                'term' => $this->input->post('term'),
                'subjectteacher' => $this->input->post('subjectteacher'),
            );

            $this->load->model('Teacher_model');
            $data['teachers'] = $this->Teacher_model->get_all_teachers();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $mark_id = $this->Markeot_model->addhsc_mark($params);
            redirect('markeot/index');
        } else {
            $this->load->model('Teacher_model');
            $data['teachers'] = $this->Teacher_model->get_all_teachers();

            $this->load->model('Student_model');
            $data['all_students'] = $this->Student_model->get_all_students();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Semester_model');
            $data['semesters'] = $this->Semester_model->get_all_semesters();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $this->load->model('Subject_model');
            $data['subjects'] = $this->Subject_model->get_all_subjects();

            $data['view'] = 'markeot/addhsc';
            $this->load->view('admin/layout', $data);
        }
    }


    /*public function get_student_positions(){
       $this->db->select('*');
       $this->db->select('SUM(mark1) AS total', FALSE);
       $this->db->group_by('student, theclass, stream, theyear, term');
       $this->db->order_by('total', 'desc');
       $result=$this->db->get(marks);
       return $result->result_array();
    }*/


    function add_stream_marks()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('comment', 'Comment', 'required|max_length[255]');
        $this->form_validation->set_rules('student', 'Student', 'required|max_length[255]');
        $this->form_validation->set_rules('hisclass', 'Hisclass', 'required|max_length[255]');
        $this->form_validation->set_rules('stream', 'Stream', 'required|max_length[255]');
        $this->form_validation->set_rules('theyear', 'Theyear', 'required|max_length[255]');
        $this->form_validation->set_rules('subject', 'Subject', 'required|max_length[255]');
        $this->form_validation->set_rules('subjectcode', 'Subjectcode', 'max_length[255]');
        $this->form_validation->set_rules('mark1', 'Mark1', 'integer');

        if ($this->form_validation->run()) {

            $params = array(
                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid'),
                    'student' => $this->input->post('student'),
                    'mark1' => $this->input->post('mark1'),
                    'comment' => $this->input->post('comment'),
                ),
                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid2'),
                    'student' => $this->input->post('student2'),
                    'mark1' => $this->input->post('mark12'),
                    'comment' => $this->input->post('comment2'),
                ),
                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid3'),
                    'student' => $this->input->post('student3'),
                    'mark1' => $this->input->post('mark13'),
                    'comment' => $this->input->post('comment3'),
                ),
                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid4'),
                    'student' => $this->input->post('student4'),
                    'mark1' => $this->input->post('mark14'),
                    'comment' => $this->input->post('comment4'),
                ),
                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid5'),
                    'student' => $this->input->post('student5'),
                    'mark1' => $this->input->post('mark15'),
                    'comment' => $this->input->post('comment5'),
                ),

                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid6'),
                    'student' => $this->input->post('student6'),
                    'mark1' => $this->input->post('mark16'),
                    'comment' => $this->input->post('comment6'),
                ),

                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid7'),
                    'student' => $this->input->post('student7'),
                    'mark1' => $this->input->post('mark17'),
                    'comment' => $this->input->post('comment7'),
                ),

                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid8'),
                    'student' => $this->input->post('student8'),
                    'mark1' => $this->input->post('mark18'),
                    'comment' => $this->input->post('comment8'),
                ),

                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid9'),
                    'student' => $this->input->post('student9'),
                    'mark1' => $this->input->post('mark19'),
                    'comment' => $this->input->post('comment9'),
                ),

                array(
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'term' => $this->input->post('term'),

                    'studentid' => $this->input->post('studentid10'),
                    'student' => $this->input->post('student10'),
                    'mark1' => $this->input->post('mark110'),
                    'comment' => $this->input->post('comment10'),
                )
            );

            $mark_id = $this->Markeot_model->add_stream_mark($params);
            redirect('markeot/index');
        } else {
            $this->load->model('Student_model');
            $data['all_students'] = $this->Student_model->get_all_students();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Semester_model');
            $data['semesters'] = $this->Semester_model->get_all_semesters();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $this->load->model('Subject_model');
            //$data['subjects'] = $this->Subject_model->get_all_subjects();
            $data['subjects'] = $this->Subject_model->get_subjects_for_drop_down();

            //get_subjects_for_drop_down($params = array())

            $data['_view'] = 'markeot/add_stream_marks';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
    * Add Marks via Excel
    */

    public function import_data()
    {
        $config = array(
            'upload_path'   => FCPATH . 'uploads/eotmarks',
            'allowed_types' => 'xls|csv'
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            @chmod($data['full_path'], 0777);

            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

            $this->spreadsheet_excel_reader->read($data['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);

            $data_excel = array();
            for ($i = 2; $i <= $sheets['numRows']; $i++) {
                if ($sheets['cells'][$i][1] == '') break;

                $data_excel[$i - 1]['student']    = $sheets['cells'][$i][1];
                $data_excel[$i - 1]['hisclass']   = $sheets['cells'][$i][2];
                $data_excel[$i - 1]['stream'] = $sheets['cells'][$i][3];
                $data_excel[$i - 1]['theyear'] = $sheets['cells'][$i][4];
                $data_excel[$i - 1]['subject'] = $sheets['cells'][$i][5];
                $data_excel[$i - 1]['subjectcode'] = $sheets['cells'][$i][6];
                $data_excel[$i - 1]['mark1'] = $sheets['cells'][$i][7];
                $data_excel[$i - 1]['comment'] = $sheets['cells'][$i][8];
                $data_excel[$i - 1]['studentid'] = $sheets['cells'][$i][9];
                $data_excel[$i - 1]['term'] = $sheets['cells'][$i][10];
                $data_excel[$i - 1]['subjectteacher'] = $sheets['cells'][$i][11];
            }

            /* $params = $this->security->xss_clean($params);
            $student_id = $this->Student_model->add_student($params);
            if($student_id){
                $this->session->set_flashdata('msg', 'Student is Registered Successfully!');
                redirect('student/index');*/

            $this->db->insert_batch('markseot', $data_excel);
            $this->session->set_flashdata('msg', 'Student EOT Marks Registered Successfully!');
            // @unlink($data['full_path']);
            //redirect('excel_import');
            redirect('markeot/index');
        }
    }

    //}

    /*
     * Editing a mark
     */
    function edit($id)
    {
        // check if the mark exists before trying to edit it
        $data['mark'] = $this->Markeot_model->get_mark($id);

        if (isset($data['mark']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('student', 'Student', 'required|max_length[255]');
            $this->form_validation->set_rules('hisclass', 'Hisclass', 'required|max_length[255]');
            $this->form_validation->set_rules('stream', 'Stream', 'required|max_length[255]');
            $this->form_validation->set_rules('theyear', 'Theyear', 'required|max_length[255]');
            $this->form_validation->set_rules('subject', 'Subject', 'required|max_length[255]');
            $this->form_validation->set_rules('subjectcode', 'Subjectcode', 'max_length[255]');
            $this->form_validation->set_rules('mark1', 'Mark1', 'integer');
            $this->form_validation->set_rules('comment', 'Comment', 'required|max_length[255]');

            if ($this->form_validation->run()) {
                $params = array(
                    'studentid' => $this->input->post('studentid'),
                    'student' => $this->input->post('student'),
                    'hisclass' => $this->input->post('hisclass'),
                    'stream' => $this->input->post('stream'),
                    'theyear' => $this->input->post('theyear'),
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'mark1' => $this->input->post('mark1'),
                    'comment' => $this->input->post('comment'),
                    'term' => $this->input->post('term'),
                    'subjectteacher' => $this->input->post('subjectteacher'),
                );

                $this->Markeot_model->update_mark($id, $params);
                redirect('markeot/index');
            } else {
                $this->load->model('Student_model');
                $data['all_students'] = $this->Student_model->get_all_students();

                $data['view'] = 'markeot/edit';
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The mark you are trying to edit does not exist.');
    }

    /*
     * Deleting mark
     */
    function remove($id)
    {
        $mark = $this->Markeot_model->get_mark($id);

        // check if the mark exists before trying to delete it
        if (isset($mark['id'])) {
            $this->Markeot_model->delete_mark($id);
            redirect('markeot/index');
        } else
            show_error('The mark you are trying to delete does not exist.');
    }
}
