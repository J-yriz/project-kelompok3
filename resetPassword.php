<?php
session_start();
require_once "config.php";

$email = $new_password = $confirm_password = "";
$email_err = $new_password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower($_POST["email"]);

    // Validasi email
    if (empty($email)) {
        $email_err = "Tolong masukan email.";
    } elseif (strlen($email) < 6 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Email tidak valid.";
    }

    // Validasi password baru
    $new_password = trim($_POST["new_password"]);
    if (empty($new_password)) {
        $new_password_err = "Tolong masukan password baru.";
    } elseif (strlen($new_password) < 6) {
        $new_password_err = "Password harus lebih dari 6 karakter.";
    }

    // Validasi konfirmasi password
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($confirm_password)) {
        $confirm_password_err = "Tolong ulangi password.";
    } elseif ($new_password != $confirm_password) {
        $confirm_password_err = "Password tidak sama.";
    }

    // Cek kesalahan input sebelum memperbarui database
    if (empty($email_err) && empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE pengguna SET password = ? WHERE email = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_email);
            $param_email = $email;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                session_destroy();
                header("location: ./index.php");
                exit();
            } else {
                echo "Terjadi kesalahan!, Silahkan coba lagi.";
            }
        }
        mysqli_stmt_close($stmt);
    }
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
    
    <div class="container bg-gray-800 font-rubik">
        <main>
            <div class="resetPassword max-w-md mx-auto mt-52 p-5 bg-slate-900 rounded-lg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <div class="mb-6 form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label for="email" class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Your email</label>
                        <input type="text" id="email" name="email" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required value="<?php echo $email; ?>">
                        <span class="mt-1 help-block text-red-800"><?php echo $email_err; ?></span>
                    </div> 
                    <div class="mb-6 form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required value="<?php echo $new_password; ?>">
                        <span class="mt-1 help-block text-red-800"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="mb-6 form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="block mb-2 text-sm font-medium text-putihMiaw dark:text-putihMiaw">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                        <span class="mt-1 help-block text-red-800"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="flex items-start">    
                        <button type="submit" value="Submit" class="text-hitamMiaw bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Konfirmasi</button>
                        <a href="./index.php" class="ml-3 text-hitamMiaw bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">Batal</a>
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