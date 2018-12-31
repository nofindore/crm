<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        	<i class="fa fa-users"></i> <?php echo $pageTitle; ?>
        </h1>
    </section>
    <section class="content">    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Select School</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
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
                        <form role="form" id="students_bulk_upload" action="<?php echo base_url() ?>students_bulk_upload_process" method="post" role="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" id="country" name="country">
                                            <option value="">SELECT COUNTRY</option>
                                            <?php foreach ($countries as $country): ?>
                                                <option value="<?php echo $country->id ?>"><?php echo trim(strtoupper($country->country_name)); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" id="state" data-live-search="true" data-live-search-add="true" name="state">
                                            <option value="">SELECT STATE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" id="city" data-live-search="true" data-live-search-add="true" name="city">
                                            <option value="">SELECT CITY</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" id="school" data-live-search="true" name="school">
                                            <option value="">SELECT SCHOOL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control required" name="students" />
                                    </div>
                                </div>
                            </div>
                            <div class="row text-right">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    
        var studentsBulkUpload = $("#students_bulk_upload");
        
        var validator = studentsBulkUpload.validate({
            
            rules:{
                country :{ required : true },
                state :{ required : true },
                city :{ required : true },
                school :{ required : true },
                students :{ required : true, extension: "csv" },
            },
            messages:{
                country : { required : "This field is required field." },
                state : { required : "This field is required field." },
                city : { required : "This field is required field." },
                school : { required : "This field is required field." },
                students : { required : "This field is required field." },
            }
        });

        $('#country').on('change', function(){
            loadStates();
        });

        $('#state').on('change', function(){
            $('#state').selectpicker('refresh');
            loadCities();
        });

        $('#city').on('change', function(){
            $('#city').selectpicker('refresh');
            loadSchools();
        });

        function loadStates(){
            var country = $('#country').val();
            $.ajax({
                type: "POST",
                url: "stateByCountry",
                data: {'country_id':country},
                success: function(data){
                    console.log(data);
                    $('#state').html(data);
                    $('#state').selectpicker('refresh');
                }
            });
        }

        function loadCities(){
            var state = $('#state').val();
            $.ajax({
                type: "POST",
                url: "cityByState",
                data: {'state_id':state},
                success: function(data){
                    $('#city').html(data);
                    $('#city').selectpicker('refresh');
                }
            });
        }

        function loadSchools(){
            var city = $('#city').val();
            $.ajax({
                type: "POST",
                url: "schoolByCity",
                data: {'city_id':city},
                success: function(data){
                    $('#school').html(data);
                    $('#school').selectpicker('refresh');
                }
            });
        }
    });
</script>