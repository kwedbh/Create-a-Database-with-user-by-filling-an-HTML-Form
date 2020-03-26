<?php

/*


AUTHOR:     WILLIAMS KINGSLEY (KWED)
FACEBOOK:   https://web.facebook.com/kwedbh/
TWITTER:    https://twitter.com/Kwedbh/
INSTAGRAM:  https://www.instagram.com/kwedbh1
EMAIL:      kwedng@gmail.com / kingsleywilliamsdaniel@gmail.com / kwedng@outlook.com
PHONE:      +2348106164751 / +2349078728644
WEBSITE:    https://www.kwed.website/


This can we use for both POST and GET request in php.


*/



// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $db = new mysqli ("localhost","root","","INFORMATION_SCHEMA");

  $db_name =  'database name';
  // $db_name = $_POST['db_name'] ?? '';
  
  $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA "; 
  $sql .= "WHERE SCHEMA_NAME = '".$db_name."' ";
  $db_result = $db->query($sql);

  if ($db_result->num_rows < 1) {
    // print "No Database Found";
    $sql = "CREATE DATABASE ".$db->escape_string($db_name)." ";
    $create_db = $db->query($sql);

    if ($create_db) {

      print htmlspecialchars($db_name)." Created Successfully";

      //Do something Else eg. like adding of tables.

    }else{
      if (!$db -> connect_errno) {
      echo "Failed : " . $db -> error;
      exit();
}
    }

  }else{
    print htmlspecialchars($db_name)." Found";
  }
// }


