<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        	<i class="fa fa-users"></i> <?php echo $pageTitle; ?>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 style="margin-bottom: 0px">Students</h3>
                        <p style="font-size: 20px;">Detail</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-book"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>students_books_details" class="small-box-footer">Download Report <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6" style="display: none;">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 style="margin-bottom: 0px">Schools</h3>
                        <p style="font-size: 20px;">Detail</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-book"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>schools_details" class="small-box-footer">Download Report <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</div>