<?php
session_start();
include 'db_connect.php';

// customer userID
$userID = $_SESSION['userID'];

$sql = "SELECT * FROM notifications 
        WHERE userID='$userID'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <style>
		.notif-container {
			background: white;
        	padding: 20px;
        	border-radius: 12px;
        	box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        	max-width: 1200px;
        	margin: 50px auto;
		}
		.notif-container h2 {
			text-align: center;
			margin: 20px auto;
		}
        .notif-box {
            background: #f8f8f8;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .notif-time {
            font-size: 0.8rem;
            color: gray;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php' ?>
<div class="notif-container">
<h2>Your Notifications</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($n = mysqli_fetch_assoc($result)): ?>
        <div class="notif-box">
            <p><?= htmlspecialchars($n['message']) ?></p>
            <div class="notif-time"><?= $n['created_at'] ?></div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No notifications yet.</p>
<?php endif; ?>
</div>
<!-- Footer -->
<?php require 'footer.php' ?>
</body>
</html>
