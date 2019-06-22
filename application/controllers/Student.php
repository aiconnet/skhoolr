<?php

class Student extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        //MINE
        $this->load->helper(array('form', 'url'));
        $this->load->helper('directory'); //load directory helper
        //	$this->load->model('upload_model');
        $this->load->model('Mark_model');
        $this->load->model('Markeot_model');
        $this->load->model('Markeot2_model');
        $this->load->model('Subject_model');
        $this->load->library('table');
        $this->load->library('image_lib');
        $this->load->dbutil();
        $this->load->dbforge();
        //$this->load->model('Image_model');
        // $this->load->model('Import_model', 'import');
        //$this->load->model('excel_import_model');
        //$this->load->library('excel');
    }

    /*
     * Listing of students
     */
    function index()
    {
        //  $params['limit'] = RECORDS_PER_PAGE;
        // $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        // $config = $this->config->item('pagination');
        // $config['base_url'] = site_url('student/index?');
        // $config['total_rows'] = $this->Student_model->get_all_students_count();
        //$this->pagination->initialize($config);

        $data['students'] = $this->Student_model->get_all_students($params = array());
        $data['view'] = 'student/index';
        $this->load->view('admin/layout', $data);
    }

    /*
     * Upload student photo
     */
    function upload_photo()
    {
        //Get  students id
        $student_id = $this->input->post('student_id');
        $student_names = $this->input->post('student');
        $student_names = strtolower($student_names);


        $config['image_library'] = 'gd2'; // $config['upload_path']          = './uploads/student_photos/';
        $config['upload_path']          = './images/student_photos/';
        // $config['allowed_types']        = 'gif|jpg|png|tiff|bmp';
        $config['allowed_types']        = 'jpg';
        $config['file_name']            = $student_id . _ . $student_names;
        $config['remove_spaces']        = TRUE;
        $config['file_ext_tolower']     = TRUE;
        $config['overwrite']            = TRUE;
        $config['max_size']             = 250;
        $config['max_width']            = 300;
        $config['max_height']           = 300;

        // $filename =  $config['file_name'];
        // $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        // echo ($file_ext); // the out should be extension of file eg:-png, gif, html

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());

            // $this->load->view('upload_form', $error);
            $this->session->set_flashdata('msg', $error);
            redirect('student/index');
        } else {
            $data = array('upload_data' => $this->upload->data());

            // $this->load->view('upload_success', $data);
            // if($student_id){
            if ($data) {
                $this->session->set_flashdata('msg', 'Student photo uploaded successfully!');
                redirect('student/index');
            }
        }


        /*  if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload_success', $data);
                }*/
    }

    /*
     * Adding a new student
     */
    function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('student', 'Student', 'required');
        $this->form_validation->set_rules('hisclass', 'Class', 'required');
        $this->form_validation->set_rules('stream', 'Stream', 'required');
        $this->form_validation->set_rules('theyear', 'Year', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'names' => $this->input->post('student'),
                'theclass' => $this->input->post('hisclass'),
                'stream' => $this->input->post('stream'),
                'theyear' => $this->input->post('theyear'),

                //	'studentphoto' => $this->input->post('studentphoto'),
            );

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $params = $this->security->xss_clean($params);
            $student_id = $this->Student_model->add_student($params);
            if ($student_id) {
                $this->session->set_flashdata('msg', 'Student is Registered Successfully!');
                redirect('student/index');
            }
        } else {

            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();
            $data['view'] = 'student/add';
            $this->load->view('admin/layout', $data);
        }
    }

    public function import_student_data()
    {
        $config = array(
            'upload_path'   => FCPATH . 'uploads/',
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

                $data_excel[$i - 1]['names']    = $sheets['cells'][$i][1];
                $data_excel[$i - 1]['theclass']   = $sheets['cells'][$i][2];
                $data_excel[$i - 1]['stream'] = $sheets['cells'][$i][3];
                $data_excel[$i - 1]['theyear'] = $sheets['cells'][$i][4];
            }

            $this->db->insert_batch('students', $data_excel);
            $this->session->set_flashdata('msg', 'Students is Registered Successfully!');
            // @unlink($data['full_path']);
            //redirect('excel_import');
            redirect('student/index');
        }
    }



    public function add_stream()
    {

        //	$this->load->view('add_stream');
        if (isset($_POST["submit"])) {

            $file = $_FILES['names']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0; //
            while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                $names = $filesop[0];
                $class = $filesop[1];
                $stream = $filesop[2];
                $year = $filesop[3];
                if ($c <> 0) {                    //SKIP THE FIRST ROW
                    $this->Student_model->saverecords($fname, $lname, $stream, $year);
                }
                $c = $c + 1;
            }
            echo "sucessfully import data !";

            //$student_id = $this->Student_model->add_student($params);
            redirect('student/index');
        } else {
            $data['view'] = 'student/add_stream';
            $this->load->view('admin/layout', $data);
        }
    }




    /*
     * Adding a new student
     */
    function add_stream2()
    {
        //$this->load->view('import_data');
        if (isset($_POST["submit"])) {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0; //
            while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                $names = $filesop[0];
                $class = $filesop[1];
                $stream = $filesop[3];
                $year =   $filesop[4];
                if ($c <> 0) {                    //SKIP THE FIRST ROW
                    $this->Excel_import_model->saverecords($names, $class, $stream, $year);
                }
                $c = $c + 1;
            }
            echo "Stream imported sucessfully";
        }
    }


    function importdata()
    {
        $this->load->view('import_data');
        if (isset($_POST["submit"])) {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0; //
            while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                $fname = $filesop[0];
                $lname = $filesop[1];
                if ($c <> 0) {                    //SKIP THE FIRST ROW
                    $this->Crud_model->saverecords($fname, $lname);
                }
                $c = $c + 1;
            }
            echo "sucessfully import data !";
        }
    }





    /*
     * Editing a student
     */
    /*function edit($id)
    {

        $data['student'] = $this->Student_model->get_student($id);

        if(isset($data['student']['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('names','Names','required');
			$this->form_validation->set_rules('theclass','Theclass','required');
			$this->form_validation->set_rules('theyear','Theyear','required');

			if($this->form_validation->run())
            {
                $params = array(
					'theclass' => $this->input->post('theclass'),
					'theyear' => $this->input->post('theyear'),
					'studentphoto' => $this->input->post('studentphoto'),
					'names' => $this->input->post('names'),
					'stream' => $this->input->post('stream'),
                );

                $this->Student_model->update_student($id,$params);
                redirect('student/index');
            }
            else
            {
                $data['view'] = 'student/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The student you are trying to edit does not exist.');
    } */



    function edit($id)
    {
        // check if the student exists before trying to edit it
        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
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

                $this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                $this->load->model('Stream_model');
                $data['streams'] = $this->Stream_model->get_all_streams();

                $this->load->model('Realclass_model');
                $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

                $data['view'] = 'student/edit';
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student you are trying to edit does not exist.');
    }

    function fileuploader($id)
    {
        // check if the student exists before trying to edit it
        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {

            $data['view'] = 'student/photouploader';
            $this->load->view('admin/layout', $data);
        } else {
            show_error('The student whose photo you are trying to uppload does not exist.');
        }
    }

    function fileuploader_removed($id)
    {
        // check if the student exists before trying to edit it
        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('studentphoto', 'Student Photo', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    //'theclass' => $this->input->post('theclass'),
                    //'theyear' => $this->input->post('theyear'),
                    'studentphoto' => $this->input->post('studentphoto'),
                    //'names' => $this->input->post('student'),
                    //'stream' => $this->input->post('stream'),
                );

                /* $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();*/

                //$this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                /*   $this->load->model('Stream_model');
                 $data['streams'] = $this->Stream_model->get_all_streams();

                $this->load->model('Realclass_model');
                $data['realclasses'] = $this->Realclass_model->get_all_realclasses();*/

                $data['view'] = 'student/uploadphoto';
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student whose photo you are trying to uppload does not exist.');
    }




    /*
     * Deleting student
     */
    function remove($id)
    {
        $student = $this->Student_model->get_student($id);

        // check if the student exists before trying to delete it
        if (isset($student['id'])) {
            $this->Student_model->delete_student($id);
            redirect('student/index');
        } else
            show_error('The student you are trying to delete does not exist.');
    }

    function import()
    {
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $names = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $class = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $stream = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $year = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    //	$country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $data[] = array(
                        'names'        =>    $names,
                        'theclass' => $class,
                        'stream' => $city,
                        'theyear' => $postal_code,
                        //'Country'	=>	$country
                    );
                }
            }
            $this->excel_import_model->insert($data);
            echo 'Data Imported successfully';
        }
    }

    function generate_report($id)
    {

        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('names', 'Names', 'required');
            $this->form_validation->set_rules('theclass', 'Theclass', 'required');
            $this->form_validation->set_rules('theyear', 'Theyear', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'theclass' => $this->input->post('theclass'),
                    'theyear' => $this->input->post('theyear'),
                    'names' => $this->input->post('names'),
                    'stream' => $this->input->post('stream'),
                );

                $this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                $this->load->model('Semester_model');
                $data['semesters'] = $this->Semester_model->get_all_semesters();

                //$data['view'] = 'student/generate_report';
                $data['view'] = 'student/generate_full_report';
                // $this->load->view('layouts/main', $data);
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student whose report you want to generate does not exist.');
    }


    function generate_report_eot_only($id)
    {

        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('names', 'Names', 'required');
            $this->form_validation->set_rules('theclass', 'Class', 'required');
            $this->form_validation->set_rules('theyear', 'Year', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'theclass' => $this->input->post('theclass'),
                    'theyear' => $this->input->post('theyear'),
                    'names' => $this->input->post('names'),
                    'stream' => $this->input->post('stream'),
                );

                $this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                $this->load->model('Semester_model');
                $data['semesters'] = $this->Semester_model->get_all_semesters();

                //$data['view'] = 'student/generate_report';
                //$data['view'] = 'student/generate_full_report';
                $data['view'] = 'student/generate_eot_report_only';
                // $this->load->view('layouts/main', $data);
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student whose report you want to generate does not exist.');
    }

    function generate_eot_report_only($id)
    {

        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('names', 'Names', 'required');
            $this->form_validation->set_rules('theclass', 'Theclass', 'required');
            $this->form_validation->set_rules('theyear', 'Theyear', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'theclass' => $this->input->post('theclass'),
                    'theyear' => $this->input->post('theyear'),
                    'names' => $this->input->post('names'),
                    'stream' => $this->input->post('stream'),
                );

                $this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                $this->load->model('Semester_model');
                $data['semesters'] = $this->Semester_model->get_all_semesters();

                $data['view'] = 'student/generate_eot_report_only';
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student whose report you want to generate does not exist.');
    }


    function generate_eot_report($id)
    {

        $data['student'] = $this->Student_model->get_student($id);

        if (isset($data['student']['id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('names', 'Names', 'required');
            $this->form_validation->set_rules('theclass', 'Theclass', 'required');
            $this->form_validation->set_rules('theyear', 'Theyear', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'theclass' => $this->input->post('theclass'),
                    'theyear' => $this->input->post('theyear'),
                    'names' => $this->input->post('names'),
                    'stream' => $this->input->post('stream'),
                );

                $this->Student_model->update_student($id, $params);
                redirect('student/index');
            } else {
                $this->load->model('Semester_model');
                $data['semesters'] = $this->Semester_model->get_all_semesters();

                $data['view'] = 'student/generate_eot_report';
                $this->load->view('admin/layout', $data);
            }
        } else
            show_error('The student whose report you want to generate does not exist.');
    }


    // add image from form
    public function add_image()
    {
        // CI form validation
        $this->form_validation->set_rules('studentphoto', 'Student Photo', 'required');
        // $this->form_validation->set_rules('image_name', 'Image Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('student');
        } else {
            // configurations from upload library
            $config['upload_path'] = './assets/images';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048000'; // max size in KB
            $config['max_width'] = '20000'; //max resolution width
            $config['max_height'] = '20000';  //max resolution height
            // load CI libarary called upload
            $this->load->library('upload', $config);
            // body of if clause will be executed when image uploading is failed
            if (!$this->upload->do_upload()) {
                $errors = array('error' => $this->upload->display_errors());
                // This image is uploaded by deafult if the selected image in not uploaded
                $image = 'no_image.png';
            }
            // body of else clause will be executed when image uploading is succeeded
            else {
                $data = array('upload_data' => $this->upload->data());
                //$image = $_FILES['userfile']['name'];  //name must be userfile
                $image = $_FILES['studentphoto']['name'];  //name must be userfile

            }
            $this->Image_model->insert_image($image);
            $this->session->set_flashdata('success', 'Image stored');
            redirect('Image');
        }
    }

    // view images fetched from database
    public function view_images()
    {
        $data['images'] = $this->Image_model->get_images();
        $this->load->view('student/index', $data);
    }



    // import excel data
    public function save()
    {
        $this->load->library('excel');

        if ($this->input->post('importfile')) {
            $path = ROOT_UPLOAD_IMPORT_PATH;

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('names', 'theclass', 'stream', 'theyear');
            $makeArray = array('names' => 'names', 'theclass' => 'theclass', 'stream' => 'stream', 'theyear' => 'theyear');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else { }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);

            if (empty($data)) {
                $flag = 1;
            }
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $addresses = array();
                    $names = $SheetDataKey['names'];
                    $class = $SheetDataKey['theclass'];
                    $stream = $SheetDataKey['stream'];
                    $year = $SheetDataKey['theyear'];
                    // $contactNo = $SheetDataKey['Contact_NO'];
                    $names = filter_var(trim($allDataInSheet[$i][$fnames]), FILTER_SANITIZE_STRING);
                    $class = filter_var(trim($allDataInSheet[$i][$class]), FILTER_SANITIZE_STRING);
                    $stream = filter_var(trim($allDataInSheet[$i][$stream]), FILTER_SANITIZE_EMAIL);
                    $year = filter_var(trim($allDataInSheet[$i][$year]), FILTER_SANITIZE_STRING);
                    //$contactNo = filter_var(trim($allDataInSheet[$i][$contactNo]), FILTER_SANITIZE_STRING);
                    $fetchData[] = array('names' => $names, 'theclass' => $class, 'stream' => $stream, 'theyear' => $year);
                }
                $data['studentInfo'] = $fetchData;
                $this->import->setBatchImport($fetchData);
                $this->import->importData();
            } else {
                echo "Please import correct file";
            }
        }
        $this->load->view('student/index', $data);
    }



    public function generate_pdf()
    {
        //load pdf library
        $this->load->library('Pdf');

        $names = $this->input->post('names');

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://www.aiconnet.com');
        $pdf->SetTitle($names . '' . 'End of Term Student Report');
        $pdf->SetSubject('Report generated powered by AICONNET.COM');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(false);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // ---------------------------------------------------------



        // create some HTML content
        //$names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $html2 = '
                 <h1 style="text-align:center;">AVEMA SECONDARY & VOCATION SCHOOL</h1>
                  <p style="text-align:center;"> P.O. Box 406, Mityana, Uganda</p>
                  <p>&nbsp;</p>
                  <img id="image1" src="<?PHP echo base_url(); ?>images/logo.jpg" />
              <!-- <img src="images/logo.jpg" alt="test alt attribute" width="30" height="30" border="0" /><br/>-->
               <h2 style="text-align:center;">END OF TERM REPORT</h2><p>&nbsp;</p>
               <!--<div style="text-align:center;">
               </div>--> ';

        $schoolname = ' <h1 style="text-align:center;">AVEMA SECONDARY & VOCATION SCHOOL</h1>';
        $schooladdress = 'P.O. Box 406, Mityana, Uganda';
        $schoollogo = '<img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /><br/>';
        $eot_report = 'END OF TERM REPORT';


        $template2 = array(
            'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',

        );

        $this->table->set_template($template2);
        $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
        $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
        $this->table->add_row('Position by Total: ', 'Out of: ');
        $html3 = $this->table->generate();

        //Generate HTML table data from MySQL - start
        $template = array(
            'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',
        );

        $this->table->set_template($template);

        $this->table->set_heading('Subject', 'BOT (100)', 'Grade', 'Remarks', 'Subject Teacher');

        $studentmarks = $this->Mark_model->get_student_marks();

        foreach ($studentmarks as $sf) :
            //find grade
            $marks = $sf['mark1'];

            if ($marks >= 80 && $marks <= 100) {
                $grade = "D 1";
                $d1 = 1;
            } else if ($marks >= 75 && $marks <= 79) {
                $grade = "D 2";
                $d2 = 2;
            } else if ($marks >= 70 && $marks <= 74) {
                $grade = "C 3";
                $c3 = 3;
            } else if ($marks >= 65 && $marks <= 69) {
                $grade = "C 4";
                $c4 = 4;
            } else if ($marks >= 60 && $marks <= 64) {
                $grade = "C 5";
                $c5 = 5;
            } else if ($marks >= 50 && $marks <= 59) {
                $grade = "C 6";
                $c6 = 6;
            } else if ($marks >= 45 && $marks <= 49) {
                $grade = "P 7";
                $p7 = 7;
            } else if ($marks >= 35 && $marks <= 44) {
                $grade = "P 8";
                $p8 = 8;
            } else if ($marks >= 0 && $marks <= 34) {
                $grade = "F 9";
                $f9 = 9;
            } else {
                //if student doesn't offer subject then put "-"
                //otherwise
                //Didn't sit for the paper
                $grade = "F 9";
            }

            $this->table->add_row($sf['subject'], $sf['mark1'], $grade, $sf['comment'], $sf['subjectteacher']);

        endforeach;
        //  }

        $subject_number = $this->Mark_model->number_of_subjects_offered();
        $marks_out_of = $subject_number * 100;

        $total_marks = $this->Mark_model->get_total_marks();
        $average_marks = $this->Mark_model->get_average_marks();
        $num_of_students_in_stream = $this->Student_model->get_all_students_count_in_stream();

        $html = $this->table->generate();
        //Generate HTML table data from MySQL - end

        // add a page
        $pdf->AddPage();

        // set cell padding
        // $pdf->setCellPaddings(1, 1, 1, 1);

        // set cell margins
        // $pdf->setCellMargins(1, 1, 1, 1);

        // set color for background
        $pdf->SetFillColor(255, 255, 127);

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        // output the HTML content
        //$pdf->$setPrintFooter(false);


        // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
        // $pdf->MultiCell(0, 4, $schoolname, 0, 'L', 0, 0, 40, 10, true);
        $pdf->Cell(0, 10, "AVEMA SECONDARY & VOCATIONAL SCHOOL", 0, 1, C);
        $pdf->Ln(2);
        $pdf->Cell(0, 10, $schooladdress, 0, 1, C);
        $pdf->Ln(3);
        $pdf->Cell(0, 27, "LOGO", 0, 1, C);
        $pdf->Ln(1);
        $pdf->Cell(0, 10, $eot_report, 0, 1, C);
        // $pdf->writeHTML($html2, true, false, true, false, '');
        $pdf->Ln(1);
        $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
        $pdf->Ln(5);
        $pdf->MultiCell(60, 5, 'Student #: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(5);

        // $pdf->MultiCell(55, 5, '[LEFT] '.$txt, 1, 'L', 1, 0, '', '', true);
        //$pdf->writeHTML($names,true, false, true, false, '');

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Ln(2);
        $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Average Mark: ' . round($average_marks), 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(5);
        $pdf->MultiCell(60, 7, 'Position by Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Division: ' . '', 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(60, 7, 'Class Teacher: ' . 'Noah Kirigwajjo', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(60, 7, 'Head Teacher: ' . 'Job Kafeero', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);


        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(12);
        $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'System developed by AiconNet.com', 0, 'R', 0, 0, '', '', true);



        // $pdf->writeHTML($html3, true, false, true, false, '');


        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        //$pdf->Output(md5(time()).'.pdf', 'D');
        //$pdf->Output(md5(Semester Report.'.pdf', 'D');
        ob_end_clean();
        $pdf->Output('Semester Report.pdf', 'I');
    }


    //END OF TERM REPORT PDF GENERATION
    public function generate_pdf_eot()
    {
        //load pdf library
        $this->load->library('Pdf');

        $names = $this->input->post('names');

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://www.aiconnet.com');
        $pdf->SetTitle($names . '' . 'End of Term Report');
        $pdf->SetSubject('Report generated powered by AICONNET.COM');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('helvetica', '', 8);

        // ---------------------------------------------------------

        $dir = "images/"; // Your Path to folder

        // create some HTML content
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $html2 = '
                 <h1 style="text-align:center;">AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>
                  <p style="text-align:center;"> P.O. Box 406, Mityana, Uganda</p>
                  <!--<p>&nbsp;</p>-->
          <p style="text-align:center;">
          <center>
          <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" />
          </centre></p>

              <!-- <img src=<?php echo site_url("/images/logo.jpg"); ?> width="30" height="30" border="0" />-->

               <h2 style="text-align:center;">END OF TERM REPORT</h2><p>&nbsp;</p>
               <!--<div style="text-align:center;">
               </div>--> ';

        $schoolname = ' <h1 style="text-align:center;">AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
        $schooladdress = 'P.O. Box 406, Mityana, Uganda';
        $schoollogo = '<img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /><br/>';
        $eot_report = 'END OF TERM REPORT';

        $template2 = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1">',

        );

        $this->table->set_template($template2);
        $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
        $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
        $this->table->add_row('Position by Total: ', 'Out of: ');
        $html3 = $this->table->generate();

        //Generate HTML table data from MySQL - start
        $template = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1">',
        );

        $this->table->set_template($template);

        $this->table->set_heading('Subject', 'BOT (100)', 'EOT (100)', 'Average', 'Grade', 'Remarks', 'Subject Teacher');

        //  $studentmarks_eot = $this->Markeot_model->get_student_marks_eot();
        $studentmarks_eot = $this->Markeot2_model->get_student_marks();

        $tot_average_mark = 0;

        foreach ($studentmarks_eot as $sf_eot) :
            //find grade
            $marks1 = $sf_eot['mark1'];
            $marks2 = $sf_eot['mark2'];
            $student_class = $sf_eot['hisclass'];
            $av_mark = $sf_eot['average_mark'];

            //find average mark
            $av_mark = round(($marks1 + $marks2) / 2, 0, PHP_ROUND_HALF_UP);

            // find the grade of each average
            if ($av_mark >= 80 && $av_mark <= 100) {
                $grade = "D 1";
                //$grade = 1;
                $comment = "Excellent";
                // $d1 = 1;
            } else if ($av_mark >= 75 && $av_mark <= 79) {
                $grade = "D 2";
                //$grade = 2;
                $comment = "Very Good";
                // $d2 = 2;
            } else if ($av_mark >= 70 && $av_mark <= 74) {
                $grade = "C 3";
                //$grade = 3;
                $comment = "Good";
                // $c3 = 3;
            } else if ($av_mark >= 65 && $av_mark <= 69) {
                $grade = "C 4";
                //$grade = 4;
                $comment = "Good";
                // $c4 = 4;
            } else if ($av_mark >= 60 && $av_mark <= 64) {
                $grade = "C 5";
                //$grade = 5;
                $comment = "Good";
                // $c5 = 5;
            } else if ($av_mark >= 50 && $av_mark <= 59) {
                $grade = "C 6";
                //$grade = 6;
                $comment = "Fair";
                // $c6 = 6;
            } else if ($av_mark >= 45 && $av_mark <= 49) {
                $grade = "P 7";
                //$grade = 7;
                $comment = "Fair";
                // $p7 = 7;
            } else if ($av_mark >= 35 && $av_mark <= 44) {
                $grade = "P 8";
                //$grade = 8;
                $comment = "Poor";
                // $p8 = 8;
            } else if ($av_mark >= 0 && $av_mark <= 34) {
                $grade = "F 9";
                //$grade = 9;
                $comment = "Work harder";
                // $f9 = 9;
            } else {
                //if student doesn't offer subject then put "-"
                // $grade = "-";
                //otherwise
                //Didn't sit for the paper
                $grade = "F 9";
                $comment = "Missed Exam";
            }

            $this->table->add_row($sf_eot['subject'], $sf_eot['mark1'], $sf_eot['mark2'], $av_mark, $grade, $comment, $sf_eot['subjectteacher']);
            // $tot_average_mark=$tot_average_mark+$av_mark;
            $tot_average_mark = $tot_average_mark + $av_mark;

        endforeach;
        //  }

        //$this->Mark_model->create_ranked_view();

        $position_in_stream = $this->Mark_model->position_by_total();

        /* $connection = mysqli_connect("localhost","frankhos_sklr3po","Matthew24:13","frankhos_sklr3po");

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
                        $position_in_stream= $row['rank'];
                    }
             endwhile;*/


        if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
            $marks_out_of = 1800;
            $a_mark = $tot_average_mark / 18;
        } else {
            //$subject_number = $this->Markeot_model->number_of_subjects_offered();
            $subject_number = 10;
            $marks_out_of = $subject_number * 100;
            $a_mark = $tot_average_mark / $subject_number;
        }

        // $subject_number = $this->Markeot_model->number_of_subjects_offered();
        // $marks_out_of = $subject_number * 100;

        //$total_marks = $this->Markeot2_model->get_total_marks();
        //$average_marks = $this->Markeot_model->get_average_marks();
        $num_of_students_in_stream = $this->Student_model->get_all_students_count_in_stream();

        $html = $this->table->generate();
        //Generate HTML table data from MySQL - end


        // add a page
        $pdf->AddPage();

        // set cell padding
        // $pdf->setCellPaddings(1, 1, 1, 1);

        // set cell margins
        // $pdf->setCellMargins(1, 1, 1, 1);

        // set color for background
        $pdf->SetFillColor(255, 255, 127);

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        // output the HTML content
        //$pdf->$setPrintFooter(false);


        // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
        // $pdf->MultiCell(0, 4, $schoolname, 0, 'L', 0, 0, 40, 10, true);


        // $pdf->Cell(0,10,"AVEMA SECONDARY & VOCATION SCHOOL",0,1,C);
        //$pdf->Ln(2);
        //$pdf->Cell(0,10,$schooladdress,0,1,C);
        // $pdf->Ln(2);
        //$pdf->Cell(0,10,"LOGO",0,1,C);
        // $pdf->Ln(1);
        // $pdf->Cell(0,10,$eot_report,0,1,C);


        $pdf->writeHTML($html2, true, false, true, false, '');
        $pdf->Ln(1);
        $pdf->MultiCell(67, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(67, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(66, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
        $pdf->Ln(5);
        $pdf->MultiCell(67, 5, 'Student #: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(67, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(66, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(6);

        // $pdf->MultiCell(55, 5, '[LEFT] '.$txt, 1, 'L', 1, 0, '', '', true);
        //$pdf->writeHTML($names,true, false, true, false, '');

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Ln(3);
        $pdf->MultiCell(67, 7, 'Total: ' . $tot_average_mark, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(67, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(66, 7, 'Average Mark: ' . round($a_mark), 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(5);
        $pdf->MultiCell(67, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(67, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(66, 7, 'Division: ' . '', 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(12);
        $pdf->MultiCell(67, 7, 'Class Teacher: ' . '__________________', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(67, 7, 'Comment: ' . '__________________', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(66, 7, 'Signature: ' . '__________________', 0, 'C', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(67, 7, 'Head Teacher: ' . 'Kizza Rosemary Kayonga', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(67, 7, 'Comment: ' . '__________________', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(66, 7, 'Signature: ' . '__________________', 0, 'C', 0, 0, '', '', true);


        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(20);
        $pdf->MultiCell(200, 7, 'Note: This report card is invalid without a stamp', 0, 'C', 0, 0, '', '', true);
        $pdf->Ln(5);
        $pdf->MultiCell(200, 7, 'System developed by AICONNET.COM', 0, 'C', 0, 0, '', '', true);



        // $pdf->writeHTML($html3, true, false, true, false, '');


        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        //$pdf->Output(md5(time()).'.pdf', 'D');
        //$pdf->Output(md5(Semester Report.'.pdf', 'D');
        ob_end_clean();
        $pdf->Output('End of Term Report.pdf', 'I');
    }

    //END OF TERM ONLY REPORT PDF GENERATION
    function generate_pdf_selector()
    {
        $generatorselector = $this->input->post('generatorselector');

        if ($generatorselector == 'Begining of Term Generator(BOT)') {
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $lcase_joined_names = strtolower($joined_names);
            $student_photo_file_name = $student_id . "_" . $lcase_joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'Beginning of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skoolr, Schools, Reports, School report generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            // Image example with resizing
            //$pdf->Image('views/student/images/student_photos/287_bbosa_denis.jpg', 350, 140, 75, 113, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);
            // $pdf->Image('images/student_photos/bbosadenis.jpg', 7, 20, 75, 113, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);

            // $html2 = '<h1 style="text-align:center;">AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>
            // <p style="text-align:center;"> P.O. Box 406, Mityana, Uganda</p>

            // <p style="text-align:center;">
            // <center>
            //  <img src="./images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0"/>
            //   </centre>
            // </p>
            //    <h2 style="text-align:center;">END OF TERM REPORT</h2><p>&nbsp;</p> ';
            $pathx = "./images/student_photos/";
            $file = $student_photo_file_name;
            // $student_image = './images/student_photos/1_asarah_juliet.jpg';
            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            // $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';

            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            /*$studentphoto = '<img src="<?php echo $student_image; ?>"  alt="test alt attribute" width="100" height="100" border="0" /><br/>';*/
            /*$studentphoto = "<img src='<?php echo $student_image; ?>'  alt='test alt attribute' width='100' height='100' border='0' /><br/>";*/
            // $studentphoto = echo '<img src="' . $pathx . $file . '">';
            $studentphoto = '<img src="' . $pathx . $file . '" alt="test alt attribute" width="100" height="100" border="0">';
            //$studentphoto = $pdf->Image('./uploads/student_photos/' . $student_photo_file_name, 15, 75, 100, 100, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);

            $template2 = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template);
            $this->table->set_heading('Subject', 'BOT (100)', 'Grade', 'Remarks', 'Subject Teacher');
            $studentmarks = $this->Mark_model->get_student_marks();
            $besteight = $this->Mark_model->get_student_best_eight_marks_bot_only();
            $total_agg_in_best_eight = 0;
            $total_aggreg = 0;

            foreach ($studentmarks as $sf) :
                //find grade
                $marks = $sf['mark1'];
                $student_class = $sf['hisclass'];
                if ($marks >= 80 && $marks <= 100) {
                    $grade = "D 1";
                    $comment = "Excellent";
                    $aggreg = 1;
                } else if ($marks >= 75 && $marks <= 79) {
                    $grade = "D 2";
                    $comment = "Very Good";
                    $aggreg = 2;
                } else if ($marks >= 70 && $marks <= 74) {
                    $grade = "C 3";
                    $comment = "Good";
                    $aggreg = 3;
                } else if ($marks >= 65 && $marks <= 69) {
                    $grade = "C 4";
                    $comment = "Good";
                    $aggreg = 4;
                } else if ($marks >= 60 && $marks <= 64) {
                    $grade = "C 5";
                    $comment = "Good";
                    $aggreg = 5;
                } else if ($marks >= 50 && $marks <= 59) {
                    $grade = "C 6";
                    $comment = "Fair";
                    $aggreg = 6;
                } else if ($marks >= 45 && $marks <= 49) {
                    $grade = "P 7";
                    $comment = "Fair";
                    $aggreg = 7;
                } else if ($marks >= 35 && $marks <= 44) {
                    $grade = "P 8";
                    $comment = "Pull up";
                    $aggreg = 8;
                } else if ($marks >= 0 && $marks <= 34) {
                    $grade = "F 9";
                    $comment = "Poor";
                    $aggreg = 9;
                } else {
                    //if student doesn't offer subject then put "-"
                    //otherwise
                    //Didn't sit for the paper
                    $grade = "F 9";
                    $comment = "Explanation needed";
                    $aggreg = 9;
                }

                $this->table->add_row($sf['subject'], $sf['mark1'], $grade, $comment, $sf['subjectteacher']);
                $total_aggreg = $total_aggreg + $aggreg;

            endforeach;

            $headteacher = 'Kizza Rosemary Kayonga';

            if ($theclass == 'Senior 4' && $stream == 'Blue') {

                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }

            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;

                foreach ($besteight as $be) :
                    $best_marks = $be['mark1'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;

                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_bot' . $lastch_class . $stream . $lastch_term . $theyear;

            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_bot();
                $position_in_stream = $this->Mark_model->position_by_total_bot();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_bot();
            }
            $total_marks = $this->Mark_model->get_total_marks();
            $average_marks = $this->Mark_model->get_average_marks();
            $num_of_students_in_stream = $this->Student_model->get_all_students_count_in_stream();

            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);

            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);

            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(1);
            $pdf->Ln(1);
            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } elseif ($generatorselector == 'End of Term Generator(EOT)') {
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $student_photo_file_name = $student_id . "_" . $joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'End of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skoolr, Schools, Reports, School report generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            // set JPEG quality
            $pdf->setJPEGQuality(75);

            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            $studentphoto = $pdf->Image('./uploads/student_photos/' . $student_photo_file_name, 15, 75, 100, 100, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);
            $template2 = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template);
            $this->table->set_heading('Subject', 'EOT (100)', 'Grade', 'Remarks', 'Subject Teacher');
            $studentmarks = $this->Mark_model->get_student_marks();
            $besteight = $this->Mark_model->get_student_best_eight_marks_eot_only();
            $total_agg_in_best_eight = 0;
            $total_aggreg = 0;

            foreach ($studentmarks as $sf) :
                //find grade
                $marks = $sf['mark1'];
                $student_class = $sf['hisclass'];
                if ($marks >= 80 && $marks <= 100) {
                    $grade = "D 1";
                    $comment = "Excellent";
                    $aggreg = 1;
                } else if ($marks >= 75 && $marks <= 79) {
                    $grade = "D 2";
                    $comment = "Very Good";
                    $aggreg = 2;
                } else if ($marks >= 70 && $marks <= 74) {
                    $grade = "C 3";
                    $comment = "Good";
                    $aggreg = 3;
                } else if ($marks >= 65 && $marks <= 69) {
                    $grade = "C 4";
                    $comment = "Good";
                    $aggreg = 4;
                } else if ($marks >= 60 && $marks <= 64) {
                    $grade = "C 5";
                    $comment = "Good";
                    $aggreg = 5;
                } else if ($marks >= 50 && $marks <= 59) {
                    $grade = "C 6";
                    $comment = "Fair";
                    $aggreg = 6;
                } else if ($marks >= 45 && $marks <= 49) {
                    $grade = "P 7";
                    $comment = "Fair";
                    $aggreg = 7;
                } else if ($marks >= 35 && $marks <= 44) {
                    $grade = "P 8";
                    $comment = "Pull up";
                    $aggreg = 8;
                } else if ($marks >= 0 && $marks <= 34) {
                    $grade = "F 9";
                    $comment = "Poor";
                    $aggreg = 9;
                } else {
                    //if student doesn't offer subject then put "-"
                    //otherwise
                    //Didn't sit for the paper
                    $grade = "F 9";
                    $comment = "Explanation needed";
                    $aggreg = 9;
                }

                $this->table->add_row($sf['subject'], $sf['mark1'], $grade, $comment, $sf['subjectteacher']);
                $total_aggreg = $total_aggreg + $aggreg;

            endforeach;

            $headteacher = 'Kizza Rosemary Kayonga';

            if ($theclass == 'Senior 4' && $stream == 'Blue') {

                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }

            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;

                foreach ($besteight as $be) :
                    $best_marks = $be['mark1'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;

                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_eot' . $lastch_class . $stream . $lastch_term . $theyear;
            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_eot();
                $position_in_stream = $this->Mark_model->position_by_total_eot();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_eot();
            }
            $total_marks = $this->Mark_model->get_total_marks_eot_only();
            $average_marks = $this->Mark_model->get_average_marks_eot_only();
            $num_of_students_in_stream = $this->Mark_model->get_all_students_count_in_stream();
            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);
            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(2);

            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } elseif ($generatorselector == 'Full Term generator (BOT & EOT)') {
            //Full term report generator here
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $student_photo_file_name = $student_id . "_" . $joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'End of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skoolr, Schools, Reports, School report generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            // set JPEG quality
            $pdf->setJPEGQuality(75);

            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            $studentphoto = $pdf->Image('./uploads/student_photos/' . $student_photo_file_name, 15, 75, 100, 100, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);
            $template2 = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template);
            //  $this->table->set_heading('Subject', 'EOT (100)', 'Grade', 'Remarks', 'Subject Teacher');
            $this->table->set_heading('Subject', 'BOT (100)', 'EOT (100)', 'Average', 'Grade', 'Remarks', 'Subject Teacher');
            //$studentmarks = $this->Mark_model->get_student_marks();
            $studentmarks_full = $this->Mark_model->get_student_full_marks();
            $besteight = $this->Mark_model->get_student_best_eight_marks_full();
            $total_agg_in_best_eight = 0;
            $total_aggreg = 0;

            foreach ($studentmarks_full as $sf) :
                //find grade
                $marks1 = $sf_eot['mark1'];
                $marks2 = $sf_eot['mark2'];
                $student_class = $sf_eot['hisclass'];
                $av_mark = $sf_eot['average_mark'];
                //find average mark
                $av_mark = round(($marks1 + $marks2) / 2, 0, PHP_ROUND_HALF_UP);

                // find the grade of each average
                if ($av_mark >= 80 && $av_mark <= 100) {
                    $grade = "D 1";
                    $comment = "Excellent";
                    $aggreg = 1;
                } else if ($av_mark >= 75 && $av_mark <= 79) {
                    $grade = "D 2";
                    $comment = "Very Good";
                    $aggreg = 2;
                } else if ($av_mark >= 70 && $av_mark <= 74) {
                    $grade = "C 3";
                    $comment = "Good";
                    $aggreg = 3;
                } else if ($av_mark >= 65 && $av_mark <= 69) {
                    $grade = "C 4";
                    $comment = "Good";
                    $aggreg = 4;
                } else if ($av_mark >= 60 && $av_mark <= 64) {
                    $grade = "C 5";
                    $comment = "Good";
                    $aggreg = 5;
                } else if ($av_mark >= 50 && $av_mark <= 59) {
                    $grade = "C 6";
                    $comment = "Fair";
                    $aggreg = 6;
                } else if ($av_mark >= 45 && $av_mark <= 49) {
                    $grade = "P 7";
                    $comment = "Fair";
                    $aggreg = 7;
                } else if ($av_mark >= 35 && $av_mark <= 44) {
                    $grade = "P 8";
                    $comment = "Poor";
                    $aggreg = 8;
                } else if ($av_mark >= 0 && $av_mark <= 34) {
                    $grade = "F 9";
                    $comment = "Work harder";
                    $aggreg = 9;
                } else {
                    //if student doesn't offer subject then put "-"
                    // $grade = "-";
                    //otherwise
                    //Didn't sit for the paper
                    $grade = "F 9";
                    $comment = "Missed Exam";
                    $aggreg = 9;
                }


                //$this->table->add_row($sf['subject'], $sf['mark1'], $grade, $comment, $sf['subjectteacher']);
                $this->table->add_row($sf_eot['subject'], $sf_eot['mark1'], $sf_eot['mark2'], $av_mark, $grade, $comment, $sf_eot['subjectteacher']);

                $total_aggreg = $total_aggreg + $aggreg;

            endforeach;
            //Find Head Teacher
            $headteacher = 'Kizza Rosemary Kayonga';

            //Find Class Teacher
            if ($theclass == 'Senior 4' && $stream == 'Blue') {
                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }
            //Total Marks based on subjects offered by student
            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;
                foreach ($besteight as $be) :
                    $best_marks = $be['average_mark'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;
                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_full' . $lastch_class . $stream . $lastch_term . $theyear;
            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_full();
                $position_in_stream = $this->Mark_model->position_by_total_full();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_full();
            }
            $total_marks = $this->Mark_model->get_total_marks_full();
            $average_marks = $this->Mark_model->get_average_marks_full();
            $num_of_students_in_stream = $this->Mark_model->get_all_students_count_in_stream();
            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);
            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(7);

            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } else {
            return;
        }
    }


    public function generate_pdf_eot_only()
    { }


    //END OF TERM REPORT PDF GENERATION






    //END OF TERM REPORT PDF GENERATION
    public function generate_full_pdf()
    {
        //load pdf library
        $this->load->library('Pdf');

        $names = $this->input->post('names');

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://www.aiconnet.com');
        $pdf->SetTitle($names . '' . '' . 'End of Term Report');
        $pdf->SetSubject('Report generated powered by AICONNET.COM');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(false);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // ---------------------------------------------------------



        // create some HTML content
        $names = $this->input->post('names');
        $theclass = $this->input->post('theclass');
        $theyear = $this->input->post('theyear');
        $stream = $this->input->post('stream');
        $semester = $this->input->post('term');

        $html2 = '
                 <h1 style="text-align:center;">AVEMA SECONDARY & VOCATION SCHOOL</h1>
                  <p style="text-align:center;"> P.O. Box 406, Mityana, Uganda</p>
                  <p>&nbsp;</p>
               <img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /><br/>
               <h2 style="text-align:center;">END OF TERM REPORT</h2><p>&nbsp;</p>
               <!--<div style="text-align:center;">
               </div>--> ';

        $schoolname = ' <h1 style="text-align:center;">AVEMA SECONDARY & VOCATION SCHOOL</h1>';
        $schooladdress = 'P.O. Box 406, Mityana, Uganda';
        $schoollogo = '<img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /><br/>';
        $eot_report = 'END OF TERM REPORT';


        $template2 = array(
            'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',

        );

        $this->table->set_template($template2);
        $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
        $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
        $this->table->add_row('Position by Total: ', 'Out of: ');
        $html3 = $this->table->generate();

        //Generate HTML table data from MySQL - start
        $template = array(
            'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',
        );

        $this->table->set_template($template);

        $this->table->set_heading('Subject', 'BOT (100)', 'EOT (100)', 'Average', 'Grade', 'Remarks', 'Subject Teacher');

        $studentmarks_eot = $this->Finalmarks_model->get_student_final_marks();


        foreach ($studentmarks_eot as $sf_eot) :
            //find grade
            $av_mark = $sf_eot['average_mark'];
            //find average mark
            //$av_mark = round(($marks1+$marks2)/2,0,PHP_ROUND_HALF_UP);
            // find the grade of each average
            if ($av_mark >= 80 && $av_mark <= 100) {
                $grade = "D 1";
                // $grade = 1;
                $comment = "Excellent";
            } else if ($av_mark >= 75 && $av_mark <= 79) {
                $grade = "D 2";
                $grade = 2;
                $comment = "Very Good";
            } else if ($av_mark >= 70 && $av_mark <= 74) {
                $grade = "C 3";
                //$grade = 3;
                $comment = "Good";
            } else if ($av_mark >= 65 && $av_mark <= 69) {
                $grade = "C 4";
                //$grade = 4;
                $comment = "Good";
            } else if ($av_mark >= 60 && $av_mark <= 64) {
                $grade = "C 5";
                //$grade = 5;
                $comment = "Good";
            } else if ($av_mark >= 50 && $av_mark <= 59) {
                $grade = "C 6";
                //$grade = 6;
                $comment = "Fair";
                // $c6 = 6;
            } else if ($av_mark >= 45 && $av_mark <= 49) {
                $grade = "P 7";
                //$grade = 7;
                $comment = "Fair";
                // $p7 = 7;
            } else if ($av_mark >= 35 && $av_mark <= 44) {
                $grade = "P 8";
                //$grade = 8;
                $comment = "Poor";
                // $p8 = 8;
            } else if ($av_mark >= 0 && $av_mark <= 34) {
                $grade = "F 9";
                //$grade = 9;
                $comment = "Work harder";
                // $f9 = 9;
            } else {
                //if student doesn't offer subject then put "-"
                // $grade = "-";
                //otherwise
                //Didn't sit for the paper
                $grade = 9;
                $comment = "Missed Exam";
            }

            // $this->table->add_row($sf_eot['subject'], $sf_eot['mark1'], $sf_eot['mark2'], $av_mark, $grade, $comment, $sf_eot['subjectteacher']);
            $this->table->add_row($sf_eot['subject'], $sf_eot['mark1'], $sf_eot['mark2'], $av_mark, $grade, $comment, $sf_eot['subjectteacher']);
        endforeach;
        //  }

        $subject_number = $this->Markeot_model->number_of_subjects_offered();
        $marks_out_of = $subject_number * 100;

        $total_marks = $this->Markeot_model->get_total_marks();
        $average_marks = $this->Markeot_model->get_average_marks();
        $num_of_students_in_stream = $this->Student_model->get_all_students_count_in_stream();

        $html = $this->table->generate();
        //Generate HTML table data from MySQL - end


        // add a page
        $pdf->AddPage();

        // set cell padding
        // $pdf->setCellPaddings(1, 1, 1, 1);

        // set cell margins
        // $pdf->setCellMargins(1, 1, 1, 1);

        // set color for background
        $pdf->SetFillColor(255, 255, 127);

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        // output the HTML content
        //$pdf->$setPrintFooter(false);


        // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
        // $pdf->MultiCell(0, 4, $schoolname, 0, 'L', 0, 0, 40, 10, true);
        $pdf->Cell(0, 10, "AVEMA SECONDARY & VOCATION SCHOOL", 0, 1, C);
        $pdf->Ln(2);
        $pdf->Cell(0, 10, $schooladdress, 0, 1, C);
        $pdf->Ln(2);
        $pdf->Cell(0, 27, "LOGO", 0, 1, C);
        $pdf->Ln(1);
        $pdf->Cell(0, 10, $eot_report, 0, 1, C);
        // $pdf->writeHTML($html2, true, false, true, false, '');
        $pdf->Ln(1);
        $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
        $pdf->Ln(5);
        $pdf->MultiCell(60, 5, 'Student #: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(5);

        // $pdf->MultiCell(55, 5, '[LEFT] '.$txt, 1, 'L', 1, 0, '', '', true);
        //$pdf->writeHTML($names,true, false, true, false, '');

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Ln(2);
        $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Average Mark: ' . round($average_marks), 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(5);
        $pdf->MultiCell(60, 7, 'Position by Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Division: ' . '', 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(9);
        $pdf->MultiCell(60, 7, 'Class Teacher: ' . 'Noah Kirigwajjo', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(60, 7, 'Head Teacher: ' . 'Job Kafeero', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);


        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(7);
        $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(14);
        $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);



        // $pdf->writeHTML($html3, true, false, true, false, '');


        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        //$pdf->Output(md5(time()).'.pdf', 'D');
        //$pdf->Output(md5(Semester Report.'.pdf', 'D');
        ob_end_clean();
        $pdf->Output('End of Term Report.pdf', 'I');
    }



//TOTAL  PDF REPORT GENERATION (A-LEVEL)
    function generate_pdf_selector_hsc()
    {
        $generatorselector = $this->input->post('generatorselector');

        if ($generatorselector == 'Begining of Term Generator(BOT)') {
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $lcase_joined_names = strtolower($joined_names);
            $student_photo_file_name = $student_id . "_" . $lcase_joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'Beginning of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skhoolr, Schools, Reports, School Report Generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            $pdf->setJPEGQuality(75);

            $pathx = "./images/student_photos/";
            $file = $student_photo_file_name;
            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            $studentphoto = '<img src="' . $pathx . $file . '" alt="test alt attribute" width="100" height="100" border="0">';

            $template2 = array(
                'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="3" cellspacing="1">',
            );

            $this->table->set_template($template);
            $this->table->set_heading('Subject', 'Paper', 'BOT(100)', 'Grade', 'Remarks', 'Subject Teacher');

            $subjectsforstudent_hsc = $this->Mark_model->get_student_subjects_hsc();
            $paper_hsc = $this->Mark_model->get_subject_paper_hsc();
            $studentmarks = $this->Mark_model->get_student_marks_hsc();

            // $total_agg_in_best_eight = 0;
            // $total_aggreg = 0;
            //$getgrade_hsc =

            foreach ($subjectsforstudent_hsc as $sfh) :
                $subject = $sfh['subject'];

                foreach ($paper_hsc as $p) :
                    $paper = $p['subjectcode'];

                    foreach ($studentmarks as $sm) :
                        $marks_hsc = $sm['mark1'];
                        $student_class = $sm['hisclass'];

                        if ($marks_hsc >= 80 && $marks_hsc <= 100) {
                            $grade = "D 1";
                            $comment = "Excellent";
                            $aggreg = 1;
                        } else if ($marks_hsc >= 75 && $marks_hsc <= 79) {
                            $grade = "D 2";
                            $comment = "Very Good";
                            $aggreg = 2;
                        } else if ($marks_hsc >= 70 && $marks_hsc <= 74) {
                            $grade = "C 3";
                            $comment = "Good";
                            $aggreg = 3;
                        } else if ($marks_hsc >= 65 && $marks_hsc <= 69) {
                            $grade = "C 4";
                            $comment = "Good";
                            $aggreg = 4;
                        } else if ($marks_hsc >= 60 && $marks_hsc <= 64) {
                            $grade = "C 5";
                            $comment = "Good";
                            $aggreg = 5;
                        } else if ($marks_hsc >= 50 && $marks_hsc <= 59) {
                            $grade = "C 6";
                            $comment = "Fair";
                            $aggreg = 6;
                        } else if ($marks_hsc >= 45 && $marks_hsc <= 49) {
                            $grade = "P 7";
                            $comment = "Fair";
                            $aggreg = 7;
                        } else if ($marks_hsc >= 35 && $marks_hsc <= 44) {
                            $grade = "P 8";
                            $comment = "Pull up";
                            $aggreg = 8;
                        } else if ($marks_hsc >= 0 && $marks_hsc <= 34) {
                            $grade = "F 9";
                            $comment = "Poor";
                            $aggreg = 9;
                        } else {
                            //if student doesn't offer subject then put "-"
                            //otherwise
                            //Didn't sit for the paper
                            $grade = "F 9";
                            $comment = "Explanation needed";
                            $aggreg = 9;
                        }

                        $this->table->add_row($sm['subject'], $sm['mark1'], $grade, $comment, $sf['subjectteacher']);

                    endforeach;
                endforeach;
            endforeach;


            $headteacher = 'Kizza Rosemary Kayonga';

            if ($theclass == 'Senior 4' && $stream == 'Blue') {

                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }

            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;

                foreach ($besteight as $be) :
                    $best_marks = $be['mark1'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;

                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_bot' . $lastch_class . $stream . $lastch_term . $theyear;

            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_bot();
                $position_in_stream = $this->Mark_model->position_by_total_bot();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_bot();
            }
            $total_marks = $this->Mark_model->get_total_marks();
            $average_marks = $this->Mark_model->get_average_marks();
            $num_of_students_in_stream = $this->Student_model->get_all_students_count_in_stream();

            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);

            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);

            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(1);
            $pdf->Ln(1);
            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } elseif ($generatorselector == 'End of Term Generator(EOT)') {
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $student_photo_file_name = $student_id . "_" . $joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'End of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skoolr, Schools, Reports, School report generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            // set JPEG quality
            $pdf->setJPEGQuality(75);

            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            $studentphoto = $pdf->Image('./uploads/student_photos/' . $student_photo_file_name, 15, 75, 100, 100, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);
            $template2 = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template);
            $this->table->set_heading('Subject', 'EOT (100)', 'Grade', 'Remarks', 'Subject Teacher');
            $studentmarks = $this->Mark_model->get_student_marks();
            $besteight = $this->Mark_model->get_student_best_eight_marks_eot_only();
            $total_agg_in_best_eight = 0;
            $total_aggreg = 0;

            foreach ($studentmarks as $sf) :
                //find grade
                $marks = $sf['mark1'];
                $student_class = $sf['hisclass'];
                if ($marks >= 80 && $marks <= 100) {
                    $grade = "D 1";
                    $comment = "Excellent";
                    $aggreg = 1;
                } else if ($marks >= 75 && $marks <= 79) {
                    $grade = "D 2";
                    $comment = "Very Good";
                    $aggreg = 2;
                } else if ($marks >= 70 && $marks <= 74) {
                    $grade = "C 3";
                    $comment = "Good";
                    $aggreg = 3;
                } else if ($marks >= 65 && $marks <= 69) {
                    $grade = "C 4";
                    $comment = "Good";
                    $aggreg = 4;
                } else if ($marks >= 60 && $marks <= 64) {
                    $grade = "C 5";
                    $comment = "Good";
                    $aggreg = 5;
                } else if ($marks >= 50 && $marks <= 59) {
                    $grade = "C 6";
                    $comment = "Fair";
                    $aggreg = 6;
                } else if ($marks >= 45 && $marks <= 49) {
                    $grade = "P 7";
                    $comment = "Fair";
                    $aggreg = 7;
                } else if ($marks >= 35 && $marks <= 44) {
                    $grade = "P 8";
                    $comment = "Pull up";
                    $aggreg = 8;
                } else if ($marks >= 0 && $marks <= 34) {
                    $grade = "F 9";
                    $comment = "Poor";
                    $aggreg = 9;
                } else {
                    //if student doesn't offer subject then put "-"
                    //otherwise
                    //Didn't sit for the paper
                    $grade = "F 9";
                    $comment = "Explanation needed";
                    $aggreg = 9;
                }

                $this->table->add_row($sf['subject'], $sf['mark1'], $grade, $comment, $sf['subjectteacher']);
                $total_aggreg = $total_aggreg + $aggreg;

            endforeach;

            $headteacher = 'Kizza Rosemary Kayonga';

            if ($theclass == 'Senior 4' && $stream == 'Blue') {

                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }

            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;

                foreach ($besteight as $be) :
                    $best_marks = $be['mark1'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;

                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_eot' . $lastch_class . $stream . $lastch_term . $theyear;
            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_eot();
                $position_in_stream = $this->Mark_model->position_by_total_eot();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_eot();
            }
            $total_marks = $this->Mark_model->get_total_marks_eot_only();
            $average_marks = $this->Mark_model->get_average_marks_eot_only();
            $num_of_students_in_stream = $this->Mark_model->get_all_students_count_in_stream();
            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);
            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(2);

            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } elseif ($generatorselector == 'Full Term generator (BOT & EOT)') {
            //Full term report generator here
            $this->load->library('Pdf');

            $student_id = $this->input->post('id');
            $names = $this->input->post('names');
            $theclass = $this->input->post('theclass');
            $theyear = $this->input->post('theyear');
            $stream = $this->input->post('stream');
            $semester = $this->input->post('term');

            $joined_names = str_replace(" ", "_", $names);
            $student_photo_file_name = $student_id . "_" . $joined_names . ".jpg";

            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('https://www.aiconnet.com');
            $pdf->SetTitle($names . '' . 'End of Term Report');
            $pdf->SetSubject('Report generated powered by AICONNET.COM');
            $pdf->SetKeywords('Skoolr, Schools, Reports, School report generator');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);
            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('helvetica', '', 8);
            // ---------------------------------------------------------
            // set JPEG quality
            $pdf->setJPEGQuality(75);

            $schoolname = '<h1>AVEMA SECONDARY & VOCATIONAL SCHOOL</h1>';
            $schooladdress = '<p style="color:green;font-size:14px;">P.O. Box 406, Mityana, Uganda</p>';
            $schoollogo = '<img src="./images/logo.jpg" alt="test alt attribute" width="100" height="100" border="0" /><br/>';
            $eot_report = '<p style="color:green;font-size:15px;">END OF TERM REPORT</p>';
            $studentphoto = $pdf->Image('./uploads/student_photos/' . $student_photo_file_name, 15, 75, 100, 100, 'JPG', 'http://www.aiconnet.com', '', true, 150, '', false, false, 1, false, false, false);
            $template2 = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template2);
            $this->table->add_row('Total: ', 'Out of: ', 'Average: ');
            $this->table->add_row('Position by Total: ', 'Out of: ', 'Best in 8: ');
            $this->table->add_row('Position by Total: ', 'Out of: ');
            $html3 = $this->table->generate();

            //Generate HTML table data from MySQL - start
            $template = array(
                'table_open' => '<table border="1" cellpadding="4" cellspacing="1">',
            );

            $this->table->set_template($template);
            //  $this->table->set_heading('Subject', 'EOT (100)', 'Grade', 'Remarks', 'Subject Teacher');
            $this->table->set_heading('Subject', 'BOT (100)', 'EOT (100)', 'Average', 'Grade', 'Remarks', 'Subject Teacher');
            //$studentmarks = $this->Mark_model->get_student_marks();
            $studentmarks_full = $this->Mark_model->get_student_full_marks();
            $besteight = $this->Mark_model->get_student_best_eight_marks_full();
            $total_agg_in_best_eight = 0;
            $total_aggreg = 0;

            foreach ($studentmarks_full as $sf) :
                //find grade
                $marks1 = $sf_eot['mark1'];
                $marks2 = $sf_eot['mark2'];
                $student_class = $sf_eot['hisclass'];
                $av_mark = $sf_eot['average_mark'];
                //find average mark
                $av_mark = round(($marks1 + $marks2) / 2, 0, PHP_ROUND_HALF_UP);

                // find the grade of each average
                if ($av_mark >= 80 && $av_mark <= 100) {
                    $grade = "D 1";
                    $comment = "Excellent";
                    $aggreg = 1;
                } else if ($av_mark >= 75 && $av_mark <= 79) {
                    $grade = "D 2";
                    $comment = "Very Good";
                    $aggreg = 2;
                } else if ($av_mark >= 70 && $av_mark <= 74) {
                    $grade = "C 3";
                    $comment = "Good";
                    $aggreg = 3;
                } else if ($av_mark >= 65 && $av_mark <= 69) {
                    $grade = "C 4";
                    $comment = "Good";
                    $aggreg = 4;
                } else if ($av_mark >= 60 && $av_mark <= 64) {
                    $grade = "C 5";
                    $comment = "Good";
                    $aggreg = 5;
                } else if ($av_mark >= 50 && $av_mark <= 59) {
                    $grade = "C 6";
                    $comment = "Fair";
                    $aggreg = 6;
                } else if ($av_mark >= 45 && $av_mark <= 49) {
                    $grade = "P 7";
                    $comment = "Fair";
                    $aggreg = 7;
                } else if ($av_mark >= 35 && $av_mark <= 44) {
                    $grade = "P 8";
                    $comment = "Poor";
                    $aggreg = 8;
                } else if ($av_mark >= 0 && $av_mark <= 34) {
                    $grade = "F 9";
                    $comment = "Work harder";
                    $aggreg = 9;
                } else {
                    //if student doesn't offer subject then put "-"
                    // $grade = "-";
                    //otherwise
                    //Didn't sit for the paper
                    $grade = "F 9";
                    $comment = "Missed Exam";
                    $aggreg = 9;
                }


                //$this->table->add_row($sf['subject'], $sf['mark1'], $grade, $comment, $sf['subjectteacher']);
                $this->table->add_row($sf_eot['subject'], $sf_eot['mark1'], $sf_eot['mark2'], $av_mark, $grade, $comment, $sf_eot['subjectteacher']);

                $total_aggreg = $total_aggreg + $aggreg;

            endforeach;
            //Find Head Teacher
            $headteacher = 'Kizza Rosemary Kayonga';

            //Find Class Teacher
            if ($theclass == 'Senior 4' && $stream == 'Blue') {
                $class_teacher = 'Nannyanje Jane';
            } else if ($theclass == 'Senior 4' && $stream == 'White') {
                $class_teacher = 'Kisseka Annual';
            } else {
                $class_teacher = 'Not yet ascertained';
            }
            //Total Marks based on subjects offered by student
            if ($student_class == 'Senior 1' || $student_class == 'Senior 2') {
                $marks_out_of = 1800;
            } else {
                $subject_number = $this->Mark_model->get_num_of_subjects_student_offers();
                $marks_out_of = $subject_number * 100;
                foreach ($besteight as $be) :
                    $best_marks = $be['average_mark'];
                    if ($best_marks >= 80 && $best_marks <= 100) {
                        $grade = "D 1";
                        $comment = "Excellent";
                        $aggreg_in_eight = 1;
                    } else if ($best_marks >= 75 && $best_marks <= 79) {
                        $grade = "D 2";
                        $comment = "Very Good";
                        $aggreg_in_eight = 2;
                    } else if ($best_marks >= 70 && $best_marks <= 74) {
                        $grade = "C 3";
                        $comment = "Good";
                        $aggreg_in_eight = 3;
                    } else if ($best_marks >= 65 && $best_marks <= 69) {
                        $grade = "C 4";
                        $comment = "Good";
                        $aggreg_in_eight = 4;
                    } else if ($best_marks >= 60 && $best_marks <= 64) {
                        $grade = "C 5";
                        $comment = "Good";
                        $aggreg_in_eight = 5;
                    } else if ($best_marks >= 50 && $best_marks <= 59) {
                        $grade = "C 6";
                        $comment = "Fair";
                        $aggreg_in_eight = 6;
                    } else if ($best_marks >= 45 && $best_marks <= 49) {
                        $grade = "P 7";
                        $comment = "Fair";
                        $aggreg_in_eight = 7;
                    } else if ($best_marks >= 35 && $best_marks <= 44) {
                        $grade = "P 8";
                        $comment = "Pull up";
                        $aggreg_in_eight = 8;
                    } else if ($best_marks >= 0 && $best_marks <= 34) {
                        $grade = "F 9";
                        $comment = "Poor";
                        $aggreg_in_eight = 9;
                    } else {
                        //if student doesn't offer subject then put "-"
                        //otherwise
                        //Didn't sit for the paper
                        $grade = "F 9";
                        $comment = "Explanation needed";
                        $aggreg_in_eight = 9;
                    }

                    $total_agg_in_best_eight = $total_agg_in_best_eight + $aggreg_in_eight;
                endforeach;

                if ($total_agg_in_best_eight >= 8 && $total_agg_in_best_eight <= 32) {
                    $division = "Division I";
                } else if ($total_agg_in_best_eight >= 33 && $total_agg_in_best_eight <= 45) {
                    $division = "Division II";
                } else if ($total_agg_in_best_eight >= 46 && $total_agg_in_best_eight <= 58) {
                    $division = "Division III";
                } else if ($total_agg_in_best_eight >= 59 && $total_agg_in_best_eight <= 68) {
                    $division = "Division IV";
                } else if ($total_agg_in_best_eight >= 69 && $total_agg_in_best_eight <= 72) {
                    $division = "Division IX";
                } else {
                    $division =  "Not Graded";
                }
            }
            //last character of a string
            $lastch_class = substr($theclass, -1);
            $lastch_term = substr($semester, -1);
            //Unique name for table
            $unique_tbl_name = 'rankingstbl_full' . $lastch_class . $stream . $lastch_term . $theyear;
            if (is_null($this->db->query("SHOW TABLES LIKE '{$unique_tbl_name}'")->row())) {
                $this->Mark_model->create_view_full();
                $position_in_stream = $this->Mark_model->position_by_total_full();
            } else {
                $position_in_stream = $this->Mark_model->position_by_total_full();
            }
            $total_marks = $this->Mark_model->get_total_marks_full();
            $average_marks = $this->Mark_model->get_average_marks_full();
            $num_of_students_in_stream = $this->Mark_model->get_all_students_count_in_stream();
            $html = $this->table->generate();
            $pdf->AddPage();
            // set color for background
            $pdf->SetFillColor(255, 255, 127);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->writeHTML($html7, true, false, true, false, '');
            // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
            // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

            $pdf->MultiCell(0, 4, $schoolname, 0, 'C', 0, 0, 15, 10, true, 0, true);
            $pdf->MultiCell(0, 4, $schooladdress, 0, 'C', 0, 0, 15, 20, true, 0, true);
            $pdf->MultiCell(0, 10, $schoollogo, 0, 'C', 0, 0, 15, 35, true, 0, true);
            $pdf->MultiCell(0, 10, $eot_report, 0, 'C', 0, 0, 15, 67, true, 0, true);
            $pdf->MultiCell(0, 10, $studentphoto, 0, 'L', 0, 0, 15, 75, true, 0, true);
            $pdf->MultiCell(0, 9, 'Names: ' . $names, 0, 'L', 0, 65, '75', '', true);
            $pdf->MultiCell(0, 9, 'Class: ' . $theclass, 0, 'L', 0, 90, '75', '', true);
            $pdf->MultiCell(0, 9, 'Stream: ' . $stream, 0, 'L', 0, 90, '75', '', true);
            $pdf->Ln(7);

            // $pdf->Cell(0,10,$eot_report,0,1,C);
            // $pdf->writeHTML($html2, true, false, true, false, '');
            // $pdf->Ln(1);
            // $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
            // $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Student #: ' . '', 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Ln(4);
            $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Total Aggregates (Best 8): ' . $total_agg_in_best_eight, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(5);
            $pdf->MultiCell(60, 7, 'Position by Total: ' . $position_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Division: ' .  $division, 1, 'L', 1, 0, '', '', true);
            $pdf->Ln(9);
            $pdf->MultiCell(60, 7, 'Class Teacher: ' . $class_teacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(60, 7, 'Head Teacher: ' . $headteacher, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(7);
            $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);
            $pdf->Ln(12);
            $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(90, 7, 'System developed by AICONNET.COM', 0, 'R', 0, 0, '', '', true);
            // set JPEG quality
            $pdf->setJPEGQuality(75);
            $pdf->Ln(10);
            //$theimg= site_url("/uploads/student_photos/287_bbosa_denis.jpg");
            //$theimg= FCPATH.('uploads/student_photos/287_bbosa_denis.jpg');
            // $theimg = APPPATH . ('/uploads/student_photos/287_bbosa_denis.jpg');
            // $pdf->Ln(5);
            // $imgdata = file_get_contents(APPPATH . ('uploads/student_photos/287_bbosa_denis.jpg'));

            // $pdf->Image('@'.$imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->Image($imgdata, 175, 5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // $pdf->MultiCell(200, 7, $theimg, 0, 'C', 0, 0, '', '', true);

            // echo '<center> <img src="/images/logo.jpg" alt="test alt attribute" width="80" height="80" border="0" /></centre>';

            // $pdf->Image('images/student_photos/287_bbosa_denis.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->Image($theimg, 15, 240, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

            // $pdf->writeHTML($html3, true, false, true, false, '');
            // reset pointer to the last page
            // Image example with resizing
            // $pdf->Image('images/logo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
            $pdf->lastPage();

            //Close and output PDF document
            //$pdf->Output(md5(time()).'.pdf', 'D');
            //$pdf->Output(md5(Semester Report.'.pdf', 'D');
            ob_end_clean();
            $pdf->Output('Semester Report.pdf', 'I');
        } else {
            return;
        }
    }



    //UPLOAD FILES FUNCTION
    public function do_upload()
    {
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('studentphoto')) {
            $error = array('error' => $this->upload->display_errors());

            //	$this->load->view('fileupload/upload', $error);
            $this->load->view('student/index', $error);
        } else {
            //upload files to server and insert into database
            $datav = $this->upload->data();
            //insert query here using model

            $data = array('upload_data' => $datav);

            // $this->load->view('fileupload/uploadsuccess', $data);
            $this->load->view('student/index', $data);
        }
    }
}
