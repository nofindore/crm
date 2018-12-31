<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        	<i class="fa fa-users"></i> <?php echo $pageTitle; ?>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $pageTitle; ?></h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>students_list" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-details">
                        	<?php echo $this->pagination->create_links(); ?>
                        	<div class="totals">
                        		<span><?php echo $totalCount; ?></span><span> record(s) found.</span>
                        		<span><?php echo $perPage; ?></span><span> items per page.</span>
                        	</div>
                        	<div class="grid-filters">
                        		
                        	</div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>S.No.</th>
                                <th>Roll No.</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Mobile</th>
                                <th>School Code</th>
                                <th>School Name</th>
                                <th>School Address</th>
                            </tr>
                            <?php
                                if(!empty($studentsRecords))
                                {
                                	$i = 0;
                                    foreach($studentsRecords as $record)
                                    {
                                    	$i++;
                                		?>
			                            <tr>
			                                <td><?php echo $i ?></td>
			                                <td><?php echo $record->roll_number ?></td>
			                                <td><?php echo ucwords($record->name) ?></td>
			                                <td><?php echo $record->class ?></td>
			                                <td><?php echo $record->mobile ?></td>
			                                <td><?php echo $record->state_code.$record->school_code ?></td>
			                                <td><?php echo $record->school_name ?></td>
			                                <td><?php echo $record->school_address ?></td>
			                            </tr>
                            			<?php
                                	}
                                }
                            ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>