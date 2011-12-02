<?php
class Home extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$variables['pagina_id'] = 0;
		$variables['home'] = true;
		$this->load->library("varios");
		$this->load->view("home",$variables);
	}
}
?>