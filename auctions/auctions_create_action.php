<?php 
	include('header.php');
	
	//με την υποβολή την φόρμας auctions create γίνεται η εισαγωγή στη βάση
	$query = "INSERT INTO auctions(owner, prod_serv_name, prod_serv_description, start_datetime, main_duration, start_price, price_step, allow_extensions, max_extensions, extension_duration, crucial_time, type, last_extension, finished) VALUES (".$_SESSION['user_id'].", '".$_POST['name']."', '".$_POST['prod_serv_description']."', '".$_POST['start_date']." ".$_POST['start_time']."', '".$_POST['main_duration']."', ".$_POST['start_price'].", ".$_POST['price_step'].", ".$_POST['allow_extensions'].", ".$_POST['max_extensions'].", '".$_POST['extension_duration']."', '".$_POST['crucial_time']."', ".$_POST['type'].", 0, 0)";
	$result = mysqli_query($con, $query);
	if($result){ 	// αν είναι επιτυχής η εισαγωγή εμφανίζεται μήνυμα επιτυχίας
		echo 'Saved successfully!<br>';
	}else{			// διαφορετικά εμφανίζεται μήνυμα αποτυχίας

		echo 'Error at saving!<br>';
	}

	include('footer.php');
?>