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
    </body>
</html>
