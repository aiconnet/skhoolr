<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>
        Student Register
    </h1> -->
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Students</a></li>
        <li class="active">Student Register</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Student Particulars</h3>
            </div>
            <?php echo form_open('student/edit/'.$student['id']); ?>
            <div class="box-body">
                <div class="row clearfix">

                  <!--Student names-->
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student"    value="<?php echo ($this->input->post('names') ? $this->input->post('names') : $student['names']); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
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
									$selected = ($value == $student['theclass']) ? ' selected="selected"' : "";

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
							<!--<input type="text" name="stream" value="<?php echo $this->input->post('stream'); ?>" class="form-control" id="stream" />-->

							<select name="stream" class="form-control">
								<option value="">Select Class Stream</option>
								<?php
								$stream_values = array(
									'Blue'=>'Blue',
									'White'=>'White',
									'Not Applicable'=>'Not Applicable',

								);



								foreach($stream_values as $value => $display_text)
								{
									$selected = ($value == $this->input->post('stream')) ? ' selected="selected"' : "";

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
								<option value="">select</option>
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
									$selected = ($value == $student['theyear']) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theyear');?></span>
						</div>
					</div>




            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Register Student
                </button>

                <!--<form action="login.php/verify_to_login" method="post">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Save marks for a stream
                    </button>
                </form>-->
                <!--add_stream_marks-->
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
