<?php 

	include('header.php');

	if(!isset($_SESSION['isProvider'])){
		// αν ο χρήστης δεν είναι Provider Moderator, εμφανίζεται μήνυμα σφάλματος και δεν εκτελείται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}

	$auction_id = $_GET['auction_id'];
	
	// φορτώνει τα auction_types
	$query = "SELECT * FROM auction_types";
	$result = mysqli_query($con, $query);
	$auction_types = [];
	while($row = mysqli_fetch_assoc($result)){
		$auction_types[$row['a_type_id']] = $row['a_type_descr'];
	}
	
?>	
	
	<h3>Auctions</h3>
	<table class="mytable">
	<tr><th>#</th><th>Name</th><th>Type</th><th>Start</th><th>End</th><th>Finished</th><th>Price</th><th>Step</th><th>Allow Ext.</th><th>Ext.</th><th>Max Ext.</th><th>Actions</th></tr>
	<?php
	// φορτώνει τα auctions 
	$query = "SELECT *, ADDTIME(start_datetime, main_duration + last_extension*extension_duration) as end_time
	FROM auctions WHERE auction_id=$auction_id";
	$result = mysqli_query($con, $query);
	
	// εμφανιζει τα auctions
	while($auction = mysqli_fetch_assoc($result)){	
		$finished = 'No';
		if($auction['finished']){
			$finished = 'Yes';
		}		
		echo "<tr><td>".$auction['auction_id']."</td><td><a href='auction_details.php?auction_id=".$auction['auction_id']."'>".$auction['prod_serv_name']."</a></td><td>".$auction_types[$auction['type']]."</td>
		<td>".$auction['start_datetime']."</td><td>".$auction['end_time']."</td><td>".$finished."</td>
		<td>".$auction['start_price']."</td><td>".$auction['price_step']."</td>
		<td>".$auction['allow_extensions']."</td><td>".$auction['last_extension']."</td><td>".$auction['max_extensions']."</td><td>";
		
		if($auction['finished']==0){
			// αν το auction δεν ειναι finished
			$now = date("Y-m-d H:i:s");
			if($now > $auction['end_time']){
				// ο moderator μπορει να βάλει finished= Yes αν το τέλος χρόνου
				echo "<form action='auction_edit_action.php' method='post'>
				<input type='hidden' name='auction_id' value='".$auction['auction_id']."'>
				<input type='submit' name='finish' value='Finish'>
				</form>";
			}elseif($_SESSION['isProvider']==1){
				// ο provider μπορεί να ακυρώσει οποιαδήποτε στιγμή
				echo "<form action='auction_edit_action.php' method='post'>
				<input type='hidden' name='auction_id' value='".$auction['auction_id']."'>
				<input type='submit' name='cancel' value='Cancel'>
				</form>";
			}
		}elseif(($auction['finished']==1) && ($_SESSION['isProvider']==1)){
			// αν είναι finished και ο χρήστης είναι o provider, εμφανίζεται link για το payment
			echo " <a href='knockdown.php?auction_id=".$auction['auction_id']."'>Knockdown</a>";
		}
		echo "</td></tr>";
	}
	echo '</table>';
	

	include('footer.php');

?>