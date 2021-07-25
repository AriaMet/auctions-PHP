<?php 
	include('header.php');
	
	// φορτωνει τα auction_types
	$query = "SELECT * FROM auction_types";
	$result = mysqli_query($con, $query);
	$auction_types = [];
	while($row = mysqli_fetch_assoc($result)){
		$auction_types[$row['a_type_id']] = $row['a_type_descr'];
	}
	
	?>
	
	<b>Auctions List</b>
	<table>
	<tr><th>ID</th><th>Name</th><th>Type</th><th>Start</th><th>Duration</th><th>Finished</th><th>Price</th><th>Step</th><th>Ext.</th><th>Max. Ext.</th><th>Ext. Dur.</th><th>Crucial</th><?php if(isset($_SESSION['isProvider']))echo '<th>Edit</th>';?></tr>
	<?php
	// φορτωνει τα auctions από τη βάση 
	$query = "SELECT * FROM auctions";
	if(!isset($_SESSION['isProvider'])){
		//για τους users κρύβεται το finished
		$query = $query." WHERE finished=0";
	}
	$result = mysqli_query($con, $query);
	
	while($auction = mysqli_fetch_assoc($result)){
		$finished = 'No';
		if($auction['finished']){
			$finished = 'Yes';
		}
		$type = $auction_types[$auction['type']]; 
		echo "<tr><td>".$auction['auction_id']."</td><td><a href='auction_details.php?auction_id=".$auction['auction_id']."'>".$auction['prod_serv_name']."</a></td>"; 
		echo "<td>".$type."</td><td>".$auction['start_datetime']."</td><td>".$auction['main_duration']."</td><td>$finished</td><td>".$auction['start_price']."</td><td>".$auction['price_step']."</td>";
		echo "<td>".$auction['last_extension']."</td><td>".$auction['max_extensions']."</td><td>".$auction['extension_duration']."</td><td>".$auction['crucial_time']."</td>";
		
		if(isset($_SESSION['isProvider'])){
			// αν ο χρήστης είναι Provider ή Moderator
			echo "<td><a href='auction_edit.php?auction_id=".$auction['auction_id']."'>Edit</a></td>";
		}
		echo "</tr>";
	}
	echo '</table>';
	

	include('footer.php');

?>