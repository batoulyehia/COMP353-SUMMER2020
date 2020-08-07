<?php require 'DatabaseConnection.php'; ?>

<?php
  $Valid1 = "";
  $ErrorEmail = $ErrorMessage1 = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $Email = $_POST["Email"];

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
   
    //Adds values to database
    if (!empty($Valid1)){
      $stmt = $conn->prepare("SELECT password
                              FROM user_account
                              WHERE email = :valid1");
      $stmt->bindParam(':valid1', $Valid1);
      $stmt->execute();
      $res = $stmt->fetchColumn();
      if ($res) {
        $msg = "Your password is: " . $res;
        $headers = "From: wxc353_1@encs.concordia.ca" . "\r\n" . "CC: wx_comp353_1@encs.concordia.ca";
        mail($Valid1,"Password Recovery",$msg, $headers);
        header("Location: LoginPage.php");
      }
      else{
        $ErrorMessage1 = " Please try again."; 
      }
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
              <input class="button" type="submit" name="submit" value="Recover" />                         
            </form>
          </div>
        </div>
      </body>
  </html>

<?php require 'DatabaseDisconnection.php'; ?>