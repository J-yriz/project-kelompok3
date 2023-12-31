<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = $repeat = $username = "";
$email_err = $password_err = $repeat_err = $username_err = "";
$mode = "putih";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Tolong masukan email.";
    } elseif (empty(trim($_POST["username"]))) {
        $username_err = "Tolong masukkan username.";
    } else {
        // Prepare select statements for email and username
        $sql_email = "SELECT email FROM pengguna WHERE email = ?";
        $sql_username = "SELECT username FROM pengguna WHERE username = ?";

        if ($stmt_email = mysqli_prepare($link, $sql_email)) {
            mysqli_stmt_bind_param($stmt_email, "s", $param_email);
            $param_email = trim($_POST["email"]);

            if (strpos($param_email, "@gmail.com") === false) {
                $email_err = "Email harus mengandung '@gmail.com'.";
            } else {
                if (mysqli_stmt_execute($stmt_email)) {
                    mysqli_stmt_store_result($stmt_email);

                    if (mysqli_stmt_num_rows($stmt_email) == 1) {
                        $email_err = "Email ini sudah pernah terdaftar.";
                    } else {
                        $email = $param_email;
                    }
                } else {
                    echo "Terjadi kesalahan pada pengecekan email!, Silahkan coba lagi.";
                }
            }
            mysqli_stmt_close($stmt_email);
        }

        if ($stmt_username = mysqli_prepare($link, $sql_username)) {
            mysqli_stmt_bind_param($stmt_username, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt_username)) {
                mysqli_stmt_store_result($stmt_username);

                if (mysqli_stmt_num_rows($stmt_username) == 1) {
                    $username_err = "Username ini sudah terdaftar.";
                } else {
                    $username = $param_username;
                }
            } else {
                echo "Terjadi kesalahan pada pengecekan username!, Silahkan coba lagi.";
            }
            mysqli_stmt_close($stmt_username);
        }
    }

    // Validate password
    if (isset($_POST["password"])) {
        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Masukan password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Gunakan password yang panjang dan rumit.";
        } else {
            $password = trim($_POST["password"]);
        }
    }

    // Validate confirm password
    if (isset($_POST["repeat"])) {
        $repeat = trim($_POST["repeat"]);
        if (empty($password_err) && ($password != $repeat)) {
            $repeat_err = "Password yang kamu masukan tidak sama.";
        }
    } else {
        $repeat_err = " ";
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($repeat_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO pengguna (email, password, username, mode) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_password, $param_username, $param_mode);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_username = $username;
            $param_mode = $mode;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: ./index.php");
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
    <title>Register - Project Kelompok 3</title>

    <!-- Style -->
    <link rel="stylesheet" href="./assets/css/foodhub.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-800">

    <div class="container bg-gray-800 font-rubik">
        <main>
            <div class="register max-w-md mx-auto mt-44 p-5 bg-slate-900 rounded-lg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label for="username"
                            class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Username</label>
                        <input type="text" id="username" name="username"
                            class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required value="<?php echo $username; ?>">
                        <span class="mt-1 help-block text-red-800">
                            <?php echo $username_err; ?>
                        </span>
                    </div>
                    <div class="mt-5 mb-6 form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Your email</label>
                        <input type="email" id="email" name="email"
                            class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="example@gmail.com" required value="<?php echo $email; ?>">
                        <span class="mt-1 help-block text-red-800">
                            <?php echo $email_err; ?>
                        </span>
                    </div>
                    <div class="mt-5 mb-6 form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Your
                            Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required value="<?php echo $password; ?>">
                        <span class="mt-1 help-block text-red-800">
                            <?php echo $password_err; ?>
                        </span>
                    </div>
                    <div class="mb-3 form-group <?php echo (!empty($repeat_err)) ? 'has-error' : ''; ?>">
                        <label for="repeat-password"
                            class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Repeat
                            password</label>
                        <input type="password" id="repeat-password" name="repeat"
                            class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required value="<?php echo $repeat; ?>">
                        <span class="mt-1 help-block text-red-800">
                            <?php echo $repeat_err; ?>
                        </span>
                    </div>
                    <div class="flex items-start mb-6">
                        <label for="terms" class="text-sm font-medium text-putihMiaw dark:text-putihMiaw">Sudah punya
                            akun? <a href="./index.php"
                                class="text-biruMiaw hover:underline dark:text-biruMiaw">Login</a></label>
                    </div>
                    <button type="submit" value="Submit"
                        class="text-hitamMiaw bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Register
                        akun baru</button>
                </form>
            </div>
        </main>
    </div>

    <!-- Script -->
    <script src="./assets/js/tailwind.config.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
</body>

</html>