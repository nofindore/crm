<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : (OlympiadReports)
 * OlympiadReports Class to control all olympiad reports related operations for nof.
 * @author : PK
 * @version : 1.1
 * @since : 23 Septemeber 2018
 */
class OlympiadStudents extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('olympiad_school_model');
        $this->load->model('olympiad_students_model');
        $this->load->model('olympiad_subjects_model');
        //load mPDF library
        $this->load->library('m_pdf');
        $this->isLoggedIn();
        ob_start();
        ini_set('memory_limit', '512M');
    }
    
    /**
     * This function is used to load the school list
     */
    function index()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Olympiad Students List';

            $searchText = '';
            $data['schools'] = $this->olympiad_school_model->getList($searchText);
            $this->loadViews("olympiad/students/index", $this->global, $data , NULL);
        }
    }

    /**
     * This function is used to list the students of selected schools
     */
    function studentsList($id)
    {
        $data['students'] = $this->olympiad_students_model->getListBySchool($id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();
        $this->load->view("olympiad/students/list", $data);
    }

    /**
     * This function is used to print the list of students
     */
    function studentsListPrint($id)
    {
        $data['school'] = $this->olympiad_school_model->getSchool($id);
        $data['students'] = $this->olympiad_students_model->getListBySchool($id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();

        //load the view and saved it into $html variable
        $html = $this->load->view("olympiad/students/list_print", $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = $data['school'][0]['name']." - ROLL NUMBER SHEET.pdf";

        $logoImage = base_url()."assets/images/nof-pdf-logo.png";
        $school_name = ucwords(strtolower($data['school'][0]['name'])).', '.ucwords(strtolower($data['school'][0]['city_name']));

        $this->m_pdf->pdf->simpleTables = true;
        $this->m_pdf->pdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="49%">{DATE j-m-Y}</td>
                    <td width="50%" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>');

        $htmlHeader = '
        <table width="100%" class="head_table">
            <tbody>
                <tr>
                    <td style="text-align: center;">National Olympiad Foundation 2018</td>
                    <td rowspan="2" style="padding: 0px 0px 10px 0px;">
                        <img width="120px" src="'.$logoImage.'" class="user-image" alt="Nof Logo"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 0px 10px 0px; text-align: center;">Roll Number Sheet - '.$school_name.'</td>
                </tr>
            </tbody>
        </table>';

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';

        $this->m_pdf->pdf->SetHTMLHeader($htmlHeader);
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }

    
    /**
     * This function is used to load the school list
     */
    function attendance()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Olympiad Students Attendance List';

            $searchText = '';
            $data['schools'] = $this->olympiad_school_model->getList($searchText);
            $data['subjects'] = $this->olympiad_subjects_model->getList();

            $this->loadViews("olympiad/students/attendance", $this->global, $data , NULL);
        }
    }
    
    /**
     * This function is used to load the school list
     */
    function attendanceList()
    {
        $school_id =  $this->uri->segment(2);
        $subject_id =  $this->uri->segment(3);
        $data['students'] = $this->olympiad_students_model->getListBySchool($school_id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();
        $data['subject_id'] = $subject_id;
        $this->load->view("olympiad/students/attendance_list", $data);
    }
    /**
     * This function is used to print the list of students
     */
    function studentsAttendanceListPrint()
    {
        ini_set('memory_limit', '256M');
        $school_id =  $this->uri->segment(2);
        $subject_id =  $this->uri->segment(3);
        $school = $this->olympiad_school_model->getSchool($school_id);
        $students = $this->olympiad_students_model->getListBySchool($school_id);
        $subject = $this->olympiad_subjects_model->getSubject($subject_id);
        $subject_id = $subject_id;
        //load the view and saved it into $html variable
        $html = $this->load->view("olympiad/students/attendance_list_header", array(), true);
        if (!empty($subject)) {
            $subject = $subject[0];
            if (count($students) > 0) {
                $i = 0; 
                foreach ($students as $student) {
                    if($student[$subject['short_code'].'_paper'] == 1) {
                        $i++;
                        $data = array();
                        $data['i'] = $i;
                        $data['student'] = $student;
                        $data['subjectValue'] = $subject['subject_code'];
                        $html .= $this->load->view("olympiad/students/attendance_list_print", $data, true);
                    }
                }
            }
        }
        $html .= $this->load->view("olympiad/students/attendance_list_footer", array(), true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = $school[0]['name']." - STUDENTS ATTENDANCE LIST.pdf";

        $logoImage = base_url()."assets/images/nof-pdf-logo.png";
        $school_name = ucwords(strtolower($school[0]['name'])).', '.ucwords(strtolower($school[0]['city_name']));
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->simpleTables = true;
        $this->m_pdf->pdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="49%">{DATE j-m-Y}</td>
                    <td width="50%" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>');

        $htmlHeader = '
        <table width="100%" class="head_table">
            <tbody>
                <tr>
                    <td style="text-align: center;">National Olympiad Foundation 2018</td>
                    <td rowspan="2" style="padding: 0px 0px 10px 0px;">
                        <img width="120px" src="'.$logoImage.'" class="user-image" alt="Nof Logo"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 0px 10px 0px; text-align: center;">Attendance Sheet - '.$school_name.'</td>
                </tr>
            </tbody>
        </table>';

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';

        $this->m_pdf->pdf->SetHTMLHeader($htmlHeader);

        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
}
?>
