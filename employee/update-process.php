<?php
$hostname="localhost";
$username="root";
$password="";
$databaseName="final_test";
$connect= mysqli_connect($hostname,$username,$password,$databaseName);

        if(count($_POST)>0) {
        mysqli_query($connect,"UPDATE user_account set first_name='" . $_POST['first_name'] . "', last_name='" . $_POST['last_name'] . "', email='" . $_POST['email'] . "',password ='". $_POST['password']."' WHERE user_ID='" . $_POST['user_ID'] . "' "); 
        mysqli_query($connect," UPDATE employee set employee_membership_type='". $_POST['employee_membership_type'] . "'  "); 
        mysqli_query($connect," UPDATE payment_method set payment_type='". $_POST['payment_type'] . "'  "); 
        
     
        
        $message = "Record Modified Successfully";
        header("Location: Employee_homepage.php"); //change to login page
        }
        $result = mysqli_query($connect,"SELECT * FROM user_account ua,employee e,payment_method pm WHERE ua.user_ID='" . $_GET['user_ID'] . "' AND ua.user_ID=e.user_ID AND ua.user_ID=pm.user_ID" );
        // $result = mysqli_query($connect,"SELECT * FROM user_account ua, e employee WHERE user_ID='" . $_GET['user_ID'] . "' AND ua.user_ID=e.user_ID");
        $row= mysqli_fetch_array($result);
        ?>
<html>
<head>
<title>Update Employee Data</title>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Employee Homepage</title>
</head>
<body>
<div class='container'>
        <nav class="nav nav-pills nav-justified flex-row  bg-light">
            <a class="nav-link active" href="Employee_homepage.php">Home</a>
            <a class="nav-link" href="Employee_payment_method_settings.php">Payment Method Setting</a>
            <a class="nav-link" href="Employee_profile_settings.php">Profile Setting</a>
            
        </nav>
</div>
<form name="frmUser" method="post" action="">
<div><?php if(isset($message)) { echo $message; } ?>
</div>
<div style="padding-bottom:5px;">
<!-- <a href="retrieve.php">Employee List</a> -->
</div>
User ID: <br>
<input type="hidden" name="user_ID" class="txtField" value="<?php echo $row['user_ID']; ?>">
<input type="text" name="user_ID"  value="<?php echo $row['user_ID']; ?>" disabled>
<br>
First Name: <br>
<input type="text" name="first_name" class="txtField" value="<?php echo $row['first_name']; ?>">
<br>
Last Name :<br>
<input type="text" name="last_name" class="txtField" value="<?php echo $row['last_name']; ?>">
<br>
Email:<br>
<input type="text" name="email" class="txtField" value="<?php echo $row['email']; ?>">
<br>
Password:<br>
<input type="text" name="password" class="txtField" value="<?php echo $row['password']; ?>">
<br>

Membership Type:<br>
<input type="text" name="employee_membership_type" class="txtField" value="<?php echo $row['employee_membership_type']; ?>">
<br>

Payment Type:<br>
<input type="text" name="payment_type" class="txtField" value="<?php echo $row['payment_type']; ?>">
<br>

<input type="submit" name="submit" value="Submit"  class="buttom">


      

</form>
</body>
</html>