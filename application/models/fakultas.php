<?php
    class Db_login extends CI_Model{
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
        
        function get_fakultas(){
            $query="SELECT * from Fakultas";
            $q = $this->db->query($query);//->result();
            //return $q;

            if ($q->cubrid_num_rows()>0){
                foreach ($q->result_array as $row) {
                    $data[$row['FA_ID']] = $row['fakultas'];                    
                }
            } 
            return $data;
        }
    }
?>
