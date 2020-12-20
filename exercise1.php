<?php
// connect to mysqli
$db_hostname = 'localhost';
$db_user = 'root';
$db_passwd = 'P@ssw0rd';
$db = mysqli_connect($db_hostname, $db_user, $db_passwd) or
    die ('Unable to connect. Check your connection parameters.');


//make sure you're using the correct database
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));

$query = 'ALTER TABLE `movie` ADD CONSTRAINT `FK_actorid` FOREIGN KEY (`movie_leadactor`) REFERENCES `people` (`people_id`) ON DELETE CASCADE ON UPDATE CASCADE';
mysqli_query($db,$query) or die(mysqli_error($db));


echo 'Constraint created!';
?>