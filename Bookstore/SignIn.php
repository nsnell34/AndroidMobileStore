<?php
  $username = "nicholas.s.snell@undcsmysql";
  $password = "nick5382";
  $database = "nicholas_s_snell";
  $host     = "undcsmysql.mysql.database.azure.com";
  $conn     = new mysqli( $host, $username, $password, $database );

  // Connect to the database.
  if ( $conn->connect_error )
    die( 'Could not connect: ' . $conn->connect_error );

  // Retrieve the Android input.
  $name  = $_GET['name'];
  $password = $_GET['pword'];

  // Compose and execute the query.
  $sql  = "SELECT * FROM customer WHERE name='$name' AND password='$password'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    echo("1"); 
  } else {
    echo("0"); 
  }
  // Close the connection.
  $conn->close( );
?>