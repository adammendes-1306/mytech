<?php
session_start();
include 'db_connect.php';

// Get form data
$userid = $_POST['userid'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$pwd = md5($_POST['password']);
$confirm_pwd = md5($_POST['confirm_pwd']);

/* Debug: check what’s received
var_dump($userid, $password);
exit();
*/

// Validation: Check if passwords match
if ($pwd != $confirm_pwd) {
    echo "<script>
        alert('Passwords do not match!');
        window.location.href='register.php';
        </script>";
    exit();
}

// Validation: Check if userID already exists
$check_sql = "SELECT * FROM login WHERE userID = '$userid'";
$check_result = mysqli_query($conn, $check_sql);

// If same userID found, execute
if (mysqli_num_rows($check_result) > 0) {
    echo "<script>
        alert('User ID already exists! Please choose another one.');
        window.location.href='register.html';
    	</script>";
    exit();
}

// Insert into login table
$sql1 = "INSERT INTO login (userID, password)
        VALUES('$userid', '$pwd')";

// Insert into customer table
$sql2 = "INSERT INTO customer (userID, name, phoneNum, email, address)
        VALUES ('$userid', '$name', '$phone', '$email', '$address')";

// Execute first query
if (mysqli_query($conn, $sql1)) {
	// Only insert into customer table if login insert succeeded
	if (mysqli_query($conn, $sql2)) {
    	echo "<script>
        	alert('Registration successful! Please login.');
        	window.location.href='login.php';
    	</script>";
	} else {
		echo "<script>
        	alert('Error registering customer account" . mysqli_error($conn) . "');
        	window.location.href='register.php';
    	</script>";
	}
} else {
    echo "<script>
        	alert('Registration failed: " . mysqli_error($conn) . "');
        	window.location.href='register.php';
    	</script>";
}

mysqli_close($conn);
?>
