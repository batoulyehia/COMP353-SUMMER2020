<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
    </head>
    <body>
        <h3 style="margin-bottom:20px;">Home</h3>
        <div style="display: flex; flex-direction: column;">
        <!-- add welcome, username --> 
            <h5>My Registered Jobs</h5>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Job ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@jt</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
            <h5>Application List</h5>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Job ID</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Applicant Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Application Status</th>
                    <th scope="col">View Application (link)</th>
                    <!-- could be a pop-up that shows the applicant name and everything?-->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Pending</td>
                    <td>View Here</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@jt</td>
                    <td>Accepted</td>
                    <td>View Link</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    <td>Withdrawn</td>
                    <td>View Link</td>
                    </tr>
                    
                    
                </tbody>
            </table>
        </div>
    </body>
</html>