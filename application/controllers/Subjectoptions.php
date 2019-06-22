<?php

class Subjectoptions extends CI_Controller
{
    function __construct(){parent::__construct();$this->load->model(base64_decode('U3ViamVjdG9wdGlvbnNfbW9kZWw='));$this->load->model(base64_decode('U3ViamVjdF9tb2RlbA=='));}
    /*
     * Listing of marks
     */
    function index(){$data[base64_decode('c3ViamVjdG9wdGlvbnM=')]=$this->Subjectoptions_model->get_all_subjectoptions($params=array());$data[base64_decode('dmlldw==')]=base64_decode('c3ViamVjdG9wdGlvbnMvaW5kZXg=');$this->load->view(base64_decode('YWRtaW4vbGF5b3V0'),$data);}

    /*
     * Adding a new subject option
     */
    function add(){$this->load->library(base64_decode('Zm9ybV92YWxpZGF0aW9u'));$this->form_validation->set_rules(base64_decode('c3R1ZGVudA=='),base64_decode('U3R1ZGVudA=='),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('aGlzY2xhc3M='),base64_decode('Q2xhc3M='),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('c3RyZWFt'),base64_decode('U3RyZWFt'),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('dGhleWVhcg=='),base64_decode('WWVhcg=='),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('c3ViamVjdA=='),base64_decode('U3ViamVjdA=='),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('c3ViamVjdGNvZGU='),base64_decode('U3ViamVjdCBDb2Rl'),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));$this->form_validation->set_rules(base64_decode('cGFwZXI='),base64_decode('UGFwZXI='),base64_decode('cmVxdWlyZWR8bWF4X2xlbmd0aFsyNTVd'));if($this->form_validation->run()){$params=array(base64_decode('c3R1ZGVudA==') =>$this->input->post(base64_decode('c3R1ZGVudA==')),base64_decode('dGhlY2xhc3M=') =>$this->input->post(base64_decode('aGlzY2xhc3M=')),base64_decode('c3RyZWFt') =>$this->input->post(base64_decode('c3RyZWFt')),base64_decode('dGhleWVhcg==') =>$this->input->post(base64_decode('dGhleWVhcg==')),base64_decode('c3ViamVjdA==') =>$this->input->post(base64_decode('c3ViamVjdA==')),base64_decode('c3ViamVjdGNvZGU=') =>$this->input->post(base64_decode('c3ViamVjdGNvZGU=')),base64_decode('cGFwZXI=') =>$this->input->post(base64_decode('cGFwZXI=')),);$this->load->model(base64_decode('U3RyZWFtX21vZGVs'));$data[base64_decode('c3RyZWFtcw==')]=$this->Stream_model->get_all_streams();$this->load->model(base64_decode('UmVhbGNsYXNzX21vZGVs'));$data[base64_decode('cmVhbGNsYXNzZXM=')]=$this->Realclass_model->get_all_realclasses();$params=$this->security->xss_clean($params);$options_id=$this->Subjectoptions_model->add_subjectoption($params);if($options_id){$this->session->set_flashdata(base64_decode('bXNn'),base64_decode('U3ViamVjdCBPcHRpb24gSGFzIEJlZW4gUmVnaXN0ZXJlZCBTdWNjZXNzZnVsbHkh'));redirect(base64_decode('c3ViamVjdG9wdGlvbnMvaW5kZXg='));}}else{$this->load->model(base64_decode('U3RyZWFtX21vZGVs'));$data[base64_decode('c3RyZWFtcw==')]=$this->Stream_model->get_all_streams();$this->load->model(base64_decode('UmVhbGNsYXNzX21vZGVs'));$data[base64_decode('cmVhbGNsYXNzZXM=')]=$this->Realclass_model->get_all_realclasses();$data[base64_decode('c3ViamVjdGNvZGU=')]=$this->Subject_model->get_subjects_code();$data[base64_decode('dmlldw==')]=base64_decode('c3ViamVjdG9wdGlvbnMvYWRk');$this->load->view(base64_decode('YWRtaW4vbGF5b3V0'),$data);}}
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

            $mark_id = $this->Mark_model->addhsc_mark($params);
            redirect('mark/index');
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

            $data['view'] = 'mark/addhsc';
            $this->load->view('admin/layout', $data);
        }
    }


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

            $mark_id = $this->Mark_model->add_stream_mark($params);
            redirect('mark/index');
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

            $data['_view'] = 'mark/add_stream_marks';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
    * Add Marks via Excel
    */

    function import_data()
    {
        $config = array(
            'upload_path'   => FCPATH . 'uploads/subjectoptions',
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
                $data_excel[$i - 1]['student_id'] = $sheets['cells'][$i][2];
                $data_excel[$i - 1]['theclass']   = $sheets['cells'][$i][3];
                $data_excel[$i - 1]['stream'] = $sheets['cells'][$i][4];
                $data_excel[$i - 1]['subject'] = $sheets['cells'][$i][5];
                $data_excel[$i - 1]['theyear'] = $sheets['cells'][$i][6];
                // $data_excel[$i - 1]['subjectcode'] = $sheets['cells'][$i][6];
                // $data_excel[$i - 1]['mark1'] = $sheets['cells'][$i][7];
                // $data_excel[$i - 1]['comment'] = $sheets['cells'][$i][8];
                // $data_excel[$i - 1]['term'] = $sheets['cells'][$i][10];
            }

            /* $params = $this->security->xss_clean($params);
            $student_id = $this->Student_model->add_student($params);
            if($student_id){
                $this->session->set_flashdata('msg', 'Student is Registered Successfully!');
                redirect('student/index');*/

            $this->db->insert_batch('subject_options', $data_excel);
            $this->session->set_flashdata('msg', 'Student Subject Options Registered Successfully!');
            // @unlink($data['full_path']);
            //redirect('excel_import');
            redirect('subjectoptions/index');
        }
    }

    //}


    function edit($id){$data[base64_decode('c3ViamVjdG9wdGlvbg==')]=$this->Subjectoptions_model->get_subjectoption($id);if(isset($data[base64_decode('c3ViamVjdG9wdGlvbg==')][base64_decode('aWQ=')])){$this->load->library(base64_decode('Zm9ybV92YWxpZGF0aW9u'));$this->form_validation->set_rules(base64_decode('c3R1ZGVudA=='),base64_decode('U3R1ZGVudA=='),base64_decode('cmVxdWlyZWQ='));$this->form_validation->set_rules(base64_decode('dGhlY2xhc3M='),base64_decode('Q2xhc3M='),base64_decode('cmVxdWlyZWQ='));$this->form_validation->set_rules(base64_decode('c3RyZWFt'),base64_decode('U3RyZWFt'),base64_decode('cmVxdWlyZWQ='));if($this->form_validation->run()){$params=array(base64_decode('c3R1ZGVudA==') =>$this->input->post(base64_decode('c3R1ZGVudA==')),base64_decode('dGhlY2xhc3M=') =>$this->input->post(base64_decode('dGhlY2xhc3M=')),base64_decode('c3RyZWFt') =>$this->input->post(base64_decode('c3RyZWFt')),base64_decode('dGhleWVhcg==') =>$this->input->post(base64_decode('dGhleWVhcg==')),base64_decode('c3ViamVjdA==') =>$this->input->post(base64_decode('c3ViamVjdA==')),base64_decode('c3ViamVjdGNvZGU=') =>$this->input->post(base64_decode('c3ViamVjdGNvZGU=')),base64_decode('cGFwZXI=') =>$this->input->post(base64_decode('cGFwZXI=')),);$this->load->model(base64_decode('U3RyZWFtX21vZGVs'));$data[base64_decode('c3RyZWFtcw==')]=$this->Stream_model->get_all_streams();$this->load->model(base64_decode('UmVhbGNsYXNzX21vZGVs'));$data[base64_decode('cmVhbGNsYXNzZXM=')]=$this->Realclass_model->get_all_realclasses();$this->Subjectoptions_model->update_subjectoption($id,$params);redirect(base64_decode('c3ViamVjdG9wdGlvbnMvaW5kZXg='));}else{$this->load->model(base64_decode('U3RyZWFtX21vZGVs'));$data[base64_decode('c3RyZWFtcw==')]=$this->Stream_model->get_all_streams();$this->load->model(base64_decode('UmVhbGNsYXNzX21vZGVs'));$data[base64_decode('cmVhbGNsYXNzZXM=')]=$this->Realclass_model->get_all_realclasses();$data[base64_decode('dmlldw==')]=base64_decode('c3ViamVjdG9wdGlvbnMvZWRpdA==');$this->load->view(base64_decode('YWRtaW4vbGF5b3V0'),$data);}}else show_error(base64_decode('VGhlIHN0dWRlbnQgeW91IGFyZSB0cnlpbmcgdG8gZWRpdCBkb2VzIG5vdCBleGlzdC4='));}


   function remove($id){$subjectoption=$this->Subjectoptions_model->get_subjectoption($id);if(isset($subjectoption[base64_decode('aWQ=')])){$this->Subjectoptions_model->delete_subjectoption($id);redirect(base64_decode('c3ViamVjdG9wdGlvbnMvaW5kZXg='));}else show_error(base64_decode('VGhlIHN1YmplY3Qgb3B0aW9uIHlvdSBhcmUgdHJ5aW5nIHRvIGRlbGV0ZSBkb2VzIG5vdCBleGlzdC4='));}
   
}
