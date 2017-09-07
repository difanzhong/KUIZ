<?php

/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/16/2015
 * Time: 11:10 PM
 */
class TakeQuiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load resources for every function in the class
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('topic_model');
        $this->load->model('quiz_model');
        $this->load->model('question_model');
        $this->load->model('answer_model');
    }

    public function Index($quiz_id){
        /* this function is to load a specific quiz
        with questions for user to take */
        if ($quiz_id == null) {
            $quiz_id = $this->session->flashdata('quiz_id');
            if($quiz_id == null)
                redirect('/Welcome'); // if cant find id, redirect user to home page
        }

        // get questions with answers from database
        $questions = $this->question_model->GetQuestoinsByQuizId($quiz_id);
        if ($questions){
            foreach ($questions as $q) {
                $qid = $q->question_id;
                // get answers from method in answer_model.php using question_id
                $answers = $this->answer_model->GetAnswersByQid($qid);
                if ($answers) {
                    $q->answers = $answers;
                }
            }
        }

        // get quiz details
        $quiz = $this->quiz_model->GetQuizById($quiz_id);

        // load views with packaged data
        $data['title'] = $quiz->quizName;
        $data['size'] = $quiz->quizSize;
        $data['Launched'] = $quiz->Launched;
        $data['quiz_id'] = $quiz_id;
        $data['questions'] = $questions;
        $this->load->view('Master/header');
        $this->load->view('Quiz/take_quiz',$data);
    }

    public function checkAnswer(){
        /*  to calculate score and
        record the quiz done by this user */
        if (isset($_REQUEST)){
            $quizid = $this->input->post('quizid');
            $quiz = $this->quiz_model->GetQuizById($quizid);

            $score = 0;
            for ($i = 1;$i<=$quiz->quizSize;$i++){
                $qval = $this->input->post('question'.$i);
                if ($qval == 1)
                    $score++;
            }

            $scoref = $score.'/'.$quiz->quizSize;
            $data_insert = array(
                "quizId" => $quizid,
                "student_no" => $this->session->userdata('student_no'),
                "score" => $scoref
            );
            $this->quiz_model->InsertStudentQuiz($data_insert);

            redirect('/Welcome');
        }
    }
}