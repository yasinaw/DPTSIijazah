<html>
<head>
<title>Coba Codeigniter</title>
</head>

<body>
<?php foreach ($tangkap_data as $value) : ?>
NIM : <?php echo $value->nim ?><br>
Nama : <?php echo $value->nama ?><br>
Alamat : <?php echo $value->alamat ?><br>
<hr><br>
<?php endforeach; ?>
</body>

</html>