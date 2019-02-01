<?php
	class post extends CI_Model 
	{
		function getAllPosts()
		{
			$q = $this->db->query('select * from tab_agama'); // query untuk mengambil data dari tabel post didalam database
			return $q->result(); // menangkap hasil query dan mengirimkan kembali ke controller chello.
		}
	}
?>