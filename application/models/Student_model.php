<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function studentListingCount($searchText = '')
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $query = $nof->select('count(id) AS count')->get('user_registration');

        $nof->where('is_bulk_uploaded', 0);

        $result = $query->result();

        return $result[0]->count;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function studentListing($searchText = '', $page, $segment)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->select('user.id AS student_id, user.email_id AS email, CONCAT(user.first_name, " ", user.last_name) AS name, 
                    user.mobile_number AS mobile, user.roll_number AS roll_number, user.user_class AS class,
                    school.school_name AS school_name, school.school_address AS school_address, school.school_code AS school_code,
                    state.short_state AS state_code'
                );
        $nof->from('user_registration as user');
        $nof->join('school as school', 'school.id = user.School','left');
        $nof->join('state as state', 'state.State_id = user.state','left');
        if(!empty($searchText)) {
            $likeCriteria = "(user.email_id  LIKE '%".$searchText."%'
                            OR  user.first_name  LIKE '%".$searchText."%'
                            OR  user.last_name  LIKE '%".$searchText."%'
                            OR  School.school_name  LIKE '%".$searchText."%'
                            OR  user.mobile_number  LIKE '%".$searchText."%')";
            $nof->where($likeCriteria);
        }
        $nof->order_by('user.user_class', 'ASC');
        $nof->limit($page, $segment);
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function getStudentsBySchoolId($schoolId)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('users.id AS student_id, users.first_name AS first_name, users.last_name AS last_name, users.image AS image, users.mobile_number AS mobile_number, users.date_of_birth AS date_of_birth, users.father_first_name AS father_first_name, users.father_last_name AS father_last_name, users.city AS city, users.pinCode AS pinCode, users.state AS state, users.country AS country, users.email_id AS email_id, users.School AS School, users.user_class AS user_class, users.roll_number AS roll_number, users.user_name AS user_name, users.password AS password, users.device_id AS device_id, users.device_token AS device_token');
        $nof->from('user_registration as users');
        $nof->where('School = ', $schoolId);
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function updateStudent($studentInfo, $student_id)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->where('id', $student_id);
        $nof->update('user_registration', $studentInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function studentsListingByAttribute($attributeCode, $attributeValue)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('CONCAT(BaseTbl.first_name, " ", BaseTbl.last_name) AS name, BaseTbl.roll_number AS roll_number, BaseTbl.user_class AS class');
        $nof->from('user_registration as BaseTbl');
        $nof->where($attributeCode.' = ', $attributeValue);
        $nof->where('is_bulk_uploaded = 0');
        $nof->order_by("RIGHT('roll_number', 4) ASC");
        //$nof->order_by('class', 'ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    function add($studentInfo)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->trans_start();
        $nof->insert('user_registration', $studentInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }
}

  