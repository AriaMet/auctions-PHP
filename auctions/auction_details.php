<?php 
	include('header.php');

	if(!isset($_SESSION['active']) || ($_SESSION['active']==0)){
		// αν ο χρήστης δεν είναι ενεργός ή Provider ή Moderator, εμφανίζεται μήνυμα σφάλματος και δεν εκτελείται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}

	$auction_id = $_GET['auction_id'];
	
	// φορτώνει auction και υπολογίζει end_datetime και crucial_start_datetime χρησιμοποιώντας  SQL ADDTIME, SUBTIME functions
	$query = "SELECT *, 
	ADDTIME(start_datetime, main_duration + last_extension*extension_duration) as end_datetime, 
	SUBTIME(ADDTIME(start_datetime, main_duration + last_extension*extension_duration),crucial_time) as crucial_start_datetime	
	FROM auctions WHERE auction_id=".$auction_id;
	$res = mysqli_query($con, $query);
	$auction = mysqli_fetch_assoc($res);

	// φόρμα του bid
	if((!$auction['finished']) && isset($_SESSION['active']) && ($_SESSION['active']==1) && (!isset($_SESSION['isProvider'])) && ($_SESSION['user_id'] != $auction['owner'])){
		// εμφάνιση αν: το auction δεν είναι finished, για του ενεργούς users, οχι για τον owner
			echo "<form action='auction_details_action.php' method='POST'>";
			echo "<input type='hidden' name='auction_id' value='".$auction_id."'>";
			echo "<table class='invisible'><tr><td>Amount</td><td><input type='text' name='amount'></td></tr>";
			echo "<tr><td></td><td><input type='submit' name='submit' value='Bid!' /></td></tr></table>";
			echo "</form>";
			echo "<br><br>";
	}
	
	// φορτώνει auction type
	$query = "SELECT * FROM auction_types WHERE a_type_id=".$auction['type'];
	$result = mysqli_query($con, $query);
	$auction_type = mysqli_fetch_assoc($result);
	$auction_type_text = $auction_type['a_type_descr'];
	
	
	if($auction['finished'] == 1){
		$finished_text = 'Yes';
	}else{
		$finished_text = 'No';
	}
		
	// εμφάνιση των auction δεδομένων
	echo '<b>Auction</b><br>';
	echo "<table><tr><td>Name</td><td>". $auction['prod_serv_name'].'</td></tr>';
	echo "<tr><td>Description</td><td>".$auction['prod_serv_description'].'</td></tr>';
	echo "<tr><td>Type</td><td>".$auction_type_text.'</td></tr>';
	echo "<tr><td>Start price</td><td>".$auction['start_price'].'</td></tr>';
	echo "<tr><td>Step</td><td>".$auction['price_step'].'</td></tr>';
	echo "<tr><td>Start</td><td>".$auction['start_datetime'].'</td></tr>';
	echo "<tr><td>End</td><td>".$auction['end_datetime'].'</td></tr>';
	echo "<tr><td>Finished</td><td>".$finished_text.'</td></tr>';
	echo "<tr><td>Extension</td><td>".$auction['last_extension'].'</td></tr>';
	echo "<tr><td>Max. Ext.</td><td>".$auction['max_extensions'].'</td></tr>';
	echo "<tr><td>Crucial time</td><td>".$auction['crucial_time'].'</td></tr>';
	echo '</table>';
	echo '<br><br>';

	// λίστα των  bids
	echo '<b>Bids</b><br>';
	echo '<table>';
	echo "<tr><th>ID</th><th>Username</th><th>Time</th><th>Amount</th><th>Status</th></tr>";

	$query = "SELECT * FROM bids, users, bid_status WHERE whoDoes=users.user_id AND bids.status=bid_status.b_status_id AND auction=".$auction_id." ORDER BY bids.bid_id DESC";
	$result = mysqli_query($con, $query);
	while($bid = mysqli_fetch_assoc($result)){
		echo "<tr><td>".$bid['bid_id']."</td><td>".$bid['username']."</td><td>".$bid['when_datetime']."</td>
		<td>".$bid['amount']."</td><td>".$bid['b_status_descr']."</td></tr>";
	}
	echo '</table>';
	

	include('footer.php');
?>