<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $time_in = $time_out = "";
$name_err = $time_in_err = $time_out_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate time_in
    $input_time_in = trim($_POST["time_in"]);
    if(empty($input_time_in)){
        $time_in_err = "Input Time in:";  
    } else{
        $time_in = $input_time_in;
    }

    // Validate time_out
    $input_time_out = trim($_POST["time_out"]);
    if(empty($input_time_out)){
        $time_out_err = "Input Time out:";  
    } else{
        $time_out = $input_time_out;
    }

    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($time_in_err) && empty($time_out_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, time_in, time_out) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_time_in, $param_time_out);
            
            // Set parameters
            $param_name = $name;
            $param_time_in = $time_in;
            $param_time_out = $time_out;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Time in</label>
                                <input type="time" name="time_in" class="form-control <?php echo (!empty($time_in_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $time_in; ?>">
                                    <span class="invalid-feedback"><?php echo $time_in_err; ?></span>
                            </div>
                        <div class="form-group">
                            <label>Time out</label>
                                <input type="time" name="time_out" class="form-control <?php echo (!empty($time_out_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $time_out; ?>">
                                    <span class="invalid-feedback"><?php echo $time_out_err; ?></span>
                            </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>