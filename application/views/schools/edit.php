<?php

$school_id = '';
$school_name = '';
$school_address = '';
$city_name = '';
$state_name = '';
$country_name = '';
$school_code = '';

if(!empty($schoolInfo))
{
    foreach ($schoolInfo as $info)
    {
        $school_id = $info->school_id;
        $school_name = $info->school_name;
        $school_address = $info->school_address;
        $city_name = $info->city_name;
        $state_name = $info->state_name;
        $country_name = $info->country_name;
        $school_code = $info->school_code;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> School Management
            <!-- <small>Add / Edit User</small> -->
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter School Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url() ?>school/editSchool" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">                                
                                    <div class="form-group">
                                        <label for="school_code">School Code</label>
                                        <input type="hidden" value="<?php echo $school_id; ?>" name="schoolId" id="schoolId" />
                                        <input type="hidden"name="orig_school_code" value="<?php echo $school_code; ?>">
                                        <input type="text" class="form-control" id="school_code" placeholder="School Code" name="school_code" value="<?php echo $school_code; ?>" maxlength="5">
                                        <input type="checkbox" name="delete_school" id="delete_school" value="1" checked>
                                        <label for="delete_school">Delete School (will delete school after updating student data)</label>
                                    </div>
                                    
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>