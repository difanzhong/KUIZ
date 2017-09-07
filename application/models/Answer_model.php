<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class answer_model extends CI_Model{
	function __construct(){
        parent::__construct();
    }
    public function GetAnswersByQid($qid){
        //get all answers belong to the question
        $this->db->where("question_id",$qid);
        $query = $this->db->get('answers');
		return $query->result();
    }

    public function insert($data){
    	$this->db->insert_batch('answers',$data);
    }
}
?>