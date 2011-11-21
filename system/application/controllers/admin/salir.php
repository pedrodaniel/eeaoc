<?php
class Salir extends Controller
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
			if ($user['id']>0)
			{
				$this->session->unset_userdata('logged_in');
			}
		}
		redirect(site_url('admin'), 'refresh');
	}
}
?>