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
            <div class="col-xs-6" style="display: block;">
                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" id="school_details" action="javascript:void(0)" method="post">
                            <fieldset>
                                <legend>REPORT OF</legend>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="radio-inline" for="report_for_all"><input type="radio" value="report_for_all" id="report_for_all" name="report_for" checked>ALL</label>
                                            <label class="radio-inline" for="report_for_school"><input type="radio" value="report_for_school" id="report_for_school" name="report_for">SELECT SCHOOL</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 select_school" style="display: none;">
                                        <div class="form-group">
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
                                    <div class="col-md-2 select_school" style="display: none;">
                                        <button class="btn btn-primary" id="view_student_list" type="button">View Report <span class="fa fa-arrow-right"></span></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-6" style="display: block;">
                <div class="box box-primary">
                    <div class="box-body">
                        <fieldset>
                            <legend>REPORT TYPE</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="radio-inline" for="report_type_all"><input type="radio" value="all_papers_books" id="report_type_all" name="report_type" checked>PAPERS & BOOKS</label>
                                        <label class="radio-inline" for="report_type_papers"><input type="radio" value="all_papers_only" id="report_type_papers" name="report_type">PAPERS ONLY</label>
                                        <label class="radio-inline" for="report_type_books"><input type="radio" value="all_books_only" id="report_type_books" name="report_type">BOOKS ONLY</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" id="report_all_papers_books" style="display: block;">
                <div class="box box-primary">
                    <div class="box-body">
                        <?php foreach($allSchoolsSubjects as $schoolId => $students): ?>
                            <fieldset class="book_paper_details" id="all_papers_books_<?php echo $schoolId; ?>" style="display: none;">
                                <legend>
                                    <div class="pull-left">REPORT ALL PAPERS & BOOKS</div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>olympiad_print_report_all_papers_books/<?php echo $schoolId; ?>" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                    </div>
                                </legend>
                                <div class="box-body table-responsive no-padding" id="report_all_papers_books_data">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle;">Class</th>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <th colspan="2" style="text-align: center;"><?php echo $subject['subject_name']; ?></th>
                                                <?php endforeach; ?>
                                                <th colspan="2" style="text-align: center;">Total</th>
                                            </tr>
                                            <tr>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <th>Papers</th>
                                                    <th>Books</th>
                                                <?php endforeach; ?>
                                                <th>Papers</th>
                                                <th>Books</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grandTotalData = array(); ?>
                                            <?php foreach ($classess as $class) : ?>
                                                <tr>
                                                    <td><?php echo $class; ?></td>
                                                    <?php $totalPapers = 0; ?>
                                                    <?php $totalBooks = 0; ?>
                                                    <?php foreach($subjects as $subject) : ?>
                                                        <?php $paper = (isset($students[$class])) ? ((isset($students[$class][$subject['short_code']])) ? $students[$class][$subject['short_code']]['paper'] : 0) : 0; ?>
                                                        <?php $book = (isset($students[$class])) ? ((isset($students[$class][$subject['short_code']])) ? $students[$class][$subject['short_code']]['book'] : 0) : 0; ?>
                                                        <?php
                                                            if (empty($grandTotalData)) {
                                                                $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                                $grandTotalData[$subject['short_code']]['book'] = $book;
                                                            } else {
                                                                if (isset($grandTotalData[$subject['short_code']])) {
                                                                    $grandTotalData[$subject['short_code']]['paper'] += $paper;
                                                                    $grandTotalData[$subject['short_code']]['book'] += $book;
                                                                } else {
                                                                   $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                                    $grandTotalData[$subject['short_code']]['book'] = $book; 
                                                                }
                                                            }
                                                        ?>
                                                        <td><?php echo ($paper > 0) ? $paper : ''; ?></td>
                                                        <td><?php echo ($book > 0) ? $book : ''; ?></td>
                                                        <?php $totalPapers += $paper; ?>
                                                        <?php $totalBooks += $book; ?>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $totalPapers; ?></td>
                                                    <td><?php echo $totalBooks; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <?php $grandTotalPapers = 0; ?>
                                                <?php $grandTotalBooks = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $sTotalPapers = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['paper'] : 0; ?>
                                                    <?php $sTotalBooks = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['book'] : 0; ?>
                                                    <td><?php echo $sTotalPapers; ?></td>
                                                    <td><?php echo $sTotalBooks; ?></td>
                                                    <?php $grandTotalPapers += $sTotalPapers; ?>
                                                    <?php $grandTotalBooks += $sTotalBooks; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $grandTotalPapers; ?></td>
                                                <td><?php echo $grandTotalBooks; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <fieldset class="book_paper_details" id="all_papers_only_<?php echo $schoolId; ?>" style="display: none;">
                                <legend>
                                    <div class="pull-left">REPORT ALL PAPERS</div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>olympiad_print_report_all_papers/<?php echo $schoolId; ?>" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                    </div>
                                </legend>
                                <div class="box-body table-responsive no-padding" id="report_all_papers_data">
                                    <table class="table table-striped table-bordered" style="width: 50%">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <th><?php echo $subject['subject_name']; ?></th>
                                                <?php endforeach; ?>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grandTotalData = array(); ?>
                                            <?php foreach ($classess as $class) : ?>
                                                <tr>
                                                    <td><?php echo $class; ?></td>
                                                    <?php $totalPapers = 0; ?>
                                                    <?php $totalBooks = 0; ?>
                                                    <?php foreach($subjects as $subject) : ?>
                                                        <?php $paper = (isset($students[$class])) ? ((isset($students[$class][$subject['short_code']])) ? $students[$class][$subject['short_code']]['paper'] : 0) : 0; ?>
                                                        <?php

                                                            if (empty($grandTotalData)) {
                                                                $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                            } else {
                                                                if (isset($grandTotalData[$subject['short_code']])) {
                                                                    $grandTotalData[$subject['short_code']]['paper'] += $paper;
                                                                } else {
                                                                   $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                                }
                                                            }
                                                        ?>
                                                        <td><?php echo ($paper > 0) ? $paper : ''; ?></td>
                                                        <?php $totalPapers += $paper; ?>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $totalPapers; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <?php $grandTotalPapers = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $sTotalPapers = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['paper'] : 0; ?>
                                                    <td><?php echo $sTotalPapers; ?></td>
                                                    <?php $grandTotalPapers += $sTotalPapers; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $grandTotalPapers; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <fieldset class="book_paper_details" id="all_books_only_<?php echo $schoolId; ?>" style="display: none;">
                                <legend>
                                    <div class="pull-left">REPORT ALL BOOKS</div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>olympiad_print_report_all_books/<?php echo $schoolId; ?>" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                    </div>
                                </legend>
                                <div class="box-body table-responsive no-padding" id="report_all_books_data">
                                    <table class="table table-striped table-bordered" style="width: 50%">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <th><?php echo $subject['subject_name']; ?></th>
                                                <?php endforeach; ?>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grandTotalData = array(); ?>
                                            <?php foreach ($classess as $class) : ?>
                                                <tr>
                                                    <td><?php echo $class; ?></td>
                                                    <?php $totalBooks = 0; ?>
                                                    <?php foreach($subjects as $subject) : ?>
                                                        <?php $book = (isset($students[$class])) ? ((isset($students[$class][$subject['short_code']])) ? $students[$class][$subject['short_code']]['book'] : 0) : 0; ?>
                                                        <?php
                                                            if (empty($grandTotalData)) {
                                                                $grandTotalData[$subject['short_code']]['book'] = $book;
                                                            } else {
                                                                if (isset($grandTotalData[$subject['short_code']])) {
                                                                    $grandTotalData[$subject['short_code']]['book'] += $book;
                                                                } else {
                                                                    $grandTotalData[$subject['short_code']]['book'] = $book; 
                                                                }
                                                            }
                                                        ?>
                                                        <td><?php echo ($book > 0) ? $book : ''; ?></td>
                                                        <?php $totalBooks += $book; ?>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $totalBooks; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <?php $grandTotalBooks = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $sTotalBooks = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['book'] : 0; ?>
                                                    <td><?php echo $sTotalBooks; ?></td>
                                                    <?php $grandTotalBooks += $sTotalBooks; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $grandTotalBooks; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        <?php endforeach; ?>

                        <fieldset class="book_paper_details" id="all_papers_books_0" style="display: block;">
                            <legend>
                                <div class="pull-left">REPORT ALL PAPERS & BOOKS</div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>olympiad_print_report_all_papers_books" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </legend>
                            <div class="box-body table-responsive no-padding" id="report_all_papers_books_data">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;">Class</th>
                                            <?php foreach($subjects as $subject) : ?>
                                                <th colspan="2" style="text-align: center;"><?php echo $subject['subject_name']; ?></th>
                                            <?php endforeach; ?>
                                            <th colspan="2" style="text-align: center;">Total</th>
                                        </tr>
                                        <tr>
                                            <?php foreach($subjects as $subject) : ?>
                                                <th>Papers</th>
                                                <th>Books</th>
                                            <?php endforeach; ?>
                                            <th>Papers</th>
                                            <th>Books</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $grandTotalData = array(); ?>
                                        <?php foreach ($classess as $class) : ?>
                                            <tr>
                                                <td><?php echo $class; ?></td>
                                                <?php $totalPapers = 0; ?>
                                                <?php $totalBooks = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $paper = (isset($schoolsSubjects[$class])) ? ((isset($schoolsSubjects[$class][$subject['short_code']])) ? $schoolsSubjects[$class][$subject['short_code']]['paper'] : 0) : 0; ?>
                                                    <?php $book = (isset($schoolsSubjects[$class])) ? ((isset($schoolsSubjects[$class][$subject['short_code']])) ? $schoolsSubjects[$class][$subject['short_code']]['book'] : 0) : 0; ?>
                                                    <?php
                                                        if (empty($grandTotalData)) {
                                                            $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                            $grandTotalData[$subject['short_code']]['book'] = $book;
                                                        } else {
                                                            if (isset($grandTotalData[$subject['short_code']])) {
                                                                $grandTotalData[$subject['short_code']]['paper'] += $paper;
                                                                $grandTotalData[$subject['short_code']]['book'] += $book;
                                                            } else {
                                                               $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                                $grandTotalData[$subject['short_code']]['book'] = $book; 
                                                            }
                                                        }
                                                    ?>
                                                    <td><?php echo ($paper > 0 ) ? $paper : ''; ?></td>
                                                    <td><?php echo ($book > 0) ? $book : ''; ?></td>
                                                    <?php $totalPapers += $paper; ?>
                                                    <?php $totalBooks += $book; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $totalPapers; ?></td>
                                                <td><?php echo $totalBooks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Total</td>
                                            <?php $grandTotalPapers = 0; ?>
                                            <?php $grandTotalBooks = 0; ?>
                                            <?php foreach($subjects as $subject) : ?>
                                                <?php $sTotalPapers = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['paper'] : 0; ?>
                                                <?php $sTotalBooks = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['book'] : 0; ?>
                                                <td><?php echo $sTotalPapers; ?></td>
                                                <td><?php echo $sTotalBooks; ?></td>
                                                <?php $grandTotalPapers += $sTotalPapers; ?>
                                                <?php $grandTotalBooks += $sTotalBooks; ?>
                                            <?php endforeach; ?>
                                            <td><?php echo $grandTotalPapers; ?></td>
                                            <td><?php echo $grandTotalBooks; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="book_paper_details" id="all_papers_only_0" style="display: none;">
                            <legend>
                                <div class="pull-left">REPORT ALL PAPERS</div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>olympiad_print_report_all_papers" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </legend>
                            <div class="box-body table-responsive no-padding" id="report_all_papers_data">
                                <table class="table table-striped table-bordered" style="width: 50%">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <?php foreach($subjects as $subject) : ?>
                                                <th><?php echo $subject['subject_name']; ?></th>
                                            <?php endforeach; ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $grandTotalData = array(); ?>
                                        <?php foreach ($classess as $class) : ?>
                                            <tr>
                                                <td><?php echo $class; ?></td>
                                                <?php $totalPapers = 0; ?>
                                                <?php $totalBooks = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $paper = (isset($schoolsSubjects[$class])) ? ((isset($schoolsSubjects[$class][$subject['short_code']])) ? $schoolsSubjects[$class][$subject['short_code']]['paper'] : 0) : 0; ?>
                                                    <?php
                                                        if (empty($grandTotalData)) {
                                                            $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                        } else {
                                                            if (isset($grandTotalData[$subject['short_code']])) {
                                                                $grandTotalData[$subject['short_code']]['paper'] += $paper;
                                                            } else {
                                                               $grandTotalData[$subject['short_code']]['paper'] = $paper;
                                                            }
                                                        }
                                                    ?>
                                                    <td><?php echo ($paper > 0) ? $paper : ''; ?></td>
                                                    <?php $totalPapers += $paper; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $totalPapers; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Total</td>
                                            <?php $grandTotalPapers = 0; ?>
                                            <?php foreach($subjects as $subject) : ?>
                                                <?php $sTotalPapers = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['paper'] : 0; ?>
                                                <td><?php echo $sTotalPapers; ?></td>
                                                <?php $grandTotalPapers += $sTotalPapers; ?>
                                            <?php endforeach; ?>
                                            <td><?php echo $grandTotalPapers; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="book_paper_details" id="all_books_only_0" style="display: none;">
                            <legend>
                                <div class="pull-left">REPORT ALL BOOKS</div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>olympiad_print_report_all_books" target="_blank" id="olympiad_print_report_all_papers_books"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </legend>
                            <div class="box-body table-responsive no-padding" id="report_all_books_data">
                                <table class="table table-striped table-bordered" style="width: 50%">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <?php foreach($subjects as $subject) : ?>
                                                <th><?php echo $subject['subject_name']; ?></th>
                                            <?php endforeach; ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $grandTotalData = array(); ?>
                                        <?php foreach ($classess as $class) : ?>
                                            <tr>
                                                <td><?php echo $class; ?></td>
                                                <?php $totalBooks = 0; ?>
                                                <?php foreach($subjects as $subject) : ?>
                                                    <?php $book = (isset($schoolsSubjects[$class])) ? ((isset($schoolsSubjects[$class][$subject['short_code']])) ? $schoolsSubjects[$class][$subject['short_code']]['book'] : 0) : 0; ?>
                                                    <?php
                                                        if (empty($grandTotalData)) {
                                                            $grandTotalData[$subject['short_code']]['book'] = $book;
                                                        } else {
                                                            if (isset($grandTotalData[$subject['short_code']])) {
                                                                $grandTotalData[$subject['short_code']]['book'] += $book;
                                                            } else {
                                                                $grandTotalData[$subject['short_code']]['book'] = $book; 
                                                            }
                                                        }
                                                    ?>
                                                    <td><?php echo ($book > 0) ? $book : ''; ?></td>
                                                    <?php $totalBooks += $book; ?>
                                                <?php endforeach; ?>
                                                <td><?php echo $totalBooks; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Total</td>
                                            <?php $grandTotalBooks = 0; ?>
                                            <?php foreach($subjects as $subject) : ?>
                                                <?php $sTotalBooks = (isset($grandTotalData[$subject['short_code']])) ? $grandTotalData[$subject['short_code']]['book'] : 0; ?>
                                                <td><?php echo $sTotalBooks; ?></td>
                                                <?php $grandTotalBooks += $sTotalBooks; ?>
                                            <?php endforeach; ?>
                                            <td><?php echo $grandTotalBooks; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("input[name$='report_type']").click(function(){
            var inputVal = $(this).val();
            $('fieldset.book_paper_details').hide();
            var school_id = 0;
            if (!$("#report_for_all").prop('checked')) {
                school_id = $('#school').val();
            }
            $("#"+inputVal+'_'+school_id).show();
        });

        $("input[name$='report_for']").click(function(){
            var inputVal = $(this).val();
            $('fieldset.book_paper_details').hide();
            if (inputVal == 'report_for_school') {
                $('.select_school').show();
            } else {
                $('.select_school').hide();
                $('#report_type_all').prop('checked', true);
                $('#all_papers_books_0').show();
            }
        });

        $('#school').on('change', function(){
            $('fieldset.book_paper_details').hide();
            $('#students_list_data').html('');
        });

        var v = jQuery("#school_details").validate({});

        $('#view_student_list').on('click', function(){
            if (v.form()) {
                var school_id = $('#school').val();
                $('#report_type_all').prop('checked', true);
                $('#all_papers_books_'+school_id).show();
            }
        });
    });
</script>