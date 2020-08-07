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

            //get account info
            $getAccountDetails = $conn->prepare("SELECT e.employee_membership_type, acc.balance, acc.status FROM user_account acc, employee e WHERE acc.email = :theEmail and acc.user_ID = :e_user_id AND e.user_ID" );
            $getAccountDetails->bindParam(':theEmail', $theEmail);
            $getAccountDetails->bindParam(':e_user_id', $user_ID);
            $getAccountDetails->execute();
            $accountDetails = $getAccountDetails->fetchAll(PDO::FETCH_NUM);

            foreach($accountDetails as $accountDetail){
                $subscription = $accountDetail[0];
                $balance = $accountDetail[1];
                $status = $accountDetail[2];

            }
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
        <div style="max-width: fit-content;margin: auto; margin-top: 30px;padding: 20px; border: 1px solid #ccc;border-radius: 16px; font-size: 24px;">
            <h2>My Account</h2>
            <div style="display:flex;">
                <div style="display: flex; flex-direction: column;margin-right: 50px;">
                    <div>Name:</div>
                    <div>Email Address:</div>
                    <div>Subscription Type:</div>
                    <div>Current Balance:</div>
                    <div>Account Status:</div>
                    <div>Payment Method:</div>
                </div>
                <div style="display: flex; flex-direction: column">
                    <div><?php echo $first_name, ' ', $last_name?></div>
                    <div><?php echo $theEmail ?></div>
                    <div><?php echo $subscription ?></div>
                    <div><?php echo  $balance?></div>
                    <div><?php echo $status?></div>
                    <!-- add radio button here --> 
                    <div>Payment Method:</div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-lg" style="margin-top: 20px">Add New Payment Method</button>
            <br>
            <div style="display:flex; justify-content: center;">
                <button type="button" class="btn btn-success btn-lg" style="margin-top: 20px">Save Changes</button>
            </div>
        </div>
    </body>
</html>
