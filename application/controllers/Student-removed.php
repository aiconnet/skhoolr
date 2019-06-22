<?php

class Student extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        //MINE
        $this->load->helper(array('form', 'url'));
        //	$this->load->model('upload_model');
         $this->load->model('Mark_model');
         $this->load->model('Subject_model');
        $this->load->library('table');
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
                 'student' => $this->input->post('student'),
                 'hisclass' => $this->input->post('hisclass'),
                 'stream' => $this->input->post('stream'),
                 'theyear' => $this->input->post('theyear'),
               
               
                 //	'studentphoto' => $this->input->post('studentphoto'),
            );
            
            $this->load->model('Stream_model');
            $data['streams'] = $this->Stream_model->get_all_streams();

            $this->load->model('Realclass_model');
            $data['realclasses'] = $this->Realclass_model->get_all_realclasses();

            $student_id = $this->Student_model->add_student($params);
            redirect('student/index');
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

            //$this->db->insert_batch('tb_import', $data_excel);
            $this->db->insert_batch('students', $data_excel);
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

            $this->form_validation->set_rules('names', 'Names', 'required');
            $this->form_validation->set_rules('theclass', 'Theclass', 'required');
            $this->form_validation->set_rules('theyear', 'Theyear', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'theclass' => $this->input->post('theclass'),
                    'theyear' => $this->input->post('theyear'),
                    'studentphoto' => $this->input->post('studentphoto'),
                    'names' => $this->input->post('names'),
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

                $data['_view'] = 'student/generate_report';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error('The student you are trying to edit does not exist.');
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


        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://www.frankhost.pw');
        $pdf->SetTitle('Student Report');
        $pdf->SetSubject('Report generated powered by FRANKHOST.PW');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

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
        $pdf->SetFont('helvetica', '', 11);

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


        // $pdf->Cell(0, 0, $subject_number, 1, 1, 'C', 0, '', 0);
        $pdf->writeHTML($html2, true, false, true, false, '');
        $pdf->Ln(1);
        $pdf->MultiCell(60, 5, 'Names: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Class: ' . $theclass, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Stream: ' . $stream, 1, 'L', 1, 0, '', '', true);
        $pdf->Ln(7);
        $pdf->MultiCell(60, 5, 'Student Number: ' . $names, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Term: ' . $semester, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 5, 'Year: ' . $theyear, 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(7);

        // $pdf->MultiCell(55, 5, '[LEFT] '.$txt, 1, 'L', 1, 0, '', '', true);
        //$pdf->writeHTML($names,true, false, true, false, '');

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Ln(4);
        $pdf->MultiCell(60, 7, 'Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $marks_out_of, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Average Mark: ' . round($average_marks), 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(9);
        $pdf->MultiCell(60, 7, 'Position by Total: ' . $total_marks, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Out of: ' . $num_of_students_in_stream, 1, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Division: ' . '', 1, 'L', 1, 0, '', '', true);

        $pdf->Ln(18);
        $pdf->MultiCell(60, 7, 'Class Teacher: ' . 'Noah Kirigwajjo', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(12);
        $pdf->MultiCell(60, 7, 'Head Teacher: ' . 'Job Kafeero', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Comment: ' . '__________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 7, 'Signature: ' . '__________________', 0, 'L', 0, 0, '', '', true);


        $pdf->Ln(15);
        $pdf->MultiCell(90, 7, 'Next term starts on: ' . '________________________', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'Next term ends on: ' . '_________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(15);
        $pdf->MultiCell(90, 7, 'Fees Balance        : ' . '________________________', 0, 'L', 0, 0, '', '', true);

        $pdf->Ln(19);
        $pdf->MultiCell(90, 7, 'Note: This report card is invalid without a stamp', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(90, 7, 'System developed by AiconNet.com', 0, 'R', 0, 0, '', '', true);



        // $pdf->writeHTML($html3, true, false, true, false, '');


        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        //$pdf->Output(md5(time()).'.pdf', 'D');
        //$pdf->Output(md5(Semester Report.'.pdf', 'D');
        $pdf->Output('Semester Report.pdf', 'I');
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
