<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = "";
$confirm_password = "";
$new_password_err = "";
$confirm_password_err = "";
$email = "";
$email_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $tEmail = strtolower($_POST["email"]);
    // Email
    if(empty($tEmail)){
        $email_err = "Tolong masukan password baru.";     
    } elseif(strlen($tEmail) < 6){
        $email_err = "Password harus lebih dari 6 huruf.";
    } elseif(preg_match_all("/@/i", $tEmail) > 1 || preg_match_all("/@/i", $tEmail) == 0){
        $email_err = "Invalid email!";
    } else{
        $email = $tEmail;
    }

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Tolong masukan password baru.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password harus lebih dari 6 huruf.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Tolong ulangi password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password tidak sama.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err) && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_email);
            
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: ./index.php");
                exit();
            } else{
                echo "Terjadi kesalahan!, Silahkan coba lagi.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.ico">
    <title>Reset Password - Project Kelompok 3</title>
    
    <!-- Style -->
    <link rel="stylesheet" href="./assets/css/foodhub.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-800">
    
    <div class="container bg-gray-800">
        <main>
            <div class="resetPassword max-w-md mx-auto mt-52 p-5 bg-slate-900 rounded-lg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <div class="mb-6 form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label for="email" class="block mb-2 text-sm font-medium text-white dark:text-white">Your email</label>
                        <input type="email" id="email" name="email" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required value="<?php echo $email; ?>">
                        <span class="mt-1 help-block text-red-800"><?php echo $email_err; ?></span>
                    </div> 
                    <div class="mb-6 form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="block mb-2 text-sm font-medium text-white dark:text-white">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required value="<?php echo $new_password; ?>">
                        <span class="mt-1 help-block text-red-800"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="mb-6 form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="block mb-2 text-sm font-medium text-white dark:text-white">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                        <span class="mt-1 help-block text-red-800"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="flex items-start">    
                        <button type="submit" value="Submit" class="text-black bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Konfirmasi</button>
                        <a href="./index.php" class="ml-3 text-black bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Script -->
    <script src="./assets/js/tailwind.config.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
</body>
</html>