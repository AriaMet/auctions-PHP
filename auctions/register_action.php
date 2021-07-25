<?php
	include('header.php');
	

	// αναζήτηστη στον πίνακα users αν υπάρχει το username που έδωσε ο χρήστης
	$query = "SELECT * FROM `users` WHERE `username` = '".$_POST['username']."'";
	$result = mysqli_query($con, $query); 
	$row = mysqli_fetch_assoc($result);

	if($row){ 		// αν το username υπάρχει, τότε εμφανίζεται μήνυμα στην οθόνη
		echo "Username exists!";
	}else{
		// διαφορετικά γίνεται η εισαγωγή του νέου user στη βάση
		$password = sha1($_POST['password']); // κρυπτογράφηση του password πριν αποθηκευτει στη βάση
		
		$query = "INSERT INTO users(firstname, lastname, email, username, password, telephone, address, status) VALUES ('".$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['email']."', '".$_POST['username']."', '".$password."', '".$_POST['telephone']."', '".$_POST['address']."', 0)";

		$result = mysqli_query($con, $query);
		
		if($result){		// αν η εισαγωγή του νέου user είναι επιτυχής
			echo 'Successful registration!<br>You can now <a href="login.php">login</a>.'; 	// εκτυπώνεται μήνυμα επιτυχίας
		}else{				// διαφορετικά, εκτυπώνεται μήνυμα σφάλματος
			echo "Error at registration!";
		}
	}
	include('footer.php');
?>
