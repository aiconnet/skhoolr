<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Student Marks
        <!-- <small>Ordinary Level</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">SKoolr</a></li>
        <li class="active">EOT Marks</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">Ordinary Level</h3>
                </div>

                <?php

                $attributes = array('name' => 'frmExcelImport', 'id' => 'frmExcelImport');

                echo form_open_multipart('markeot2/import_data_eot2', $attributes); ?>

                <input type="file" name="file" id="file" accept=".xls,.xlsx, .csv"><br />
                <button type="submit" id="submit" name="import" class="btn-submit">Import Student Marks Using Excel (.xls & .csv Only)</button>
                <?php echo form_close(); ?>

                <div class="text-right box-tools">
                    <a href="<?php echo site_url('markeot2/add'); ?>" class="btn btn-success btn-sm">Add EOT & BOT Marks</a>
                    <a href="<?php echo site_url('markot2/add_stream'); ?>" class="btn btn-success btn-sm">Register Stream EOT & BOT Marks</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <!--<th>Student ID</th>-->
                                <th>Student</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>Year</th>
                                <th>Subject</th>
                                <!-- <th>Subject Code</th> -->
                                <th>Marks (BOT)</th>
                                <th>Marks (EOT)</th>
                                <th>Average</th>
                               <!-- <th>Comments</th>-->
                                <th>Term</th>
                                <!--<th>Subject Teacher</th>-->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($marks as $m) { ?>
                                <tr>
                                    <td><?php echo $m['id']; ?></td>
                                    <!--<td><?php echo $m['studentid']; ?></td>-->
                                    <td><?php echo $m['student']; ?></td>
                                    <td><?php echo $m['hisclass']; ?></td>
                                    <td><?php echo $m['stream']; ?></td>
                                    <td><?php echo $m['theyear']; ?></td>
                                    <td><?php echo $m['subject']; ?></td>
                                    <!-- <td><?php echo $m['subjectcode']; ?></td> -->
                                    <td><?php echo $m['mark1']; ?></td>
                                    <td><?php echo $m['mark2']; ?></td>
                                    <td><?php echo $m['average_mark']; ?></td>
                                   <!-- <td><?php echo $m['comment']; ?></td>-->
                                    <td><?php echo $m['term']; ?></td>
                                    <!--<td><?php echo $m['subjectteacher']; ?></td>-->
                                    <td>
                                       <!-- <a href="<?php echo site_url('mark/edit/' . $m['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>
                                        <a href="<?php echo site_url('mark/remove/' . $m['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>-->
                                    <a href="<?php echo site_url('markeot2/edit/' . $m['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>
                                    <a href="<?php echo site_url('markeot2/remove/' . $m['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                               <!-- <th>Student ID</th>-->
                                <th>Student</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>Year</th>
                                <th>Subject</th>
                                <th>Subject Code</th>
                                <th>Marks (BOT)</th>
                                <th>Marks (EOT)</th>
                                <th>Avearge </th>
                               <!-- <th>Comments</th>-->
                                <th>Term</th>
                                <!--<th>Subject Teacher</th>-->
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

<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
   // var table = $('#example1').DataTable();
 
    // Apply the search
    //table.columns().every( function () {
    //    var that = this;
 
    //    $( 'input', this.footer() ).on( 'keyup change', function () {
    //        if ( that.search() !== this.value ) {
   //             that
    //                .search( this.value )
    //                .draw();
    //        }
    //    } );
  //  } );
//} );
</script>
    <script>//$('#example thead th').each( function () {
   //     var title = $('#example1 tfoot th').eq( $(this).index() ).text();
   //     $(this).html( '&amp;lt;input type=&amp;quot;text&amp;quot; placeholder=&amp;quot;Search '+title+'&amp;quot; /&amp;gt;' );
   // } );
 
    // DataTable
   // var table = $('#example1').DataTable();
 
    // Apply the search
   // table.columns().eq( 0 ).each( function ( colIdx ) {
    //    $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
     //       table
      //          .column( colIdx )
       //         .search( this.value )
      //          .draw();
      //  } );
   // } );
//} );</script>