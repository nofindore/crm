<?php $random = rand(100000, 9999999) ?>
<table class="table table-striped table-bordered" id="olympiad_students_<?php echo $random ?>">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Roll Number</th>
            <th>Student Name</th>
            <th>Class</th>
            <?php foreach ($subjects as $subject): ?>
                <th><?php echo $subject['subject_name']; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (count($students) > 0 ): ?>
            <?php $i = 0; foreach ($students as $student): $i++; ?>
                <tr>
                    <td style="text-align: center;"><?php echo $i ?></td>
                    <td><?php echo $student['roll_number']; ?></td>
                    <td><?php echo $student['student_name']; ?></td>
                    <td style="text-align: center;"><?php echo $student['class']; ?></td>
                    <?php foreach ($subjects as $subject): ?>
                        <?php $subjectValue = (isset($student[$subject['short_code'].'_paper']) && $student[$subject['short_code'].'_paper'] == 1) ? $subject['subject_code'] : ''; ?>
                        <td style="text-align: center;"><?php echo $subjectValue; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php if (count($students) > 0 ): ?>
    <script type="text/javascript">
        $('#olympiad_students_'+<?php echo $random; ?>).DataTable();
    </script>
<?php endif; ?>
