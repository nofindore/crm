<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Schools Management
            <!-- <small>Add, Edit, Delete</small> -->
        </h1>
    </section>
    <section class="content">
        <div class="row" style="display: none;">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
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
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Schools List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table id="schools" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>School Name</th>
                                    <th>School Code</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <!-- <th>Total Students</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schools as $school): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $school->school_id ?></td>
                                        <td width="30%">
                                            <div class="school_name" style="font-weight: bold;"><?php echo $school->school_name; ?></div>
                                            <div class="school_address"><?php echo $school->school_address ?></div>
                                        </td>
                                        <td class="text-center"><?php echo $school->school_code ?></td>
                                        <td class="text-center"><?php echo $school->country_name ?></td>
                                        <td class="text-center"><?php echo $school->state_name ?></td>
                                        <td class="text-center"><?php echo $school->city_name ?></td>
                                        <!-- <td class="text-center"><?php //echo $school->total_students ?></td> -->
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'school/edit/'.$school->school_id; ?>"><i class="fa fa-pencil"></i></a>
                                            <!-- <a class="btn btn-sm btn-info" href="#" data-userid="<?php //echo $school->school_id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                            <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php //echo $school->school_id; ?>"><i class="fa fa-trash"></i></a> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" data-attr="">Id</th>
                                    <th class="text-center" data-attr="">School Name</th>
                                    <th class="text-center" data-attr="">School Code</th>
                                    <th class="text-center" data-attr="sort">Country</th>
                                    <th class="text-center" data-attr="sort">State</th>
                                    <th class="text-center" data-attr="sort">City</th>
                                    <th class="text-center" data-attr="">Total Students</th>
                                    <th class="text-center" data-attr="">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });

    jQuery(document).ready(function() {
        var oTable = jQuery('#schools').DataTable( {
            columnDefs: [
                { orderable: false, targets: -1 }
            ],
            stateSave: true,
            "order": [
                /*[ 2, "asc" ],*/
                [ 3, "asc" ],
                [ 4, "asc" ],
                [ 5, "asc" ],
                [ 6, "asc" ],
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
        } );

        var input = jQuery('#schools_filter').find('input');
        var searchbtn = '<div class="input-group-btn">\
                            <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>\
                        </div>';
        jQuery('#schools_filter').addClass('input-group').html(input).append(searchbtn);
        jQuery('#schools_filter').find('input').addClass('form-control input-sm pull-right').attr('placeholder', 'Search');
        $(input).keyup(function(){
            oTable.search($(this).val()).draw() ;
        });
    });
</script>
<style type="text/css">
    #schools_wrapper{
        padding: 10px;
    }
    #schools_filter{
        width: 40%;
    }
    #schools_filter input{
        width: 150px;
    }
</style>