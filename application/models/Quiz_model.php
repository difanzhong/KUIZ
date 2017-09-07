<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/16/2015
 * Time: 5:51 PM
 */
class quiz_model extends CI_Model
{
    function Insert($data){
        $this->db->insert('quiz',$data);
        return $this->db->insert_id();
    }

    function GetQuizesById($tid){
        $this->db->where('topicId',$tid);
        $query = $this->db->get('quiz');
        return $query->result();
    }

    function GetQuizById($qid){
        $this->db->where('quizId',$qid);
        $query = $this->db->get('quiz');
        return $query->result()[0];
    }

    function GetAvailableQuiz($student_no){
        $query = $this->db->query("select * from quiz q left join topic t on t.topicId = q.topicId where q.Launched = 1 and q.quizId not in (select quizId from student_quiz where student_no = '".$student_no."')");
        return $query->result();
    }
    function InsertQuestionQuiz($data){
        $this->db->insert('question_quiz',$data);
    }

    function Update($data){
        $this->db->where('quizId',$data['quizId']);
        $this->db->update('quiz',$data);
        return $this->db->affected_rows();
    }

    function GetQuizesDoneByStudent($student_no){
        $query = $this->db->query("select * from student_quiz sq left join quiz q on q.quizId = sq.quizId left join topic t on t.topicId= q.topicId where sq.student_no = '".$student_no."'");
        return $query->result();
    }

    function InsertStudentQuiz($data){
        $this->db->insert('student_quiz',$data);
        return $this->db->affected_rows();
    }
}