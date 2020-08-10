<!DOCTYPE php>
<php lang="en">
<?php 
    require 'DatabaseConnection.php'; 
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
           

            
        
      
           $selected_category_name=$_POST['category'];

           //Job, Employer, Apply combined Table
           $je=$conn->prepare("SELECT  job_title,j.job_ID,e.user_ID,date_posted,job_status,job_description, app_status,c.category_name,a.employee_user_ID,a.job_ID from job j,employer e,apply a, category c,employee emp, choose ch  WHERE j.user_ID = e.user_ID AND j.job_ID= a.job_ID AND emp.user_ID=a.employee_user_ID AND e.user_ID=c.user_ID AND c.category_name LIKE '$selected_category_name' AND ch.employee_user_ID='$user_ID' GROUP BY emp.user_ID  HAVING emp.user_ID='$user_ID' ");
    
           $je->execute();

        //    $je=$conn->prepare("SELECT job_title,j.job_ID,e.user_ID,date_posted,job_status,job_description, app_status,c.category_name from job j,employer e,apply a, category c  WHERE j.user_ID = e.user_ID AND j.job_ID= a.job_ID AND e.user_ID=c.user_ID AND c.category_name LIKE '$selected_category_name' ");
    
        //    $je->execute();
 
          //get array
          $je_array=$je->fetchALL(PDO::FETCH_NUM);
 
          $je_a_employee_user_ID=null;
          
          foreach($je_array as $component){
               $je_job_title=$component[0];
               $je_job_ID=$component[1];
               $je_employer_ID=$component[2];
               $je_date_posted=$component[3];
               $je_job_status=$component[4];
               $je_job_description=$component[5];
               $je_app_status=$component[6];
               $je_category_name=$component[7];
               $je_a_employee_user_ID=$component[8];
               $je_a_job_ID=$component[9];
              
          }

        //   print_r($je_array);


          // NEW Job, Employer, Apply combined Table
          $je2=$conn->prepare("SELECT  job_title,j.job_ID,e.user_ID,date_posted,job_status,job_description,c.category_name from job j,employer e, category c  WHERE j.user_ID = e.user_ID   AND e.user_ID=c.user_ID AND c.category_name LIKE '$selected_category_name'   ");
    
          $je2->execute();

      

         //get array
         $je2_array=$je2->fetchALL(PDO::FETCH_NUM);

         foreach($je_array as $component){
              $je2_job_title=$component[0];
              $je2_job_ID=$component[1];
              $je2_employer_ID=$component[2];
              $je2_date_posted=$component[3];
              $je2_job_status=$component[4];
              $je2_job_description=$component[5];
              $je2_category_name=$component[6];
             
             
         }

        //  print_r($je2_array);

     //Give offer Table
     $give_offer=$conn->prepare("SELECT g.employee_user_ID,g.employer_user_ID,g.job_ID FROM employer e, give_offer g,employee emp, category c  WHERE e.user_ID=g.employer_user_ID AND emp.user_ID=g.employee_user_ID AND emp.user_ID='$user_ID'AND e.user_ID=c.user_ID AND c.category_name LIKE '$selected_category_name'");
     
     $give_offer->execute();
    //get array
    $give_offer_array=$give_offer->fetchALL(PDO::FETCH_NUM);

    $give_offer_employee_user_ID=null;
    $give_offer_employer_ID=null;
    $give_offer_job_id=null;
    foreach($give_offer_array as $component){
        $give_offer_employee_user_ID=$component[0];
        $give_offer_employer_ID=$component[1];
        $give_offer_job_id=$component[2];
       
   }

   //num_of_jobs_applied
   //Give offer Table
   $num_of_jobs=$conn->prepare("SELECT COUNT(*) FROM apply a, employee emp  WHERE a.employee_user_ID=emp.user_ID GROUP BY emp.user_ID HAVING emp.user_ID='$user_ID'  ");
   $num_of_jobs->execute();

   $num_of_jobs_array=$num_of_jobs->fetchALL(PDO::FETCH_NUM);

//    print_r($num_of_jobs_array);

   $num_of_jobs_total=0;
   foreach($num_of_jobs_array as $component){
    $num_of_jobs_total=$component[0];
  
    }
//    echo $num_of_jobs_total;

    // print_r($give_offer_array);




          //apply table 
           $apply=$conn->prepare("SELECT employee_user_ID,job_ID,app_status,date_applied FROM apply  WHERE employee_user_ID='$user_ID'");
     
            $apply->execute();
  
           //get array
           $apply_array=$apply->fetchALL(PDO::FETCH_NUM);
  
           foreach($apply_array as $component){
                $apply_employee_user_ID=$component[0];
                $apply_job_ID=$component[1];
                $apply_app_status=$component[2];
                $apply_date_applied=$component[3];
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
              <h5 class="card-title display-3">Relevant Jobs</h5>
              
            </div>
    </div>

    <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Job Title</th>
                        <th scope="col">Job ID</th>
                        <th scope="col">Employer ID</th>
                        <th scope="col">Date Posted</th>
                        <th scope="col">Job Status</th>
                        <th scope="col">Job Description</th>
                        <th scope="col">Application Status</th>
                        <th scope="col">Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <!-- print_r($je_array); -->

                        
                        <?php if($je_a_employee_user_ID==$user_ID) {foreach($je_array as $component){ ?>
                        <th scope="row"><?php  echo $component[0] ;  ?></th>
                        <td><?php echo $component[1] ?></td>
                        <td><?php echo $component[2] ?></td>
                        <td><?php echo $component[3] ?></td>
                        <td><?php echo $component[4] ?></td>
                        <td><?php echo $component[5]?></td>
                        <td><?php echo $component[6]?></td>
                      
                        <td>
                        <?php if($employee_membership_type!="basic" ){ ?>
                                <form action="process.php?je_job_ID=<?php echo $component[1]; ?>" method="POST">
                                <td><button class="btn btn-warning " name="withdraw"  >Withdraw</button></td>
                                </form>
                        <?php }else {}?>



<!--                          
                                print_r($je2_array); -->
                    <?php }} else {  foreach($je2_array as $part){?>
                     <th scope="row"><?php  echo $part[0]  ?></th>
                        <td><?php echo $part[1] ?></td>
                        <td><?php echo $part[2] ?></td>
                        <td><?php echo $part[3] ?></td>
                        <td><?php echo $part[4] ?></td>
                        <td><?php echo $part[5]?></td>
                        <td><?php echo "unapplied!"; ?></td>
                        
                        <!-- change $num_of_jobs_total<1   -->
                        <?php  if($employee_membership_type=="prime" && $num_of_jobs_total<6  ){ ?> ;;
                            <form action="process.php?je2_job_ID=<?php echo $part[1]; ?>" method="POST">
                                <td><button class="btn btn-success " name="apply"  >Apply</button></td>
                            </form>
                        <?php } else if($employee_membership_type=="gold"){?>
                            <form action="process.php?je2_job_ID=<?php echo $part[1]; ?>" method="POST">
                                <td><button class="btn btn-success " name="apply"  >Apply</button></td>
                            </form>
                        <?php } else{}?>







                        <?php } ?>
                    
                    <?php } ?>
                    <?php if($give_offer_employee_user_ID=$user_ID && $give_offer_job_id!="") {echo "OFFER GIVEN BY "; echo "JOB ID:". $give_offer_job_id ; ?>


                        <?php if($employee_membership_type!="basic" ){ ?>
                            <form action="process.php" method="POST">
                                <td><button class="btn btn-outline-success " name="accept"  >Accept</button></td>
                            </form>
                            <form action="process.php?give_offer_job_ID=<?php echo $give_offer_job_id; ?>" method="POST">
                                <td><button class="btn btn-outline-danger " name="reject"  >Reject</button></td>
                            </form>
                        <?php }else{} ?>


                    <?php }?>
                       
                    </tr>

                   
                </tbody>
            </table>



        
    </div>


  

   <table style="width:100%">
</table>


  



    
</body>
</php>