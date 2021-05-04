<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		not_login();
		$this->template->load('template', 'v_dashboard');
	}
}