<?php
//this is in viewer page, this is the cms selection page for homepage
$sql = "SELECT * FROM homepage";
$result = $conn->query($sql);
$row = $result->fetch_assoc();




?>