<?
class welcome_model extends Model{

function select_db(){


$sqlquery = "SELECT * FROM kelas";


$query = $this->db->query ($sqlquery);


$get = $query->result();


return $get;
}

}
?>