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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Employee Homepage</title>
</head>
<body>

<?php 


 $hostname="wxc353.encs.concordia.ca";
 $username="wxc353_1";
 $password="DBSU2020";
 $databaseName="wxc353_1";
 $connect= mysqli_connect($hostname,$username,$password,$databaseName);



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

      //Job Table
      $job=$conn->prepare("SELECT job_ID,job_title from job  ");

       $job->execute();

      //get array
      $job_array=$job->fetchALL(PDO::FETCH_NUM);

      foreach($job_array as $component){
           $job_ID=$component[0];
           $job_title=$component[1];
      }

      
      //Employer Table
      $employer=$conn->prepare("SELECT user_ID from employer ");

       $employer->execute();

      //get array
      $employer_array=$employer->fetchALL(PDO::FETCH_NUM);

      foreach($employer_array as $component){
           $employer_ID=$component[0];
           
      }

      //Job, Employer, Apply combined Table
      $je=$conn->prepare("SELECT job_title,j.job_ID,e.user_ID,date_posted,job_status,job_description, app_status from job j,employer e, apply a WHERE j.user_ID = e.user_ID AND j.job_ID= a.job_ID  ");

      $je->execute();

     //get array
     $je_array=$je->fetchALL(PDO::FETCH_NUM);

     foreach($je_array as $component){
          $je_job_title=$component[0];
          $je_job_ID=$component[1];
          $je_employer_ID=$component[2];
          $je_date_posted=$component[3];
          $je_job_status=$component[4];
          $je_job_description=$component[5];
          $je_app_status=$component[6];
         
     }

     //payment_method,credit_card,checking_account combined Table
     $all_payment_methods=$conn->prepare("SELECT credit_card_name,card_number,bank_account_num,name_of_assoc_acct from payment_method pm,credit_card cc,checking_account ca    ");

    //  AND pm.id_ref=ca.id_ref

        //get array
    $all_payment_methods_array=$je->fetchALL(PDO::FETCH_NUM);

    foreach($all_payment_methods_array as $component){
      $allp_credit_card_name=$component[0];
      $allp_card_number=$component[1];
      $allp_bank_account_num=$component[2];
      $allp_name_of_assoc_acct=$component[3];
     
     
 }

    //credit_card table
    $credit_card=$conn->prepare("SELECT credit_card_name,card_number from credit_card  WHERE user_ID=$user_ID");

        //get array
        $credit_card_array=$je->fetchALL(PDO::FETCH_NUM);

        foreach($credit_card_array as $component){
          $credit_card_name=$component[0];
          $card_number=$component[1];
        
        
    }


    $fullname=$first_name." ".$last_name;
    // echo $fullname;

    //checking account table
    $checking_account=$conn->prepare("SELECT bank_account_num,name_of_assoc_acct,id_ref from checking_account  WHERE name_of_assoc_acct like '%$fullname%' ");
    $checking_account->execute();
        //get array
        $checking_account_array=$checking_account->fetchALL(PDO::FETCH_NUM);

        $all_checking_accounts=array();
        $all_checking_accounts_id_ref=array();

        $j=0;
        foreach($checking_account_array as $component){
          $bank_account_num=$component[0];
          $all_checking_accounts[$j]=$bank_account_num;

          $id_ref=$component[2];
          $all_checking_accounts_id_ref[$j]=$id_ref;

          $name_of_assoc_acct=$component[1];
        
           $j++;
        }
        // print_r($checking_account_array);



    $query="SELECT bank_account_num,name_of_assoc_acct from checking_account  WHERE name_of_assoc_acct like '%$fullname%' ";
    $result1= mysqli_query($connect,$query);


    //credit_credit table
    $credit_card_all=$conn->prepare("SELECT card_number,credit_card_name  from credit_card WHERE credit_card_name like '%$fullname%' ");
    $credit_card_all->execute();
        //get array
        $credit_card_all_array=$credit_card_all->fetchALL(PDO::FETCH_NUM);

        $all_credit_cards=array();
        $k=0;
        foreach( $credit_card_all_array as $component){
          $card_num=$component[0];
          $all_credit_cards[$k]=$card_num;

           $k++;
        }
    



    // $query="SELECT bank_account_num,name_of_assoc_acct from checking_account  WHERE name_of_assoc_acct like '%$fullname%' ";
    // $result1= mysqli_query($connect,$query);
    
        // print_r($credit_card_all_array);

    //payment_method table
    $payment_method=$conn->prepare("SELECT payment_type from payment_method WHERE user_ID=:current_ID");
    $payment_method->bindParam(':current_ID',$user_ID);
    $payment_method->execute();


    //get array
    $payment_method_array=$payment_method->fetchALL(PDO::FETCH_NUM);

    foreach($payment_method_array as $component){
        $payment_type=$component[0];
    }

    //Checking account check table 
    $checking_account_check=$conn->prepare("SELECT pm.id_ref,ca.id_ref,ca.bank_account_num,ca.name_of_assoc_acct,pm.selected from payment_method pm,checking_account ca WHERE pm.id_ref=ca.id_ref AND ca.name_of_assoc_acct like '$fullname' ");
    $checking_account_check->execute();

    //get array
    $checking_account_check_array=$checking_account_check->fetchALL(PDO::FETCH_NUM);

    foreach($checking_account_check_array as $component){
        $checking_account_check_pm_id_ref=$component[0];
        $checking_account_check_ca_id_ref=$component[1];
        $checking_account_check_ca_account_num=$component[2];
        $checking_account_check_ca_name=$component[3];
        $checking_account_check_pm_selected=$component[4];
        // echo $checking_account_check_pm_selected;

        // echo "Checking Account Number: ".$checking_account_check_ca_account_num." <br>"; 
        // echo "Selected: ".$checking_account_check_pm_selected." <br>"; 
    }

    // print_r($checking_account_check_array);


        //credit card check table 
        $credit_card_check=$conn->prepare("SELECT pm.id_ref,c.id_ref,c.card_number,c.credit_card_name,pm.selected from payment_method pm,credit_card c WHERE pm.id_ref=c.id_ref AND c.credit_card_name like '$fullname' ");
        $credit_card_check->execute();
    
        //get array
        $credit_card_check_array=$credit_card_check->fetchALL(PDO::FETCH_NUM);
    
        foreach($credit_card_check_array as $component){
            $credit_card_check_pm_id_ref=$component[0];
            $credit_card_check_c_id_ref=$component[1];
            $credit_card_check_c_card_number=$component[2];
            $credit_card_check_c_name=$component[3];
            $credit_card_check_pm_selected=$component[4];
            // echo "Credit Card Number: ".$credit_card_check_c_card_number." <br>"; 
            // echo "Selected[0=no selected and 1=selected]:  ".$credit_card_check_pm_selected." <br>"; 
            // echo $credit_card_check_pm_selected;
        }
    
        // print_r($credit_card_check_array);
    
    ?>

    <div class='container'>
        <nav class="nav nav-pills nav-justified flex-row  bg-light">
            <a class="nav-link  " href="Employee_homepage.php">Home</a>
            <a class="nav-link  active" href="Employee_payment_method_settings.php">Payment Method Setting</a>
            <a class="nav-link " href="Employee_profile_settings.php">Profile Setting</a>
            
        </nav>
    </div>
    <?php $first_name ?>
    
    <div class="container">
        <span class="d-block border border-secondary rounded bg-dark text-white font-weight-bold  display-1 text-center">Payment Method Setting</span>
        <div class="card w-100 text-center">
            <div class="card-body">
              
              
           
            </div>

          

            <p class="display-4">Credit Card:</p>
             <label for="exampleInputFirstName "><span class="font-weight-bold"></span></label>
             <input name="firstName" type="text" class="form-control" id="exampleInputFirstName"  placeholder="<?php echo $first_name ?>" disabled="disabled">
     

             <label for="exampleInputLastName text-white"><span class="font-weight-bold"></span></label>
             <input name="lastName" type="text" class="form-control" id="exampleInputLastName" disabled="disabled" placeholder="<?php echo $last_name ?>">
             
            
             <form method="post" action="process.php">
                Card Number:<br>
                <input type="text" name="card_number" required>
                <br>
                Expiry Date:<br>
                <input type="text" name="exp_date" required placeholder="YYYY-MM-DD">
                <br>
                CVC:<br>
                <input type="text" name="cvc" required>
                <br>
                <!-- Full Name:<br>
                <input type="text" name="credit_card_name" required>
                <br> -->
              
                <br><br>
                <input type="submit" name="add_card" value="Add Card">
            </form>
            <hr>
       
            <br><br>
            <hr>
            <h1>Select a  primary card</h1>

            <form action="process.php" method="POST">
                
                <?php  

               

                // for($i=0;$i<=sizeof($all_credit_cards)-1;$i++){
                //     echo "<br> Credit Card Number: ".$all_credit_cards[$i]." <br>";
                    
                // }

                foreach($credit_card_check_array as $component){
                    $credit_card_check_pm_id_ref=$component[0];
                    $credit_card_check_c_id_ref=$component[1];
                    $credit_card_check_c_card_number=$component[2];
                    $credit_card_check_c_name=$component[3];
                    $credit_card_check_pm_selected=$component[4];
                    echo "Credit Card Number: ".$credit_card_check_c_card_number." <br>"; 
                    echo "Selected:  ".$credit_card_check_pm_selected." <br>"; 
                    //  echo $credit_card_check_pm_selected;
                }
                ?>
                <br><h2>Enter primary Credit Card Number</h2>
                 Credit Card Number:<br>
                <input type="text" name="s_credit_card_number" required>
                <input type="submit" name="p_c" value="Select Primary ">
                    
             </form>


            <br><hr>

       

            <p class="display-4">Checking Account:</p>
            <form method="post" action="process.php">
                Account Number:<br>
                <input type="text" name="bank_account_num" required>
                <br>
                <!-- Full Name:<br>
                <input type="text" name="name_of_assoc_acct" required>
                <br> -->
              
                <br><br>
                <input type="submit" name="add_ca" value="Add Checking Account">
            </form>
            <hr>
         
            <br><hr>
            <h1>Select a primary checking account</h1>
           
            <form action="process.php" method="POST">
                
                <?php  

                $i=0;
                $id_ref1="";

                // for($i=0;$i<=sizeof($all_checking_accounts)-1;$i++){
                //     echo "<br> Account Number: ".$all_checking_accounts[$i]."<br>";
                //     // $id_ref1=$all_checking_accounts_id_ref[$i];
                //     // echo $id_ref1;
                // }
                foreach($checking_account_check_array as $component){
                    $checking_account_check_pm_id_ref=$component[0];
                    $checking_account_check_ca_id_ref=$component[1];
                    $checking_account_check_ca_account_num=$component[2];
                    $checking_account_check_ca_name=$component[3];
                    $checking_account_check_pm_selected=$component[4];
                    // echo $checking_account_check_pm_selected;
            
                    echo "Checking Account Number: ".$checking_account_check_ca_account_num." <br>"; 
                    echo "Selected: ".$checking_account_check_pm_selected." <br>"; 
                }


                ?>
                <br><h2>Enter primary Checking Account Number</h2>
                Checking Account Number:<br>
                <input type="text" name="s_bank_account_num" required>
                <input type="submit" name="p_ca" value="Select Primary ">
                    
             </form>


           
                   
                  
            
            


           

           
            <script>
           
              function saveChanges(){
                  alert("changes have been saved Successfully!");
              }

                function enablecardNum() {
                    document.getElementById("exampleInputcardNum").disabled = false;
                 }

                 function enableexpDate(){
                    document.getElementById("exampleInputexpDate").disabled = false;
                 }

                 function enableCVC(){
                    document.getElementById("exampleInputCVC").disabled = false;
                 }
                
                 function enableCAN(){
                    document.getElementById("exampleInputCAN").disabled = false;
                 }
                
                
              
        
            </script>
            
    </div>
    </div>


   


   

<?php 
  $hostname="wxc353.encs.concordia.ca";
  $username="wxc353_1";
  $password="DBSU2020";
  $databaseName="wxc353_1";

  $connect= mysqli_connect($hostname,$username,$password,$databaseName);
  if(isset($_POST['savechanges'])){
    $card_num=$_POST['card_num'];
    $exp_date=$_POST['expDate'];
    $cvc=$_POST['cvc'];

    $query =" INSERT INTO 'credit_card' ('card_number','exp_date','cvc') values('$card_num','$exp_date','$cvc')";
    $query_run=mysquli_query($connect,$query);

    if($query_run){
      echo '<script type="text/javascript">alert("Data Saved") </script>';
    }
    else{
      echo '<script type="text/javascript">alert("Data NOT Saved") </script>';
    }
  }
?>

    
</body>
</php>