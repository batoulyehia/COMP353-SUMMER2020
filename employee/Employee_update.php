<?php
    require_once('../src/DatabaseConnection.php');
    if(isset($_POST['update'])){

        $user_ID=$_GET['ID'];
        $first_name=$_POST['first_name'];

        $query="UPDATE user_account SET frist_name='".$first_name."' WHERE user_ID='".$user_ID."'  ";
        $result= mysqli_query($conn,$query);

        if($result){
            ?>
                <script type="text/javascript">
                    window.location.href = '../employee/Employee_profile_settings.php';
                </script>
            <?php  
        }
        else{
            echo 'PLease check your query!';
        }
    }
    else{

        ?>
            <script type="text/javascript">
                window.location.href = '../employee/Employee_homepage.php';
            </script>
        <?php  
    }
?>
