<?php
include 'db_connect.php';
session_start();

// --- PART 1: FETCH STAFF DATA ---
if (!isset($_GET['id'])) {
    die("No staff selected.");
}
$staffID = $_GET['id'];

$sql = "SELECT * FROM staff WHERE staffID = '$staffID' LIMIT 1";
$result = mysqli_query($conn, $sql);
$staff = mysqli_fetch_assoc($result);

if (!$staff) {
    die("Staff not found.");
}

// --- PART 2: UPDATE STAFF WHEN USER SUBMITS FORM ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newName = $_POST['staffName'];
    $newPosition = $_POST['position'];

    // Update query
    $sqlUpdate = "UPDATE staff 
                  SET staffName = '$newName',
                      position = '$newPosition'
                  WHERE staffID = '$staffID'";

    mysqli_query($conn, $sqlUpdate);

    // success popup
    echo "<script>
            alert('Staff information updated successfully!');
            window.location.href='manage_staff.php';
          </script>";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff</title>

    <style>
        .edit-container {
            width: 700px;
            background: #fff;
            margin: 50px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 15px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
			font-size: 1rem;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        .btn-cancel, .btn-save {
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }
        .btn-cancel {
            background: #d9534f;
            color: white;
        }
        .btn-save {
            background: #27ae60;
            color: white;
        }
    </style>
</head>

<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
	
<div class="edit-container">
    <h2>Edit Staff</h2>

    <form method="POST" enctype="multipart/form-data">
        
		<!-- Display staffID but prevent editing -->
		<div class="form-group">
			<label>Staff ID:</label>
			<input type="text" value="<?= htmlspecialchars($staff['staffID']) ?>" disabled>
        	<input type="hidden" name="staffID" value="<?= $staff['staffID'] ?>">
		</div>

        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="staffName" value="<?= htmlspecialchars($staff['staffName']) ?>" required>
        </div>
		
		<div class="form-group">
            <label>Position:</label>
            <input type="text" name="position" value="<?= htmlspecialchars($staff['position']) ?>" required>
        </div>

        <div class="button-group">
            <a href="manage_staff.php" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">Save Changes</button>
        </div>

    </form>
</div>
	
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
