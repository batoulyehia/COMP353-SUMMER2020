<?php 
    require '../src/DatabaseConnection.php'; 
    session_start();

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
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
    </head>
    <body>
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

        <h1 style="margin: auto; margin-top: 20xp; margin-bottom: 40px;">Contact Us</h1>
        <div>Do you have any questions? <br> Call us at (514) 123-4567 <br> Or email us at contact@comp353.ca</div>
    </body>
</html>