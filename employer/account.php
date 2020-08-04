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
            <a class="navbar-brand" href="/COMP353-SUMMER2020/employer/home.php">Contact Us</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <div style="margin-right: 20px">Welcome, [YOUR_NAME]</div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div style="margin: 50px;padding: 20px; border: 1px solid #ccc;border-radius: 16px; font-size: 24px;">
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
                    <div>Justin Trudeau</div>
                    <div>justin_trudeau@canada.com</div>
                    <div>Prime</div>
                    <div>$50</div>
                    <div>Active</div>
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
