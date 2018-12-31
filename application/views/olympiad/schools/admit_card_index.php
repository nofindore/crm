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
                                        <button class="btn btn-primary" id="download_admit_cards" type="button">Download Admit Cards <span class="fa fa-arrow-right"></span></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var v = jQuery("#school_details").validate({});

        $('#download_admit_cards').on('click', function(){
            if (v.form()) {
                var school_id = $('#school').val();
                getStudentsAdmitCards(school_id);
            }
        });

        function getStudentsAdmitCards(schoolId){
            var url = "olympiad_school_admit_cards_download/"+schoolId;
            window.open(url, "_blank");
        }
    });
</script>