<?php
/* Database connection start */
$servername = "67.222.16.110";
$username = "leaderbo_lbuser";
$password = "lM{JK9[crSf[";
$dbname = "leaderbo_db2018";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>