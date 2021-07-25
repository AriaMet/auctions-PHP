<?php 
	include('header.php');

	$auction_id = $_POST['auction_id'];
	$amount = $_POST['amount'];
	
	// φορτώνει τα δεδομένα απο auction και υπολογίζει το end_datetime και crucial_start_datetime χρημισοποιώντας  SQL ADDTIME, SUBTIME functions
	$query = "SELECT *, 
	ADDTIME(start_datetime, main_duration + last_extension*extension_duration) as end_datetime, 
	SUBTIME(ADDTIME(start_datetime, main_duration + last_extension*extension_duration),crucial_time) as crucial_start_datetime	
	FROM auctions WHERE auction_id=".$auction_id;
	$res = mysqli_query($con, $query);
	$auction = mysqli_fetch_assoc($res);
	
	
	$when = date("Y-m-d H:i:s");
	
	$status = 0; 
	
	//check: εύρεση διαφοράς με το προηγούμενο bid
	if($auction['type']==1){ //αν το auction type είναι max. price
		$query = "SELECT max(amount) as max_bid FROM bids WHERE status=0 AND auction=".$auction_id;
		$result = mysqli_query($con, $query);
		$data = mysqli_fetch_assoc($result);
		if(empty($data)){ 
			$previous_price = $auction['start_price'];
		}else{
			$previous_price = $data['max_bid'];
		}
		$extra_amount = $amount - $previous_price;
	}else{ // αν το auction type είναι min. price
		$query = "SELECT min(amount) as min_bid FROM bids WHERE status=0 AND auction=".$auction_id;
		$result = mysqli_query($con, $query);
		$data = mysqli_fetch_assoc($result);
		if(empty($data)){ 
			$previous_price = $auction['start_price'];
		}else{
			$previous_price = $data['min_bid'];
		}
		$extra_amount = $previous_price - $amount ;
	}
	
	//check: αν είναι μεγαλύτερο ή μικρότερο από το τελεύταιο bid
	if($extra_amount <= 0){
		$status = 1; //step violation
	}
	//check: αν υπάρχει price step και το extra_amount = n*step, όπου n θετικός ακέραιος
	if(($auction['price_step']>0) && ($extra_amount % $auction['price_step'] != 0)){
		$status = 1; //step violation
	}

	//check: μετά την έναρξη του auction
	if($auction['start_datetime'] > $when){
		$status = 2;
	}
	//check: πριν την έναρξη του auction
	if($when > $auction['end_datetime']){
		$status = 2;
	}
	//check: αν το auction ειναι finished/ακυρωμένο
	if($auction['finished']){
		$status = 2;
	}

	// αποθήκευση του bid
	$query = "INSERT INTO bids (whoDoes, auction, when_datetime, amount, status) 
	VALUES (".$_SESSION['user_id'].", ".$auction_id.", '".$when."', ".$amount.", ".$status.")";
	mysqli_query($con, $query);

	
	//check: αν το auction θα πάρει παράταση
	if($auction['allow_extensions'] && ($auction['last_extension'] < $auction['max_extensions'])){
		//check: αν είναι μέσα στο crucial time
		if(($when < $auction['end_datetime']) && ($when > $auction['crucial_start_datetime'])){
			$query = "UPDATE auctions SET last_extension=last_extension+1 WHERE auction_id=".$auction_id;
			mysqli_query($con, $query);
		}
	}
	
	//check: αν είναι finished
	if($when > $auction['end_datetime']){
		
		$query = "UPDATE auctions SET finished=1 WHERE auction_id=".$auction['auction_id'];
		mysqli_query($con, $query);

		// λήψη τελευταίου έγκυρου bid
		$query = "SELECT bid_id, amount FROM bids WHERE status=0 AND auction=".$auction['auction_id']." ORDER BY bid_id DESC LIMIT 1";
		$result = mysqli_query($con, $query);
		$bid = mysqli_fetch_array($result);
		
		// υπολογισμός του fee 5%
		$fee = 0.05 * $bid['amount'];
		
		// εισαγωγή στο knockdown 
		$query = "INSERT INTO knockdown (bid_id, isDelivered, IsPaidByBuyer, IsPaidBySeller, ProviderFees, IsFeesPaid) 
		VALUES (".$bid['bid_id'].",0,0,0,".$fee.",0)";
		mysqli_query($con, $query);
	}		

	header('Location: auction_details.php?auction_id='.$_POST['auction_id']); // επιστροφή στη σελίδα auction details
	

	include('footer.php');
?>