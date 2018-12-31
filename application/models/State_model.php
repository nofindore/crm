<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

CONST BASE_TABLE = 'state';

class State_model extends CI_Model
{

    function getStatesList($searchText = '')
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('state.State_id AS id, state.State AS state_name, state.short_state AS state_code, country.country_name AS country_name, state.latest_school_code AS latest_school_code, state.latest_temp_school_code AS latest_temp_school_code');
        $nof->from('state as state');
        $nof->join('country as country', 'country.id = state.country_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(country.country_name  LIKE '%".$searchText."%')";
            $nof->where($likeCriteria);
        }
        $nof->order_by('state.State ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    function getStatesListByCountry($country_id)
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('state.State_id AS id, state.State AS state_name, state.short_state AS state_code, country.country_name AS country_name');
        $nof->from('state as state');
        $nof->join('country as country', 'country.id = state.country_id','left');
        if(!empty($country_id)) {
            $likeCriteria = "(state.country_id  = ".$country_id.")";
            $nof->where($likeCriteria);
        }
        $nof->order_by('state.State', 'ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    function getState($state_id)
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('state.State_id AS id, state.State AS state_name, state.short_state AS state_code, country.country_name AS country_name, state.latest_school_code AS latest_school_code');
        $nof->from('state as state');
        $nof->join('country as country', 'country.id = state.country_id','left');
        $likeCriteria = "(state.State_id  = ".$state_id.")";
        $nof->where($likeCriteria);

        $query = $nof->get();
        $result = $query->result();

        return $result;
    }

    function update($stateInfo, $state_id)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->where('State_id', $state_id);
        $nof->update('state', $stateInfo);
        
        return TRUE;
    }
}

?>
