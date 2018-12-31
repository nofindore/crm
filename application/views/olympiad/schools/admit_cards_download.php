<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
        table {
            font-family: "Segoe UI",Arial,sans-serif;
            font-size: 17px;
        }

        p {
            font-weight: bold;
        }

        .title {
            font-weight: normal;
        }

        td { border-collapse: 0; }
        
        @media print {
         /*table tr:nth-child(2n + 0) {  page-break-before: always; }*/
         .page-break {  page-break-after: always; display: block; }
         tr    { page-break-inside:avoid; page-break-after:auto }
      }
    </style>
</head>
<body>
    <?php $admitCardsRows = array_chunk($students, 4); ?>
    <table cellspacing="0" cellpadding="0" style="width: 100%;">
        <?php $i = 1;  foreach ($admitCardsRows as $admitCardsRow): ?>
            <tr >
                <?php foreach ($admitCardsRow as $admitCardDetail): ?>
                    <td style="width: 200px; padding: 15px 30px; height: 300px; ">
                        <table>
                            <tr>
                                <td style="height: 162px; "> &nbsp;</td>
                            </tr>
                            <tr>
                                <td style="height: 132px; vertical-align: bottom;">
                                    <?php
                                        $student_name = ucwords(strtolower($admitCardDetail['student_name']));
                                        $roll_number = $admitCardDetail['roll_number'];
                                        $studentSubjects = array();
                                        foreach ($subjects as $subject => $subjectCode) {
                                            if (isset($admitCardDetail[$subject]) && $admitCardDetail[$subject] == 1) {
                                                $studentSubjects[] = $subjectCode;
                                            }
                                        }
                                        //$studentSubjects = array('IMQ', 'ISQ', 'IEQ', 'IGQ', 'ICOMQ', 'IBQ');
                                        $exam_subjects = implode(' , ', $studentSubjects);
                                        $studentClass = $admitCardDetail['class'];
                                        $class = ($studentClass == 1) ? $studentClass."st" : (($studentClass == 2) ? $studentClass."nd" : (($studentClass == 3) ? $studentClass."rd" : (($studentClass >= 4 && $studentClass <= 12) ? $studentClass."th" : '') ) ) ;
                                        $school_name = ucwords(strtolower($admitCardDetail['school_name'])).",";
                                        //$school_name = "Shree Cloth Market Vaishnav Bal Mandir Girls Higher Secondary School, ";
                                        $school_address = $admitCardDetail['city_name'];
                                    ?>
                                    <p style="margin: 3px 0;"><?php echo $student_name; ?></p>
                                    <p style="margin: 3px 0;"><?php echo $roll_number; ?></p>
                                    <p style="margin: 3px 0;"><?php echo $class; ?></p>
                                    <p style="margin: 3px 0;" class="title"><?php echo $school_name." ".$school_address; ?></p>
                                    <p style="margin: 3px 0;"><?php echo $exam_subjects; ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                <?php endforeach; ?>
                <?php if($i == 2): ?>
                    <tr  class="page-break">
                        <td></td>
                    </tr>
                <?php $i = 0; endif; ?>
            </tr>
        <?php $i++; endforeach; ?>
    </table>

    <script type="text/javascript">
        //window.print();
    </script>
</body>
</html>