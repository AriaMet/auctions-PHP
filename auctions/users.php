<?php 
	include('header.php');

	if(!isset($_SESSION['isProvider'])){
		// αν ο χρήστης δεν είναι provider ή moderator , τότε εφανίζεται μήνυμα σφάλματος και δεν εκτελείται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}
		
	?>
	<b>Users List</b>
	<table class="mytable">
	<tr><th>ID</th><th>First name</th><th>Last name</th><th>E-mail</th><th>Username</th><th>Telephone</th><th>Address</th><th>Status</th><th>Edit</th></tr>
	
	<?php
	// φόρτωση των users απο την βάση και user_status και εμφάνιση δεδομένων
	$query = "SELECT * FROM users, user_status WHERE users.status=user_status.u_status_id";
	$result = mysqli_query($con, $query);
	while($user = mysqli_fetch_assoc($result)){
		echo "<tr><td>".$user['user_id']."</td><td>".$user['firstname']."</td><td>".$user['lastname']."</td><td>".$user['email']."</td><td>".$user['username']."</td><td>".$user['telephone']."</td><td>".$user['address']."</td><td>".$user['u_status_descr']."</td><td>";
		//ανάλογα με το user_status, εμφανίζονται και οι αντίστιχες επιλογές
		// φόρμα για user_status
		$form_start = "<form action='users_action.php' method='POST'><input type='hidden' name='user_id' value='".$user['user_id']."'>";
		if($user['status']==0){ // αν ο user έχει κάνει register και δεν έχει ενεργοποιηθεί
			// τότε εμφανίζεται κουμπί για ενεργοποίηση
			echo $form_start.
			"<input type='submit' name='activate' value='Activate'>
			</form>";
		}elseif($user['status']==1){ // αν ο user είναι προσωρινά απενεργοποιημένος
			// τότε εμφανίζονται κουμπιά για ενεργοποιήση και απενεργοποιήση
			echo $form_start.
			"<input type='submit' name='activate' value='Activate'>
			<input type='submit' name='perm_deactivate' value='Permantent Deactivate'>
			</form>";
		}elseif($user['status']==2 && $_SESSION['isProvider']==1){ //αν ο χρήστης είναι o provider μπορεί να ενεργοποιήσει user υστέρα απο προηγούμενη απενεργοποιήση
			echo $form_start.
			"<input type='submit' name='activate' value='Activate'>
			</form>";
		}elseif($user['status']==3){ // αν ο user είναι ενεργός 
			// τότε εμφανίζονται κουμπιά για προσωρινή απενεργοποιήση και απενεργοποιήση
			echo $form_start.
			"<input type='submit' name='temp_deactivate' value='Temporary Deactivate'>
			<input type='submit' name='perm_deactivate' value='Permantent Deactivate'>
			</form>";			
		}		
		echo "</td></tr>";
	}
	echo '</table>';
	

	include('footer.php');

?>