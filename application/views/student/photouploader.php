<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
   <!--<h1>-->
        <!-- Student Photo Uploader-->
        <!-- <small>Ordinary Level</small> -->
   <!-- </h1>-->
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
                <h3 class="box-title">Student Photo Uploader</h3>
            </div>
           
            <div class="box-body">
                <div class="row clearfix">
                   <?php echo form_open_multipart('student/upload_photo/'.$student['id']); ?>
                    <!--Student id-->
                    <div class="col-md-6">
                        <label for="student id" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student_id"    value="<?php echo ($this->input->post('id') ? $this->input->post('id') : $student['id']); ?>" class="form-control" id="student_id" />
                            <span class="text-danger"><?php echo form_error('student_id'); ?></span>
                        </div>
                    </div>
                    
                  <!--Student names-->
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student Names</label>
                        <div class="form-group">
                            <input type="text" name="student"    value="<?php echo ($this->input->post('names') ? $this->input->post('names') : $student['names']); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>
                   
                    
                    <!--Student photo-->
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Select Student Photo</label>
                        <div class="form-group">
                            
                           <!-- <input type="file" name="userfile" size="50" />-->
                            <input type="file" name="userfile" class="form-control-file" id="userfile">
                            
                        </div>
                            <div class="box-footer">
                                 <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Upload Student Photo
                                 </button>
                           </div>
                    </div>
                    
           
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

