<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Student Register
        <!-- <small>Ordinary Level</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
    </ol>
</section>


<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Register Full Exam Marks</h3>
            </div>
            <?php echo form_open('markeot2/add'); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid" class="form-control">
                                <option value="">Select student</option>
                                <?php
                                foreach ($all_students as $student) {
                                    $selected = ($student['id'] == $this->input->post('studentid')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $student['id'] . '" ' . $selected . '>' . $student['names'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student</label>
                        <div class="form-group">
                            <input type="text" name="student" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="hisclass" class="control-label"><span class="text-danger">*</span>Class</label>
                        <div class="form-group">
                            <!--<input type="text" name="hisclass" value="<?php echo $this->input->post('hisclass'); ?>" class="form-control" id="hisclass" />
							<span class="text-danger"><?php echo form_error('hisclass'); ?></span>-->

                            <select name="hisclass" class="form-control">
                                <option value="">Select Class</option>
                                <?php
                                foreach ($realclasses as $class) {
                                    $selected = ($class['id'] == $this->input->post('hisclass')) ? ' selected="selected"' : "";

                                    //	echo '<option value="'.$class['id'].'" '.$selected.'>'.$class['theclass'].'</option>';
                                    echo '<option value="' . $class['theclass'] . '" ' . $selected . '>' . $class['theclass'] . '</option>';
                                }
                                ?>
                            </select>


                            <!--<input type="text" name="hisclass" value="<?php echo $this->input->post('hisclass'); ?>" class="form-control" id="hisclass" />-->
                            <span class="text-danger"><?php echo form_error('hisclass'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="stream" class="control-label"><span class="text-danger">*</span>Stream</label>
                        <div class="form-group">
                            <!--<input type="text" name="stream" value="<?php echo $this->input->post('stream'); ?>" class="form-control" id="stream" />
							<span class="text-danger"><?php echo form_error('stream'); ?></span>-->

                            <select name="stream" class="form-control">
                                <option value="">Select Stream</option>
                                <?php

                                foreach ($streams as $stream) {
                                    $selected = ($stream['id'] == $this->input->post('stream')) ? ' selected="selected"' : "";

                                    //	echo '<option value="'.$stream['id'].'" '.$selected.'>'.$stream['streamname'].'</option>';
                                    echo '<option value="' . $stream['streamname'] . '" ' . $selected . '>' . $stream['streamname'] . '</option>';
                                }
                                ?>
                            </select>

                            <!--<input type="text" name="stream" value="<?php echo $this->input->post('stream'); ?>" class="form-control" id="stream" />-->
                            <span class="text-danger"><?php echo form_error('stream'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="theyear" class="control-label"><span class="text-danger">*</span>Year</label>
                        <div class="form-group">
                            <!--<input type="text" name="theyear" value="<?php echo $this->input->post('theyear'); ?>" class="form-control" id="theyear" />
							<span class="text-danger"><?php echo form_error('theyear'); ?></span>-->



                            <select name="theyear" class="form-control">
                                <option value="">Select Year</option>
                                <?php
                                $year_values = array(
                                    '2019' => '2019',
                                    '2020' => '2020',
                                    '2021' => '2021',
                                    '2022' => '2022',
                                );

                                foreach ($year_values as $value => $display_text) {
                                    $selected = ($value == $this->input->post('comment')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
                        <div class="form-group">
                            <input type="text" name="subject" value="<?php echo $this->input->post('subject'); ?>" class="form-control" id="subject" />
                            <span class="text-danger"><?php echo form_error('subject'); ?></span>


                            <!--<select name="subject" class="form-control">
								<option value="">Select Subject</option>
								<?php

                                foreach ($subjects as $subject) {
                                    $selected = ($subject['id'] == $this->input->post('term')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $subject['subject'] . '" ' . $selected . '>' . $subject['subject'] . '</option>';
                                }
                                ?>
							</select>
							<span class="text-danger"><?php echo form_error('subject'); ?></span>-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subjectcode" class="control-label">Subject Code</label>
                        <div class="form-group">
                            <input type="text" name="subjectcode" value="<?php echo $this->input->post('subjectcode'); ?>" class="form-control" id="subjectcode" />
                            <span class="text-danger"><?php echo form_error('subjectcode'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark1" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment" class="form-control">
                                <option value="">select</option>
                                <?php
                                $comment_values = array(
                                    'Excellent' => 'Excellent',
                                    'VeryGood' => 'Very Good',
                                    'Good' => 'Good',
                                    'Fair' => 'Fair',
                                    'Tryharder' => 'Try harder',
                                    'TryAgain' => 'Try Again',
                                );

                                foreach ($comment_values as $value => $display_text) {
                                    $selected = ($value == $this->input->post('comment')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('comment'); ?></span>
                        </div>
                    </div>





                    <div class="col-md-6">
                        <label for="term" class="control-label">Term</label>
                        <div class="form-group">
                            <!--<input type="text" name="term" value="<?php echo $this->input->post('term'); ?>" class="form-control" id="term" />-->

                            <select name="term" class="form-control">
                                <option value="">Select Stream</option>
                                <?php

                                foreach ($semesters as $semester) {
                                    $selected = ($semester['id'] == $this->input->post('term')) ? ' selected="selected"' : "";

                                    //echo '<option value="'.$semester['id'].'" '.$selected.'>'.$semester['semester'].'</option>';
                                    echo '<option value="' . $semester['semester'] . '" ' . $selected . '>' . $semester['semester'] . '</option>';
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subjectteacher" class="control-label">Subject Teacher</label>
                        <div class="form-group">
                            <!--<input type="text" name="subjectteacher" value="<?php echo $this->input->post('subjectteacher'); ?>" class="form-control" id="subjectteacher" />-->
                            <select name="subjectteacher" class="form-control">
                                <option value="">Select Subject Teacher</option>
                                <?php
                                foreach ($teachers as $teacher) {
                                    $selected = ($teacher['id'] == $this->input->post('teacher')) ? ' selected="selected"' : "";

                                    //	echo '<option value="'.$teacher['id'].'" '.$selected.'>'.$teacher['names'].'</option>';
                                    echo '<option value="' . $teacher['names'] . '" ' . $selected . '>' . $teacher['names'] . '</option>';
                                }
                                ?>
                            </select>

                            <!--<input type="text" name="hisclass" value="<?php echo $this->input->post('hisclass'); ?>" class="form-control" id="hisclass" />-->

                            <span class="text-danger"><?php echo form_error('teacher'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Save for one student
                </button>

                <form action="login.php/verify_to_login" method="post">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Save marks for a stream
                    </button>
                </form>
                <!--add_stream_marks-->
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>