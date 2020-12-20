<?php
// connect to mysqli
$db_hostname = 'localhost';
$db_user = 'root';
$db_passwd = 'P@ssw0rd';
$db = mysqli_connect($db_hostname, $db_user, $db_passwd) or
    die ('Unable to connect. Check your connection parameters.');


//make sure you're using the correct database
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));



// insert data into the movietype table
$query = 'INSERT INTO movietype 
    VALUES 
        (NULL,"Bollywod"),
        (NULL, "Hollywod"), 
        (NULL, "Adults")';
mysqli_query($db,$query) or die(mysqli_error($db));

// insert data into the people table
$query  = 'INSERT INTO people
    VALUES
        (NULL, "Leonardo Di Caprio", 1, 0),
        (NULL, "Shah Rukh Khan", 1, 0),
        (NULL, "Drew Barrymore", 1, 0)';
mysqli_query($db,$query) or die(mysqli_error($db));

// insert data into the movie table
$query = 'INSERT INTO movie
    VALUES
        (NULL, "Titanic", 10, 1997, 7, 2),
        (NULL, "Dilwale Dulhania Le Jayenge", 9, 1995, 8, 6),
        (NULL, "Scream", 9, 1996, 9, 3)';
mysqli_query($db,$query) or die(mysqli_error($db));

echo 'Update data successfully!';
?>
