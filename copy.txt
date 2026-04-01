<?php
//  MENYAMBUNGKAN FAIL PHP KEPADA PANGKALAN DATA
$pangkalan_data = "VOTE4LEADER";
$condb = mysqli_connect( 'localhost', 'root', '');
mysqli_select_db($condb, $pangkalan_data);
?>