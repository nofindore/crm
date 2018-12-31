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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control selectpicker" id="school" data-live-search="true">
                                        <?php foreach ($schools as $school): ?>
                                            <?php $schoolName = $school->school_name.', '.$school->city_name.' - '.$school->school_code; ?>
                                            <option value="<?php echo $school->school_id ?>"><?php echo trim(strtoupper($schoolName)) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="button" onclick="downloadCSV()" class="btn btn-primary" value="Submit" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<script type="text/javascript">
    function downloadCSV(){
        var school_id = $('#school').val();
        var school_name = $("#school option:selected").text();
        var school_name = school_name.trim();
        var downloadUrl = "<?php echo base_url(); ?>";
        $.ajax({
            type: "POST",
            url: "students_books_details_csv",
            data: {'school_id':school_id},
            success: function(data){
                if (data == '200') {
                    var a = document.createElement('a');
                    var csvUrl = downloadUrl+'assets/students/students_data_sheet.csv';
                    a.href = csvUrl;
                    a.download = school_name+'.csv';
                    a.click();
                    window.URL.revokeObjectURL(csvUrl);
                } else {
                     alert('There is some problem in generating CSV file! Please contact System Administrator.');
                }
            }
        });
    }
</script>