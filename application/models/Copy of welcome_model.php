<?
class welcome_model extends Model{

function welcome_model(){
parent::Model();
}

function select_db(){


$sqlquery = "SELECT * FROM tbl_mahasiswa";


$query = $this->db->query ($sqlquery);


$get = $query->result();


return $get;
}

}
?>