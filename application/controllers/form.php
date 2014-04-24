<?php

class Form extends CI_Controller {

	function index()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->library('basicpasswordmanagement');

	//	if ($this->form_validation->run() == FALSE)
	//	{
			//$this->load->view('form');
	//	}
	//	else
	//	{
			//$this->load->view('formsuccess');
	//	}
			//if($this->form_validation->run() == FALSE)
			$form=$this->input->post();
			if($form)
			{
			$entropy=$this->basicpasswordmanagement->entropy($form["password"]);
			echo $entropy.'   :   ';
			if($this->basicpasswordmanagement->hasorderedcharacters($form["password"],strlen($form["password"])/2)==true)
				echo "success ordered characters"."<br>";
			else
				echo "failure ordered characters"."<br>";

			if($this->basicpasswordmanagement->hasKeyboardOrderedCharacters($form["password"],strlen($form["password"]))==true)
				echo "success keyboard ordered characters"."<br>";
			else
				echo "failure keyboard ordered characters"."<br>";

			if($this->basicpasswordmanagement->containsString($form["password"],$form["passconf"]) == true)
				echo "I failed!!!!";
			else
				echo "Yeeee!!!!!";
			//echo($this->basicpasswordmanagement->strength($form["password"]).':::');
			}
				$this->load->view('form');
			
			
	}
}
?>