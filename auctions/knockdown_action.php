<?php 

	include('header.php');
	
	// Ενημέρωση της βάσης knockdown σύμφωνα με όσα δώθηκαν στη φόρμα knockdown
	$query = "UPDATE knockdown SET IsDelivered=".$_POST['IsDelivered'].", IsPaidByBuyer=".$_POST['IsPaidByBuyer'].", IsPaidBySeller=".$_POST['IsPaidBySeller'].", IsFeesPaid=".$_POST['IsFeesPaid']." WHERE bid_id=".$_POST['bid_id'];
	$result = mysqli_query($con, $query);
	if($result){	// αν είναι επιτυχής η ενημέρωση δεδομένων, εμφανίζεται μήνυμα επιτυχίας
		echo 'Knockdown data updated!<br><br>';
	}else{			// διαφορετικά, εμφανίζεται μήνυμα αποτυχίας
		echo 'Error at saving in database!<br><br>';
	}

	echo '<a href="knockdown.php?auction_id='.$_POST['auction_id'].'">Back to knowckdown data</a><br><br>';

	include('footer.php');
?>