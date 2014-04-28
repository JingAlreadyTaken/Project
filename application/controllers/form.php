<?php

class Form extends CI_Controller {

	function index()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->library('basicpasswordmanagement');


			$form=$this->input->post();
			if($form)
			{
				$changePasswordResult = 0;

			$diffValue = $this->basicpasswordmanagement->getPasswordDistance($form["oldpassword"],strlen($form["oldpassword"]),$form["newpassword"],strlen($form["newpassword"]));
			//echo $diffValue;
				
			$entropy=$this->basicpasswordmanagement->entropy($form["newpassword"]);
			//echo $entropy.'   :   ';
			if($this->basicpasswordmanagement->hasorderedcharacters($form["newpassword"],strlen($form["newpassword"])/2)==true)
				{
					//echo "success ordered characters"."<br>";
				}
			else
			{
				//echo "failure ordered characters"."<br>";
				$changePasswordResult = "failure ordered characters";
			}
				

			if($this->basicpasswordmanagement->hasKeyboardOrderedCharacters($form["newpassword"],strlen($form["newpassword"]))==true)
			{
				//echo "success keyboard ordered characters"."<br>";
			}
			else
			{
				//echo "failure keyboard ordered characters"."<br>";
				$changePasswordResult = $changePasswordResult + "failure keyboard ordered characters";
			}
				

			if($this->basicpasswordmanagement->containsString($form["newpassword"],$form["confpassword"]) == true)
			{
				//echo "I failed!!!!";
				$changePasswordResult = $changePasswordResult + "failure keyboard ordered characters";
			}
			
			//echo $this->basicpasswordmanagement->checkPasswordRepetition($form["oldpassword"],$form["newpassword"]);
			//echo($this->basicpasswordmanagement->strength($form["newpassword"]).':::');

				$this->load->view('result');
				if($changePasswordResult == 0)
				{

				}
				else
				{
					echo $changePasswordResult;
				}

			}
			else
				$this->load->view('form');			
	}
}
?>