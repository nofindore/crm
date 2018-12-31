<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
                font-size: 15px;
                font-family: "Segoe UI",Arial,sans-serif;
            }
            .table {
                border-collapse: collapse;
                border: 1px solid black;
            }

            .table th, .table td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <table class="table table-striped table-bordered" width="100%" cellpadding="5px">
            <thead>
                <tr>
                    <td>Class</td>
                    <?php foreach($subjects as $subject) : ?>
                        <td><?php echo $subject['subject_name']; ?></td>
                    <?php endforeach; ?>
                    <td>Total</td>
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
    </body>
</html>
