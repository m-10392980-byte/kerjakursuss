<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
session_destroy();
header("Location: index.php");
exit();
?>