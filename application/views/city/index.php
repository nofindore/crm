<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> City Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>city/add"><i class="fa fa-plus"></i> Add New</a> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Cities List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-striped table-bordered" id="city" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>City Name</th>
                                    <th>State Name</th>
                                    <!-- <th class="text-center">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($cities))
                                    {
                                        foreach($cities as $city)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $city->id ?></td>
                                                <td><?php echo $city->city_name ?></td>
                                                <td><?php echo $city->state_name ?></td>
                                                <!-- <td class="text-center">
                                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$city->id; ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $city->id; ?>"><i class="fa fa-trash"></i></a>
                                                </td> -->
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No Record Found.</td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot style="display: none;">
                                <tr>
                                    <th class="" data-attr="">Id</th>
                                    <th class="" data-attr="">City Name</th>
                                    <th class="" data-attr="sort">State Name</th>
                                </tr>
                            </tfoot>
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
<script type="text/javascript">
    jQuery(document).ready(function(){
        var oTable = $('#city').DataTable({
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
        var input = jQuery('#city_filter').find('input');
        var searchbtn = '<div class="input-group-btn">\
                            <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>\
                        </div>';
        jQuery('#city_filter').addClass('input-group').html(input).append(searchbtn);
        jQuery('#city_filter').find('input').addClass('form-control input-sm pull-right').attr('placeholder', 'Search');
        $(input).keyup(function(){
            oTable.search($(this).val()).draw() ;
        });
    });
</script>
<style type="text/css">
    #city_wrapper{
        padding: 10px;
    }
    #city_filter{
        width: 40%;
        margin-bottom: 10px;
    }
    #city_filter input{
        width: 150px;
    }
</style>