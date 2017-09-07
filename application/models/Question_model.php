<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class question_model extends CI_Model{
	function __construct(){
        parent::__construct();
    }

    public function GetQuestions(){
        //get all questions from db
        $query = $this->db->get('questions');
		return $query->result();
    }

    public function insert($data,$c_answer,$answers){
    	//nested insertion, insert question followed by answers that belong to the question

		//insert quetsion
    	$this->db->insert('questions',$data);
    	$q_id = $this->db->insert_id();

		// form answers with inserted question id in a new array
    	$data_a = array();
    	foreach($answers as $a){
    		$a_arr = array(
    			"a_content" => $a,
    			"question_id" => $q_id,
    			"IsCorrect" => 0
    		);
    		array_push($data_a,$a_arr);
    	}
    	array_push($data_a,
    		array(
    			"a_content" => $c_answer,
    			"question_id" => $q_id,
    			"IsCorrect" => 1
    			)
    	);

		// insert answer
    	$this->load->model("answer_model");
    	$this->answer_model->insert($data_a);

		return $q_id;
    }

	public function GetQuestoinsByQuizId($qid){
		// get all questions within a specific quiz
		$query = $this->db->query('select * from questions q left join question_quiz qq on qq.question_id = q.question_id where qq.quizId = '.$qid);
		return $query->result();
	}
}
?>
