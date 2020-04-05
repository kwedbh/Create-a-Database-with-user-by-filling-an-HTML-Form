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


function password($length = 13) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $db = new mysqli ("localhost","root","","INFORMATION_SCHEMA");

   $db_name = str_replace(' ', '', $_POST['db_name']);
   $db_password = $_POST['db_password'];

  
  $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA "; 
  $sql .= "WHERE SCHEMA_NAME = '".$db->escape_string($db_name)."' ";
  $db_result = $db->query($sql);

  if ($db_result->num_rows < 1) {
    // print "No Database Found";
    $sql = "CREATE DATABASE ".$db->escape_string($db_name)." ";
    $create_db = $db->query($sql);

    if ($create_db) {

      // print htmlspecialchars($db_name)." Created Successfully";

      //Select Database
        $db -> select_db($db_name);      

        $select_db = $db -> query("SELECT DATABASE()");

        if ($select_db) {
        $row = $select_db -> fetch_row();
        // echo "Default database is " . $row[0]."<br>";
        $select_db -> close();

        $sql  = "GRANT ALL PRIVILEGES ON *.* TO '".$db->escape_string($db_name)."'@'localhost' IDENTIFIED BY '".$db->escape_string($db_password)."' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
        $db->query($sql); 

        }




    }else{
      if (!$db -> connect_errno) {
      echo "Failed : " . $db -> error;
      exit();
}
    }

  }else{
    print "
    <br><br>
    <h1 class='text-danger text-center'>Database with the name ". htmlspecialchars($db_name)." already exist </h1>";
  }
}else{
  $db_name = "";
  $db_password = "";
}





?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Create Database</title>
  </head>
  <body>

    <div class="container">
      <br><br><br>
  <div class="text-center">
    <h1 class="text-danger">Create a database!</h1>
    <p class="text-info">Note: This will also create a user for you with the database name.</p>
    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

          <div class="row">
            <div class="col-sm-6">
              <label>Database Name</label>
              <input required type="text" class="form-control" placeholder="Database Name" name="db_name">
            </div>
            <div class="col-sm-6">
              <label>Password</label>
              <input required type="text" class="form-control" value="<?php print password() ?>" readonly name="db_password">
            </div>
          </div>
          <br><br>
          <button class="btn btn-danger" type="submit">Create</button>


    </form>  <br><br>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
      <?php if ($db_result->num_rows < 1): ?>
      <h1 class="text-danger">
    Database has been set up successfully <br><br>
    Database Name: <?php print htmlspecialchars($db_name)."<br>"; ?> 
    Database User: <?php print htmlspecialchars($db_name)."<br>"; ?> 
    Database Password: <?php print htmlspecialchars($db_password)."<br>"; ?> 
      </h1>        
      <?php endif; ?>
<?php endif ?>

<br><br><br><br><br><br><br><br><br>

<h4 class="text-danger">NB: If you ever change your root password, edit line 34 to your new password</h4>
  </div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>