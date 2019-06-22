<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Generate Student's Report</h3>
            </div>
            
            
			<?php // echo form_open('student/generate_report/'.$student['id']); ?>
            
            <?php echo form_open(base_url()."student/generate_pdf");?>
            
			<div class="box-body">
				<div class="row clearfix">

				<div class="col-md-6">
						<label for="names" class="control-label"><span class="text-danger">*</span>Full Names</label>
						<div class="form-group">
							<input type="text" name="names" value="<?php echo ($this->input->post('names') ? $this->input->post('names') : $student['names']); ?>" class="form-control" id="names" />
							<span class="text-danger"><?php echo form_error('names');?></span>
						</div>
					</div>


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
									$selected = ($value == $student['theyear']) ? ' selected="selected"' : "";

									echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('theyear');?></span>
						</div>
					</div>
					
					<div class="col-md-6">
						<label for="stream" class="control-label">Stream</label>
						<div class="form-group">
							<input type="text" name="stream" value="<?php echo ($this->input->post('stream') ? $this->input->post('stream') : $student['stream']); ?>" class="form-control" id="stream" />
						</div>
					</div>

                    <div class="col-md-6">
						<label for="semester" class="control-label">Semester</label>
						<div class="form-group">
                        <select name="term" class="form-control">
								<option value="">Select Term</option>
								<?php  
								
								foreach($semesters as $semester)
								{
									$selected = ($semester['id'] == $this->input->post('term')) ? ' selected="selected"' : "";

									//echo '<option value="'.$semester['id'].'" '.$selected.'>'.$semester['semester'].'</option>';
									echo '<option value="'.$semester['semester'].'" '.$selected.'>'.$semester['semester'].'</option>';
								} 
								?>
							</select>
							<!--<input type="text" name="semester" value="<?php echo ($this->input->post('semester')) ; ?>" class="form-control" id="stream" />-->
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer"> 
                
                <!--<a href="<?php echo site_url('semester/generate_pdf'); ?>" class="btn btn-success">Generate Report</a> -->
                
            	<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-check"></i> Generate Report</button>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>