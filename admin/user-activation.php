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
            $totalActive_query = $conn->prepare("SELECT COUNT(*) FROM user_account acc WHERE acc.status='active'");
            $totalActive_query->execute();
            $totalActive = $totalActive_query->fetch(\PDO::FETCH_ASSOC);

            $totalInactive_query = $conn->prepare("SELECT COUNT(*) FROM user_account acc WHERE acc.status='inactive'");
            $totalInactive_query->execute();
            $totalInactive = $totalInactive_query->fetch(\PDO::FETCH_ASSOC);

            //active users info
            $ActiveInformation_query = $conn->prepare("SELECT AC.first_name, AC.last_name, AC.user_ID , AC.email, AC.balance , AC.status FROM user_account AC WHERE AC.status = 'active' 
                                                       UNION
                                                       SELECT AC.first_name, AC.last_name, AC.user_ID , AC.email, AC.balance , AC.status FROM user_account AC WHERE AC.status = 'active'");
            $ActiveInformation_query->execute();
            $ActiveInformation = $ActiveInformation_query->fetchAll(PDO::FETCH_ASSOC);

            //deactivated users info 
            $InactiveInformation_query = $conn->prepare("SELECT AC.first_name, AC.last_name, AC.user_ID , AC.email, AC.balance , AC.status FROM user_account AC WHERE AC.status = 'inactive' 
                                                         UNION
                                                         SELECT AC.first_name, AC.last_name, AC.user_ID , AC.email, AC.balance , AC.status FROM user_account AC WHERE AC.status = 'inactive'");
            $InactiveInformation_query->execute();
            $InactiveInformation = $InactiveInformation_query->fetchAll(PDO::FETCH_ASSOC);

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
                        <th scope="col">Total Number of Active Users</th>
                        <th scope="col">Total Number of Deactivated Users</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $totalActive['COUNT(*)'] ?></td>
                        <td><?php echo $totalInactive['COUNT(*)'] ?></td>
                    </tr>
                </tbody>
            </table>
            
            <h5 style="margin-top: 40px;">List of Active Users</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($ActiveInformation as $ActiveInformation){ ?>
                            <td><?php echo $ActiveInformation['user_ID']?></td>
                            <td><?php echo $ActiveInformation['first_name'],' ', $ActiveInformation['last_name'] ?></td>
                            <td><?php echo $ActiveInformation['email']?></td>
                            <td><?php echo $ActiveInformation['balance'] . "$"?></td>
                            <td><?php echo $ActiveInformation['status']?></td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <td>Update Status:
                                    <select name="status">                               <!--//echo "status" . $ActiveInformation['user_ID']-->
                                    <option value="active" selected>active</option>
                                    <option value="inactive">inactive</option>
                                </select>
                            </td>
                            <td>
                                <div style="display:flex; justify-content: center;">
                                    <button type="submit" name="<?php echo "status" . $ActiveInformation['user_ID'] ?>" class="btn btn-success btn-lg" style="font-size:16px;">Update</button>
                                </div>
                            </td>
                            </form>
                            <?php
                                $ID = $ActiveInformation['user_ID'];
                                if(isset($_POST["status" . $ActiveInformation['user_ID']])){                //if(isset($_POST["status" . $ActiveInformation['user_ID']])){
                                    if(!($ActiveInformation['status'] == $_POST["status"])) {              //$_POST["status" . $ActiveInformation['user_ID']]

                                        $update = "UPDATE user_account
                                                   SET status = 'inactive'
                                                   WHERE user_ID = $ID";
                                        try {
                                        $conn->exec($update);
                                        echo("<meta http-equiv='refresh' content='0.1'>");
                                        } catch(PDOException $e) {
                                        echo $sql . "<br>" . $e->getMessage();
                                        }
                                    } else {
                                    echo 'SAME ANSWERRRRRRRRRRRRRRRR';
                                    }
                                }
                            ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
                
            <h5 style="margin-top: 40px;">List of Deactivated Users</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($InactiveInformation as $InactiveInformation){ ?>
                            <td><?php echo $InactiveInformation['user_ID']?></td>
                            <td><?php echo $InactiveInformation['first_name'],' ', $InactiveInformation['last_name'] ?></td>
                            <td><?php echo $InactiveInformation['email']?></td>
                            <td><?php echo $InactiveInformation['balance'] . "$"?></td>
                            <td><?php echo $InactiveInformation['status']?></td>
                            <td>Update Status:
                                <select name="<?php echo "status" . $ActiveInformation['user_ID'] ?>">
                                    <option value="active">active</option>
                                    <option value="inactive" selected>inactive</option>
                                </select>
                            </td>
                            <td>
                                <div style="display:flex; justify-content: center;">
                                    <button type="button" class="btn btn-success btn-lg" style="font-size:16px;">Update</button>
                                </div>
                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>