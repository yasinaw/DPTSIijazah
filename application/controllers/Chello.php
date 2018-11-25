<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class chello extends CI_Controller {
	public function index()
	{
		$this->load->view('vposts');
	}

	public function posts()
	{
		$this->load->model('post'); //load model post
		$data['posts']=$this->post->getAllPosts(); // akses fungtion getAllPost didalam class (model) post
		$this->load->view('vposts',$data); //load view vpost dan kirimkan data dalam bentuk objek $data
	}
}
?>