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
            <h2 style="margin: 40px 0;">My Account</h5>
            <table class="table" style="border: 0;">
                <thead>
                    <tr>
                        <th scope="col" style="border: transparent;">Name: <?php echo $first_name, ' ', $last_name ?> </th>
                        
                    </tr>
                    <tr>
                        <th scope="col" style="border: transparent;">Email: <?php echo $theEmail ?> </th>
                    </tr>
                </thead>
            </table>
        </div>
    </body>
</html>
