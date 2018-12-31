<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Country Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>country/add"><i class="fa fa-plus"></i> Add New</a> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Countries List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-striped table-bordered" id="country" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <!-- <th class="text-center">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($countries))
                                    {
                                        foreach($countries as $country)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $country->id ?></td>
                                                <td><?php echo $country->country_name ?></td>
                                                <!-- <td class="text-center">
                                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$country->id; ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $country->id; ?>"><i class="fa fa-trash"></i></a>
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
        var oTable = $('#country').DataTable({
            columnDefs: [
                { orderable: false, targets: -1 }
            ],
            stateSave: true,
            "order": [
                [ 1, "asc" ],
            ]
        });
        var input = jQuery('#country_filter').find('input');
        var searchbtn = '<div class="input-group-btn">\
                            <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>\
                        </div>';
        jQuery('#country_filter').addClass('input-group').html(input).append(searchbtn);
        jQuery('#country_filter').find('input').addClass('form-control input-sm pull-right').attr('placeholder', 'Search');
        $(input).keyup(function(){
            oTable.search($(this).val()).draw() ;
        });
    });
</script>
<style type="text/css">
    #country_wrapper{
        padding: 10px;
    }
    #country_filter{
        width: 40%;
        margin-bottom: 10px;
    }
    #country_filter input{
        width: 150px;
    }
</style>