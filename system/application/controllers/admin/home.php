<?php
class Home extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$user=$this->session->userdata('logged_in');
		if ($user)
		{
			$variables['user'] = $user;
			$variables['padre_id'] = 0;	
			$variables['modulo_id'] = 0;
			$this->load->view('admin/home/home',$variables);
		}
		else
		{
			$variables['error'] = "";
			$this->load->view('admin/loginlayout',$variables);
		}
	}
}
?>