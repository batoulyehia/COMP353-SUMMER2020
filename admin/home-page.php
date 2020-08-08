<?php 
    require '../src/DatabaseConnection.php'; 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../includes/css/admin-home-page.css" />
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
        <script src="../includes/js/admin-home-page.js"></script>

    </head>
    <body>
        <?php 
        
            //retrieve first name and last name for the top bar
            $theEmail = $_SESSION["user_email"];
            
            $displayName = $conn->prepare("SELECT first_name, last_name FROM administrator admin WHERE email = :theEmail ");
            $displayName->bindParam(':theEmail', $theEmail);
            $displayName->execute();

            $fullName = $displayName->fetchAll(PDO::FETCH_NUM);

            foreach($fullName as $partName){
                $first_name = $partName[0]; //column 1
                $last_name = $partName[1]; //column 2
            }

            //summary of users
            $totalEmployees_query = $conn->prepare("SELECT COUNT(*) FROM employee e");
            $totalEmployees_query->execute();
            $totalEmployees = $totalEmployees_query->fetch(\PDO::FETCH_ASSOC);

            $totalEmployers_query = $conn->prepare("SELECT COUNT(*) FROM employer e");
            $totalEmployers_query->execute();
            $totalEmployers = $totalEmployers_query->fetch(\PDO::FETCH_ASSOC);

            //employee info
            $employeeInformation_query = $conn->prepare("SELECT first_name, last_name, E.user_ID ,email, E.employee_membership_type , AC.status FROM user_account AC, employee E WHERE AC.user_ID = E.user_ID");
            $employeeInformation_query->execute();
            $employeeInformation = $employeeInformation_query->fetchAll(PDO::FETCH_ASSOC);

            //employer info
            $employerInformation_query = $conn->prepare("SELECT first_name, last_name, E.user_ID ,email, E.employer_membership_type, AC.status FROM user_account AC, employer E WHERE AC.user_ID = E.user_ID");
            $employerInformation_query->execute();
            $employerInformation = $employerInformation_query->fetchAll(PDO::FETCH_ASSOC);

            //jobs posted info
            $postedJobsInformation_query = $conn->prepare("SELECT job_ID, category_name, first_name, last_name, date_posted, job_title FROM job J, user_account AC WHERE AC.user_ID = J.user_ID ");
            $postedJobsInformation_query->execute();
            $postedJobsInformation = $postedJobsInformation_query->fetchAll(PDO::FETCH_ASSOC);

            //applied jobs  info
            $appliedJobsInformation_query = $conn->prepare("SELECT first_name, last_name, J.job_ID, job_title, A.date_applied, app_status, A.employee_user_ID FROM apply A, user_account AC, job J WHERE AC.user_ID = A.employee_user_ID AND J.job_ID = A.job_ID ");
            $appliedJobsInformation_query->execute();
            $appliedJobsInformation = $appliedJobsInformation_query->fetchAll(PDO::FETCH_ASSOC);

            //offers given info
            $givenOffersEmployeesInformation_query = $conn->prepare("SELECT first_name, last_name, GOF.job_ID, J.job_title FROM give_offer GOF, user_account AC, job J WHERE GOF.employee_user_ID = AC.user_ID AND GOF.job_ID = J.job_ID");
            $givenOffersEmployeesInformation_query->execute();
            $givenOffersEmployeesInformation = $givenOffersEmployeesInformation_query->fetchAll(PDO::FETCH_ASSOC);


            $givenOffersEmployersInformation_query = $conn->prepare("SELECT first_name, last_name, GOF.job_ID, J.job_title, GOF.employee_user_ID FROM give_offer GOF, user_account AC, job J WHERE GOF.employer_user_ID = AC.user_ID AND GOF.job_ID = J.job_ID");
            $givenOffersEmployersInformation_query->execute();
            $givenOffersEmployersInformation = $givenOffersEmployersInformation_query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/COMP353-SUMMER2020/admin/home-page.php">Home</a>
            <a class="navbar-brand" href="#">User Activation/Deactivation</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/admin/account.php">My Account</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <div style="margin-right: 20px"><?php echo $first_name, ' ', $last_name ?></div>
            </div>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/src/LoginPage.php">Sign Out</a>
        </nav>
        <div style="margin: auto;max-width: fit-content; display: flex; flex-direction: column;">
            <h4 style="margin-top: 20px;">Welcome, <?php echo $first_name, ' ', $last_name ?></h4>
            <h5 style="margin-top: 40px;">Summary of users</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Total Number of Employers</th>
                        <th scope="col">Total Number of Employees</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $totalEmployees['COUNT(*)'] ?></td>
                        <td><?php echo $totalEmployees['COUNT(*)'] ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown button
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="radio">
                        <label style="margin-left: 10px;"><input style="display: none;" id ="employeeList" type="radio" name="optradio">List of Employees</label>
                    </div>
                    <div class="radio">
                        <label style="margin-left: 10px;"><input style="display: none;" id ="employerList" type="radio" name="optradio">List of Employers</label>
                    </div>
                    <div class="radio ">
                        <label style="margin-left: 10px;"><input style="display: none;" id ="postedJobs" type="radio" name="optradio">Jobs posted by Employers</label>
                    </div>
                    <div class="radio ">
                        <label style="margin-left: 10px;"><input style="display: none;" id ="appliedJobs" type="radio" name="optradio" >Jobs applied by Employees</label>
                    </div>
                    <div class="radio ">
                        <label style="margin-left: 10px;"><input style="display: none;" id ="offersGiven" type="radio" name="optradio" >Offers given by Employers</label>
                    </div>
                </div>
            </div>
            

            <!--dropdown here-->
            <h5 class="employeeListTitle" style="margin-top: 40px;">List of Employees</h5>
            <table class="table employeeList">
                <thead>
                    <tr>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Employee User ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Membership Type</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($employeeInformation as $employeeInformation){ ?>
                            <td><?php echo $employeeInformation['first_name'],' ', $employeeInformation['last_name'] ?></td>
                            <td><?php echo $employeeInformation['user_ID']?></td>
                            <td><?php echo $employeeInformation['email']?></td>
                            <td><?php echo $employeeInformation['employee_membership_type']?></td>
                            <td><?php echo $employeeInformation['status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--dropdown here-->
            <h5 class="employerListTitle" style="margin-top: 40px;">List of Employers</h5>
            <table class="table employerList">
                <thead>
                    <tr>
                        <th scope="col">Employer Name</th>
                        <th scope="col">Employer User ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Membership Type</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($employerInformation as $employerInformation){ ?>
                            <td><?php echo $employerInformation['first_name'],' ', $employerInformation['last_name'] ?></td>
                            <td><?php echo $employerInformation['user_ID']?></td>
                            <td><?php echo $employerInformation['email']?></td>
                            <td><?php echo $employerInformation['employer_membership_type']?></td>
                            <td><?php echo $employerInformation['status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--dropdown here-->
            <h5 class="postedJobsTitle" style="margin-top: 40px;">Jobs posted by Employers</h5>
            <table class="table postedJobs">
                <thead>
                    <tr>
                        <th scope="col">Employer Name</th>
                        <th scope="col">Job ID</th>
                        <th scope="col">Category</th>
                        <th scope="col">Job Title</th>
                        <th scope="col">Date Posted</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($postedJobsInformation as $postedJobsInformation){ ?>
                            <td><?php echo $postedJobsInformation['first_name'],' ', $postedJobsInformation['last_name'] ?></td>
                            <td><?php echo $postedJobsInformation['job_ID']?></td>
                            <td><?php echo $postedJobsInformation['category_name']?></td>
                            <td><?php echo $postedJobsInformation['job_title']?></td>
                            <td><?php echo $postedJobsInformation['date_posted']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--dropdown here-->
            <h5 class="appliedJobsTitle" style="margin-top: 40px;">Jobs applied to by Employees</h5>
            <table class="table appliedJobs">
                <thead>
                    <tr>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Job ID</th>
                        <th scope="col">Job Title</th>
                        <th scope="col">Date Applied</th>
                        <th scope="col">Application Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($appliedJobsInformation as $appliedJobsInformation){ ?>
                            <td><?php echo $appliedJobsInformation['first_name'],' ', $appliedJobsInformation['last_name'] ?></td>
                            <td><?php echo $appliedJobsInformation['job_ID']?></td>
                            <td><?php echo $appliedJobsInformation['job_title']?></td>
                            <td><?php echo $appliedJobsInformation['date_applied']?></td>
                            <td><?php echo $appliedJobsInformation['app_status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>


            <!--dropdown here-->
            <h5 class="offersGivenTitle" style="margin-top: 40px;">Offers given by Employers</h5>
            <table class="table offersGiven">
                <thead>
                    <tr>
                        <th scope="col">Offered by Employer</th>
                        <th scope="col">Job_ID</th>
                        <th scope="col">Job Title</th>
                        <th scope="col">Offered to Employee name</th>
                        <th scope="col">Employee Response</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php 
                            $appliedJobsInformation_query->execute();
                            $appliedJobsInformation = $appliedJobsInformation_query->fetchAll(PDO::FETCH_ASSOC);
                            $simpleArray = array();
                            $simpleArray = array_values($appliedJobsInformation);
                        ?>

                        <?php foreach($givenOffersEmployersInformation as $givenOffersEmployersInformation){ ?>
                            <td><?php echo $givenOffersEmployersInformation['first_name'],' ', $givenOffersEmployersInformation['last_name'] ?></td>
                            <td><?php echo $givenOffersEmployersInformation['job_ID']?></td>
                            <td><?php echo $givenOffersEmployersInformation['job_title']?></td>

                            <?php for ($x = 0; $x < sizeof($simpleArray); $x++){
                                if ($simpleArray[$x]['employee_user_ID'] == $givenOffersEmployersInformation['employee_user_ID']){
                                    $tempEmployeeName = $simpleArray[$x]['first_name'];
                                    $tempEmployeeName .= " " . $simpleArray[$x]['last_name'];
                                    if ($simpleArray[$x]['app_status'] == "applied") {
                                        $appStatus = "pending";    
                                    }else{
                                        $appStatus = $simpleArray[$x]['app_status'];
                                    }
                                }
                            } ?>

                            <td><?php  echo $tempEmployeeName?></td>
                            <td><?php  echo $appStatus?></td>                            
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </body>
</html>