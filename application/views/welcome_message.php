<html>
<head>
<title>Coba Codeigniter</title>
</head>

<body>
<? foreach ($tangkap_data as $value) : ?>
NIM : <? echo $value->nim ?><br>
Nama : <? echo $value->nama ?><br>
Alamat : <? echo $value->alamat ?><br>
<hr><br>
<? endforeach; ?>
</body>

</html>