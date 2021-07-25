<?php
	include('header.php');
	

	// από τα δεδομένα που δώθηκαν στη φόρμα Login, θα γίνει αναζήτηση στον πίνακα users για να διαπιστωθεί αν είναι user 
	$username = $_POST['username'];
	$password = sha1($_POST['password']); //  κρυπτογράφηση password
	$query = "SELECT * FROM users WHERE username = '$username' AND password='$password'";

	$result = mysqli_query($con, $query);
	
	if($row = mysqli_fetch_assoc($result)){
		// αν βρίσκεται στον πίνακα users
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['status'] = $row['status'];
		
		if($row['status']==3){
			$_SESSION['active'] = 1; // ενεργός
		}else{
			$_SESSION['active'] = 0; // ανενεργός
		}
		header("Location: auctions.php"); // στη συνέχεια γίνεται redirect στην σελίδα auctions.php
	} else { 
		// αν δεν βρίσκεται στον πίνακα users ,τοτε γίνεται αναζήτηση στον πίνακα providerormoderator
		$query = "SELECT * FROM providerormoderator WHERE username = '$username' AND password='$password'";
		$result = mysqli_query($con, $query);
		
		if($row = mysqli_fetch_assoc($result)){
			// αν βρίσκεται στον πίνακα providerormoderator
			$_SESSION['pom_id'] = $row['pom_id'];
			$_SESSION['isProvider'] = $row['isProvider'];
			$_SESSION['isModerator'] = $row['isModerator'];
			$_SESSION['active'] = 1;
			header("Location: users.php");	// στη συνέχεια γίνεται redirect στην σελίδα users.php
		}else{
			// αν βρεθεί σε κάποια απο τις παραπάνω περιπτώσεις, τότε εμφανίζεται μήνυμα σφάλματος στην οθόνη
			echo "Wrong username or password!<br><br>";
		}
	}

	include('footer.php');
?>