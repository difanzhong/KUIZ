<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "uq/auth.php"; // to retrieve user info from server
auth_require();

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$student_no = auth_get_payload()['user']; // get student_number from uq single-signon

		// load resources
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->model('quiz_model');

		//retrieve user info from database if the user is exist
		$students = null;
		if ($this->user_model->isValid($student_no)){
			$students = $this->user_model->GetDetails($student_no);
			$this->session->set_userdata(array(
				'student_no' => $students[0]->student_no,
				'username'=>$students[0]->nickname,
				'avatar'=>$students[0]->avatar
			));
		}
		else{
			redirect('/User');
		}

		// extract available launched quizes and the quizes this user done from database
		$quizes = $this->quiz_model->GetAvailableQuiz($student_no);
		$quizesDone = $this->quiz_model->GetQuizesDoneByStudent($student_no);

		// load view with packaged data
		$data['availableQuizes'] = $quizes;
		$data['quizesDone'] = $quizesDone;
		$data['student'] = $students[0];
		$this->load->view('Master/header');
		$this->load->view('home',$data);
	}
}
