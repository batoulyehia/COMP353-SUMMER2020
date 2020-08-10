<?php require 'DatabaseConnection.php'; ?>

<?php
  $Valid1 = $Valid2 = "";
  $ErrorEmail = $ErrorPassword = $ErrorMessage1 = $ErrorMessage2 = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];

    //Email verification
    if (empty($_POST["Email"])){
      $ErrorEmail = "Email is required.";
    }
    else {
      if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $ErrorEmail = "Invalid Email format."; 
      }
      else{
        $Valid1 = $Email;
      }
    }

    //Password verification
    if (empty($_POST["Password"])){
      $ErrorPassword = "Password is required.";
    }
    else{
      $Valid2 = $Password;
    }
   
    //Adds values to database
    if (!empty($Valid1) and !empty($Valid2)){
      $sql = "INSERT INTO user_account (email, password, first_name, last_name)
              VALUES ('$Valid1','$Valid2','$FirstName','$LastName');
              INSERT INTO suffering_account (sa_ID)
              SELECT user_ID
              FROM user_account
              WHERE email = '$Valid1' AND password = '$Valid2';
              UPDATE user_account
              SET sa_ID = user_ID
              WHERE email = '$Valid1' AND password = '$Valid2';
              INSERT INTO employee (user_ID)
              SELECT user_ID
              FROM user_account
              WHERE email = '$Valid1' AND password = '$Valid2';";

      try {
        $conn->exec($sql);
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      header("Location: LoginPage.php");
    }
  }
?>

<!DOCTYPE html>
  <html lang = "en">
      <head>
        <meta charset="utf-8"> 
        <title>Login</title>
        <link rel="stylesheet" href="LoginStyle.css">
        <style>
        .error {color: #FF0000;}
        </style>
      </head>
      <body >
        <div class="login-page">
          <div class="form">
            <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <span class="error"><?php echo $ErrorEmail, $ErrorMessage1;?></span>
              <input type="email" placeholder="Email" name="Email" />
              <span class="error"><?php echo $ErrorPassword, $ErrorMessage2;?></span>
              <input type="password" placeholder="Password" name="Password" />
              <input type="text" placeholder="First Name" name="FirstName" />
              <input type="text" placeholder="Last Name" name="LastName" />
              <input class="button" type="submit" name="submit" value="Create" />                         
            </form>
          </div>
        </div>
      </body>
  </html>

<?php require 'DatabaseDisconnection.php'; ?>