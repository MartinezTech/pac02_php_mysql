<!DOCTYPE html>
<?php
// connect to mysqli
$db_hostname = 'localhost';
$db_user = 'root';
$db_passwd = 'P@ssw0rd';
$db = mysqli_connect($db_hostname, $db_user, $db_passwd) or
    die ('Unable to connect. Check your connection parameters.');


//make sure you're using the correct database
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));

// select movies with each leadactor and director
$query  = 'SELECT m.movie_id id, m.movie_name, a.people_fullname actor, b.people_fullname director
FROM movie m 
LEFT JOIN people a ON m.movie_leadactor = a.people_id
LEFT JOIN people b ON m.movie_director = b.people_id
WHERE
m.movie_leadactor = a.people_id AND 
m.movie_director = b.people_id
ORDER BY movie_leadactor;';
$result = mysqli_query($db,$query) or die(mysqli_error($db));
?>
<html lang="en">
<head>
  <title>Exercise 3</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2 class="text-center">Query results:</h2>
         
  <table class="table">
  <?php
  while ($row = mysqli_fetch_assoc($result)) {
	extract($row);
	echo '<tr><td>'. $id .'</td><td>' . $movie_name . '</td><td>' . $actor . '</td><td>'. $director . '</td></tr>';
	}
   ?> 
  </table>
</div>

</body>
</html>

