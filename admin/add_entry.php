<?php

if(isset($_SESSION['admin'])) {

    $author_ID = $_SESSION['Add_Quote'];
    echo "Author:ID: ".$author_ID;
    
    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject_ID` ASC";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject_ID');
    
    $quote = "Please type your quote here";
    $notes = "";
    $tag_1 = "";
    $tag_2 = "";
    $tag_3 = "";
    
    $tag_1_ID = $tag_2_ID = $tag_3_ID = 0;
    
    $has_errors = "no";
    
    $quote_error = $tag_1_error = "no-error";
    $quote_field = "form-ok";
    $tag_1_field = "tag-ok";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
    
    
    
    if ($quote == "Please type your quote here") {
        $has_errors= "yes";
        $quote_error = "error-text";
        $quote_field = "form-error";
        }
}    
    
    
}

else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


<h1>Add quote...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>"enctype="multipart/form-data">

    <div class="<?php echo $quote_error; ?>">
        This field cannot be blank
    </div>
    
    <textarea class="add-field <?php echo $quote-field?>" name="quote"
    rows="6"><?php echo $quote; ?></textarea>
    <br/><br />
    
    <p>
        <input type="submit" value="Submit" />    
    </p>
    


</form>
