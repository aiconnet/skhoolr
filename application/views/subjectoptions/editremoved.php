<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"> Edit Subject Option</h3>
            </div>
            <?php echo form_open('subjectoptions/edit/'.$subjectoptions['id']); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="studentid" class="control-label">Edit Student Subject Option</label>
                        <div class="form-group">
                            <select name="subjectid" class="form-control">
                                <option value="">Select subject</option>
                                <?php
                                foreach ($all_subject as $subject) {
                                    $selected = ($subject['id'] == $subject['id']) ? ' selected="selected"' : "";

                                    echo '<option value="' . $subject['id'] . '" ' . $selected . '>' . $subjectoption['id'] . '</option>';
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
                        <label for="subjectteacher" class="control-label">Subjectteacher</label>
                        <div class="form-group">
                            <input type="text" name="subjectteacher" value="<?php echo ($this->input->post('subjectteacher') ? $this->input->post('subjectteacher') : $mark['subjectteacher']); ?>" class="form-control" id="subjectteacher" />
                        </div>
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
