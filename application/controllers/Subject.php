<?php

class Subject extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Subject_model');
    }

    /*
     * Listing of subjects
     */
    function index()
    {
        // $params['limit'] = RECORDS_PER_PAGE;
        // $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        // $config = $this->config->item('pagination');
        // $config['base_url'] = site_url('subject/index?');
        // $config['total_rows'] = $this->Subject_model->get_all_subjects_count();
        // $this->pagination->initialize($config);

        $data['subjects'] = $this->Subject_model->get_all_subjects($params = array());

        $data['view'] = 'subject/index';
        $this->load->view('admin/layout', $data);
        
    }

    /*
     * Adding a new subject
     */
    function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('teacher', 'Teacher', 'required');
        $this->form_validation->set_rules('theclass', 'Theclass', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'subject' => $this->input->post('subject'),
                'subjectcode' => $this->input->post('subjectcode'),
                'theclass' => $this->input->post('theclass'),
                'teacher' => $this->input->post('teacher'),
                'stream' => $this->input->post('stream'),
            );

            $subject_id = $this->Subject_model->add_subject($params);
            redirect('subject/index');
        } else {

            $this->load->model('Teacher_model');
            $data['teachers'] = $this->Teacher_model->get_all_teachers();

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $data['view'] = 'subject/add';
            //$this->load->view('layouts/main', $data);
            $this->load->view('admin/layout', $data);
        }
    }

    /*
     * Editing a subject
     */
    function edit($id)
    {
        // check if the subject exists before trying to edit it
        $data['subject'] = $this->Subject_model->get_subject($id);

        if (isset($data['subject']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('teacher', 'Teacher', 'required');
            $this->form_validation->set_rules('theclass', 'Theclass', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'subject' => $this->input->post('subject'),
                    'subjectcode' => $this->input->post('subjectcode'),
                    'theclass' => $this->input->post('theclass'),
                    'teacher' => $this->input->post('teacher'),
                    'stream' => $this->input->post('stream'),
                );

                $this->Subject_model->update_subject($id, $params);
                redirect('subject/index');
            } else {
                $data['view'] = 'subject/edit';
                // $this->load->view('layouts/main', $data);
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The subject you are trying to edit does not exist.');
    }

    /*
     * Deleting subject
     */
    function remove($id)
    {
        $subject = $this->Subject_model->get_subject($id);

        // check if the subject exists before trying to delete it
        if (isset($subject['id'])) {
            $this->Subject_model->delete_subject($id);
            redirect('subject/index');
        } else
            show_error('The subject you are trying to delete does not exist.');
    }
}
