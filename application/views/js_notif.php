<script>
	$(function()
	{           
		//$('#notify_btn_2').on('load', function(){
		$(document).ready(function() {
			setTimeout(function(){
				$.Notify({style: {background: 'red', color: 'white'}, caption: 'Error...', content: "<?php echo $alasan; ?>"});
			}, 1000);
			/*
			setTimeout(function(){
				$.Notify({style: {background: '#1ba1e2', color: 'white'}, caption: 'Info...', content: "Data Berhasil Diubah!!!"});
			}, 1000);*/
			setTimeout(function(){
				$.Notify({style: {background: 'blue', color: 'white'}, content: "Silahkan Periksa Kembali Inputan Anda"});
			}, 2000);
		});
	});
</script>
