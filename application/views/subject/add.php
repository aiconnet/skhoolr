<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
	<!-- <h1>
		Subject Register
	</h1> -->
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Subjects</a></li>
		<li class="active">Register Subject</li>
	</ol>
</section>

<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Register Subject</h3>
			</div>
			<?php echo form_open('subject/add'); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
						<div class="form-group">
							<input type="text" name="subject" value="<?php echo $this->input->post('subject'); ?>" class="form-control" id="subject" />
							<span class="text-danger"><?php echo form_error('subject'); ?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="subjectcode" class="control-label">Subject Code</label>
						<div class="form-group">
							<!--<input type="text" name="subjectcode" value="<?php echo $this->input->post('subjectcode'); ?>" class="form-control" id="subjectcode" />-->
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
									'360/1' => 'Luganda: Garmmar & Culture 360/1',
									'360/2' => 'Luganda: Translation & Composition 360/2',
									'360/3' => 'Luganda: Literature 360/3',
									'527' => 'Agriculture',
									'800' => 'Commerce',
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
									'850' => 'Entrepreneurship',
									'610' => 'Fine Art',
									'840' => 'Computer',
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
						<label for="theclass" class="control-label"><span class="text-danger">*</span>Class</label>
						<div class="form-group">
							<!--	<input type="text" name="theclass" value="<?php echo $this->input->post('theclass'); ?>" class="form-control" id="theclass" />
							<span class="text-danger"><?php echo form_error('theclass'); ?></span>-->
							<select name="theclass" class="form-control">
								<option value="">Select Class</option>
								<?php
								$theclass_values = array(
									'Senior 1' => 'Senior 1',
									'Senior 2' => 'Senior 2',
									'Senior 3' => 'Senior 3',
									'Senior 4' => 'Senior 4',
									'Senior 5' => 'Senior 5',
									'Senior 6' => 'Senior 6',
									'All Classes' => 'All Classes',
								);

								foreach ($theclass_values as $value => $display_text) {
									$selected = ($value == $this->input->post('theclass')) ? ' selected="selected"' : "";

									echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theclass'); ?></span>

						</div>
					</div>
					<div class="col-md-6">
						<label for="teacher" class="control-label"><span class="text-danger">*</span>Teacher</label>
						<div class="form-group">
							<!--<input type="text" name="teacher" value="<?php echo $this->input->post('teacher'); ?>" class="form-control" id="teacher" />
							<span class="text-danger"><?php echo form_error('teacher'); ?></span>-->

							<select name="teacher" class="form-control">
								<option value="">Select Subject Teacher</option>
								<?php
								foreach ($teachers as $teacher) {
									$selected = ($teacher['id'] == $this->input->post('teacher')) ? ' selected="selected"' : "";

									//	echo '<option value="'.$teacher['id'].'" '.$selected.'>'.$teacher['names'].'</option>';
									echo '<option value="' . $teacher['names'] . '" ' . $selected . '>' . $teacher['names'] . '</option>';
								}
								?>
							</select>

							<span class="text-danger"><?php echo form_error('teacher'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="stream" class="control-label">Stream</label>
						<div class="form-group">
							<!--	<input type="text" name="stream" value="<?php echo $this->input->post('stream'); ?>" class="form-control" id="stream" />-->
							<select name="stream" class="form-control">
								<option value="">Select Stream</option>
								<?php
								$stream_values = array(
									'Blue' => 'Blue',
									'White' => 'White',
									'Science' => 'Science',
									'Arts' => 'Arts',
									'Not Applicable' => 'Not Applicable',

								);

								foreach ($stream_values as $value => $display_text) {
									$selected = ($value == $this->input->post('stream')) ? ' selected="selected"' : "";

									echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
								}
								?>
							</select>

							<span class="text-danger"><?php echo form_error('stream'); ?></span>
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
