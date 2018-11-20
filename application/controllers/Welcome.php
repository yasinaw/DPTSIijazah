<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
function __construct() 
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));		
	}

function index()
{
	$this->load->view('login_view');
}
}
