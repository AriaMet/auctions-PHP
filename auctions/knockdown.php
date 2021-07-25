<?php 

	include('header.php');
	
	if(!isset($_SESSION['isProvider']) && $_SESSION['isProvider']!=1){
		// αν ο χρήστης δεν είναι o Provider , τότε εφανίζεται μήνυμα σφάλματος και δεν εκτελείται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}
	
	//φορτώνει την πληρωμή 
	$auction_id = $_GET['auction_id'];
	$query = "SELECT * FROM knockdown JOIN bids ON knockdown.bid_id=bids.bid_id WHERE auction=$auction_id";
	$res = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($res);
		
	//Ακολουθεί η φόρμα knockdown όπου o provider διαλεγει με yes ή no στις επιλογές που του δίνονται
?>

<b>Knockdown data</b>
	<form action="knockdown_action.php" method="post">
		<input type='hidden' name='auction_id' value='<?php echo $auction_id;?>'>
		<input type='hidden' name='bid_id' value='<?php echo $row['bid_id'];?>'>
		<table>
			<tr>
				<td>Fee</td>			
				<td><?php echo $row['ProviderFees'];?>€</td>
			</tr>
			<tr>
				<td>Delivered</td>		
				<td>
					<input type="radio" name="IsDelivered" value="0" <?php if(!$row['IsDelivered']){echo 'checked';}?> /> No <br>
					<input type="radio" name="IsDelivered" value="1" <?php if($row['IsDelivered']){echo 'checked';}?> /> Yes
				</td>
			</tr>
			<tr>
				<td>Paid By Buyer</td>	
				<td>
					<input type="radio" name="IsPaidByBuyer" value="0" <?php if(!$row['IsPaidByBuyer']){echo 'checked';}?> /> No <br>
					<input type="radio" name="IsPaidByBuyer" value="1" <?php if($row['IsPaidByBuyer']){echo 'checked';}?> /> Yes
				</td>
			</tr>
			<tr>
				<td>Paid By Seller</td>	
				<td>
					<input type="radio" name="IsPaidBySeller" value="0" <?php if(!$row['IsPaidBySeller']){echo 'checked';}?> /> No <br>
					<input type="radio" name="IsPaidBySeller" value="1" <?php if($row['IsPaidBySeller']){echo 'checked';}?> /> Yes
				</td>
			</tr>
			<tr>
				<td>Fees Paid</td>		
				<td>
					<input type="radio" name="IsFeesPaid" value="0" <?php if(!$row['IsFeesPaid']){echo 'checked';}?> /> No <br>
					<input type="radio" name="IsFeesPaid" value="1" <?php if($row['IsFeesPaid']){echo 'checked';}?> /> Yes
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Submit" /></td> 
			</tr>
		</table>
	</form>

<?php
	include('footer.php');
?>