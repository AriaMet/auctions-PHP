<?php

session_start();
session_unset();
session_destroy();		//τερματισμός session και redirect στη σελίδα index.php
header("Location: index.php"); 

?>