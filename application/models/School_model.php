<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function studentListingCount($searchText = '')
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $query = $nof->select('count(id) AS count')->get('school');

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
    function schoolsListing($condition = '')
    {
        ini_set('max_execution_time', 900);
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        //$nof->select('school.id AS school_id, school.school_name AS school_name, school.school_address AS school_address, city.city_name AS city_name, state.State AS state_name, country.country_name AS country_name, CONCAT(state.short_state, school.school_code) AS school_code, count(users.id) AS total_students');
        $nof->select('school.id AS school_id, school.school_name AS school_name, school.school_address AS school_address, city.city_name AS city_name, state.State AS state_name, country.country_name AS country_name, CONCAT(state.short_state, school.school_code) AS school_code');
        $nof->from('school as school');
        $nof->join('state as state', 'state.State_id = school.state_id','left');
        $nof->join('city as city', 'city.id = school.city_id','left');
        $nof->join('country as country', 'country.id = state.country_id','left');
        // $nof->join('user_registration as users', 'users.School = school.id','left');
        if ($condition == 'all') {
            $nof->where("school.school_code = ''");
            $nof->where("school.school_code = '0'");
        } else {
            $nof->where("school.school_code != ''");
            $nof->where("school.school_code != '0'");
        }
        //$nof->group_by('users.School');

        $nof->order_by('school.school_name ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return array $result : This is result
     */
    function getSchoolInfo($schoolId)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('school.id AS school_id, school.school_name AS school_name, school.school_address AS school_address, city.city_name AS city_name, state.State AS state_name, country.country_name AS country_name, CONCAT(state.short_state, school.school_code) AS school_code, school.school_code AS schoolcode, school.latest_student_code AS latest_student_code, school.state_id AS state_id, school.city_id AS city_id');
        $nof->from('school as school');
        $nof->join('state as state', 'state.State_id = school.state_id','left');
        $nof->join('city as city', 'city.id = school.city_id','left');
        $nof->join('country as country', 'country.id = state.country_id','left');
        $nof->where("school.id = $schoolId");
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return array $result : This is result
     */
    function getSchoolInfoBySchoolCode($schoolCode)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('school.id AS school_id, school.school_name AS school_name, school.school_address AS school_address, school.city_id AS city_id, school.state_id AS state_id, country.id AS country_id, CONCAT(state.short_state, school.school_code) AS school_code, school.latest_student_code AS latest_student_code');
        $nof->from('school as school');
        $nof->join('state as state', 'state.State_id = school.state_id','left');
        // $nof->join('city as city', 'city.id = school.city_id','left');
        $nof->join('country as country', 'country.id = state.country_id','left');
        $nof->where("school.school_code = '$schoolCode'");
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    function schoolStudentsListingByAttribute($school_id, $students_type){
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('*');
        $nof->from('school as school');
        $nof->join('user_registration as user_registration', 'school.id = user_registration.School','left');
        $nof->where("school.id = $school_id");
        if ($students_type == 1) {
            $nof->where("school.school_code LIKE '%N%'");
        }
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function updateNewSchool($schoolInfo, $schoolId)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->where('id', $schoolId);
        $nof->update('school', $schoolInfo);
        
        return TRUE;
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function deleteSchool($schoolId)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->where('id', $schoolId);
        $nof->delete('school');
        
        return TRUE;
    }

    function getSchoolsListByCity($city_id)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->select('school.id AS school_id, school.school_name AS school_name, school.school_address AS school_address, city.city_name AS city_name, state.State AS state_name, country.country_name AS country_name, CONCAT(state.short_state, school.school_code) AS school_code, school.school_code AS schoolcode, school.latest_student_code AS latest_student_code, school.state_id AS state_id, school.city_id AS city_id');
        $nof->from('school as school');
        $nof->join('state as state', 'state.State_id = school.state_id','left');
        $nof->join('city as city', 'city.id = school.city_id','left');
        $nof->join('country as country', 'country.id = state.country_id','left');
        if(!empty($city_id)) {
            $likeCriteria = "(school.city_id = ".$city_id.")";
            $nof->where($likeCriteria);
        }
        $nof->order_by('school.school_name ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function update($schoolInfo, $schoolId)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->where('id', $schoolId);
        $nof->update('school', $schoolInfo);
        
        return TRUE;
    }
}
  