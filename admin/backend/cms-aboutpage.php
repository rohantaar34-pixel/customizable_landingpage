<?php
//this is cms section of homepage
//you can see all the code regarding in changing values here in homepage
if (isset($_POST['about'])) {
    $input = $_POST['about_input'];
    $id = 1;
    $sql_insert1 = "UPDATE about SET about = ? WHERE id = ?";
    $prepare = $conn->prepare($sql_insert1);
    $prepare->bind_param("si", $input, $id);
    $prepare->execute();
    header("location: about.php");
}



?>