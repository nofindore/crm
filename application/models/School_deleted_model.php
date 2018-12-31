<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class School_deleted_model extends CI_Model
{   
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewEntry($schoolInfo)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->trans_start();
        $nof->insert('school_deleted', $schoolInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }
}

  