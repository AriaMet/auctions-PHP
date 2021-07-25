<?php	
session_start();

include('db.php'); // σύνδεση με τη βάση 

date_default_timezone_set('Europe/Athens'); // για την λειτουργία ημερομηνίας

// Ακολουθεί το μενού με τις επιλογές που δίνονται στον χρήστη 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">    
    <title>e-Auctions</title>
	<link href="style.css" rel="stylesheet" type="text/css" /> 
</head>



<body>
		<div id="header">
			<h1>e-Auctions</h1>
			<div id="menu">  
				<a href="auctions.php">Auctions</a>
				<?php
				if(isset($_SESSION['isProvider'])){ 	
				// σε περίπτωση που είναι ο provider θα δίνεται η επιλογή users και logout
				?>
					<a href="users.php">Users</a>
					<a href="logout.php">Logout</a>
				<?php 
				}elseif(isset($_SESSION['active']) && ($_SESSION['active'] == 0)){
				// σε περίπτωση που είναι user ο οποίος δεν έχει ενεργοποιηθεί τοτε εχει μόνο την επιλογή logout
				?>
					<a href="logout.php">Logout</a>	
				<?php
				}elseif(isset($_SESSION['active']) && ($_SESSION['active'] == 1)){
				// σε περίπτωση που είναι ενεργός user τοτε έχει τις επιλογές δημιουργίας δημοπρασίας και logout
				?>
					<a href="auctions_create.php">New Auction</a>
					<a href="logout.php">Logout</a>
				<?php
				}else{
				// αν δεν είναι κάτι από τα παραπάνω τότε μπορεί να κάνει login ή register
				?>
					<a href="login.php">Login</a>
					<a href="register.php">Register</a>
				<?php
				}
				?>
			</div>
		</div>	
		
		<div id="main">
	  <br />