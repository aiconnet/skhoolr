<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Subjects
        <!-- <small>Ordinary Level</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Skoolr</a></li>
        <li class="active">Edit Subjects</li>
    </ol>
</section>
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Subject Edit</h3>
            </div>
			<?php echo form_open('subject/edit/'.$subject['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
						<div class="form-group">
							<input type="text" name="subject" value="<?php echo ($this->input->post('subject') ? $this->input->post('subject') : $subject['subject']); ?>" class="form-control" id="subject" />
							<span class="text-danger"><?php echo form_error('subject');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="subjectcode" class="control-label">Subjectcode</label>
						<div class="form-group">
							<input type="text" name="subjectcode" value="<?php echo ($this->input->post('subjectcode') ? $this->input->post('subjectcode') : $subject['subjectcode']); ?>" class="form-control" id="subjectcode" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="theclass" class="control-label"><span class="text-danger">*</span>Theclass</label>
						<div class="form-group">
							<input type="text" name="theclass" value="<?php echo ($this->input->post('theclass') ? $this->input->post('theclass') : $subject['theclass']); ?>" class="form-control" id="theclass" />
							<span class="text-danger"><?php echo form_error('theclass');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="teacher" class="control-label"><span class="text-danger">*</span>Teacher</label>
						<div class="form-group">
							<input type="text" name="teacher" value="<?php echo ($this->input->post('teacher') ? $this->input->post('teacher') : $subject['teacher']); ?>" class="form-control" id="teacher" />
							<span class="text-danger"><?php echo form_error('teacher');?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="stream" class="control-label">Stream</label>
						<div class="form-group">
							<input type="text" name="stream" value="<?php echo ($this->input->post('stream') ? $this->input->post('stream') : $subject['stream']); ?>" class="form-control" id="stream" />
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> Save
				</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>