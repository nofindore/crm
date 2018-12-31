<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : School (SchoolController)
 * School Class to control all school related operations for nof.
 * @author : PK
 * @version : 1.1
 * @since : 01 Septemeber 2018
 */
class OlympiadSchool extends BaseController
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
        $this->load->model('country_model');
        $this->load->model('user_model');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->load->library('email');

        $this->email->initialize($config);
        //$this->load->library('excel');
        $this->isLoggedIn();   
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
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $data['schools'] = $this->olympiad_school_model->getList($searchText);

            $this->global['pageTitle'] = 'NOF : Olympiad Schools';

            $this->loadViews("olympiad/schools/index", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to add/edit school
     */
    function edit()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Add New School';

            $data['countries'] = $this->country_model->getCountryList();

            $this->loadViews("olympiad/schools/add", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to save school
     */
    function save()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $postData = $this->input->post();
            $schoolData = $postData['school'];
            $schoolData['created_date'] = date('Y-m-d');
            $school_id = $this->olympiad_school_model->save($schoolData);
            if ($school_id) {
                try{
                    /* save school principal details */
                    $principal = $postData['principal'];
                    $principal['olympiad_school'] = $school_id;
                    $this->olympiad_school_model->savePrincipal($principal);

                    /* save school co1 details */
                    $co1 = $postData['co1'];
                    $co1['olympiad_school'] = $school_id;
                    $this->olympiad_school_model->saveRepresentative($co1);


                    /* save school co2 details */
                    $co2 = $postData['co2'];
                    $payment = $postData['payment'];
                    if (count(array_filter($payment))) {
                        $co2['olympiad_school'] = $school_id;
                        $this->olympiad_school_model->saveRepresentative($co2);
                    }

                    /* save school payment details */
                    $payment = $postData['payment'];
                    if (count(array_filter($payment))) {
                        $payment['olympiad_school'] = $school_id;
                        $this->olympiad_school_model->savePaymentDetails($payment);
                    }

                    /* save olympiad student details */
                    $postFile = $_FILES['students_details'];
                    // Get File extension eg. 'xlsx' to check file is excel sheet
                    $pathinfo = pathinfo($postFile["name"]);

                    $student_data = array();
                    $key_array = array('srno', 'roll_number', 'student_name', 'class', 'science_paper', 'science_book', 'math_paper', 'math_book', 'english_paper', 'english_book', 'gk_paper', 'gk_book', 'commerce_paper', 'commerce_book', 'bio_paper', 'bio_book',  'aptitude_paper', 'aptitude_book');
                    if (($pathinfo['extension'] == 'csv') && $postFile['size'] > 0 ) {

                        $filename = $postFile['tmp_name'];
 
                        if (($handle = fopen($filename, "r")) !== FALSE) {
                            $row = 1;
                            while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                                if ($row > 1) {
                                    $temp = array();
                                    $temp = array_combine($key_array, $data);
                                    unset($temp['srno']);
                                    $temp['school'] = $school_id;
                                    $student_data[] = $temp;
                                }
                                $row++;
                            }
                        }
                        fclose($handle);
                    }

                    $this->olympiad_school_model->saveStudentCsvDetails($student_data);

                    $to = $principal['email_id'];
                    $cc1 = $co1['email_id'];
                    $cc2 = $co2['email_id'];
                    $cc3 = $schoolData['email_id'];
                    // paramas - $to, $cc1, $cc2, $cc3, template_id
                    $template = $this->getEmailTemplates('school_registration');
                    $this->nofSendmail($to, $cc1, $cc2, $cc3, $template);

                    $this->session->set_flashdata('success', 'School successfully registered.');
                    redirect('olympiad_school');
                }
                catch(Exeption $e){
                    echo $e->getMessage();
                    die;
                }
            }
        }
    }

    /**
     * This function is used to delete the school using schoolId
     * @return boolean $result : TRUE / FALSE
     */
    function delete()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            echo "<pre>";
            print_r($this->input->post());
            die;
            $schooId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

            die('3764387648736');
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    /**
     * This function is used to send login to the school using schoolId
     * @return boolean $result : TRUE / FALSE
     */
    function sendLogin($school_id){
        $schoolData = $this->olympiad_school_model->getSchool($school_id);
        if (!empty($schoolData)) {
            $school = $schoolData[0];
            $school_email = $school['email_id'];
            $school_email = "pritesh.pk1@gmail.com";

            $username = $school['state_code'].$school['school_code'];

            $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $password = '';
            foreach (array_rand($seed, 8) as $k) $password .= $seed[$k];

            $additional_param['username'] = $username;
            $additional_param['password'] = $password;

            $template = $this->getEmailTemplates('send_school_login', $additional_param);
            $result = $this->nofSendmail($school_email, '', '', '', $template);
            if ($result) {
                $school_name = ucwords(strtolower($school['name']));
                $roleId = 3;
                $mobile = $school['phone_number'];
                
                $userInfo = array('email'=> $username, 'school' => $school_id, 'password' => getHashedPassword($password), 'roleId' => $roleId, 'name' => $school_name, 'mobile' => $mobile, 'createdBy'=> 1, 'createdDtm' => date('Y-m-d H:i:s'));

                $result = $this->user_model->addNewUser($userInfo);

                $this->session->set_flashdata('success', 'School login sent successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to send login to school. Please try again');
            }
        } else {
            $this->session->set_flashdata('error', 'School not found.');
        }
        redirect('olympiad_school');
    }

    function nofSendmail($to, $cc1, $cc2, $cc3, $template){
        $this->email->from('support@nof.org.in', 'Team NOF');
        $this->email->to($to);
        if (!empty($cc1)) {
            $this->email->cc($cc1);
        }
        if (!empty($cc2)) {
            $this->email->cc($cc2);
        }
        if (!empty($cc3)) {
            $this->email->cc($cc3);
        }
        
        //default to admin
        $admin_email = "ashish@nof.org.in";
        $this->email->cc($admin_email);

        $this->email->subject('National Olympiad Foundation- 2018');

        $message = $template;
        
        $this->email->message($message);

        $result = $this->email->send();
        return $result;
    }

    function getEmailTemplates($templateId, $additional_param = array()) {
        if ($templateId == 'school_registration') {
            $message = "<p>Respected Sir/Madam,</p></br>
                <p>Greetings of the day!</p></br>
                <p>We are pleased to inform you that we have received the details of the participating students from your school for the <b>NATIONAL OLYMPIAD FOUNDATION-2018 exams.</b> </p>
                <p>We request you to reply this mail with the dates of the examination you have chosen for the following NOF - Olympiads. </p>
                <p><b>(Note: Examination dates should be selected from the Month of October to December. Ignore if already shared)</b></p>
                <ul>
                    <li>International <b>Math</b> Qualifier</li>
                    <li>International <b>Science</b> Qualifier</li>
                    <li>International <b>English</b> Qualifier</li>
                    <li>International <b>GK</b> Qualifier</li>
                    <li>International <b>Commerce</b> Qualifier</li>
                    <li>International <b>BIO</b> Qualifier</li>
                    <li>International <b>APTITUDE</b> Qualifier</li>
                </ul>
                <p>Happy to help,</p>
                <p>Team NOF</p>";
        } else if ($templateId == 'send_school_login') {
            $message = "<p>Trust you are doing good!</p>
                <p>We are glad to share with you the new NOF DashBoard (<a href='http://nofbackoffice.com/schooladmin'>URL CLICK HERE</a>).</p>

                <p>Once when you will click this link you will find the complete details of the number of students who have participated with us, their roll numbers, their admit cards, the number of papers they have opted for and the books they have requested.</p>

                <p>We understand that managing this data on papers round the year is quite a hectic task and is also very time-consuming, therefore we have digitized the complete procedure.</p>

                <p>Features of the NOF DashBoard:</p>

                <ol>
                    <li>Edit names of the students, In case of any mistake in spelling.</li>
                    <li>Check and Print attendance sheets,</li>
                    <li>Check and Print roll number sheets,</li>
                    <li>Search students with roll no/class/name/subject.</li>
                    <li>Print admit cards.</li>
                    <li>Print certificates.</li>
                    <li>Search/Print results.</li>
                    <li>List of the students in Phase2.</li>
                    <li>Complied copy of all the certificates.</li>
                    <li>List of the students eligible for bags.(Students with 4 subjects).</li>
                    <li>List of participating students with all the details.</li>
                </ol>

                <p>Feel free to call our helpline in case of any doubt.</p>

                <div>Username : ".$additional_param['username']."</div>
                <div>Password : ".$additional_param['password']."</div>

                <p>Happy to help,</p>
                <p>Team NOF</p>";
        }
        return $message;
    }

    function admitCard(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = '';

            $data['schools'] = $this->olympiad_school_model->getList($searchText);

            $this->global['pageTitle'] = 'NOF Olympiad : School Admit Cards';

            $this->loadViews("olympiad/schools/admit_card_index", $this->global, $data, NULL);
        }
    }

    function admitCardDownload(){
        ini_set('memory_limit', '256M');
        $school_id =  $this->uri->segment(2);

        $subjects = $this->olympiad_subjects_model->getList();
        $subjectList = array();
        foreach ($subjects as $subject) {
            $subjectList[$subject['short_code']."_paper"] = $subject['subject_code'];
        }
        $data['subjects'] = $subjectList;
        $data['students'] = $this->olympiad_students_model->getListBySchool($school_id);

        //load the view and saved it into $html variable
        echo $html = $this->load->view("olympiad/schools/admit_cards_download", $data, true);
        exit;
    }
}
?>
