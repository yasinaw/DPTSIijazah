<?php
if (empty($hasil)) {
    echo "Tidak ada data mahasiswa";
}
else {
?>
<h3> Daftar Mahasiswa </h3>
<?php echo anchor('con_mahasiswa/tambahdata', '+ Tambah Data'); ?>
<table>
<tr bgcolor="FF8844">
    <th> No </th>
    <th> Nim </th>
    <th> Nama </th>
    <th> Alamat </th>
    <th> Email </th>
</tr>
<?php
$no = 1;
foreach ($hasil as $data):
?>
<tr>
    <td> <?php echo $no; ?> </td>
    <td> <?php echo $data->nim; ?> </td>
    <td> <?php echo $data->nama; ?> </td>
    <td> <?php echo $data->alamat; ?> </td>
    <td> <?php echo $data->email; ?> </td>
</tr>
<?php
$no++;
endforeach;
?>
</table>
<?php
}
?>