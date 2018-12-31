<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i> Reports - National Olympiad Foundation 2018
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- ./col -->
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" id="school_details" action="javascript:void(0)" method="post">
                            <fieldset>
                                <legend>SELECT DETAILS</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php //echo "<pre>"; print_r($schools); echo "</pre>"; ?>
                                            <select class="form-control selectpicker required" id="school">
                                                <option value="">SELECT SCHOOL</option>
                                                <?php foreach ($schools as $school): ?>
                                                    <?php $school_name = trim(strtoupper($school->name)); ?>
                                                    <?php $city_name = ', '.trim(strtoupper($school->city_name)); ?>
                                                    <?php $school_code = (!empty($school->school_code)) ? ', '.$school->school_code : '' ; ?>
                                                    <?php $state_code = ", ".$school->state_code; ?>
                                                    <?php $schoolName = $school_name.$city_name.$school_code.$state_code; ?>
                                                    <option value="<?php echo $school->id ?>"><?php echo $schoolName; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary" id="view_student_list" type="button">View List <span class="fa fa-arrow-right"></span></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" id="students_list" style="display: none;">
                <div class="box box-primary">
                    <div class="box-body">
                        <fieldset>
                            <legend>
                                <div class="pull-left">STUDENTS LIST OF <span id="school_name"></span></div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>olympiad_students_list_print" data-attr="<?php echo base_url(); ?>olympiad_students_list_print" target="_blank" id="print_students_list"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </legend>
                            <div class="box-body table-responsive no-padding" id="students_list_data"></div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#school').on('change', function(){
            $('#students_list').hide();
            $('#students_list_data').html('');
        });

        var v = jQuery("#school_details").validate({});

        $('#view_student_list').on('click', function(){
            if (v.form()) {
                var school_id = $('#school').val();
                getStudentsList(school_id);
                $('#students_list').show();
                setSchoolName(school_id);
            }
        });

        function getStudentsList(schoolId){
            $.ajax({
                type: "POST",
                url: "olympiad_students_list/"+schoolId,
                success: function(data){
                    $('#students_list_data').html(data);
                }
            });
        }

        function setSchoolName(school_id){
            if (school_id != '') {
                var school_name = $('#school').find('option[value='+school_id+']').html();
                $('#school_name').html(school_name);
                var url = $('#print_students_list').attr('data-attr');
                $('#print_students_list').attr('href', url+'/'+school_id);
            }
        }
    });
</script>