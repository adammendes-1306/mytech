<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Us</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f7;
        margin: 0;
        padding: 0;
    }

    .about-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
    }

    .team-title {
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 35px;
        color: #2c3e50;
    }

    /* GRID */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
    }

    /* CARD */
    .team-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    /* IMAGE */
    .team-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid #3498db;
    }

    .member-name {
        font-size: 22px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 6px;
    }

    .member-role {
        color: #555;
        font-size: 15px;
        line-height: 1.6;
    }
	.goal-section {
        margin-top: 40px;
		text-align: center;
	}

    .goal-section h2 {
        color: #2c3e50;
        margin-bottom: 10px;
		font-size: 32px;
  	}

   	.goal-section p {
        color: #555;
		max-width: 1000px;
		font-size: 1.05rem;
		text-align: justify;
		margin: 0 auto;		/* Center the whole p block */
   	}
</style>
</head>

<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="about-container">

    <div class="team-title">Meet Our Team</div>

    <div class="team-grid">

        <!-- ADAM -->
        <div class="team-card">
            <img src="images/team/adam.jpg" class="team-img" alt="Adam Rais">
            <div class="member-name">Adam Rais bin Armendes</div>
            <div class="member-role">
                Backend Developer responsible for system logic, coding implementation,
                and full website functionality.
            </div>
        </div>

        <!-- WAWA -->
        <div class="team-card">
            <img src="images/team/wawa.jpg" class="team-img" alt="Saidatul Azwa">
            <div class="member-name">Saidatul Azwa binti Amir</div>
            <div class="member-role">
                Front-end & UI designer. Handles page layout, styling, and user interface
                to ensure smooth user experience.
            </div>
        </div>

        <!-- KAI -->
        <div class="team-card">
            <img src="images/team/kai.jpg" class="team-img" alt="Muhammad Syawal">
            <div class="member-name">Muhammad Syawal bin Tajudin</div>
            <div class="member-role">
                Database engineer handling tables, relationships, queries, and
                all product data insertion.
            </div>
        </div>

    </div>
	<!-- GOAL SECTION -->
    <div class="goal-section">
        <h2>Our Goal</h2>
        <p>
            Our objective is to create a fully functional demonstration of an online store,
            complete with product browsing, cart, checkout, order history, and proper backend database logic.
            This project also highlights teamwork, structured development, and role distribution.
        </p>
    </div>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>

</body>
</html>
