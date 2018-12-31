<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Olympiad_school_model extends CI_Model
{
    /**
     * This function is used to get the olympiad schools listing
     * @return array $result : This is schools list
     */
    function getList($id = 0)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $nof->select('os.*, country.country_name as country_name, state.State as state_name, state.short_state as state_code, city.city_name, school.school_code');

        $nof->from('olympiad_school as os');

        $nof->join('country as country', 'country.id = os.country','left');
        $nof->join('state as state', 'state.State_id = os.state','left');
        $nof->join('city as city', 'city.id = os.city','left');
        $nof->join('school as school', 'school.id = os.school','left');

        if ($id) {
            $nof->where('os.id', $id);
        }

        $nof->order_by('os.name', 'ASC');

        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    /**
     * This function is used to get the olympiad schools details
     * @return true
     */
    function getSchool($id)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $nof->select('os.*, country.country_name as country_name, state.State as state_name, state.short_state as state_code, city.city_name, school.school_code');

        $nof->from('olympiad_school as os');

        $nof->join('country as country', 'country.id = os.country','left');
        $nof->join('state as state', 'state.State_id = os.state','left');
        $nof->join('city as city', 'city.id = os.city','left');
        $nof->join('school as school', 'school.id = os.school','left');

        $nof->where('os.id', $id);

        $query = $nof->get();

        $result = $query->result_array();

        return $result;
    }

    /**
     * This function is used to save the olympiad schools
     * @return string $id : This is new school id
     */
    function save($schoolInfo)
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->trans_start();
        $nof->insert('olympiad_school', $schoolInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to save the olympiad schools principal
     * @return string $id : This is new school id
     */
    function savePrincipal($principalInfo)
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->trans_start();
        $nof->insert('olympiad_school_principal', $principalInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to save the olympiad schools principal
     * @return string $id : This is new school id
     */
    function saveRepresentative($representativeInfo)
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->trans_start();
        $nof->insert('olympiad_school_representative', $representativeInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to save the olympiad schools principal
     * @return string $id : This is new school id
     */
    function savePaymentDetails($paymentInfo)
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->trans_start();
        $nof->insert('olympiad_school_payment', $paymentInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to save the olympiad schools students details from csv file
     * @return true
     */
    function saveStudentCsvDetails($studentsInfo)
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->trans_start();
        $nof->insert_batch('olympiad_student', $studentsInfo);
        
        $nof->trans_complete();
        
        return true;
    }
}
