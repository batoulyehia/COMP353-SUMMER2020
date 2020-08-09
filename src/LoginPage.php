<?php require 'DatabaseConnection.php'; ?>

<?php
  $Valid1 = $Valid2 = "";
  $ErrorEmail = $ErrorPassword = $ErrorMessage1 = $ErrorMessage2 = "";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];

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

    //Checks values from database
    if (!empty($Valid1) and !empty($Valid2)){
      $stmt = $conn->prepare("SELECT * 
                              FROM user_account acc, administrator adm 
                              WHERE (acc.email = :valid1 AND acc.password = :valid2) OR (adm.email = :valid1 AND adm.password = :valid2)");
      $stmt->bindParam(':valid1', $Valid1);
      $stmt->bindParam(':valid2', $Valid2);
      $stmt->execute();

      $isAdmin = $isEmployer = $isEmployee = false;

      //checks for admin 
      $checkAdmin = $conn->prepare("SELECT adm.email FROM administrator adm WHERE adm.email = :valid1");
      $checkAdmin->bindParam(':valid1', $Valid1);
      $checkAdmin->execute();
      if($checkAdmin->fetch()){
        $isAdmin = true;
      }

      //checks for employer
      $checkEmployer = $conn->prepare("SELECT e.user_ID FROM employer e LEFT JOIN user_account acc ON acc.user_ID = e.user_ID WHERE acc.email = :valid1 AND e.user_ID IS NOT NULL");
      $checkEmployer->bindParam(':valid1', $Valid1);
      $checkEmployer->execute();
      if($checkEmployer->fetch()){
        $isEmployer = true;
      }

      //checks for employee
      $checkEmployee = $conn->prepare("SELECT e.user_ID FROM employee e LEFT JOIN user_account acc ON acc.user_ID = e.user_ID WHERE acc.email = :valid1 AND e.user_ID IS NOT NULL");
      $checkEmployee->bindParam(':valid1', $Valid1);
      $checkEmployee->execute();
      if($checkEmployee->fetch()){
        $isEmployee = true;
      }

      if ($stmt->fetch()) {
        session_start();
        $_SESSION["user_email"] = $Valid1;
        if($isEmployer){
          header("Location: ../employer/home.php");
        }
        elseif($isAdmin){
          header("Location: ../admin/home-page.php"); //need to change location, this is currently for testing
        }
        elseif($isEmployee){
          header("Location: ../employer/job-description.php"); //need to change location
        }
        else{
          header("Location: ../LoginPage.php");
        }

      }
      else{
        $ErrorMessage1 = " Please try again."; 
        $ErrorMessage2 = " Please try again.";
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
              <span class="error"><?php echo $ErrorPassword, $ErrorMessage2;?></span>
              <input type="password" placeholder="Password" name="Password" />
              <input class="button" type="submit" name="submit" value="Login" />
              <p class="message">Not registered? <a href="CreatePage.php">Create an account</a></p>
              <p class="message"><a href="RecoveryPage.php">Forgot password?</a></p>
            </form>
          </div>
        </div>
      </body>
  </html>

<?php require 'DatabaseDisconnection.php'; ?>