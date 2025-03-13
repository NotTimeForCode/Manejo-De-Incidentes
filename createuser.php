<?php
require_once 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($username == '' || $password == '') {
        $error_message = 'Please enter a username and password';
        echo $error_message;
        $_SESSION['redirect'] = 'redirect';
        header('Location: register.php?error=' . urlencode($error_message));
        exit();
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "User registered successfully!";
            $_SESSION['redirect'] = 'redirect';
            header("location:register.php?success=" . urlencode($success_message));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close the connection
    mysqli_close($conn);
}
