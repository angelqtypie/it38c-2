<?php
session_start();
require_once "../db/config.php";
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $id = $_SESSION['id']; // Getting user ID from the session
} else {
    echo "No username found in session.";
    exit; // Exit if the user is not logged in
}

// Include the database connection file

// Insert the attendance if the button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['present'])) {
        // Prepare SQL query to insert attendance
        $sql = "INSERT INTO tbl_attendance (user_id) VALUES (:user_id)";
        
        // Prepare the statement
        if ($stmt = $pdo->prepare($sql)) {
            // Bind the user ID to the query
            $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('You are marked as present!');</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }

            // Close the statement
            unset($stmt);
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <!--
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        -->
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <div class="container mt-5">
        <!-- Greeting message -->
        <h3>Just Click Pesent if you are, <?php echo $username; ?>!</h3>
        
        <!-- Form to mark present -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <button type="submit" name="present" class="btn btn-primary w-20">Present</button>
            </div>
        </form>
    </div>

</body>
</html>