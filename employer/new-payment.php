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

    //get user_ids
    $user_ID_get = $conn->prepare("SELECT user_ID FROM user_account acc WHERE acc.email = :theEmail ");
    $user_ID_get->bindParam(':theEmail', $theEmail);
    $user_ID_get->execute();
    $user_ID_array = $user_ID_get->fetchAll(PDO::FETCH_NUM);
    
    foreach($user_ID_array as $user_ID_el){
        $user_ID = $user_ID_el[0]; 
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
        <div>
            <h2>Add New Credit</h2>
            <p>Please only select one of these at a time</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="creditName">Credit Card Name</label>
                <input type="text" id="creditName" name="creditName" class="form-control"/> <br>
                <label for="creditNum">Credit Card Number</label>
                <input type="text" id="creditNum" name="creditNumber" class="form-control"/> <br>
                <label for="cvc">CVC</label>
                <input type="text" id="cvc" name="creditCVC" class="form-control"/> <br>
                <label for="exp">Expiration Date</label>
                <input type="text" id="exp" name="expDate" class="form-control" placeholder="YYYY-MM-DD"/> <br>
            <button class="btn btn-primary" type="submit" value="SubmitCredit" name="SubmitCredit"> Submit Credit </button>
            </form>
        </div>
        <hr>
        <div>
            <h2>Add New Checking Account</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="accName">Account Name</label>
                <input type="text" id="accName" name="accName" class="form-control" /> <br>
                <label for="accNum">Account Number</label>
                <input type="text" id="accNum" name="accNum" class="form-control" /> <br>
                <button class="btn btn-primary" type="submit" value="SubmitChecking" name="SubmitChecking"> Submit Checking Account </button>
            </form>
        </div>
        <?php
            if(isset($_POST['SubmitCredit'])){
                $creditName = $_POST['creditName'];
                $creditNumber = $_POST['creditNumber'];
                $creditCVC = $_POST['creditCVC'];
                $expDate = $_POST['expDate'];

                $selected = 0;
                $payType = "manual";

                $newPaymentCr = "INSERT INTO payment_method (user_ID, selected, payment_type) VALUES ('$user_ID', '$selected', '$payType')";
                
                try{
                $conn->exec($newPaymentCr);
                } catch(PDOException $e) {
                    echo $newPaymentCr . "<br>" . $e->getMessage();
                }
                
                //retrieve ID ref
                $getCCIDRef = $conn->prepare("SELECT p.id_ref FROM payment_method p LEFT JOIN credit_card c ON p.id_ref = c.id_ref LEFT JOIN checking_account ch ON p.id_ref = ch.id_ref WHERE c.id_ref IS NULL AND ch.id_ref IS NULL AND user_ID = '$user_ID'");
                $getCCIDRef->bindParam(':userID',$user_ID);
                $getCCIDRef->execute();
                $retrievedRef = $getCCIDRef->fetchAll(PDO::FETCH_NUM);
                foreach($retrievedRef as $ref){
                    $ccIDRef = $ref[0];
                }

                $newCredit = "INSERT INTO credit_card VALUES ('$creditNumber', '$ccIDRef','$creditCVC', '$creditName','$expDate')";
                try{
                    $conn->exec($newCredit);
                } catch(PDOException $e) {
                    echo $newCredit . "<br>" . $e->getMessage();
                }
                header("Location: account.php");
            }
            if(isset($_POST['SubmitChecking'])){
                
                $selected = 0;
                $payType = "manual";
                $insertUID = $user_ID + 0;
                $newPaymentCh = "INSERT INTO payment_method (user_ID, selected, payment_type) VALUES ($insertUID, $selected, '$payType')";
                
                try{
                $conn->exec($newPaymentCh);
                } catch(PDOException $e) {
                    echo $newPaymentCh . "<br>" . $e->getMessage();
                }

                //retrieve ID ref
                $getCCIDRef = $conn->prepare("SELECT p.id_ref FROM payment_method p LEFT JOIN credit_card c ON p.id_ref = c.id_ref LEFT JOIN checking_account ch ON p.id_ref = ch.id_ref WHERE c.id_ref IS NULL AND ch.id_ref IS NULL AND user_ID = '$user_ID'");
                $getCCIDRef->bindParam(':userID',$user_ID);
                $getCCIDRef->execute();
                $retrievedRef = $getCCIDRef->fetchAll(PDO::FETCH_NUM);
                foreach($retrievedRef as $ref){
                    $chIDRef = $ref[0];
                }
                
                $accNum = $_POST['accNum'];
                $accName = $_POST['accName'];
                $newCheck = "INSERT INTO checking_account VALUES ('$accNum','$chIDRef','$accName')";
                $conn->exec($newCheck);

                header("Location: account.php");
            }
        ?>
    </body>
</html>
