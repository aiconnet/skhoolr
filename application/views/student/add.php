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
                <h3 class="box-title">Student Register</h3>
            </div>
            <?php echo form_open('student/add'); ?>
            <div class="box-body">
                <div class="row clearfix">
                    
                  <!--Student names-->
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student" value="<?php echo $this->input->post('student'); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>
                    
                    <!--Student Class-->
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
                    


                    
            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Register Student
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
