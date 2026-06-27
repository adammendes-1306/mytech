<?php
include 'db_connect.php';

// Compatible with PHP v5
$q = isset($_GET['q']) ? $_GET['q'] : '';
$inputId = isset($_GET['inputId']) ? $_GET['inputId'] : '';
$resultId = isset($_GET['resultId']) ? $_GET['resultId'] : '';
$hiddenId = isset($_GET['hiddenId']) ? $_GET['hiddenId'] : '';


$q = mysqli_real_escape_string($conn, $q);

if ($q !== '') {
    $sql = "SELECT productID, productName FROM product WHERE productName LIKE '%$q%' LIMIT 5";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        // Output div with correct onclick for the specific input
        echo "<div onclick=\"selectProduct('".addslashes($row['productName'])."', '{$row['productID']}', '$inputId', '$resultId', '$hiddenId')\">{$row['productName']}</div>";
    }
}
?>