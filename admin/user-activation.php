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

        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/COMP353-SUMMER2020/admin/home-page.php">Home</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/admin/user-activation.php">User Activation/Deactivation</a>
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

            <!--dropdown here-->
            <h5 style="margin-top: 40px;">List of Employees</h5>
            <table class="table">
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
            <h5 style="margin-top: 40px;">List of Employers</h5>
            <table class="table">
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
        </div>
    </body>
</html>