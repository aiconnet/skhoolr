<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>
        Subject Options Management
    </h1> -->
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Subject Options Management</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Subject Options Management</h3>
            </div>
            <?php echo form_open('subjectoptions/edit/'.$subjectoption['id']); ?>
            <div class="box-body">
                <div class="row clearfix">

                  <!--Student names-->
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student"    value="<?php echo ($this->input->post('names') ? $this->input->post('names') : $subjectoption['student']); ?>" class="form-control" id="student" />
                            <span class="text-danger">
                              <?php echo form_error('student'); ?>
                            </span>
                        </div>
                    </div>

            <!--Student Class-->
            <div class="col-md-6">
						<label for="theclass" class="control-label"><span class="text-danger">*</span>Class</label>
						<div class="form-group">
							<select name="theclass" class="form-control">
								<option value="">Select Class</option>
								<?php
								$theclass_values = array(
								  'Senior 1'=>'Senior 1',
									'Senior 2'=>'Senior 2',
									'Senior 3'=>'Senior 3',
									'Senior 4'=>'Senior 4',
									'Senior 5'=>'Senior 5',
									'Senior 6'=>'Senior 6',
								);

								foreach($theclass_values as $value => $display_text)
								{
                  $selected = ($value == $subjectoption['theclass']) ? ' selected="selected"' : "";
									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theclass');?></span>
						</div>
					</div>
						<div class="col-md-6">
						<label for="stream" class="control-label">Stream</label>
						<div class="form-group">

							<select name="stream" class="form-control">
								<option value="">Select Class Stream</option>
								<?php
								$stream_values = array(
									'Blue'=>'Blue',
									'White'=>'White',
                  'Arts'=>'Arts',
                  'Science'=>'Science',
									'Not Applicable'=>'Not Applicable',
								);

								foreach($stream_values as $value => $display_text)
								{
								//	$selected = ($value == $this->input->post('stream')) ? ' selected="selected"' : "";
                  $selected = ($value == $subjectoption['stream']) ? ' selected="selected"' : "";
                  echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';


								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theclass');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="theyear" class="control-label"><span class="text-danger">*</span>Year</label>
						<div class="form-group">
							<select name="theyear" class="form-control">
								<option value="">Select Year</option>
								<?php
								$theyear_values = array(
									'2019'=>'2019',
									'2020'=>'2020',
									'2021'=>'2021',
									'2022'=>'2022',
									'2023'=>'2023',
									'2024'=>'2024',
									'2025'=>'2025',
								);

								foreach($theyear_values as $value => $display_text)
								{
                  $selected = ($value == $subjectoption['theyear']) ? ' selected="selected"' : "";
                  echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theyear');?></span>
						</div>
					</div>


          <div class="col-md-6">
              <label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
              <div class="form-group">
                  <input type="text" name="subject" value="<?php echo ($this->input->post('subject') ? $this->input->post('subject') : $subjectoption['subject']); ?>" class="form-control" id="subject" />
                  <span class="text-danger"><?php echo form_error('subject'); ?></span>
              </div>
          </div>

          <!-- Subject code -->
          <div class="col-md-6">
            <label for="subjectcode" class="control-label">Subject Code</label>
            <div class="form-group">
            <select name="subjectcode" class="form-control">
                <option value="">Select Subject Code</option>
                <?php
                $subjectcode_values = array(
                  '112/1' => 'English 112/1 (O-Level)',
                  '112/2' => 'English 112/2 (O-Level)',
                  '456/1' => 'Mathematics 456/1 (O-Level)',
                  '456/2' => 'Mathematics 456/2 (O-Level)',
                  '425/1' => 'Mathematics 425/1 (A-Level)',
                  '425/2' => 'Mathematics 425/2 (A-Level)',
                  '545/1' => 'Chemistry 545/1 (O-Level)',
                  '545/2' => 'Chemistry 545/2 (O-Level)',
                  '545/3' => 'Chemistry 545/3 (O-Level)',
                  '525/1' => 'Chemistry 525/1 (A-Level)',
                  '525/2' => 'Chemistry 525/2 (A-Level)',
                  '525/3' => 'Chemistry 525/3 (A-Level)',
                  '553/1' => 'Biology 553/1 (O-Level)',
                  '553/2' => 'Biology  553/2 (O-Level)',
                  '530/1' => 'Biology 530/1 (A-Level)',
                  '530/2' => 'Biology 530/2 (A-Level)',
                  '530/3' => 'Biology 530/3 (A-Level)',
                  '241/1' => 'History 241/1 (O-Level)',
                  '241/2' => 'History 241/2 (O-Level)',
                  '210/1' => 'History: National Movements & New States 210/1 (A-Level)',
                  '210/2' => 'History: Economic & Social History of E.A. 210/2 (A-Level)',
                  '210/3' => 'History: European History 210/3 (A-Level)',
                  '210/4' => 'History: World Affairs Since 1939 210/4 (A-Level)',
                  '210/5' => 'History: Theory of Government & Constitutional Development 210/5 (A-Level)',
                  '210/6' => 'History: History of Africa (1855-1914) 210/6 (A-Level)',
                  '273/1' => 'Geography 273/1 (O-Level)',
                  '273/2' => 'Geography 273/2 (O-Level)',
                  '250/1' => 'Geography 250/1 (A-Level)',
                  '250/2' => 'Geography 250/2 (A-Level)',
                  '250/3' => 'Geography 250/3 (A-Level)',
                  '335/1' => 'Luganda 335/1 (O-Level)',
                  '335/2' => 'Luganda 335/2 (O-Level)',
                  '360/1' => 'Luganda: Garmmar & Culture 360/1',
                  '360/2' => 'Luganda: Translation & Composition 360/2',
                  '360/3' => 'Luganda: Literature 360/3',
                '527/1' => 'Agriculture: Principles & Practices 527/1 (O-Level)',
                '515/1' => 'Agriculture: Principles & Practices 515/1 (A-Level)',
                '515/2' => 'Agriculture: Principles & Practices 515/2 (A-Level)',
                  '800/1' => 'Commerce 800/1 (O-Level)',
                  '223/1' => 'CRE: Christian Living Today 223/1 (O-Level) ',
                  '224/1' => 'CRE: St. Luke\'s Gospel 224/1 (O-Level) ',
                  '224/2' => 'CRE: Old Testament 224/2 (O-Level) ',
                  '224/3' => 'CRE: The Early Church 224/3 (O-Level) ',
                  '224/4' => 'CRE: The Church In E.A 224/4 (O-Level) ',
                  '224/5' => 'CRE: African Religious Heritage 224/5 (O-Level) ',
                  '245/1' => 'CRE: The Old Testament 245/1 (A-Level)',
                  '245/2' => 'CRE: The New Testament 245/2 (A-Level)',
                  '245/3' => 'CRE: Christianity in East Africa 245/3 (A-Level)',
                  '245/4' => 'CRE: Social & Ethical Issues 245/4 (A-Level)',
                  '845/1' => 'Entrepreneurship 845/1 (O-Level)',
                  '845/2' => 'Entrepreneurship 845/2 (O-Level)',
                  '230/1' => 'Entrepreneurship Studies 230/1 (A-Level)',
                  '230/2' => 'Entrepreneurship Studies230/2 (A-Level)',
                  '610' => 'Fine Art',
                  '840/1' => 'Computer Studies 840/1 (O-Level)',
                  'S850/1' => 'Subsidiary ICT 850/1 (A-Level)',
                  'S850/2' => 'Subsidiary ICT 850/2 (A-Level)',
                  'S850/3' => 'Subsidiary ICT 850/3 (A-Level)',
                  '208' => 'Literature',
                  '310/1' => 'Literature: Prose & Poetry 310/1 (A-Level)',
                  '310/2' => 'Literature: Plays 310/2 (A-Level)',
                  '310/3' => 'Literature: Novels 310/3 (A-Level)',
                  '341' => 'French',
                  '225' => 'IRE',
                  '993' => 'Catering',
                  '990' => 'Craft',
                  '535' => 'Physics',
                  '992' => 'Tailoring',
                  '220/1' => 'Economics 220/1 (A-Level)',
                  '220/2' => 'Economics 220/2 (A-Level)'


                );

                foreach ($subjectcode_values as $value => $display_text) {
                  $selected = ($value == $this->input->post('subjectcode')) ? ' selected="selected"' : "";

                  echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <label for="paper" class="control-label">Paper</label>
            <div class="form-group">
              <select name="paper" class="form-control">
                <option value="">Select Paper</option>
                <?php
                $paper_values = array(
                  'Paper 1' => 'Paper 1',
                  'Paper 2' => 'Paper 2',
                  'Paper 3' => 'Paper 3',
                  'Paper 4' => 'Paper 4',
                  'Paper 5' => 'Paper 5',
                  'Paper 6' => 'Paper 6',
                  'Paper 7' => 'Paper 7',
                  'Paper 8' => 'Paper 8',
                  'Paper 9' => 'Paper 9',
                );
                foreach ($paper_values as $value => $display_text) {
                  $selected = ($value == $this->input->post('paper')) ? ' selected="selected"' : "";

                  echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

</div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Update Subject Option
                </button>

            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
