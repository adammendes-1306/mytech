<?php
session_start();
include 'db_connect.php';

// Fetch all products
$sql = "SELECT * FROM staff";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Management</title>

    <style>
        .staff-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 20px auto;
        }

        .staff-container h2 {
            margin: 20px auto;
			text-align: center;
        }

        .top-button {
            margin-bottom: 15px;
        }

        .top-button a {
            text-decoration: none;
            transition: 0.2s;
        }

        .top-button a:hover {
            transform: ;
        }
		
		.top-button img {
			width: 40px; 
		}

        table {
            width: 650px;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
			margin: 0 auto;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #3498db;
            color: white;
        }

        tr:hover {
            background: #f1f7ff;
        }
		.btn-edit , .btn-delete {
			text-decoration: none;
		}
		.btn-edit img, .btn-delete img {
			width: 25px;
			transition: 0.2s;
		}
		.btn-edit img:hover {
			transform: translateY(-5px);
		}
		.btn-delete img:hover {
			transform: translateY(5px);
		}
		.print-btn {
    		padding: 10px 20px;
			background: #3498db; 
			color: #fff; 
			border: none; 
			border-radius: 8px; 
			cursor: pointer; 
			font-size: 1rem;
		}
    	.print-btn:hover {
        	background: #217EBC;
    	}
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>

<div class="staff-container">

    <h2>Staff Information</h2>

    <div class="top-button" align="right">
        <a href="add_staff.php"><img src="images/add_staff.png"></a>
    </div>

    <table>
        <tr>
            <th>Staff ID</th>
            <th>Name</th>
            <th>Position</th>
			<th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['staffID'] ?></td>
                <td><?= $row['staffName'] ?></td>
                <td><?= $row['position'] ?></td>
				<td>
        			<a href="edit_staff.php?id=<?= $row['staffID'] ?>" class="btn-edit">
						<img src="images/edit.png">
					</a>
        			<a href="delete_staff.php?id=<?= $row['staffID'] ?>" class="btn-delete"
           					onclick="return confirm('Are you sure you want to delete staff <?= $row['staffID'] ?>?')">
           				<img src="images/delete.png">
        			</a>
    			</td>
            </tr>
        <?php } ?>

    </table>
	
	<div style="text-align: center; margin-top: 20px;">
    	<button class="print-btn" onclick="window.print()">
    	Print
    	</button>
	</div>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
