<?php

if(isset($_SESSION['admin'])) {
    
    $deletequote_sql = "DELETE FROM `quotes` WHERE `ID`=".$_REQUEST['ID'];
    $deletequote_query=mysqli_query($dbconnect, $deletequote_sql);

?>

<h1> Delete Success</h1>

<p> The Quote has been deleted</p>

<?php
}

else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>