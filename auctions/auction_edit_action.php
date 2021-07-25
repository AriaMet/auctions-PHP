<?php 

	include('header.php');

	if(isset($_POST['cancel'])){	// αν πατήθηκε το κουμπί cancel
		$query = "UPDATE auctions SET finished=2 WHERE auction_id=".$_POST['auction_id'];
		mysqli_query($con, $query);
	}

	if(isset($_POST['finish'])){
		$query = "UPDATE auctions SET finished=1 WHERE auction_id=".$_POST['auction_id'];
		mysqli_query($con, $query);
		// εισαγωγή στο knockdown
		// λήψη τελευταίου έγκυρου bid
		$query = "SELECT bid_id, amount FROM bids WHERE status=0 AND auction=".$_POST['auction_id']." ORDER BY bid_id DESC LIMIT 1";
		$result = mysqli_query($con, $query);
		$bid = mysqli_fetch_array($result);
		
		$fee = 0.05*$bid['amount'];
		
		$query = "INSERT INTO knockdown (bid_id, isDelivered, IsPaidByBuyer, IsPaidBySeller, ProviderFees, IsFeesPaid) 
		VALUES (".$bid['bid_id'].",0,0,0,".$fee.",0)";

		mysqli_query($con, $query);
	}
	
	header('Location: auction_edit.php?auction_id='.$_POST['auction_id']); // επιστροφή στη σελίδα auction edit

	include('footer.php');

?>