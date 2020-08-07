<?php 
    require '../src/DatabaseConnection.php'; 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
    </head>
    <body>
        <?php 
            //retrieve first name and last name for the top bar
            $theEmail = $_SESSION["user_email"];
            
            $displayName = $conn->prepare("SELECT first_name, last_name FROM user_account acc WHERE email = :theEmail ");
            $displayName->bindParam(':theEmail', $theEmail);
            $displayName->execute();

            $fullName = $displayName->fetchAll(PDO::FETCH_NUM);

            foreach($fullName as $partName){
                $first_name = $partName[0]; //column 1
                $last_name = $partName[1]; //column 2
            }

            //get user_id
            $user_ID_get = $conn->prepare("SELECT user_ID FROM user_account acc WHERE acc.email = :theEmail ");
            $user_ID_get->bindParam(':theEmail', $theEmail);
            $user_ID_get->execute();
            $user_ID_array = $user_ID_get->fetchAll(PDO::FETCH_NUM);
            
            foreach($user_ID_array as $user_ID_el){
                $user_ID = $user_ID_el[0]; 
            }

            //get registered jobs
            $getRegisteredJobs = $conn->prepare("SELECT job_ID, job_title, description, job_status, date_posted FROM job j WHERE j.user_ID = :current_ID");
            $getRegisteredJobs->bindParam(':current_ID', $user_ID);
            $getRegisteredJobs->execute();
            $registeredJobs = $getRegisteredJobs->fetchAll(PDO::FETCH_NUM);

            //get applications summary
            
            $getApplicationSummaries = $conn->prepare("SELECT app.job_ID,j.job_title, acc.first_name, acc.last_name, acc.email, app.app_status, app.date_applied FROM user_account acc, job j, apply app WHERE app.employee_user_ID = acc.user_ID AND app.job_ID = j.job_ID AND j.user_ID = :current_user_ID");
            $getApplicationSummaries->bindParam(':current_user_ID', $user_ID);
            $getApplicationSummaries->execute();
            $applicationSummaries = $getApplicationSummaries->fetchAll(PDO::FETCH_NUM);

        ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/home.php">Home</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/view-employees.php">Users</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/account.php">My Account</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/home.php">Contact Us</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <div style="margin-right: 20px"><?php echo $first_name, ' ', $last_name ?></div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div style="margin: auto;max-width: fit-content; display: flex; flex-direction: column;">
        <h3 style="margin-top: 20px; margin-bottom: 20px;">Home</h3>
        <!-- add welcome, username --> 
            <h5>My Registered Jobs</h5>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Job ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($registeredJobs as $registeredJob){ ?>
                        <th scope="row"><?php echo $registeredJob[0] ?></th>
                        <td><?php echo $registeredJob[1] ?></td>
                        <td><?php echo $registeredJob[2] ?></td>
                        <td><?php echo $registeredJob[3] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h5>Application List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Job ID</th>
                        <th scope="col">Job Title</th>
                        <th scope="col">Applicant Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Application Status</th>
                        <th scope="col">Date Applied</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($applicationSummaries as $applicationSummary) { ?>
                            <th scope="row"><?php echo $applicationSummary[0] ?></th>
                            <td><?php echo $applicationSummary[1] ?></td>
                            <td><?php echo $applicationSummary[2], ' ',$applicationSummary[3] ?></td>
                            <td><?php echo $applicationSummary[4] ?></td>
                            <td><?php echo $applicationSummary[5] ?></td>
                            <td><?php echo $applicationSummary[6] ?></td>
                        <?php } ?>
                    </tr> 
                </tbody>
            </table>
        </div>
    </body>
</html>