<?php
	date_default_timezone_set("Asia/jakarta");
	$conn = mysqli_connect("localhost", "root", "", "db_soalpg");
	if (mysqli_connect_errno()){
		echo "Oops! Koneksi database gagal : --> " . mysqli_connect_error();
	}
?>