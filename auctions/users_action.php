<?php 
	include('header.php');

	if(!isset($_SESSION['isProvider'])){
		// αν ο χρήστης δεν είναι Provider ή Moderator , τότε εφανίζεται μήνυμα σφάλματος και δεν εκτελείται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}
	
	// έλεγχος για ποιο κουμπί πατήθηκε
	if(isset($_POST['activate'])){ // για ενεργοποίηση user
		$query = "UPDATE users SET status=3, approval_pom=".$_SESSION['pom_id'].", approval_date=NOW() WHERE user_id=".$_POST['user_id'];
		mysqli_query($con, $query);
	}
	if(isset($_POST['temp_deactivate'])){ // για προσωρινή απενεργοποίηση user
		$query = "UPDATE users SET status=1 WHERE user_id=".$_POST['user_id'];
		mysqli_query($con, $query);
	}
	if(isset($_POST['perm_deactivate'])){ // για απενεργοποίηση user
		$query = "UPDATE users SET status=2 WHERE user_id=".$_POST['user_id'];
		mysqli_query($con, $query);
	}
	
	header('Location: users.php'); // επιστροφή στη σελίδα users

	include('footer.php');

?>