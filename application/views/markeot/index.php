<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Student End Of Term Marks
        <!-- <small>Ordinary Level</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">SKoolr</a></li>
        <li class="active">Marks</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">Ordinary Level - End Of Term Marks</h3>
                </div>

                <?php

                $attributes = array('name' => 'frmExcelImport', 'id' => 'frmExcelImport');

                echo form_open_multipart('markeot/import_data', $attributes); ?>

                <input type="file" name="file" id="file" accept=".xls,.xlsx, .csv"><br />
                <button type="submit" id="submit" name="import" class="btn-submit">Import Student Marks Using Excel (.xls & .csv Only)</button>
                <?php echo form_close(); ?>

                <div class="text-right box-tools">
                    <a href="<?php echo site_url('markeot/add'); ?>" class="btn btn-success btn-sm">Add Marks</a>
                    <a href="<?php echo site_url('markeot/add_stream'); ?>" class="btn btn-success btn-sm">Register Stream Marks</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                               <!-- <th>Student ID</th>-->
                                <th>Student</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>Year</th>
                                <th>Subject</th>
                                <th>Subject Code</th> 
                                <th>Marks</th>
                                <th>Comments</th>
                                <th>Term</th>
                                <th>Subject Teacher</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($marks as $m) { ?>
                                <tr>
                                    <td><?php echo $m['id']; ?></td>
                                   <!-- <td><?php echo $m['studentid']; ?></td>-->
                                    <td><?php echo $m['student']; ?></td>
                                    <td><?php echo $m['hisclass']; ?></td>
                                    <td><?php echo $m['stream']; ?></td>
                                    <td><?php echo $m['theyear']; ?></td>
                                    <td><?php echo $m['subject']; ?></td>
                                     <td><?php echo $m['subjectcode']; ?></td> 
                                    <td><?php echo $m['mark1']; ?></td>
                                    <td><?php echo $m['comment']; ?></td>
                                    <td><?php echo $m['term']; ?></td>
                                    <td><?php echo $m['subjectteacher']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('markeot/edit/' . $m['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>
                                        <a href="<?php echo site_url('markeot/remove/' . $m['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <!--<th>Student ID</th>-->
                                <th>Student</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>Year</th>
                                <th>Subject</th>
                                <th>Subject Code</th>
                                <th>Marks</th>
                                <th>Comments</th>
                                <th>Term</th>
                                <th>Subject Teacher</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<script>
    $("#tables").addClass('active');
    $("#data-tables").addClass('active');
</script>