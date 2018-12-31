<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
                font-size: 14px;
                font-family: "Segoe UI",Arial,sans-serif;
            }
            .table {
                border-collapse: collapse;
                border: 1px solid black;
            }

            .table th, .table td {
                border: 1px solid black;
            }

            .head_table{
                font-size: 15px;
                font-weight: bold;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <table class="table table-striped table-bordered" width="100%" cellpadding="5px;">
            <thead>
                <tr>
                    <td>No.</td>
                    <td>Roll Number</td>
                    <td>Student Name</td>
                    <td style="padding-right: 5px; padding-left: 5px;">Class</td>
                    <?php foreach ($subjects as $subject): ?>
                        <td style="padding-right: 5px; padding-left: 5px;"><?php echo $subject['subject_name']; ?></td>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0 ): ?>
                    <?php $i = 0; foreach ($students as $student): $i++; ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $i ?></td>
                            <td style="padding-left: 5px; padding-right: 5px;"><?php echo $student['roll_number']; ?></td>
                            <td><?php echo ucwords(strtolower($student['student_name'])); ?></td>
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
    </body>
</html>
