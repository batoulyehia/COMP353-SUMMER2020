<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css" />
    </head>
    <body>
        <div>
            <div class="form-group" style="max-width: 50vw; padding: 30px; border: 1px solid #ccc; border-radius: 15px; margin: 10vh" >
                <h2>New Job Posting</h2>
                <form>
                    <label for="jobTitle">Job Title</label>
                    <input type="text" id="jobTitle" name="jobTitle" class="form-control"/> <br>
                    <div>Job Description:</div>
                    <textarea class="form-control" id="jobDescription" name="jobDescription" rows="3" style="height: 180px;" ></textarea> <br><br>
                    <div>Job Category:
                        <select class="browser-default custom-select">
                            <option selected>Engineering</option>
                            <option value="1">Finance</option>
                            <option value="2">Accounting</option>
                            <option value="3">Design</option>
                        </select>
                    </div>
                    <br>
                    <label for="newCategory">Can't find your category? Enter one here: </label>
                    <input type="text" id="newCategory" name="newCategory" class="form-control" /> <br>
                    <label for="numWorkers">Number of workers needed:</label>
                    <input type="number" id="numWorkers" name="numWorkers" min="1" class="form-control" />
                </form>
            </div> 
        </div>    
    </body>
</html>
