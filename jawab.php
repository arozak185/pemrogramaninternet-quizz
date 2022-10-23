<?php
	include "koneksi.php";
	if(isset($_POST['submit'])){
		if(empty($_POST['pilihan'])){
		?>
			<script language="JavaScript">
                alert('Anda tidak mengerjakan soal apapun ...');
                document.location='./';
            </script>
		<?php
		}
		
		$pilihan	=$_POST["pilihan"];
		$id_soal	=$_POST["id"];
		$jumlah		=$_POST["jumlah"];
		
		$score	=0;
		$benar	=0;
		$salah	=0;
		$kosong	=0;

		for($i=0;$i<$jumlah;$i++){
			$nomor	=$id_soal[$i];
			
			// jika peserta tidak memilih jawaban
			if(empty($pilihan[$nomor])){
				$kosong++;
			}
			// jika memilih
			else {
				$jawaban	=$pilihan[$nomor];

				// cocokan kunci jawaban dengan database
				$query	=mysqli_query($conn, "SELECT * FROM tbl_soal WHERE id_soal='$nomor' AND kunci='$jawaban'");
				$cek	=mysqli_num_rows($query);
				
				// jika jawaban benar (cocok dengan database)
				if($cek){
					$benar++;
				}
				// jika jawaban salah (tidak cocok dengan database)
				else {
					$salah++;
				}
			}
			/*
				----------
				Nilai 100
				----------
				Hasil = 100 / jumlah soal * Jawaban Benar
			*/
			// hitung skor
			$hitung =mysqli_query($conn, "SELECT * FROM tbl_soal WHERE aktif='Y'");
			$jumlah_soal	=mysqli_num_rows($hitung);
			$score	=100 / $jumlah_soal * $benar;
			$hasil	=number_format($score);
		}

		switch ($hasil) {
			case 100:
			  $keterangan = "A";
			  break;
			case 80:
			  $keterangan = "B";
			  break;
			case 60:
			  $keterangan = "C";
			  break;
			case 40:
			  $keterangan = "D";
			  break;
			case 20:
			  $keterangan = "E";
			  break;
			  default:
			  $keterangan = "Belajar lagi Ya!!";
			  break;
		  }
	}

	// Tampilkan Hasil Ujian Soal Pilihan Ganda
	echo"
	<table border='0'>
		<tbody>
			<tr>
				<td colspan='4'><h4>Nilai Ujian Anda</h4></td>
			</tr>
			<tr>
				<td width='80'><u>Benar &#10004;</u></td>
				<td width='80'><u>Salah &#x2715;</u></td>
				<td width='140'><u>Tidak Terjawab &#33;</u></td>
				<td width='100'><u>Skor Akhir &#35;</u></td>
				<td width='100'>Status</td>
			</tr>
			<tr>
				<td align='center'>$benar</td>
				<td align='center'>$salah</td>
				<td align='center'>$kosong</td>
				<td align='center'><b>$hasil</b></td>
				<td align='center'><b>$keterangan</b></td>
			</tr>
		</tbody>
	</table>
	";
	echo "<br /><a href='./'><< kembali</a>";
?>