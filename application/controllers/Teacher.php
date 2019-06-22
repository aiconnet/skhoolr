<?php

class Teacher extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Teacher_model');
    }

    /*
     * Listing of teachers
     */
    function index()
    {

        $data['teachers'] = $this->Teacher_model->get_all_teachers($params = array());
        $data['view'] = 'teacher/index';
        $this->load->view('admin/layout', $data);
    }

    /*
     * Adding a new teacher
     */
    function add()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $params = array(
                'names' => $this->input->post('names'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
            );

            $teacher_id = $this->Teacher_model->add_teacher($params);
            redirect('teacher/index');
        } else {
            $data['_view'] = 'teacher/add';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Editing a teacher
     */
    function edit($id)
    {
        // check if the teacher exists before trying to edit it
        $data['teacher'] = $this->Teacher_model->get_teacher($id);

        if (isset($data['teacher']['id'])) {
            if (isset($_POST) && count($_POST) > 0) {
                $params = array(
                    'names' => $this->input->post('names'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                );

                $this->Teacher_model->update_teacher($id, $params);
                redirect('teacher/index');
            } else {
                $data['_view'] = 'teacher/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error('The teacher you are trying to edit does not exist.');
    }

    /*
     * Deleting teacher
     */
    function remove($id)
    {
        $teacher = $this->Teacher_model->get_teacher($id);

        // check if the teacher exists before trying to delete it
        if (isset($teacher['id'])) {
            $this->Teacher_model->delete_teacher($id);
            redirect('teacher/index');
        } else
            show_error('The teacher you are trying to delete does not exist.');
    }
}
