<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Register End of Term Marks (Stream)</h3>
            </div>
            <?php echo form_open('markeot/add_stream_marks'); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <!--CLASS-->
                    <div class="col-md-6">
                        <label for="hisclass" class="control-label"><span class="text-danger">*</span>Class</label>
                        <div class="form-group">

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
                    <!--STREAM-->
                    <div class="col-md-6">
                        <label for="stream" class="control-label"><span class="text-danger">*</span>Stream</label>
                        <div class="form-group">

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
                    <!--YEAR -->
                    <div class="col-md-6">
                        <label for="theyear" class="control-label"><span class="text-danger">*</span>Year</label>
                        <div class="form-group">
                            <!--<input type="text" name="theyear" value="<?php echo $this->input->post('theyear'); ?>" class="form-control" id="theyear" />-->

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

                            <span class="text-danger"><?php echo form_error('theyear'); ?></span>
                        </div>
                    </div>
                    <!--SUBJECT-->
                    <div class="col-md-6">
                        <label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
                        <div class="form-group">
                            <!--	<input type="text" name="subject" value="<?php echo $this->input->post('subject'); ?>" class="form-control" id="subject" />-->
                            <select name="subject" class="form-control">
                                <option value="">Select Subject</option>
                                <?php

                                foreach ($subjects as $subject) {
                                    $selected = ($subject['id'] == $this->input->post('term')) ? ' selected="selected"' : "";

                                    //echo '<option value="'.$subject['id'].'" '.$selected.'>'.$subject['subject'].'</option>';
                                    echo '<option value="' . $subject['thesubjects'] . '" ' . $selected . '>' . $subject['thesubjects'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('subject'); ?></span>
                        </div>
                    </div>
                    <!--SUBJECT CODE-->
                    <div class="col-md-6">
                        <label for="subjectcode" class="control-label">Subject Code</label>
                        <div class="form-group">

                            <select name="subjectcode" class="form-control">
                                <option value="">Select Subject Code</option>
                                <?php
                                $subjectcode_values = array(
                                    'BOT' => 'BOT',
                                    'EOT' => 'EOT',
                                );

                                foreach ($subjectcode_values as $value => $display_text) {
                                    $selected = ($value == $this->input->post('subjectcode')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('subjectcode'); ?></span>

                            <!--	<input type="text" name="subjectcode" value="<?php echo $this->input->post('subjectcode'); ?>" class="form-control" id="subjectcode" />-->
                            <span class="text-danger"><?php echo form_error('subjectcode'); ?></span>
                        </div>
                    </div>
                    <!--SEMESTER-->
                    <div class="col-md-6">
                        <label for="term" class="control-label">Semester</label>
                        <div class="form-group">
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
                    <hr /><br /><br /><br />

                    <!--START HERE -->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark1" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
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
                    <!--SUBJECT TEACHER-->
                    <!-- STOP HERE-->

                    <!--START HERE 2-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid2" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student2" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark12" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment2" class="form-control">
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
                    <!--SUBJECT TEACHER-->

                    <!--STOP HERE 2-->

                    <!--START HERE 3-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid3" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student3" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark13" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment3" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 3-->

                    <!--START HERE 4-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid4" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student4" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student4" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark14" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment4" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 4-->

                    <!--START HERE 5-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid5" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student5" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark15" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment5" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 5-->


                    <!--START HERE 6-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid6" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student6" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark16" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment6" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 6-->


                    <!--START HERE 7-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid7" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student7" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark17" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment7" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 7-->

                    <!--START HERE 8-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid8" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student8" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark18" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment8" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 8-->

                    <!--START HERE 9-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid9" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student9" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark19" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment9" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 9-->

                    <!--START HERE 10-->
                    <!--STUDENT ID-->
                    <div class="col-md-3">
                        <label for="studentid" class="control-label">Student ID</label>
                        <div class="form-group">
                            <select name="studentid10" class="form-control">
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



                    <!--STUDENT -->
                    <div class="col-md-3">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student10" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>

                    <!--MARKS-->
                    <div class="col-md-3">
                        <label for="mark1" class="control-label">Marks</label>
                        <div class="form-group">
                            <input type="text" name="mark110" value="<?php echo $this->input->post('mark1'); ?>" class="form-control" id="mark1" />
                            <span class="text-danger"><?php echo form_error('mark1'); ?></span>
                        </div>
                    </div>

                    <!--COMMENTS -->
                    <div class="col-md-3">
                        <label for="comment" class="control-label"><span class="text-danger">*</span>Comment</label>
                        <div class="form-group">
                            <select name="comment10" class="form-control">
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
                    <!--SUBJECT TEACHER-->


                    <!--STOP HERE 10-->

                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Register Marks
                </button>

            </div>
            <div>
                You MUST register in groups of 5 students
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>