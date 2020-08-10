<!DOCTYPE php>
<php lang="en">
<?php 
    require '../src/DatabaseConnection.php';    
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Employee Homepage</title>
</head>
<body>


    <?php 
        //retrive first name and last name
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

        }

         //employee table
         $employee=$conn->prepare("SELECT employee_membership_type from employee  WHERE user_ID=:current_ID");
         $employee->bindParam(':current_ID',$user_ID);
         $employee->execute();

         //get array
         $employee_array=$employee->fetchALL(PDO::FETCH_NUM);

         foreach($employee_array as $component){
             $employee_membership_type=$component[0];
         }

         //payment_method table
         $payment_method=$conn->prepare("SELECT payment_type from payment_method WHERE user_ID=:current_ID");
         $payment_method->bindParam(':current_ID',$user_ID);
         $payment_method->execute();


         //get array
         $payment_method_array=$payment_method->fetchALL(PDO::FETCH_NUM);

         foreach($payment_method_array as $component){
             $payment_type=$component[0];
         }
    
    ?>

    <div class='container'>
        <nav class="nav nav-pills nav-justified flex-row  bg-light">
            <a class="nav-link active" href="Employee_homepage.php">Home</a>
            <a class="nav-link" href="Employee_payment_method_settings.php">Payment Method Setting</a>
            <a class="nav-link" href="Employee_profile_settings.php">Profile Setting</a>
           
        </nav>
    </div>

    <div class='container'>
        <div class="card w-100 text-center">
            <div class="card-body">
              <p class="card-text display-5">User(Employee) Dashboard :)</p>
              <h5 class="card-title">Welcome,<?php echo $first_name,' ',$last_name?> </h5>
              <p class="display-6"> <span class="font-weight-bold">User ID: </span> <?php echo " ".$user_ID ." " ?></p>
              <hr>
              <p class="display-6"> <span class="font-weight-bold">Account status:</span> <?php echo " ".$status ." " ?></p>
              <p class="display-6"> <span class="font-weight-bold">Balance:</span> <?php echo " ".$balance ." " ?></p>
              <p class="display-6"> <span class="font-weight-bold">Membership Type:</span> <?php echo " ".$employee_membership_type ." " ?></p>
              <p class="display-6 "> <span class="font-weight-bold"> Payment Type:</span> <?php echo " ".$payment_type ." " ?></p>

            
            </div>
        </div>


        
    </div>


   <div class="container  ">
    <div class="row align-items-end">
        <div class="col-6">
           
           <?php if($balance>=0) {  ?>
            <a href="Employee_search_jobs.php" class="btn btn-outline-primary" role="button">Search Jobs</a>

           <?php } else { echo "<p class='display-4'>YOU HAVE A NEGATIVE BALANCE</p>"; ?>
            
            <form action="process.php" method="POST">
                <button class="btn btn-lg btn-primary" name="pay_now" role="button" > PAY NOW</button>
            
            </form>
            <!-- <a href="process.php" class="btn btn-primary" name="pay_now" role="button">Pay Now</a> -->

           <?php } ?>

        </div>
    
       
    </div>
   </div>


   



    
</body>
</php>
