<?php $random = rand(100000, 9999999) ?>
<table width="70%" class="table table-striped table-bordered" id="olympiad_students_<?php echo $random ?>">
    <thead>
        <tr>
            <th width="5%">Sr.</th>
            <th width="20%">Roll Number</th>
            <th width="30%">Student Name</th>
            <th width="5%">Class</th>
            <th width="10%">Subject</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($students) > 0 ): ?>
            <?php $i = 0; foreach ($students as $student): ?>
                <?php foreach ($subjects as $subject): ?>
                    <?php if(($subject['id'] == $subject_id) && $student[$subject['short_code'].'_paper'] == 1): $i++; ?>
                        <tr>
                            <td width="5%" style="text-align: center;"><?php echo $i ?></td>
                            <td width="20%"><?php echo $student['roll_number']; ?></td>
                            <td width="30%"><?php echo $student['student_name']; ?></td>
                            <td width="5%" style="text-align: center;"><?php echo $student['class']; ?></td>
                            <?php $subjectValue = (isset($student[$subject['short_code'].'_paper']) && $student[$subject['short_code'].'_paper'] == 1) ? $subject['subject_code'] : ''; ?>
                            <td width="10%" style="text-align: center;"><?php echo $subjectValue; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php if (count($students) > 0 ): ?>
    <script type="text/javascript">
        $('#olympiad_students_'+<?php echo $random; ?>).DataTable();
    </script>
<?php endif; ?>
