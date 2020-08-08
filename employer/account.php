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
            
              //get user_id
            $subs_get = $conn->prepare("SELECT employer_membership_type FROM employer WHERE user_ID = :userID ");
            $subs_get->bindParam(':userID', $user_ID);
            $subs_get->execute();
            $subs_array = $subs_get->fetchAll(PDO::FETCH_NUM);

            foreach($subs_array as $sub){
                $member = $sub[0];
            }
            
            //get account info
            $getAccountDetails = $conn->prepare("SELECT acc.balance, acc.status FROM employer e, user_account acc WHERE acc.email = :theEmail and acc.user_ID = :e_user_id" );
            $getAccountDetails->bindParam(':theEmail', $theEmail);
            $getAccountDetails->bindParam(':e_user_id', $user_ID);
            $getAccountDetails->execute();
            $accountDetails = $getAccountDetails->fetchAll(PDO::FETCH_NUM);

            foreach($accountDetails as $accountDetail){
                $balance = $accountDetail[0];
                $status = $accountDetail[1];
            }

            //get payment type

            $getPaymentType = $conn->prepare("SELECT payment_type FROM payment_method WHERE user_ID = :userID");
            $getPaymentType->bindParam(':userID', $user_ID);
            $getPaymentType->execute();
            $retrievedTypes = $getPaymentType->fetchAll(PDO::FETCH_NUM);
            foreach($retrievedTypes as $retrievedType){
                $paymentType = $retrievedType[0];
            }

            // GET PAYMENT INFO 

            //Get credit info
            
            $getCreditInfo = $conn->prepare("SELECT c.credit_card_name, c.card_number, c.exp_date FROM payment_method p, credit_card c WHERE p.user_ID = :userid AND p.id_ref = c.id_ref");
            $getCreditInfo->bindParam(':userid', $user_ID);
            $getCreditInfo->execute();
            if($getCreditInfo->fetch()){
                $hasCredit = true;
            }
            $getCreditInfo->execute();
            $creditDetails = $getCreditInfo->fetchAll(PDO::FETCH_NUM);
            var_dump($creditDetails);

            //get checking info
            $getCheckingInfo = $conn->prepare("SELECT ca.name_of_assoc_acct, bank_account_num FROM payment_method p, checking_account ca WHERE p.user_ID = :userid AND p.id_ref = ca.id_ref");
            $getCheckingInfo->bindParam(':userid', $user_ID);
            $getCheckingInfo->execute();
            if($getCheckingInfo->fetch()){
                $hasChecking = true; 
            }

            $getCheckingInfo->execute();
            $checkingDetails = $getCheckingInfo->fetchAll(PDO::FETCH_NUM);
            

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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div style="display:flex;">
                <div style="display: flex; flex-direction: column;margin-right: 50px;">
                    <div>Name:</div>
                    <div>Email Address:</div>
                    <div>Subscription Type:</div>
                    <div>Current Balance:</div>
                    <div>Account Status:</div>
                    <div>Change Subscription</div>
                    <br><br>
                    <div>Payment Type</div>
                    <br><br>
                    <div>Payment Info</div>
                </div>
                
                    <div style="display: flex; flex-direction: column">
                        <div><?php echo $first_name, ' ', $last_name?></div>
                        <div><?php echo $theEmail ?></div>
                        <div><?php echo $member ?></div>
                        <div><?php echo  $balance?></div>
                        <div><?php echo $status?></div>
                        <!-- add radio button here --> 
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="subscription_type" value="prime" <?php if($member == 'prime'){ ?> checked <?php } ?> />
                                <label class="form-check-label">
                                    Prime
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="subscription_type" value="gold" <?php if($member == 'gold'){ ?> checked <?php } ?> />
                                <label class="form-check-label">
                                    Gold
                                </label>
                            </div>
                        </div> <br>
                        <div class="form-check">
                            <div>
                                <input class="form-check-input" type="radio" name="payment_type" value="manual" <?php if($paymentType == 'manual'){ ?> checked <?php } ?> />
                                <label class="form-check-label">
                                    Manual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_type" value="automatic" <?php if($paymentType == 'automatic'){ ?> checked <?php } ?> />
                                <label class="form-check-label">
                                    Automatic
                                </label>
                            </div>
                        </div>
                        
                        <br>
                        <!-- Check for credit-->
                        <?php if($hasCredit){ ?>
                        <div>
                            <b><u>Credit Card</u></b> <br>
                            <?php foreach($creditDetails as $creditDetail) { ?>
                                <div><b>Card Name:</b> <?php echo $creditDetail[0] ?></div>
                                <div><b>Card Number:</b> <?php echo $creditDetail[1] ?></div>
                                <div><b>Expiration Date:</b> <?php echo $creditDetail[2] ?></div>
                                
                            <?php } ?>
                        </div>
                        <?php }?>
                        <!-- Check for checking account-->
                        <?php if($hasCredit){ ?>
                        <div><b><u>Checking Account</u></b>
                            <br>
                            <?php foreach($checkingDetails as $checkingDetail) { ?>
                                <div><b>Card Name:</b> <?php echo $creditDetail[0] ?> </div>
                                <div><b>Account Number:</b> <?php echo $creditDetail[1] ?> </div>
                            <?php } ?>
                        </div>
                        <?php }?>
                    </div>
                </div>
            <button class="btn btn-success btn-lg" style="margin-top: 20px" type="submit" value="Submit" name="Submit">Save Changes</button>
            <br><br>
            <a href="new-payment.php" class="btn btn-primary btn-lg">Add New Payment</a>
        </div>
        </form>
        
        <?php
            if(isset($_POST['Submit'])){
                $changeSubscriptionType = $conn->prepare("UPDATE employer SET employer_membership_type = :subType WHERE user_ID = :userID");
                //may need to update the balance if person upgrades to gold
                $changeSubscriptionType->bindParam(':userID', $user_ID);
                $changeSubscriptionType->bindParam(':subType', $_POST['subscription_type']);
                $changeSubscriptionType->execute();

                $changePaymentType = $conn->prepare("UPDATE payment_method SET payment_type = :newType WHERE user_ID = :userID");
                $changePaymentType->bindParam(':userID', $user_ID);
                $changePaymentType->bindParam(':newType', $_POST['payment_type']);
                $changePaymentType->execute();
                header("Location: account.php");
            }
        ?>
    </body>
</html>
