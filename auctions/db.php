<?php

// Σύνδεση με την βάση

$con = mysqli_connect('localhost', 'root', '', 'auctions');
if (!$con) {
    echo "Failed to connect to MySQL!";
}

?>