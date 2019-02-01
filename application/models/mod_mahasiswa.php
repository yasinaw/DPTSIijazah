<?php
class Mod_mahasiswa extends Model {
    function getall() {
    $ambildata = $this->db->get('tb_mahasiswa');
        //jika data ada (lebih dari 0)
        if ($ambildata->num_rows() > 0 ) {
            foreach ($ambildata->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}
?>