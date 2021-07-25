<?php
	include('header.php');
	
	//Ακολουθεί η φόρμα login όπου ο χρήστης συμπληρώνει username και password 
?>
 
	<form action="login_action.php" method="post">
		<table>
			<tr>
				<td>Username</td> 		
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td>Password:</td>		
				<td><input type="password" name="password" /></td>
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