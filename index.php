<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to the welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ./kulinerSemarang.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Masukan username!";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if the password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Masukan password!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT username, password FROM pengguna WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify the password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $fetched_username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $fetched_username;

                            // Redirect user to the welcome page
                            header("location: ./kulinerSemarang.php");
                        } else {
                            // Display an error message if the password is not valid
                            $password_err = "Password yang anda masukan salah.";
                        }
                    }
                } else {
                    // Display an error message if the username doesn't exist
                    $username_err = "username tidak tedaftar.";
                }
            } else {
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
    <title>Login - Project Kelompok 3</title>
    
    <!-- Style -->
    <link rel="stylesheet" href="./assets/css/foodhub.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-800">
    
    <div class="container bg-gray-800 font-rubik">
        <main>
            <div class="login max-w-md mx-auto mt-52 p-5 bg-slate-900 rounded-lg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-6 form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label for="username" class="block mb-2 text-sm font-medium text-putihMiaw dark:text-white">Username</label>
                        <input type="text" id="username" name="username" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-hitamMiaw text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required value="<?php echo $username; ?>">
                        <span class="mt-1 help-block text-red-800"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="mb-3 form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="block mb-2 text-sm font-medium text-putihMiaw dark:text-white">Your password</label>
                        <input type="password" id="password" name="password" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-hitamMiaw text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                        <span class="mt-1 help-block text-red-800"><?php echo $password_err; ?></span>
                    </div>
                    <div class="flex items-start mb-6">
                        <label for="terms" class="text-sm font-medium text-putihMiaw dark:text-gray-300">
                            <a href="./resetPassword.php" class="text-biruMiaw hover:underline dark:text-biruMiaw">Lupa password?</a>
                        </label>
                    </div>
                    <button type="submit" value="Login" class="mb-3 text-black bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Login</button>
                    <div class="flex items-start">
                        <label for="terms" class="text-sm font-medium text-putihMiaw dark:text-gray-300">Belum punya akun?
                            <a href="./register.php" class="text-biruMiaw hover:underline dark:text-biruMiaw">Register</a>
                        </label>
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