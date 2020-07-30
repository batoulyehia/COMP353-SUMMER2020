<?php
        $servername = "localhost";
        $username = "root";
        $password = "";                                                      //put your mysql server password to connect [and this is password with small p]
        $dbname = "login";                                                             // whatever you do make sure you create a database named login and table named UserInfo
        $Password = "";
        $ErrorPass = "";
        $Email = "";
        $ErrorEmail = "";
        $Valid1 = "";
        $Valid2 = "";
        $ErrorMessage1 = "";
        $ErrorMessage2 = "";


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";                                   // use only as print to make sure connection is made successfully, to be commented out on final version

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

          $sql = "SELECT * FROM UserInfo WHERE Email='$Valid1' AND Password = '$Valid2'";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0){
          	  session_start();
              $_SESSION["Flag"] = "Works!";
              header("Location: profilePage.php");
          }                                                     // to enter website once login is successfull

            else{
              $ErrorMessage1 = " Please try again."; 
              $ErrorMessage2 = " Please try again.";
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
              <input class="button" type="submit" name="submit" value="Login" />
              <p class="message">Not registered? <a href="CreatePage.php">Create an account</a></p>             <!-- Need to make html page for creation of user account/-->


                <?php
                  $conn->close();                                                                               //at the end of program end connection to mysql database server
                ?>
            </form>
          </div>
        </div>
      </body>
  </html>
