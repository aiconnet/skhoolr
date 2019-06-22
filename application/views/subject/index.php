<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ordinary Level Subjects
        <!-- <small>Ordinary Level</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Skoolr</a></li>
        <li class="active">Ordinary Level Subjects</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">Ordinary Level Subjects</h3>
                </div>

                <div class="box-tools">
                    <a href="<?php echo site_url('subject/add'); ?>" class="btn btn-success btn-sm">Register Subject</a>
                    <!-- <a href="<?php echo site_url('student/add_stream'); ?>" class="btn btn-success btn-sm">Register Stream of Students</a> -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Subject Code</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Stream</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $s) { ?>
                                <tr>
                                    <td><?php echo $s['id']; ?></td>
                                    <td><?php echo $s['subject']; ?></td>
                                    <td><?php echo $s['subjectcode']; ?></td>
                                    <td><?php echo $s['theclass']; ?></td>
                                    <td><?php echo $s['teacher']; ?></td>
                                    <td><?php echo $s['stream']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('subject/edit/' . $s['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>
                                        <a href="<?php echo site_url('subject/remove/' . $s['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Subject Code</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Stream</th>
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
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "stripeClasses": true
        });
        
    });
    
       // Setup - add a text input to each footer cell
    $('#example2 tfoot th').each( function () {
        var title = $('#example2 thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );
    
    table.columns().every( function () {
    var column = this;
 
    $( 'input', this.footer() ).on( 'keyup change', function () {
        column
            .search( this.value )
            .draw();
    } );
    
} );
</script>

<script>

// DataTable
//var table = $('#example2').DataTable();
 
// Apply the filter
/*
table.columns().every( function () {
    var column = this;
 
    $( 'input', this.footer() ).on( 'keyup change', function () {
        column
            .search( this.value )
            .draw();
    } );
} );*/

</script>
<script>
    $("#tables").addClass('active');
    $("#data-tables").addClass('active');
</script>