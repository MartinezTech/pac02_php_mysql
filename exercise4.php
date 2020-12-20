<!DOCTYPE html>

<?php
// BEGIN CONNECTION WITH DATABASE
$db_hostname = 'localhost';
$db_user = 'root';
$db_passwd = 'P@ssw0rd';
$db = mysqli_connect($db_hostname, $db_user, $db_passwd) or
    die ('Unable to connect. Check your connection parameters.');
//make sure you're using the correct database
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));
// DATABASE CONNECTION SUCCESSFUL

//BEGIN SQL PAGINATION
$noRegistros = 2; //Registros por página
$pagina = 1; //Por defecto pagina = 1
if($_GET['pagina'])
    $pagina = $_GET['pagina']; //Si hay pagina, lo asigna
$buskr=$_GET['searchs']; //Palabra a buscar
//END SQL PAGINATION CODE
?> 
<html lang="en">
<head>
  <title>Exercise 4</title>
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
    <thead>
      <tr>
        <th>ID</th>
        <th>Movie</th>
        <th>Movietype</th>
        <th>Year</th>
        <th>Actor</th>
        <th>Director</th>
      </tr>
    </thead>
    
    <?php
    // DO QUERY TO DATABASE
    $query  = "SELECT m.movie_id, m.movie_name movie, mt.movietype_label movietype, m.movie_year year, a.people_fullname actor, b.people_fullname director
    FROM movie m 
    LEFT JOIN people a ON m.movie_leadactor = a.people_id
    LEFT JOIN people b ON m.movie_director = b.people_id
    LEFT JOIN movietype mt ON m.movie_type = mt.movietype_id
    WHERE
    m.movie_leadactor = a.people_id AND 
    m.movie_director = b.people_id AND
    m.movie_type = mt.movietype_id
    ORDER BY m.movie_id
    LIMIT ".($pagina-1)*$noRegistros.",$noRegistros";
    $query_result = mysqli_query($db, $query) or die(mysqli_error($db));
    //QUERY DATABASE DONE

    //SHOW ROWS DATABASE
    while ($row = mysqli_fetch_assoc($query_result)) {
        extract($row);
        echo '<tr><td> '. $movie_id .'</td><td>' . $movie . '</td><td>'. $movietype .'</td><td>'. $year .'</td><td>' . $actor . '</td><td>'. $director . '</td></tr>';
    }
    //ROWS DISPLAYED


    //COUNT PAGES
    $sSQL = "SELECT count(*) FROM movie WHERE movie_name LIKE '%$buskr%'"; //Cuento el total de registros
    $result = mysqli_query($db,$sSQL);
    $row = mysqli_fetch_array($result);
    $totalRegistros = $row["count(*)"]; //Almaceno el total en una variable

    $noPaginas = $totalRegistros/$noRegistros; //Determino la cantidad de paginas
    //PAGES COUNTED

    //SHOW BOTTOM NAVIGATION PAGES
    ?>
    <tr>
        <td colspan="3" align="center"><?php echo "<strong>Total registros: </strong>". $totalRegistros; ?> </td>
        <td colspan="3" align="center"><?php echo "<strong>Pagina: </strong>".$pagina; ?></td>
    </tr>
    <tr bgcolor="f3f4f1">
    <td colspan="6" align="right"><strong>Pagina:
    <?php
    for($i=1; $i<$noPaginas+1; $i++) { //Imprimo las paginas
        if($i == $pagina)
            echo "<font color=red> $i </font>"; //A la pagina actual no le pongo link
        else
            echo "<a href=\"?pagina=".$i."&searchs=".$buskr."\" style=color:#000;> ".$i."</a>";
    }
    //PAGINATION FINISH HERE
    ?>
    </strong></td>
    </tr>
  </table>
</div>

</body>
</html>