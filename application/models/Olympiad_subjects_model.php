<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Olympiad_subjects_model extends CI_Model
{
    /**
     * This function is used to get the olympiad schools listing
     * @return array $result : This is schools list
     */
    function getList() {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('olympiad_subjects.*');
        $nof->from('olympiad_subjects as olympiad_subjects');
        $nof->where('olympiad_subjects.status', 1);
        $nof->order_by('olympiad_subjects.sort_order', 'ASC');
        $query = $nof->get();
        $result = $query->result_array();
        return $result;
    }

    /**
     * This function is used to get the olympiad schools listing
     * @return array $result : This is schools list
     */
    function getSubject($subjectId) {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $nof->select('olympiad_subjects.*');
        $nof->from('olympiad_subjects as olympiad_subjects');
        $nof->where('olympiad_subjects.status', 1);
        $nof->where('olympiad_subjects.id', $subjectId);
        $nof->order_by('olympiad_subjects.sort_order', 'ASC');
        $query = $nof->get();
        $result = $query->result_array();
        return $result;
    }
}
