<?php
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to index page
echo "<script>
    alert('You have been logged out!');
    window.location.href = 'index.php';
	</script>";
exit();
?>