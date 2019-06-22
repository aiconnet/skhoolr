<?php
class Subjectoptions extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Subjectoptions_model');
      //  $this->load->model('Subject_model');
    }



function edit($id)
{
    // check if the student exists before trying to edit it
    //$data['student'] = $this->Student_model->get_student($id);
    $data['subjectoption'] = $this->Subjectoptions_model->get_subjectoption($id);


    if (isset($data['subjectoption']['id'])) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('student', 'Student', 'required');
        $this->form_validation->set_rules('theclass', 'Class', 'required');
        $this->form_validation->set_rules('stream', 'Stream', 'required');
        $this->form_validation->set_rules('theyear', 'Year', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'theclass' => $this->input->post('theclass'),
                'theyear' => $this->input->post('theyear'),
                'names' => $this->input->post('student'),
                'stream' => $this->input->post('stream'),
            );

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

          //  $this->Student_model->update_student($id, $params);
            $this->Subjectoptions_model->update_subjectoption($id, $params);
          //redirect('student/index');
            redirect('subjectoptions/index');
        } else {
            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            //$data['view'] = 'student/edit';
            $data['view'] = 'subjectoptions/edit';
            $this->load->view('admin/layout', $data);
        }
    } else
        show_error('The student you are trying to edit does not exist.');
}
