<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Studentlab extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('studentlab_model','students');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
         
        $classes = $this->classes->get_list_classes();
 
        $opt = array('' => 'All Classes');
        foreach ($classes as $class) {
            $opt[$class] = $class;
        }
 
        $data['form_class'] = form_dropdown('',$opt,'','id="class" class="form-control"');
        $this->load->view('classes_view', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $classes) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $classes->names;
            $row[] = $classes->theclass;
            $row[] = $classes->stream;
            $row[] = $classes->theyear;
            /*$row[] = $customers->city;
            $row[] = $customers->country;*/
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->classes->count_all(),
                        "recordsFiltered" => $this->classes->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
}