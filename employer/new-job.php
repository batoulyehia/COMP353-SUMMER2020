<?php
    require '../src/DatabaseConnection.php';
 
    session_start();
    //get user_id
   
    
    /*
    if($_SERVER["REQUEST_METHOD" == "POST"]){
        $jobTitle = $_POST["jobTitle"];
        $jobDescription = $_POST["jobDescription"];
        $category = $_POST["newCategory"];
        $num_workers = $POST["numWorkers"];
    }*/

/*
    $newJob = $conn->prepare("INSERT INTO job (user_ID, num_of_workers_needed, job_title, job_status, description) 
VALUES (:userID, :numworkers, :title, 'active', :jobDescription)");
    $newJob->bindParam(':userID', $user_ID);
    $newJob->bindParam(':title', $jobTitle);
    $newJob->bindParam(':numworkers', $num_workers);
    $newJob->bindParam(':jobDescription', $jobDescription);
    //$newJob->bindParam(':jobStatus', $status);

    //$status = 'active';
    $newJob->execute();

    echo "Added new job successfully!";
    */

    //retrieve the existing categories
    $getCategories = $conn->prepare("SELECT category_name FROM category");
    $getCategories->execute();
    $categories = $getCategories->fetchAll(PDO::FETCH_NUM);

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
    </head>
    <body>

    <?php 
        $theEmail = $_SESSION["user_email"];

         $user_ID_get = $conn->prepare("SELECT user_ID FROM user_account acc WHERE acc.email = :theEmail ");
         $user_ID_get->bindParam(':theEmail', $theEmail);
         $user_ID_get->execute();
         $user_ID_array = $user_ID_get->fetchAll(PDO::FETCH_NUM);
         
         foreach($user_ID_array as $user_ID_el){
             $user_ID = $user_ID_el[0]; 
         }
     
         var_dump($user_ID);
    ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/home.php">Home</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/view-employees.php">Users</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/account.php">My Account</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/contact.php">Contact Us</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <div style="margin-right: 20px">Welcome, [YOUR_NAME]</div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div>
            <div class="form-group" style="max-width: 50vw; padding: 30px; border: 1px solid #ccc; border-radius: 15px; margin: 10vh" >
                <h2>New Job Posting</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label for="jobTitle">Job Title</label>
                    <input type="text" id="jobTitle" name="jobTitle" class="form-control"/> <br>
                    <div>Job Description:</div>
                    <textarea class="form-control" id="jobDescription" name="jobDescription" rows="3" style="height: 180px;" ></textarea> <br><br>
                    <div>Job Category:
                        <select class="browser-default custom-select" name="category">
                            <?php foreach($categories as $category) { ?>
                            <option value="<?php echo $category[0] ?>"><?php echo $category[0] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br>
                    <label for="numWorkers">Number of workers needed:</label>
                    <input type="number" id="numWorkers" name="numWorkers" min="1" class="form-control" />
                    <button class="btn btn-primary" type="submit" value="Submit" name="Submit">Submit </button>

                </form>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label for="newCategory">Can't find your category? Enter one here: </label>
                    <input type="text" id="newCategory" name="newCategory" class="form-control" /> <br>
                    <button class="btn btn-primary" type="submit" value="SubmitCategory" name="SubmitCategory"> Submit New Category </button>
                </form>
            </div> 
        </div>    
        <?php
            if(isset($_POST['SubmitCategory'])){
                $newCategory = $_POST["newCategory"];
                $sqlCat = "INSERT INTO category VALUES ('$newCategory', '$user_ID')";
                $conn->exec($sqlCat);
            }
            if(isset($_POST['Submit'])){
                $currentDate = date("Y-m-d");
                $postCategory = $_POST['category'];
                $postNumWorkers = $_POST['numWorkers'];
                $postJobTitle = $_POST['jobTitle'];
                $postDescription = $_POST['jobDescription'];
                $status = 'open';
                var_dump($user_ID);
                $sql = "INSERT INTO job (category_name,user_ID,num_of_workers_needed, date_posted, job_title, job_status, job_description) VALUES ('$postCategory', '$user_ID', '$postNumWorkers', '$currentDate',' $postJobTitle','$status', '$postDescription')";
                
                try {
                    $conn->exec($sql);
                    header("Location: home.php");
                } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
                
            }

        ?>
    </body>
</html>
