<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Students extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_model');
        $this->load->model('state_model');
        $this->load->model('city_model');
        $this->load->model('school_model');
        $this->load->model('student_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $this->global['total_registrations'] = $this->student_model->studentListingCount();
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function studentsListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->student_model->studentListingCount($searchText);

            $perPage = 50;

            $returns = $this->paginationCompress ( "students_list/", $count, $perPage );
            
            $data['studentsRecords'] = $this->student_model->studentListing($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'Students List';
            $this->global['totalCount'] = $count;
            $this->global['perPage'] = $perPage;
            
            $this->loadViews("students/index", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load the user list
     */
    function booksDetails()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Students Detail';

            $data['schools'] = $this->school_model->schoolsListing();

            $this->loadViews("students/book_details", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load the user list
     */
    function booksDetailsCsv()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $school_id = $this->input->post('school_id');

            $students = $this->student_model->studentsListingByAttribute('School', $school_id);

            if ($students & !empty($students)) {
                $file = fopen("assets/students/students_data_sheet.csv", "w");

                if ($file) {
                    $header = array('SR. No.', 'Roll Number', 'NAME OF STUDENT', 'CLASS', 'SCI.', 'SB', 'MATH', 'MB', 'ENG', 'EB', 'GK', 'GB', 'COM.','CB', 'BIO.', 'BB');
                    
                    fputcsv($file, $header);

                    $i = 1;
                    foreach ($students as $student) {
                        $line = array($i, $student->roll_number, $student->name, $student->class, 1, '', '', '', '', '', '', '', '','', '', '');
                        fputcsv($file, $line);
                        $i++;
                    }
                    echo '200';
                    exit;
                } else {
                    echo '400';
                    exit;
                }
            }
            echo '400';
            exit;
        }
    }
    
    /**
     * This function is used to load the user list
     */
    function bulkUploadIndex()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Students Bulk Upload';

            $data['countries'] = $this->country_model->getCountryList();
            //$data['schools'] = $this->school_model->schoolsListing('all');

            $this->loadViews("students/bulk_uploads", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load the user list
     */
    function file_check()
    {
        $extensions = array('xlsx','xls','csv');
        $pathinfo = pathinfo($_FILES["students"]["name"]);
        $extension = $pathinfo['extension'];

        if ($_FILES['students']['size'] > 0) {
            if (in_array($extension, $extensions)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Please select only csv/xls/xlsx file.');
                return false;
            }
        }
        $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
        return false;
    }

    function readFile(){
        //$header = array('SR. No.','First Name','Last Name','Email','Mobile Number','DOB','Father First Name','Father Last Name','Class');
        $header = array('SR. No.','Student First Name','Class','Mobile Number','Student Last Name','DOB','Father First Name','Father Last Name','Email');
        $pathinfo = pathinfo($_FILES["students"]["name"]);
        $extension = $pathinfo['extension'];
        $student_data = array();
        if ($_FILES['students']['size'] > 0) {
            if ($extension == 'csv') {
                $filename = $_FILES['students']['tmp_name'];
                if (($handle = fopen($filename, "r")) !== FALSE) {
                    $row = 1;
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        if ($row == 1) {
                            $fileHeader = array_map('trim', $data);
                            $result = array_diff($header, $fileHeader);
                            if(count($result) > 0){
                                $wrong_format = true;
                                break;
                            } else {
                                if ($fileHeader !== $header) {
                                    $wrong_format = true;
                                    break;
                                }
                            }
                        }
                        if ($row > 1) {
                            $student_data[] = $data;
                        }
                        $row++;
                    }
                }
                fclose($handle);
            } else {
                //die('readfile die');
            }
        }
        return $student_data;
    }

    function bulkUpload()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('students', '', 'callback_file_check');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->bulkUploadIndex();
            }
            else
            {
                $data = $this->input->post();

                $country_id = $this->input->post('country'); 

                $city_id = $this->input->post('city'); 

                $state_id = $this->input->post('state');
                $state = $this->state_model->getState($state_id);
                $state_code = $state[0]->state_code;

                $school_id = $this->input->post('school');
                $school = $this->school_model->getSchoolInfo($school_id);
                $latest_student_code = $school[0]->latest_student_code;
                $school_code = $state_code.$school[0]->schoolcode;

                $fileData = $this->readFile();
                $updateStatus = false;
                $count = 0;
                if (!empty($fileData)) {
                    if (empty($school[0]->schoolcode)) {
                        $latest_school_code = $state[0]->latest_school_code;
                        if ($latest_school_code >= '001' && $latest_school_code <= '999')
                        {
                            $school_code = $latest_school_code;
                            $latest_school_code = $latest_school_code + 1;
                            $latest_school_code = str_pad($latest_school_code, 3, '0', STR_PAD_LEFT);
                        }
                        else if ($latest_school_code >= '1000')
                        {
                            if ($latest_school_code == 1399) {
                                $latest_school_code = $latest_school_code + 101;
                            } else {
                                $latest_school_code = $latest_school_code + 1;
                            }
                            $part = str_split($latest_school_code, 2);
                            $alphabets = range('A', 'Z');
                            $numCode = $alphabets[$part[0]-1];
                            $school_code = $numCode.$part[1];
                        }

                        $latest_school_code = str_pad($latest_school_code, 3, '0', STR_PAD_LEFT);

                        $stateData = array('latest_school_code' => $latest_school_code);
                        $this->state_model->update($stateData, $state_id);

                        $schoolData = array('school_code' => $school_code);
                        $this->school_model->update($schoolData, $school_id);

                        $school_code = $state_code.$school_code;
                    }

                    foreach ($fileData as $student_data) {
                        $student = array();

                        $class = $student_data[2];
                        if ($class >= 1 && $class <= 9) {
                            $class = str_pad($class, 2, '0', STR_PAD_LEFT);
                        }

                        $student_code = str_pad($latest_student_code, 4, '0', STR_PAD_LEFT);

                        $roll_number = $school_code.$class.$student_code;
                        $student['first_name'] = $student_data[1];
                        $student['last_name'] = $student_data[4];
                        $student['image'] = '';
                        $student['email_id'] = $student_data[8];
                        $student['mobile_number'] = $student_data[3];
                        $student['date_of_birth'] = $student_data[5];
                        $student['father_first_name'] = $student_data[6];
                        $student['father_last_name'] = $student_data[7];
                        $student['city'] = $city_id;
                        $student['pinCode'] = '';
                        $student['state'] = $state_id;
                        $student['country'] = $country_id;
                        $student['School'] = $school_id;
                        $student['user_class'] = $class;
                        $student['roll_number'] = $roll_number;
                        $student['user_name'] = '';
                        $student['password'] = '';
                        $student['device_id'] = '';
                        $student['device_token'] = '';

                        $studentId = $this->student_model->add($student);
                        if ($studentId) {
                            $latest_student_code = $latest_student_code + 1;
                            $count++;
                        }
                    }

                    $schoolData = array('latest_student_code' => $latest_student_code);
                    $updateStatus = $this->school_model->update($schoolData, $school_id);
                }
                if ($updateStatus) {
                    $this->session->set_flashdata('success', "Total $count student(s) registered successfully." );
                    redirect('students_bulk_upload_index');
                } else {
                    $message = "Some error occured while registering students.";
                    if ($count) {
                        $message = $message." Only $count students registered.";
                    } else {
                        $message = $message." Either file format is not accepted or file is empty. Only CSV file format is accepted. Please check and try again.";
                    }
                    $this->session->set_flashdata('error', $message );
                    redirect('students_bulk_upload_index');
                }
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'NOF : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>