<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : (OlympiadReports)
 * OlympiadReports Class to control all olympiad reports related operations for nof.
 * @author : PK
 * @version : 1.1
 * @since : 23 Septemeber 2018
 */
class OlympiadSubjects extends BaseController
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
        ini_set('memory_limit', '512M');
    }
    
    /**
     * This function is used to load report for papers and books
     */
    function reportPapersAndBooks() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Report - Olympiad Papers & Books';

            $searchText = '';
            $classess = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
            $data['schools'] = $this->olympiad_school_model->getList($searchText);
            $data['allSchoolsSubjects'] = $this->getAllSchoolsSubjectsDetails(0);
            $data['schoolsSubjects'] = $this->getSchoolsSubjectsDetails(0);
            $data['subjects'] = $this->olympiad_subjects_model->getList();
            $data['classess'] = $classess;

            $this->loadViews("olympiad/reports/papers_books", $this->global, $data , NULL);
        }
    }

    function reportPrintPapersAndBooks(){
        ini_set('memory_limit', '256M');
        $school_id =  $this->uri->segment(2);
        $classess = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $school_name = '';
        if ($school_id) {
            $school = $this->olympiad_school_model->getSchool($school_id);
            $school_name = $school[0]['name'];
        }
        $data['school_name'] = $school_name;
        $data['allSchoolsSubjects'] = $this->getAllSchoolsSubjectsDetails($school_id);
        $data['schoolsSubjects'] = $this->getSchoolsSubjectsDetails($school_id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();
        $data['classess'] = $classess;
        //load the view and saved it into $html variable
        $html = $this->load->view("olympiad/reports/print_papers_books", $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "Papers & Books";
        if (!empty($school_name)) {
            $school_name = ucwords(strtolower($school[0]['name'])).', '.ucwords(strtolower($school[0]['city_name']));
            $pdfFilePath = $school_name." - ".$pdfFilePath;
        }

        $logoImage = base_url()."assets/images/nof-pdf-logo.png";

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
                    <td style="padding: 5px 0px 10px 0px; text-align: center;">'.$pdfFilePath.'</td>
                </tr>
            </tbody>
        </table>';

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';

        $this->m_pdf->pdf->SetHTMLHeader($htmlHeader);
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath."pdf", "I");
    }

    function reportPrintPapers(){
        $school_id =  $this->uri->segment(2);
        ini_set('memory_limit', '256M');
        $school_id =  $this->uri->segment(2);
        $classess = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $school_name = '';
        if ($school_id) {
            $school = $this->olympiad_school_model->getSchool($school_id);
            $school_name = $school[0]['name'];
        }
        $data['school_name'] = $school_name;
        $data['allSchoolsSubjects'] = $this->getAllSchoolsSubjectsDetails($school_id);
        $data['schoolsSubjects'] = $this->getSchoolsSubjectsDetails($school_id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();
        $data['classess'] = $classess;
        //load the view and saved it into $html variable
        $html = $this->load->view("olympiad/reports/print_papers_details", $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "Papers";
        if (!empty($school_name)) {
            $school_name = ucwords(strtolower($school[0]['name'])).', '.ucwords(strtolower($school[0]['city_name']));
            $pdfFilePath = $school_name." - ".$pdfFilePath;
        }

        $logoImage = base_url()."assets/images/nof-pdf-logo.png";

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
                    <td style="padding: 5px 0px 10px 0px; text-align: center;">'.$pdfFilePath.'</td>
                </tr>
            </tbody>
        </table>';

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';

        $this->m_pdf->pdf->SetHTMLHeader($htmlHeader);
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath."pdf", "I");
    }

    function reportPrintBooks(){
        ini_set('memory_limit', '256M');
        $school_id =  $this->uri->segment(2);
        $classess = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $school_name = '';
        if ($school_id) {
            $school = $this->olympiad_school_model->getSchool($school_id);
            $school_name = $school[0]['name'];
        }
        $data['school_name'] = $school_name;
        $data['allSchoolsSubjects'] = $this->getAllSchoolsSubjectsDetails($school_id);
        $data['schoolsSubjects'] = $this->getSchoolsSubjectsDetails($school_id);
        $data['subjects'] = $this->olympiad_subjects_model->getList();
        $data['classess'] = $classess;
        //load the view and saved it into $html variable
        $html = $this->load->view("olympiad/reports/print_books_details", $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "Books";
        if (!empty($school_name)) {
            $school_name = ucwords(strtolower($school[0]['name'])).', '.ucwords(strtolower($school[0]['city_name']));
            $pdfFilePath = $school_name." - ".$pdfFilePath;
        }

        $logoImage = base_url()."assets/images/nof-pdf-logo.png";

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
                    <td style="padding: 5px 0px 10px 0px; text-align: center;">'.$pdfFilePath.'</td>
                </tr>
            </tbody>
        </table>';

        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';

        $this->m_pdf->pdf->SetHTMLHeader($htmlHeader);
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath."pdf", "I");
    }

    function getSchoolsSubjectsDetails($school_id = 0){
        if ($school_id) {
            $students = $this->olympiad_students_model->getListBySchool($school_id);
        } else {
            $students = $this->olympiad_students_model->getList();
        }
        $subjectsList = $this->olympiad_subjects_model->getList();

        $subjects = array();

        foreach ($subjectsList as $subject) {
            $subjects[$subject['short_code']] = $subject['short_code'];
        }

        $data = array();
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                if(isset($student[$subject.'_paper'])){
                    if (empty($data)) {
                        $data[$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                        $data[$student['class']][$subject]['book'] = $student[$subject.'_book'];
                    } else {
                        if (isset($data[$student['class']])) {
                            if (isset($data[$student['class']][$subject])) {
                                $data[$student['class']][$subject]['paper'] += $student[$subject.'_paper'];
                                $data[$student['class']][$subject]['book'] += $student[$subject.'_book'];
                            } else {
                                $data[$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                                $data[$student['class']][$subject]['book'] = $student[$subject.'_book'];
                            }
                        } else {
                            $data[$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                            $data[$student['class']][$subject]['book'] = $student[$subject.'_book'];
                        }
                    }
                }
            }
        }

        return $data;
    }

    function getAllSchoolsSubjectsDetails($school_id = 0){
        if ($school_id) {
            $students = $this->olympiad_students_model->getListBySchool($school_id);
        } else {
            $students = $this->olympiad_students_model->getList();
        }
        $subjectsList = $this->olympiad_subjects_model->getList();

        $subjects = array();

        foreach ($subjectsList as $subject) {
            $subjects[$subject['short_code']] = $subject['short_code'];
        }

        $data = array();
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                if(isset($student[$subject.'_paper'])){
                    if (empty($data)) {
                        $data[$student['school']][$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                        $data[$student['school']][$student['class']][$subject]['book'] = $student[$subject.'_book'];
                    } else {
                        if (isset($data[$student['school']])) {
                            if (isset($data[$student['school']][$student['class']])) {
                                if (isset($data[$student['school']][$student['class']][$subject])) {
                                    $data[$student['school']][$student['class']][$subject]['paper'] += $student[$subject.'_paper'];
                                    $data[$student['school']][$student['class']][$subject]['book'] += $student[$subject.'_book'];
                                } else {
                                    $data[$student['school']][$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                                    $data[$student['school']][$student['class']][$subject]['book'] = $student[$subject.'_book'];
                                }
                            } else {
                                $data[$student['school']][$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                                $data[$student['school']][$student['class']][$subject]['book'] = $student[$subject.'_book'];
                            }
                        } else {
                            $data[$student['school']][$student['class']][$subject]['paper'] = $student[$subject.'_paper'];
                            $data[$student['school']][$student['class']][$subject]['book'] = $student[$subject.'_book'];
                        }
                    }
                }
            }
        }

        return $data;
    }
}
