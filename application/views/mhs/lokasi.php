<html>	
<head>
	<?php echo $this->load->view('css_js');?>
	<title>Cari Kursi Wisuda</title>
<head>

<body class="metro" align="center">	
	
	<!-- HEADER -->
		
	<div class="grid">
		<div class="row">
			<!--div class="span3" >
				<div class="span3">
					<!?php echo $this->load->view('sidebar_baak');?>
				</div>
			</div-->
			
			<div>
				<!-- content -->
				<div class="row">
				<table align="center">
					<tr>
						<td align="right" class="span2" style="padding-right:10">
							<img src="/simwisuda/inc/logo_its.gif" style="width: 100; height: 100" />
						</td>	
						<td align="center">
							<h2><strong>
					Biro Akademik, Kemahasiswaan, dan Perencanaan<br>
					Institut Teknologi Sepuluh Nopember
				</strong></h2>
						</td>
					</tr>
				</table>
				
				
				<br><br>
				<?php echo form_open(base_url().'mahasiswa/posisikursi');?>
					<legend><p class="item-title">Posisi Kursi Wisuda</p></legend>		
					<label class="span2">
						Masukkan NRP
					</label>
					<div class="span2">						
						<div class="input-control text" data-role="input-control">
							<input type="text" class="span2" name='input_nrp'>
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>	
						<br>
					</div>
					<button class="primary span1" align="left">Cari</button>	
					</form>	
				</div>
				<hr>
				<div class="row" align="center">	
					<?php foreach($posisi as $row){ ?>					
					<table align="center"  width="100%">
						<tr>
							<td width="50%"align="right"><strong><label >Nomor Kursi : </label></strong></td>
							<td>
								&nbsp;<p class="item-title bg-cobalt fg-white span2 padding10" align="center"><strong><?php echo $row->deret.'-'.$row->kursi.'-'.$row->urut;?></strong></p>
							</td>
						</tr>
						
						<tr>
							<td align="right"><strong><label>Periode Wisuda : </label></strong></td>
							<td>&nbsp;<?php echo $row->periodewisuda;?></td>
						</tr>
						<tr>
							<td align="right"><strong><label>NRP : </label></strong></td>
							<td>&nbsp;<?php echo $row->nrp;?></td>
						</tr>
						<tr>
							<td align="right"><strong><label>Nama : </label></strong></td>
							<td>&nbsp;<?php echo $row->nama;?></td>
						</tr>
						<tr>
							<td align="right"><strong><label>Jurusan : </label></strong></td>
							<td>&nbsp;<?php echo $row->jurusan_mhs;?></td>
						</tr>
						<tr>
							<td align="right"><strong><label>Hari, Tanggal Wisuda : </label></strong></td>
							<td>&nbsp;<?php echo $row->hari_tanggal_wisuda;?></td>
						</tr>
					</table>
					
					<?php } ?>	
					
					<br>
					<strong><p class="item-title">
					TATA TERTIB UPACARA WISUDA KE-<?echo $row->periodewisuda;?> ITS<br>
					Pukul 07.00 - selesai
					</p></strong>
					<br>
					<button onclick="window.print()"><i class="icon-printer on-left"></i>Cetak Nomor Kursi</button>
					<br><br>
					<div align="left">
					<table>
						<tr>
							<td width="10mm"></td>
							<td><p>
	1. Pukul 07.00, wisudawan sudah siap berada di lapangan Grha Sepuluh Nopember;<br>
	2. Pukul 07.30, wisudawan dengan susunan barisan yang rapi dan tertib serta sesuai dengan nomor urut
	   kursi, siap memasuki ruang upacara;<br>
	3. Pukul 08.00, wisudawan telah berada di ruang upacara dengan menempati kursi menurut baris dan nomor
	   <br>&nbsp;&nbsp;&nbsp;
	   yang telah ditentukan;<br>
	4. Wisudawan yang datang terlambat dan pintu sudah ditutup, tidak diperkenankan memasuki ruang upacara.<br>
	5. Setelah Rektor membuka secara resmi Rapat Terbuka Senat Institut, seluruh wisudawan menyanyikan Hymne Guru yang dipimpin oleh
	   <br>&nbsp;&nbsp;&nbsp;
	   seorang wisudawan yang telah ditunjuk dengan diiringi oleh Paduan Suara Mahasiswa ITS;<br>
	6. Pengukuhan wisudawan oleh Rektor, wisudawan berdiri sampai selesainya lagu Satu Nusa Satu Bangsa yang dinyanyikan oleh Paduan
	   <br>&nbsp;&nbsp;&nbsp;&nbsp;
	   Suara Mahasiswa ITS;<br>
	7. Penyerahan Ijazah, Transkrip dan Piagam Penghargaan bagi wisudawan yang berpredikat Dengan Pujian (Cumlaude) : Pada saat Ketua
	   <br>&nbsp;&nbsp;&nbsp;
	   Jurusan menyebut nama wisudawan, wisudawan dari jurusan tersebut berdiri dan maju satu persatu untuk menerima ijazah, transkrip
	   <br>&nbsp;&nbsp;&nbsp;
	   dan piagam dari Dekan dan ucapan selamat dari Rektor, selanjutnya kembali ke tempat duduk semula;<br>
	8. Pembacaan Janji Wisudawan dipimpin oleh dua orang wisudawan yang telah ditunjuk dan diikuti oleh seluruh wisudawan, wisudawan
	   <br>&nbsp;&nbsp;&nbsp;
	   tetap berdiri sampai selesainya lagu Padamu Negeri yang dinyanyikan oleh Paduan Suara Mahasiswa ITS;<br>
	9. Selama upacara wisuda berlangsung, wisudawan harus mengikuti dengan tenang dan khidmat;<br>
	10. Upacara selesai, prosesi meninggalkan ruang upacara;<br>
	11. Wisudawan membubarkan diri dengan tertib.
						</p></td>
						<tr>
					</table>
						
					</div>
					<br>
						<p class="description padding20 bg-grayLighter" align="center">
                            KAMI MENGUCAPKAN SELAMAT ATAS KEBERHASILAN ANDA MENYELESAIKAN STUDI DI ITS.<br>
							SEMOGA TUHAN YANG MAHA ESA SENANTIASA MELIMPAHKAN RAHMAT-NYA SERTA MELAPANGKAN DAN MELURUSKAN USAHA ANDA SELANJUTNYA DALAM MENGGAPAI CITA-CITA.
                        </p>
						
						
				</div>
					
					
				
			</div>					
		</div>
		
	</div>		
	
	
	
	
	
	
</body>
</html>	