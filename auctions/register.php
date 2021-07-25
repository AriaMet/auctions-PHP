<?php
	include('header.php');
?>
<script>
function validateForm() { // έλεγχος δεδομένων που εισάγει ο χρήστης στη φόρμα register
  var formname = 'register';
  // τα πεδία που θα ελεγχθούν αν είναι κενά
  var fields = ["firstname", "lastname", "email", "username", "password"]; 

  for(var i = 0; i < fields.length; i++){
	var field = fields[i];
	if (document.forms[formname][field].value == "") {	// αν κάποιο πεδίο είναι κενό,τότε εμφανίζεται μήνυμα σφάλματος
    alert("Field " + field + " must be filled out");
    return false;
	}  
  }
	
  var email = document.forms[formname]["email"].value;
  var result = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);		// έλεγχος αν το email τηρεί τις προϋποθέσεις
  if (result == false)	// αν δεν είναι πληρεί τις προϋποθέσεις τότε εμφανίζεται μήνυμα σφάλματος
  {
    alert("You have entered an invalid email address!");
    return false;
  }
    
  return true;
} 
// Ακολουθεί η φόρμα register όπου ο χρήστης συμπληρώνει τα στοιχεία που ζητούνται. Στη συνέχεια γίνεται έλεγχος αν όλα τα πεδία είναι συμπληρωμένα και για την εγκυρότητα του email 
</script>

<form name="register" action="register_action.php"  onsubmit="return validateForm()"  method="POST">
	<table>
		<tr>
			<td>First Name:</td>		
			<td><input type="text" name="firstname" /></td>
		</tr>
		<tr>
			<td>Last Name:</td>			
			<td><input type="text" name="lastname" /></td>
		</tr>
		<tr>
			<td>Email:</td>				
			<td><input type="text" name="email" /></td>
		</tr>
		<tr>
			<td>Username:</td>			
			<td><input type="text" name="username" /></td>
		</tr>					<tr>
			<td>Password:</td>			
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td>Telephone:</td>			
			<td><input type="text" name="telephone" /></td>
		</tr>
		<tr>
			<td>Address:</td>			
			<td><input type="text" name="address" /></td>
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