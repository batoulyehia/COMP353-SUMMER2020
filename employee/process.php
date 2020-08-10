<?php


    require 'DatabaseConnection.php'; 
    session_start();


// include_once 'database.php';
$hostname="localhost";
      $username="root";
      $password="";
      $databaseName="login";
       
      $connect= mysqli_connect($hostname,$username,$password,$databaseName);

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
        $full_name=$first_name." ".$last_name;
        


        //PAY NOW
        if(isset($_POST['pay_now'])){
            

            $pay_now= $conn->prepare("UPDATE  user_account SET balance='0.0' WHERE user_ID=$user_ID ");
           
            $pay_now->execute();
    
            header("location:Employee_homepage.php");
        
        }
       



      //change application status to reject
      if(isset($_POST['reject']))
      {	 
        //Using GET
        $give_offer_job_ID= $_GET['give_offer_job_ID'];
        echo $give_offer_job_ID;
        
         
      $sql = "DELETE FROM  apply  WHERE employee_user_ID=$user_ID AND job_ID=$give_offer_job_ID";
      if (mysqli_query($connect, $sql)) {
          
          header("Location: Employee_homepage.php");
      } else {
          echo "Error: " . $sql . "
  " . mysqli_error($connect);
      }
      mysqli_close($connect);

      }
       //change application status to accepted
       if(isset($_POST['accept']))
       {	 
         $sql = "UPDATE apply
         SET app_status='accepted' WHERE employee_user_ID=$user_ID";
         if (mysqli_query($connect, $sql)) {
             
             header("Location: Employee_homepage.php");
         } else {
             echo "Error: " . $sql . "
     " . mysqli_error($connect);
         }
         mysqli_close($connect);
 
       }

      //change application status to applied
      if(isset($_POST['apply']))
      {	 
         
          
   

            //Using GET
            $je2_job_ID= $_GET['je2_job_ID'];
            echo $je2_job_ID;

            $sql = "INSERT INTO apply(employee_user_ID,job_ID,app_status,date_applied)
            VALUES ('$user_ID','$je2_job_ID','applied','2020-08-09')  ";
            if (mysqli_query($connect, $sql)) {
            echo "New record created successfully !";
            header("Location: Employee_homepage.php");
            } else {
            echo "Error: " . $sql . "
        " . mysqli_error($connect);
            }
            mysqli_close($connect);
      }

       //change application status to withdrawn
       if(isset($_POST['withdraw']))
       {	 

          //Using GET
          $je_job_ID= $_GET['je_job_ID'];
          echo $je_job_ID;
          
           
        $sql = "DELETE FROM  apply  WHERE employee_user_ID=$user_ID AND job_ID=$je_job_ID";
        if (mysqli_query($connect, $sql)) {
            
            header("Location: Employee_homepage.php");
        } else {
            echo "Error: " . $sql . "
    " . mysqli_error($connect);
        }
        mysqli_close($connect);

       }




if(isset($_POST['add_card']))
{	 
	 $card_number = $_POST['card_number'];
	 $exp_date = $_POST['exp_date'];
     $cvc = $_POST['cvc'];
     $credit_card_name=$first_name." ".$last_name;

     $selected = 0;
     $payType = "manual";

     $newPaymentCr = "INSERT INTO payment_method (user_ID, selected, payment_type) VALUES ('$user_ID', '$selected', '$payType')";
     
     try{
        $conn->exec($newPaymentCr);
        } catch(PDOException $e) {
            echo $newPaymentCr . "<br>" . $e->getMessage();
        }

        //retrieve ID ref
        $getCCIDRef = $conn->prepare("SELECT p.id_ref FROM payment_method p LEFT JOIN credit_card c ON p.id_ref = c.id_ref LEFT JOIN checking_account ch ON p.id_ref = ch.id_ref WHERE c.id_ref IS NULL AND ch.id_ref IS NULL AND user_ID = '$user_ID'");
        $getCCIDRef->bindParam(':userID',$user_ID);
        $getCCIDRef->execute();
        $retrievedRef = $getCCIDRef->fetchAll(PDO::FETCH_NUM);
        foreach($retrievedRef as $ref){
            $ccIDRef = $ref[0];
        }

        $newCredit = "INSERT INTO credit_card VALUES ('$card_number', '$ccIDRef','$cvc', '$full_name','$exp_date')";
        try{
            $conn->exec($newCredit);
        } catch(PDOException $e) {
            echo $newCredit . "<br>" . $e->getMessage();
        }
        header("Location: Employee_homepage.php");
    
     


}
else if(isset($_POST['add_ca'])){
    $bank_account_num = $_POST['bank_account_num'];
    $name_of_assoc_acct = $first_name." ".$last_name;

    $selected = 0;
                $payType = "manual";
                $insertUID = $user_ID + 0;
                $newPaymentCh = "INSERT INTO payment_method (user_ID, selected, payment_type) VALUES ('$user_ID', '$selected', '$payType')";
                
                try{
                $conn->exec($newPaymentCh);
                } catch(PDOException $e) {
                    echo $newPaymentCh . "<br>" . $e->getMessage();
                }

                //retrieve ID ref
                $getCCIDRef = $conn->prepare("SELECT p.id_ref FROM payment_method p LEFT JOIN credit_card c ON p.id_ref = c.id_ref LEFT JOIN checking_account ch ON p.id_ref = ch.id_ref WHERE c.id_ref IS NULL AND ch.id_ref IS NULL AND user_ID = '$user_ID'");
                $getCCIDRef->bindParam(':userID',$user_ID);
                $getCCIDRef->execute();
                $retrievedRef = $getCCIDRef->fetchAll(PDO::FETCH_NUM);
                foreach($retrievedRef as $ref){
                    $chIDRef = $ref[0];
                }
                
                
                $newCheck = "INSERT INTO checking_account VALUES ('$bank_account_num','$chIDRef','$full_name')";
                $conn->exec($newCheck);

                header("location: Employee_homepage.php");
    

}
// else if(isset($_POST['remove_card'])){
//     $r_card_number = $_POST['r_card_number'];

    
//     $sql = "DELETE FROM credit_card WHERE  card_number='$r_card_number'";
//     if (mysqli_query($connect, $sql)) {
//        echo "New record created successfully !";
//        header("Location: Employee_homepage.php");
//     } else {
//        echo "Error: " . $sql . "
// " . mysqli_error($connect);
//     }
//     mysqli_close($connect);;
// }
// else if(isset($_POST['remove_ca'])){
//     $r_bank_account_num = $_POST['r_bank_account_num'];

//        //retrieve ID ref
//        $getCCIDRef = $conn->prepare("SELECT p.id_ref FROM payment_method p LEFT JOIN credit_card c ON p.id_ref = c.id_ref LEFT JOIN checking_account ch ON p.id_ref = ch.id_ref WHERE c.id_ref IS NULL AND ch.id_ref IS NULL AND user_ID = '$user_ID'");
//        $getCCIDRef->bindParam(':userID',$user_ID);
//        $getCCIDRef->execute();
//        $retrievedRef = $getCCIDRef->fetchAll(PDO::FETCH_NUM);
//        foreach($retrievedRef as $ref){
//            $chIDRef = $ref[0];
//            echo "IDREF".$chIDRef."<br>";
//        }
//        $chIDRef++;
      

//        $sql = "DELETE FROM payment_method WHERE  id_ref=$chIDRef AND bank_account_num='$r_bank_account_num ";
       
    
//     // $sql = "DELETE FROM checking_account WHERE  bank_account_num='$r_bank_account_num'";

//     if (mysqli_query($connect, $sql)) {
//        echo "New record created successfully !";
//        header("Location: Employee_homepage.php");
//     } else {
//        echo "Error: " . $sql . "
// " . mysqli_error($connect);
//     }
//     mysqli_close($connect);
// }
else if(isset($_POST['p_ca'])){
    $s_bank_account_num = $_POST['s_bank_account_num'];
    $name_of_assoc_acct = $first_name." ".$last_name;



    //Checking account check table 
    $checking_account_check=$conn->prepare("SELECT pm.id_ref,ca.id_ref,ca.bank_account_num,ca.name_of_assoc_acct,pm.selected from payment_method pm,checking_account ca WHERE pm.id_ref=ca.id_ref AND ca.name_of_assoc_acct like '$full_name' ");
    $checking_account_check->execute();

    //get array
    $checking_account_check_array=$checking_account_check->fetchALL(PDO::FETCH_NUM);
    $id_ref_selected="";
    foreach($checking_account_check_array as $component){
        $checking_account_check_pm_id_ref=$component[0];
        $checking_account_check_ca_id_ref=$component[1];
        $checking_account_check_ca_account_num=$component[2];
        $checking_account_check_ca_name=$component[3];
        $checking_account_check_pm_selected=$component[4];
        echo $checking_account_check_pm_selected;
        
        if($checking_account_check_ca_account_num == $s_bank_account_num){
            $id_ref_selected=$checking_account_check_pm_id_ref;
        }

    }

    $setZero = $connect->prepare("UPDATE payment_method SET selected = 0 WHERE user_ID =$user_ID");
    $setZero->execute();
  
    $setSelectedCA = $connect->prepare("UPDATE payment_method SET selected = 1 WHERE user_ID =$user_ID AND id_ref=$id_ref_selected ");
    $setSelectedCA->execute();

    echo "New record created successfully !";
    header("Location: Employee_homepage.php");

    

    
//     $sql = "INSERT INTO checking_account(bank_account_num,name_of_assoc_acct,id_ref)
//     VALUES ('$bank_account_num ','$name_of_assoc_acct')";
//     if (mysqli_query($connect, $sql)) {
//        echo "New record created successfully !";
//        header("Location: Employee_homepage.php");
//     } else {
//        echo "Error: " . $sql . "
// " . mysqli_error($connect);
//     }
//     mysqli_close($connect);
}
elseif(isset($_POST['p_c'])){
    $s_credit_card_number = $_POST['s_credit_card_number'];
    

       //credit card check table 
       $credit_card_check=$conn->prepare("SELECT pm.id_ref,c.id_ref,c.card_number,c.credit_card_name,pm.selected from payment_method pm,credit_card c WHERE pm.id_ref=c.id_ref AND c.credit_card_name like '$full_name' ");
       $credit_card_check->execute();
   
       //get array
       $credit_card_check_array=$credit_card_check->fetchALL(PDO::FETCH_NUM);
   
       $id_ref_selected_2="";
       foreach($credit_card_check_array as $component){
           $credit_card_check_pm_id_ref=$component[0];
           $credit_card_check_c_id_ref=$component[1];
           $credit_card_check_c_card_number=$component[2];
           $credit_card_check_c_name=$component[3];
           $credit_card_check_pm_selected=$component[4];
           
           if($credit_card_check_c_card_number == $s_credit_card_number){
            $id_ref_selected_2= $credit_card_check_pm_id_ref;
        }

       }

       $setZero = $connect->prepare("UPDATE payment_method SET selected = 0 WHERE user_ID =$user_ID");
       $setZero->execute();

       $setSelectedCC = $connect->prepare("UPDATE payment_method SET selected = 1 WHERE user_ID =$user_ID AND id_ref=$id_ref_selected_2 ");
       $setSelectedCC->execute();
   
       echo "New record created successfully !";
       header("Location: Employee_homepage.php");

}



?>
