<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Olympiad Schools Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>olympiad_school_add"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <?php
                    $error = $this->session->flashdata('error');
                    if($error)
                    { 
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $error; ?>
                        </div>
                        <?php
                    }
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $success; ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Schools List</h3>
                        <div class="box-tools" style="display: none;">
                            <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="olympiad_schools" width="98%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>District</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tableStatus = 0; if(!empty($schools)): $tableStatus = 1; ?>
                                    <?php foreach($schools as $record): ?>
                                        <tr>
                                            <td><?php echo $record->id ?></td>
                                            <td><?php echo $record->name ?></td>
                                            <td><?php echo $record->phone_number ?></td>
                                            <td><?php echo $record->country_name ?></td>
                                            <td><?php echo $record->state_name ?></td>
                                            <td><?php echo $record->city_name ?></td>
                                            <td><?php echo $record->district ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info" title="Send Login" href="<?php echo base_url().'olympiad_school_send_login/'.$record->id; ?>"><i class="fa fa-send"></i></a>
                                                <!-- <a class="btn btn-sm btn-danger deleteUser" href="<?php //echo base_url().'olympiad_school_delete/'.$record->id; ?>"><i class="fa fa-trash"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Records Found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php //echo $this->pagination->create_links(); ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<?php if($tableStatus): ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var oTable = $('#olympiad_schools').DataTable({
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                stateSave: true,
                "order": [
                    [ 1, "asc" ],
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var footer = jQuery(column.footer());
                        if (footer.attr('data-attr') == 'sort') {
                            var label = jQuery(column.footer()).text();
                            if (true) {}
                            var select = jQuery('<select class="form-control"><option value=""></option></select>')
                                .appendTo( jQuery(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = jQuery.fn.dataTable.util.escapeRegex(
                                        jQuery(this).val()
                                    );
             
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                            select.parent('th').prepend( '<label>'+label+'</label>' );
                        }
                    } );
                }
            });
            var input = jQuery('#olympiad_schools_filter').find('input');
            var searchbtn = '<div class="input-group-btn">\
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>\
                            </div>';
            jQuery('#olympiad_schools_filter').addClass('input-group').html(input).append(searchbtn);
            jQuery('#olympiad_schools_filter').find('input').addClass('form-control input-sm pull-right').attr('placeholder', 'Search');
            $(input).keyup(function(){
                oTable.search($(this).val()).draw() ;
            });
        });
    </script>
<?php endif; ?>
<style type="text/css">
    #olympiad_schools_wrapper{
        padding: 10px;
    }
    #olympiad_schools_filter{
        width: 40%;
        margin-bottom: 10px;
    }
    #olympiad_schools_filter input{
        width: 150px;
    }
</style>