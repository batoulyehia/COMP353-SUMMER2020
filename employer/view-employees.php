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

            $theEmail = $_SESSION["user_email"];

            $displayName = $conn->prepare("SELECT first_name, last_name FROM user_account acc WHERE email = :theEmail ");
            $displayName->bindParam(':theEmail', $theEmail);
            $displayName->execute();

            $fullName = $displayName->fetchAll(PDO::FETCH_NUM);

            foreach($fullName as $partName){
                $first_name = $partName[0]; //column 1
                $last_name = $partName[1]; //column 2
            }

            $sqlEmployees = $conn->prepare("SELECT acc.user_ID, acc.first_name, acc.last_name, acc.email, acc.status FROM user_account acc, employee em WHERE acc.user_ID = em.user_ID ORDER BY acc.user_ID DESC");
            $sqlEmployees->execute();

            $employees = $sqlEmployees->fetchAll(PDO::FETCH_NUM);
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/home.php">Home</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/view-employees.php">Users</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/account.php">My Account</a>
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/contact.php">Contact Us</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <div style="margin-right: 20px"><?php echo $first_name, ' ', $last_name ?></div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <div style="width: fit-content; margin: auto; margin-top: 30px;">
        <h2 style="margin-bottom:20px;">View New Employees</h2>
            <div style="margin-bottom: 20px;">Displays the employees who joined, sorted by most recent.</div>
            <!-- have to sort by NEWEST --> 
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">user_ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($employees as $employee){ ?>
                        
                        <th scope="row"><?php echo $employee[0] ?></th>
                        <td><?php  echo $employee[1], $employee[2] ?></td>
                        <td><?php echo $employee[3] ?></td>
                        <td><?php echo $employee[4] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>