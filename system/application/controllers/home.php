<?php
class Home extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$this->load->view("home");
	}
}
?>