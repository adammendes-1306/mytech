<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $_POST['staffID']; // Admin-defined
    $staffName = $_POST['staffName'];
    $position = $_POST['position'];

    // Insert into DB including productID
    $sql = "INSERT INTO staff (staffID, staffName, position)
            VALUES ('$staffID', '$staffName', '$position')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Staff information added successfully!'); window.location.href='manage_staff.php';</script>";
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Staff Information</title>
    <style>
        body {
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-add { background: #27ae60; }
        .btn-add:hover { background: #1e8449; }

        .btn-cancel { background: #D83B3F; }
        .btn-cancel:hover { background: #BB191A; }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="container">
    <h2>Add New Staff Information</h2>
    <form method="POST" enctype="multipart/form-data">
		<label>Staff ID:</label>
        <input type="text" name="staffID" required
			   placeholder="Example: AM2408010000" pattern="[A-Z]{2}[0-9]{10}" 
			   title="Format: Two uppercase letters followed by ten digits, e.g., AM2408010000">

        <label>Staff Name:</label>
        <input type="text" name="staffName" required>

        <label>Position:</label>
        <input type="text" name="position" required
			   placeholder="Example: Manager">

        <div class="btn-group">
            <a href="manage_staff.php" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-add">Add Staff</button>
        </div>
    </form>
</div>

<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
