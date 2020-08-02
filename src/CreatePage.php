<?php require 'DatabaseConnection.php'; ?>

<?php
        $Password = "";
        $ErrorPass = "";
        $Email = "";
        $ErrorEmail = "";
        $Valid1 = "";
        $Valid2 = "";
        $ErrorMessage1 = "";
        $ErrorMessage2 = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST"){

          if (empty($_POST["Email"])){
            $ErrorEmail = "Email is required.";
          }
          else {
            $Email = $_POST["Email"];
              if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                $ErrorEmail = "Invalid Email format."; 
              }
              else{
                $Valid1 = $Email;
              }
          }

          if (empty($_POST["Password"])){
            $ErrorPass = "Password is required.";
          }
          else{
            $Password = $_POST["Password"];
              if (!preg_match("/(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*(){\|}~_']*$/",$Password)){   //kept same password requirements as assignment
                $ErrorPass = "Invalid Password format.";
              }  
              else {
                $Valid2 = $Password;
              }
          }

            if (!(isset($Valid1)) and  !(isset($Valid2))){                                                         // to enter website once login is successfull
              $ErrorMessage1 = " Please try again."; 
              $ErrorMessage2 = " Please try again.";
            }
                   
                if (!empty($Valid1) and !empty($Valid2)){
                 $sql = "INSERT INTO UserInfo (Email, Password)
                  VALUES ('$Valid1','$Valid2')";              //php code to be added from account creation html page

                  if ($conn->query($sql) === TRUE) {
                      echo "New record created successfully";            // use only as print to make sure connection is made successfully, to be commented out on final version
                  } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;    // use only as print to make sure connection is made successfully, to be commented out on final version
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
        <link rel="stylesheet" href="loginStyle.css">
        <style>
        .error {color: #FF0000;}
        </style>
      </head>
      <body >
        <div class="login-page">
          <div class="form">
            <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <span class="error"><?php echo $ErrorEmail, $ErrorMessage1;?></span>
              <input type="Email" placeholder="Email" name="Email" />
              <span class="error"><?php echo $ErrorPass, $ErrorMessage2;?></span>
              <input type="Password" placeholder="Password" name="Password" />
              <input class="button" type="submit" name="submit" value="Create" />                         
            </form>
          </div>
        </div>
      </body>
  </html>

<?php require 'DatabaseDisconnection.php'; ?>