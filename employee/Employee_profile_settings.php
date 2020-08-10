<!DOCTYPE php>
<php lang="en">
<?php 
    require 'DatabaseConnection.php'; 
    session_start();

    

      $hostname="localhost";
      $username="root";
      $password="";
      $databaseName="login";
      $email= $_SESSION["user_email"];
      

         //user_account table
         $user_account= $conn->prepare("SELECT first_name,last_name,user_ID,email,status,balance from user_account acc WHERE email= :email");
         $user_account->bindParam(':email',$email);
         $user_account->execute();

         //get array
        $user_account_array=$user_account->fetchALL(PDO::FETCH_NUM);

        foreach($user_account_array as $component){
            $first_name=$component[0];
            $last_name=$component[1];
            $user_ID=$component[2];
            $email=$component[3];
            $status=$component[4];
            $balance=$component[5];
            // echo $user_ID;
            // echo $email;

        }
    
    
      $connect= mysqli_connect($hostname,$username,$password,$databaseName);
      $query="SELECT * FROM user_account ua ,employee e,payment_method pm WHERE ua.user_ID='$user_ID' AND ua.user_ID=e.user_ID AND ua.user_ID=pm.user_ID  " ;
      $result=mysqli_query($connect,$query);

     

    
    
?>



<head>
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
            <a class="nav-link  " href="Employee_homepage.php">Home</a>
            <a class="nav-link " href="Employee_payment_method_settings.php"">Payment Method Setting</a>
            <a class="nav-link active" href="Employee_profile_settings.php">Profile Setting</a>
            
        </nav>
    </div>

    <table>
            <tr>
            <td>First Name</td>
              <td></td>
            <td>Last Name</td>
              <td></td>
            <td>Email</td>
              <td></td>
            <td>Password</td>
              <td></td>
            <td>User ID</td>
              <td></td>
            <td>Membership Type</td>
              <td></td>
              <td></td>
            <td>Payment Type</td>
              <td></td>
            <td>Action</td>
              <td></td>
            </tr>
            <?php
       
            while($row = mysqli_fetch_array($result)) {
      
         
            ?>
            <tr >
            <td><?php echo $row["first_name"]; ?></td>
            <td></td>
            <td><?php echo $row["last_name"]; ?></td>
            <td></td>
            <td><?php echo $row["email"]; ?></td>
            <td></td>
            <td><?php echo $row["password"]; ?></td>
            <td></td>
            <td><?php echo $row["user_ID"]; ?></td>
            <td></td>
            <td><?php echo $row["employee_membership_type"]; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $row["payment_type"]; ?></td>
            <td></td>
            <td><a href="update-process.php?user_ID=<?php echo $row["user_ID"]; ?>">Update</a></td>
            <td></td>
            </tr>
            <?php
           
            return;
            }
            ?>
  </table>



    
  
 


   


   



    
</body>
</php>

