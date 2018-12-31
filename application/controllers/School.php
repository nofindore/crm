<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class School extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('school_model');
        $this->load->model('student_model');
        $this->load->model('school_deleted_model');
        $this->load->model('user_deleted_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function is used to load the user list
     */
    function index()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            //$this->school_model->studentListingCountNew();
            $this->global['pageTitle'] = 'Schools';

            $data['schools'] = $this->school_model->schoolsListing();

            $this->loadViews("schools/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the user list
     */
    function edit($schoolId = NULL)
    {
        if($this->isAdmin() == TRUE || $schoolId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($schoolId == null)
            {
                redirect('schools/index');
            }

            $data['schoolInfo'] = $this->school_model->getSchoolInfo($schoolId);
            
            $this->global['pageTitle'] = 'NOF : Edit School';
            
            $this->loadViews("schools/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editSchool()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $schoolId = $this->input->post('schoolId');

            $this->form_validation->set_rules('school_code','School Code','trim|required|xss_clean|max_length[5]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($schoolId);
            }
            else
            {
                $orig_school_code = $this->input->post('orig_school_code');
                $new_school_code = $this->input->post('school_code');
                $delete_school = $this->input->post('delete_school');

                if ($orig_school_code == $new_school_code) {
                    $this->session->set_flashdata('error', 'Unable to update school code.');
                    redirect('schools');
                }

                if (strlen($new_school_code) != 5) {
                    $this->session->set_flashdata('error', 'School code provided is wrong.');
                    redirect('schools');
                }

                $schoolCode = substr($new_school_code, 2);
                $newSchool = $this->school_model->getSchoolInfoBySchoolCode($schoolCode);

                if (empty($newSchool)) {
                    $this->session->set_flashdata('error', 'School code not found.');
                    redirect('schools');
                    exit;
                }

                $new_school = false;
                foreach ($newSchool as $school) {
                    if ($school->school_code == $new_school_code) {
                        $new_school = $school;
                        break;
                    }
                }

                if (!$new_school) {
                    $this->session->set_flashdata('error', 'School code not found.');
                    redirect('schools');
                    exit;
                }

                $old_school_students = $this->student_model->getStudentsBySchoolId($schoolId);
                $result = false;

                if (!empty($old_school_students)) {
                    $new_school_id = $new_school->school_id;
                    $student_number = $new_school->latest_student_code;
                    $city_id = $new_school->city_id;
                    $state_id = $new_school->state_id;
                    
                    $initialSchoolNumber = $student_number;
                    $newSchoolNumber = $student_number + count($old_school_students);
                    $newSchoolNumber = str_pad($newSchoolNumber, 4, '0', STR_PAD_LEFT);

                    $schoolUpdateStatus = $this->school_model->updateNewSchool(array('latest_student_code' => $newSchoolNumber), $new_school_id);

                    foreach ($old_school_students as $student) {
                        $student_number = str_pad($student_number, 4, '0', STR_PAD_LEFT);
                        $student_id = $student->student_id;
                        $student_class = $student->user_class;
                        $old_roll_number = $student->roll_number;

                        $roll_number = $new_school_code.$student_class.$student_number;

                        $studentInfo = array('city' => $city_id, 'state' => $state_id, 'roll_number' => $roll_number, 'School' => $new_school_id);
                        //$studentOldInfo[] = array('city' => $city_id, 'state' => $state_id, 'roll_number' => $roll_number, 'School' => $new_school_id);
                        $studentOldInfo = array();
                        $studentOldInfo['old_id'] = $student->student_id;
                        $studentOldInfo['first_name'] = $student->first_name;
                        $studentOldInfo['last_name'] = $student->last_name;
                        $studentOldInfo['image'] = $student->image;
                        $studentOldInfo['email_id'] = $student->email_id;
                        $studentOldInfo['mobile_number'] = $student->mobile_number;
                        $studentOldInfo['date_of_birth'] = $student->date_of_birth;
                        $studentOldInfo['father_first_name'] = $student->father_first_name;
                        $studentOldInfo['father_last_name'] = $student->father_last_name;
                        $studentOldInfo['city'] = $student->city;
                        $studentOldInfo['pinCode'] = $student->pinCode;
                        $studentOldInfo['state'] = $student->state;
                        $studentOldInfo['country'] = $student->country;
                        $studentOldInfo['School'] = $student->School;
                        $studentOldInfo['user_class'] = $student->user_class;
                        $studentOldInfo['roll_number'] = $student->roll_number;
                        $studentOldInfo['user_name'] = $student->user_name;
                        $studentOldInfo['password'] = $student->password;
                        $studentOldInfo['device_id'] = $student->device_id;
                        $studentOldInfo['device_token'] = $student->device_token;

                        $result = $this->user_deleted_model->addNewEntry($studentOldInfo);
                        $result = $this->student_model->updateStudent($studentInfo, $student_id);

                        if($result == true)
                        {
                            $student_number++;
                        }
                        else
                        {
                            break;
                        }
                    }
                    
                    $newSchoolAgain = $this->school_model->getSchoolInfo($new_school_id);
                    $newSchoolStudentNumber = $newSchoolAgain[0]->latest_student_code;
                    $maxNewSchoolNumber = max($initialSchoolNumber, $student_number, $newSchoolNumber, $newSchoolStudentNumber);
                    $maxNewSchoolNumber = str_pad($maxNewSchoolNumber, 4, '0', STR_PAD_LEFT);
                    $schoolUpdateStatus = $this->school_model->updateNewSchool(array('latest_student_code' => $maxNewSchoolNumber), $new_school_id);
                }

                if (!$result) {
                    $this->session->set_flashdata('error', 'Can\'t update school codes. Some error occured !' );
                    redirect('schools');
                }

                $oldSchool = $this->school_model->getSchoolInfo($schoolId);
                $oldSchoolInfo = array();
                $oldSchoolInfo['school_code'] = $orig_school_code;
                $oldSchoolInfo['school_name'] = $oldSchool[0]->school_name;
                $oldSchoolInfo['school_address'] = $oldSchool[0]->school_address;
                $oldSchoolInfo['state_id'] = $oldSchool[0]->state_id;
                $oldSchoolInfo['city_id'] = $oldSchool[0]->city_id;
                $oldSchoolInfo['school_id'] = $schoolId;

                $result = $this->school_deleted_model->addNewEntry($oldSchoolInfo);
                $result = $this->school_model->deleteSchool($schoolId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'School code updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'School code update failed');
                }
                
                redirect('schools');
            }
        }
    }

    function loadByCity(){
        $city_id = $this->input->post('city_id');
        $schools = $this->school_model->getSchoolsListByCity($city_id);
        
        $data = '';
        if(!empty($schools)){
            $data = $data."<option value=''>SELECT SCHOOL</option>";
            foreach($schools as $school){
                $school_name = trim(strtoupper($school->school_name));
                $city_name = trim(strtoupper($school->city_name));
                $schoolcode = $school->schoolcode;
                $school_code = (!empty($schoolcode)) ? ' - '.$school->school_code : '';
                $schoolName = $school_name.', '.$city_name.$school_code;
                $data = $data."<option data-attr='".$school_name."' value=".$school->school_id.">".$schoolName."</option>";
            }
        } else {
            $data = $data."<option value=''>NO RECORD FOUND</option>";
        }
        echo $data;
    }
}

?>