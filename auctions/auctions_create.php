<?php 
	include('header.php');
	
	if(!isset($_SESSION['active']) || ($_SESSION['active']!=1)){
		// αν ο user δεν είναι ενεργός, εμφανίζεται μήνυμα σφάλματος και δεν εκτελειται ο υπόλοιπος κώδικας
		echo "You have no rights to see this page!";
		include('footer.php');
		exit(0);
	}
	
?>
<script>
function validateForm() {	// Έλεγχος δεδομένων που εισάγει ο χρήστης στη φόρμα auctions_create
  var formname='auctions_create';
  // τα πεδία που θα ελεγχθούν αν είναι κενά
  var fields = ["name", "start_price", "start_time", "main_duration"]; 

  for(var i = 0; i < fields.length; i++){
	var field = fields[i];
	if (document.forms[formname][field].value == "") {
    alert("Field " + field + " must be filled out");
    return false;
	}  
  }
	    
  return true;
} 
//Ακολουθεί η φόρμα auctions_create όπου ο χρήστης συμπλήνει τα πεδία. Στη συνέχεια γίνονται έλεγχοι αν τα πεδία είναι συμπληρωμένα.
</script>

<form name="auctions_create" action="auctions_create_action.php" onsubmit="return validateForm()" method="POST">
	<table>
		<tr>
			<td>Name</td>		 
			<td><input type="text" name="name" ></td>
		</tr>
		<tr>
			<td>Description</td> 
			<td><textarea name="prod_serv_description" ></textarea></td>
		</tr>
		<tr>
			<td>Type</td>		
			<td>
				<input type="radio" name="type" value="1" checked /> Max. Price<br>
				<input type="radio" name="type" value="2" /> Min. Price
			</td>
		</tr>
		<tr>
			<td>Start Price</td> 
			<td><input type="text" name="start_price" /></td>
		</tr>
		<tr>
			<td>Price Step</td>	
			<td><input type="text" name="price_step" value="0" /></td>
		</tr>			
		<tr>
			<td>Start date</td>	
			<td><input type="date" name="start_date" value="<?php echo date("Y-m-d");?>" /></td>
		</tr>
		<tr>
			<td>Start time (HH:mm:ss)</td> 
			<td><input type="text" name="start_time" value="12:00:00" /></td>
		</tr>			
		<tr>
			<td>Duration (HH:mm:ss)</td>	
			<td><input type="text" name="main_duration" value="1:00:00" /></td>
		</tr>
		<tr>
			<td>Allow Extensnions</td>		
			<td>
				<input type="radio" name="allow_extensions" value="0" checked /> No<br>
				<input type="radio" name="allow_extensions" value="1" /> Yes
			</td>
		</tr>
		<tr>
			<td>Max. Extensions</td>		
			<td><input type="text" name="max_extensions" value="0" /></td>
		</tr>
		<tr>
			<td>Extensions Duration (HH:mm:ss)</td> 
			<td><input type="text" name="extension_duration" value="00:10:00" /></td>
		</tr>
		<tr>
			<td>Crucial time (HH:mm:ss)</td>		
			<td><input type="text" name="crucial_time" value="00:01:00" /></td>
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