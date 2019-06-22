<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Mark Edit</h3>
            </div>
            <?php echo form_open('mark/edit/' . $mark['id']); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="studentid" class="control-label">Student</label>
                        <div class="form-group">
                            <select name="studentid" class="form-control">
                                <option value="">select student</option>
                                <?php
                                foreach ($all_students as $student) {
                                    $selected = ($student['id'] == $mark['studentid']) ? ' selected="selected"' : "";

                                    echo '<option value="' . $student['id'] . '" ' . $selected . '>' . $student['id'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="student" class="control-label"><span class="text-danger">*</span>Student</label>
                        <div class="form-group">
                            <input type="text" name="student" value="<?php echo ($this->input->post('student') ? $this->input->post('student') : $mark['student']); ?>" class="form-control" id="student" />
                            <span class="text-danger"><?php echo form_error('student'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="hisclass" class="control-label"><span class="text-danger">*</span>Hisclass</label>
                        <div class="form-group">
                            <input type="text" name="hisclass" value="<?php echo ($this->input->post('hisclass') ? $this->input->post('hisclass') : $mark['hisclass']); ?>" class="form-control" id="hisclass" />
                            <span class="text-danger"><?php echo form_error('hisclass'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="stream" class="control-label"><span class="text-danger">*</span>Stream</label>
                        <div class="form-group">
                            <input type="text" name="stream" value="<?php echo ($this->input->post('stream') ? $this->input->post('stream') : $mark['stream']); ?>" class="form-control" id="stream" />
                            <span class="text-danger"><?php echo form_error('stream'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="theyear" class="control-label"><span class="text-danger">*</span>Theyear</label>
                        <div class="form-group">
                            <input type="text" name="theyear" value="<?php echo ($this->input->post('theyear') ? $this->input->post('theyear') : $mark['theyear']); ?>" class="form-control" id="theyear" />
                            <span class="text-danger"><?php echo form_error('theyear'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
                        <div class="form-group">
                            <input type="text" name="subject" value="<?php echo ($this->input->post('subject') ? $this->input->post('subject') : $mark['subject']); ?>" class="form-control" id="subject" />
                            <span class="text-danger"><?php echo form_error('subject'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subjectcode" class="control-label">Subjectcode</label>
                        <div class="form-group">
                            <input type="text" name="subjectcode" value="<?php echo ($this->input->post('subjectcode') ? $this->input->post('subjectcode') : $mark['subjectcode']); ?>" class="form-control" id="subjectcode" />
                            <span class="text-danger"><?php echo form_error('subjectcode'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mark1" class="control-label">Mark1</label>
                        <div class="form-group">
                            <input type="text" name="mark1" value="<?php echo ($this->input->post('mark1') ? $this->input->post('mark1') : $mark['mark1']); ?>" class="form-control" id="mark1" />
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
                                    $selected = ($value == $mark['comment']) ? ' selected="selected"' : "";

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
                            <input type="text" name="term" value="<?php echo ($this->input->post('term') ? $this->input->post('term') : $mark['term']); ?>" class="form-control" id="term" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="subjectteacher" class="control-label">Subjectteacher</label>
                        <div class="form-group">
                            <input type="text" name="subjectteacher" value="<?php echo ($this->input->post('subjectteacher') ? $this->input->post('subjectteacher') : $mark['subjectteacher']); ?>" class="form-control" id="subjectteacher" />
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


<!--<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Mark Edit</h3>
            </div>
			<?php echo form_open('mark/edit/' . $mark['id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="studentid" class="control-label">Student</label>
						<div class="form-group">
							<select name="studentid" class="form-control">
								<option value="">select student</option>
								<?php
                                foreach ($all_students as $student) {
                                    $selected = ($student['id'] == $mark['studentid']) ? ' selected="selected"' : "";

                                    echo '<option value="' . $student['id'] . '" ' . $selected . '>' . $student['id'] . '</option>';
                                }
                                ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<label for="student" class="control-label"><span class="text-danger">*</span>Student</label>
						<div class="form-group">
							<input type="text" name="student" value="<?php echo ($this->input->post('student') ? $this->input->post('student') : $mark['student']); ?>" class="form-control" id="student" />
							<span class="text-danger"><?php echo form_error('student'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="hisclass" class="control-label"><span class="text-danger">*</span>Hisclass</label>
						<div class="form-group">
							<input type="text" name="hisclass" value="<?php echo ($this->input->post('hisclass') ? $this->input->post('hisclass') : $mark['hisclass']); ?>" class="form-control" id="hisclass" />
							<span class="text-danger"><?php echo form_error('hisclass'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="stream" class="control-label"><span class="text-danger">*</span>Stream</label>
						<div class="form-group">
							<input type="text" name="stream" value="<?php echo ($this->input->post('stream') ? $this->input->post('stream') : $mark['stream']); ?>" class="form-control" id="stream" />
							<span class="text-danger"><?php echo form_error('stream'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="theyear" class="control-label"><span class="text-danger">*</span>Theyear</label>
						<div class="form-group">
							<input type="text" name="theyear" value="<?php echo ($this->input->post('theyear') ? $this->input->post('theyear') : $mark['theyear']); ?>" class="form-control" id="theyear" />
							<span class="text-danger"><?php echo form_error('theyear'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
						<div class="form-group">
							<input type="text" name="subject" value="<?php echo ($this->input->post('subject') ? $this->input->post('subject') : $mark['subject']); ?>" class="form-control" id="subject" />
							<span class="text-danger"><?php echo form_error('subject'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="subjectcode" class="control-label">Subjectcode</label>
						<div class="form-group">
							<input type="text" name="subjectcode" value="<?php echo ($this->input->post('subjectcode') ? $this->input->post('subjectcode') : $mark['subjectcode']); ?>" class="form-control" id="subjectcode" />
							<span class="text-danger"><?php echo form_error('subjectcode'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="mark1" class="control-label">Mark1</label>
						<div class="form-group">
							<input type="text" name="mark1" value="<?php echo ($this->input->post('mark1') ? $this->input->post('mark1') : $mark['mark1']); ?>" class="form-control" id="mark1" />
							<span class="text-danger"><?php echo form_error('mark1'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="term" class="control-label">Term</label>
						<div class="form-group">
							<input type="text" name="term" value="<?php echo ($this->input->post('term') ? $this->input->post('term') : $mark['term']); ?>" class="form-control" id="term" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="subjectteacher" class="control-label">Subjectteacher</label>
						<div class="form-group">
							<input type="text" name="subjectteacher" value="<?php echo ($this->input->post('subjectteacher') ? $this->input->post('subjectteacher') : $mark['subjectteacher']); ?>" class="form-control" id="subjectteacher" />
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
</div>-->