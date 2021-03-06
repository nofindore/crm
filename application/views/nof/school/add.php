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
                    <!-- <div class="box-header">
                        <h3 class="box-title">Select School</h3>
                    </div> --><!-- /.box-header -->
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
                        <form role="form" id="school_save" name="school_save" action="<?php echo base_url() ?>school_save" method="post" enctype="multipart/form-data">
                            <!-- id will be unique, but class name will be same -->
                            <div id="section-one" class="section-form">
                                <fieldset>
                                    <legend>Select Address</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="form-control selectpicker required" id="country" name="school[country]">
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
                                                <select class="form-control selectpicker required" id="state" data-live-search="true" data-live-search-add="true" name="school[state]">
                                                    <option value="">SELECT STATE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="form-control selectpicker required" id="city" data-live-search="true" data-live-search-add="true" name="school[city]">
                                                    <option value="">SELECT CITY</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="form-control selectpicker required" id="school" data-live-search="true" name="school[school]" onchange="setSchoolName(this)">
                                                    <option value="">SELECT SCHOOL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary section-one-next" type="button">Next <span class="fa fa-arrow-right"></span></button>
                                        </div>
                                    </div>
                                </fieldset>
                                <!--  user name field will be here with next button -->
                            </div>

                            <!-- id will be unique, but class name will be same -->
                            <div id="section-two" class="section-form" style="display: none;">
                                <fieldset>
                                    <legend>School Details</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_name">School Name</label><span class="req"> *</span>
                                                <input type="text" class="form-control required" id="school_name" name="school[name]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_postal_address">Postal Address</label><span class="req"> *</span>
                                                <input type="text" class="form-control required" id="school_postal_address" name="school[postal_address]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_pin_code">Pin Code</label><span class="req"> *</span>
                                                <input type="text" class="form-control required digits" id="school_pin_code" name="school[pin_code]" maxlength="6" minlength="4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_district">District</label>
                                                <input type="text" class="form-control" id="school_district" name="school[district]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_phone_number">Phone Number</label><span class="req"> *</span>
                                                <input type="text" class="form-control required digits" id="school_phone_number" name="school[phone_number]" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_alternate_number">Alternate Number</label>
                                                <input type="text" class="form-control digits" id="school_alternate_number" name="school[alternate_number]" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <!-- back2 unique class name  -->
                                            <button class="btn btn-warning section-two-back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                            <!-- open2 unique class name -->
                                            <button class="btn btn-primary section-two-next" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                        </div>
                                    </div>
                                </fieldset>
                                <!--  user email field will be here with next and previous button -->
                            </div>

                            <!-- id will be unique, but class name will be same -->
                            <div id="section-three" class="section-form" style="display: none;">
                                <fieldset>
                                    <legend>Principal Details</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="principal_name">Name</label><span class="req"> *</span>
                                                <input type="text" class="form-control required" id="principal_name" name="principal[name]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="principal_mobile_number">Mobile Number</label><span class="req"> *</span>
                                                <input type="text" class="form-control required digits" id="principal_mobile_number" name="principal[mobile_number]" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="principal_phone_number">Phone Number</label>
                                                <input type="text" class="form-control" id="principal_phone_number" name="principal[phone_number]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="principal_emial_id">Email Id</label><span class="req"> *</span>
                                                <input type="text" class="form-control required email" id="principal_emial_id" name="principal[emial_id]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="principal_residential_address">Residential Address</label>
                                                <textarea class="form-control" id="principal_residential_address" name="principal[residential_address]"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <!-- back2 unique class name  -->
                                            <button class="btn btn-warning section-three-back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                            <!-- open2 unique class name -->
                                            <button class="btn btn-primary section-three-next" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                        </div>
                                    </div>
                                </fieldset>
                                <!--  user email field will be here with next and previous button -->
                            </div>

                            <!-- id will be unique, but class name will be same -->
                            <div id="section-four" class="section-form" style="display: none;">
                                <fieldset>
                                    <legend>Representative Details</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="representative_name">Name</label><span class="req"> *</span>
                                                <input type="text" class="form-control required" id="representative_name" name="representative[name]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="representative_mobile_number">Mobile Number</label><span class="req"> *</span>
                                                <input type="text" class="form-control required digits" id="representative_mobile_number" name="representative[mobile_number]" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="representative_phone_number">Phone Number</label>
                                                <input type="text" class="form-control" id="representative_phone_number" name="representative[phone_number]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="representative_email_id">Email Id</label><span class="req"> *</span>
                                                <input type="text" class="form-control required email" id="representative_email_id" name="representative[email_id]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="representative_designation">Designation</label>
                                                <input type="text" class="form-control" id="representative_designation" name="representative[designation]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <!-- back2 unique class name  -->
                                            <button class="btn btn-warning section-four-back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                            <!-- open2 unique class name -->
                                            <button class="btn btn-primary section-four-next" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                        </div>
                                    </div>
                                </fieldset>
                                <!--  user email field will be here with next and previous button -->
                            </div>

                            <!-- id will be unique, but class name will be same -->
                            <div id="section-five" class="section-form" style="display: none;">
                                <fieldset>
                                    <legend>Payment Details</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_bank">Bank</label>
                                                <input type="text" class="form-control" id="payment_bank" name="payment[bank]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_transaction_id">Transaction Id</label>
                                                <input type="text" class="form-control" id="payment_transaction_id" name="payment[transaction_id]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_details">Cheque/DD Number</label>
                                                <input type="text" class="form-control" id="payment_details" name="payment[details]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_amount">Amount</label>
                                                <input type="text" class="form-control" id="payment_amount" name="payment[amount]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <!-- back2 unique class name  -->
                                            <button class="btn btn-warning section-five-back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                            <!-- open2 unique class name -->
                                            <button class="btn btn-primary section-five-next" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- id will be unique, but class name will be same -->
                            <div id="section-six" class="section-form" style="display: none;">
                                <fieldset>
                                    <legend>Student(s) Subject Details</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!-- <label for="payment_bank">File Upload</label>
                                                <input type="file" class="form-control" id="payment_bank" name="payment[bank]"> -->

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-right">
                                        <div class="col-md-6">
                                            <!-- back2 unique class name  -->
                                            <button class="btn btn-warning section-six-back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                            <!-- open2 unique class name -->
                                            <button class="btn btn-primary section-six-next" type="submit">Submit</span></button> 
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    jQuery().ready(function() {
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

        var v = jQuery("#school_save").validate({
            rules: {
                country: {
                    required: true,
                },
            },
            errorElement: "span",
            errorClass: "help-inline",
        });

        // Binding next button on first step
        $(".section-one-next").click(function() {
            if (v.form()) {
                $(".section-form").hide("fast");
                $("#section-two").show("slow");
            }
        });

        // Binding next button on second step
        $(".section-two-next").click(function() {
            if (v.form()) {
                $(".section-form").hide("fast");
                $("#section-three").show("slow");
            }
        });

        // Binding back button on second step
        $(".section-two-back").click(function() {
            $(".section-form").hide("fast");
            $("#section-one").show("slow");
        });

        // Binding next button on third step
        $(".section-three-next").click(function() {
            if (v.form()) {
                $(".section-form").hide("fast");
                $("#section-four").show("slow");
            }
        });

        // Binding back button on third step
        $(".section-three-back").click(function() {
            $(".section-form").hide("fast");
            $("#section-two").show("slow");
        });

        // Binding next button on fourth step
        $(".section-four-next").click(function() {
            if (v.form()) {
                $(".section-form").hide("fast");
                $("#section-five").show("slow");
            }
        });

        // Binding back button on fourth step
        $(".section-four-back").click(function() {
            $(".section-form").hide("fast");
            $("#section-three").show("slow");
        });

        // Binding next button on fifth step
        $(".section-five-next").click(function() {
            if (v.form()) {
                $(".section-form").hide("fast");
                $("#section-six").show("slow");
            }
        });

        // Binding back button on fifth step
        $(".section-five-back").click(function() {
            $(".section-form").hide("fast");
            $("#section-four").show("slow");
        });

        // Binding back button on sixth step
        $(".section-six-back").click(function() {
            $(".section-form").hide("fast");
            $("#section-five").show("slow");
        });
    });

    function setSchoolName(element){
        var school_id = $(element).val();
        var school_name = $(element).find('option[value='+school_id+']').attr('data-attr');
        $('#school_name').val(school_name);
    }
</script>
<style type="text/css">
    .form-group{
        margin-bottom: 25px;
    }
    .help-inline, .req{
        color: red;
    }
</style>