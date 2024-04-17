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

  $sqlCheck  = "SELECT * FROM customer WHERE name='$name' AND password='$password'";
  $result = $conn->query($sqlCheck);

  //flag 0 -> user already exists
  $flag = 1;
  if ($result && $result->num_rows > 0) {
   $flag = 0;
  }

  if ($flag == 1){
    $sql = "INSERT INTO `customer` (`name`, `password`) VALUES ('$name', '$password')";
    $sqlInsert = $conn->query($sql);
    if ($sqlInsert === TRUE) {
      echo ("1");
    }
  } else if ($flag == 0){
    echo("2");
  }

  $conn->close();

  // On 0, Android toasts "login failed"
  // On 1, user is authenticated/inserted, navigate to next page
  // on 2, Android toasts "user already exists"