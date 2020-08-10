<!DOCTYPE php>
<php lang="en">
<?php 

    
    // require 'DatabaseConnection.php'; 
    // session_start();
    $hostname="wxc353.encs.concordia.ca";
    $username="wxc353_1";
    $password="DBSU2020";
    $databaseName="wxc353_1";

    $connect= mysqli_connect($hostname,$username,$password,$databaseName);
    $query=" SELECT category_name from category";
    
    $result1= mysqli_query($connect,$query);

    if(isset($_POST['search'])){
        $category=$_POST['category'];
        //Job, Employer, Apply combined Table
        $je=$conn->prepare("SELECT job_title,j.job_ID,e.user_ID,date_posted,job_status,job_description, app_status,category_name from job j,employer e, apply a,category c WHERE j.user_ID = e.user_ID AND j.job_ID= a.job_ID AND e.user_ID=c.user_ID AND c.category_name='" . $_POST['category'] . "'  ");
     
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
            $je_category_name=$component[7];
           
       }

       echo $je_category_name;


    }
    
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
              <h5 class="card-title display-3">Search Jobs</h5>

            <form action="" method="POST">
                <label> please select a category</label>
              <?php  $row1=mysqli_fetch_array($result1); 
              $val1=$row1[0];
              ?>
                <select  >
                    <?php while($row1=mysqli_fetch_array($result1)):; ?>
                    <option value="<?php echo $row1[0]; ?>" > <?php echo $row1[0]; ?> </option>
                    <?php endwhile;?>
                </select>
            </form>
           

            <?php 
                if(isset($_POST['search'])){
                    $category_name=$_POST['category'];
                }
            
            ?>

           <form action="Employee_relevant_jobs.php" method="POST">
            Enter your choice:<input type="text" value="<?php echo $val1 ?>" name="category">
            
            <!-- <a href="Employee_relevant_jobs.php?category_name=<?php echo $val1; ?>">Search Jobs</a> -->
              <br><br>
              <button class="btn btn-success " name="search"  >Search Jobs</button>
            </form>
            
            
            </div>
        </div>


        
    </div>


    <script>
        function searchJob(){
            location.replace("Employee_relevant_jobs.php");
        }

    </script>


   




    
</body>
</php>