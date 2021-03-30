<?php

if (isset($_SESSION['admin'])) {

    $author_ID = $_SESSION['Add_Quote'];
<<<<<<< HEAD

    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');

=======
    echo "Author:ID: ".$author_ID;
    
    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject_ID` ASC";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject_ID');
    
>>>>>>> parent of f9f70a1 (cont.)
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

<<<<<<< HEAD
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
        $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
        $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
        $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
        $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);


        if ($quote == "Please type your quote here") {
            $has_errors = "yes";
            $quote_error = "error-text";
            $quote_field = "form-error";
        }

        if ($tag_1 == "") {
            $has_errors = "yes";
            $tag_1_error = "error-text";
            $tag_1_field = "form-error";
        }
        
        if ($has_errors != "yes") {

        $subjectID_1 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_1);
        $subjectID_2 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_2);
        $subjectID_3 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_3);


        $addentry_sql = "INSERT INTO `quotes` (`ID`, `Author_ID`, `Quote`, `Notes`, `Subject1_ID`, `Subject2_ID`, `Subject3_ID`) VALUES (NULL,
            '$author_ID', '$quote', '$notes', '$subjectID_1', '$subjectID_2', '$subjectID_3');";
        $addentry_query = mysqli_query($dbconnect, $addentry_sql);

=======
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
    $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
    
    
    
    if ($quote == "Please type your quote here") {
        $has_errors= "yes";
        $quote_error = "error-text";
        $quote_field = "form-error";
        }
}    
    
    
}
>>>>>>> parent of f9f70a1 (cont.)

        $get_quote_sql = "SELECT * FROM `quotes` WHERE 'Quote' LIKE '$quote'";
        $get_quote_query = mysqli_query($dbconnect, $get_quote_sql);
        $get_quote_rs = mysqli_fetch_assoc($get_quote_query);

        $quote_ID = $get_quote_rs['ID'];
        $_SESSION['Quote_Success'] = $quote_ID;

        header('Location: index.php?page=quote_success');
            
        }
    }
} else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


<h1>Add quote...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?page=../admin/add_entry"); ?>" enctype="multipart/form-data">

    <div class="<?php echo $quote_error; ?>">
        This field cannot be blank
    </div>
<<<<<<< HEAD

    <textarea class="add-field <?php echo $quote_field ?>" name="quote" rows="6"><?php echo $quote; ?></textarea>
    <br /><br />

    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..." />

    <br /><br />

    <div class="<?php echo $tag_1_error; ?>">
=======
    
    <textarea class="add-field <?php echo $quote_field?>" name="quote"
    rows="6"><?php echo $quote; ?></textarea>
    <br/><br />
    
        <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..."/>
    
    <br/><br />
    
        <div class="<?php $tag_1_error ?>">
>>>>>>> parent of f9f70a1 (cont.)
        Please enter at least one subject tag
    </div>

    <div class="autocomplete">
        <input class="<?php echo $tag_1_field; ?>" id="subject1" type="text" name="Subject_1" placeholder="Subject 1 (Start Typing)...">
    </div>
<<<<<<< HEAD

    <br /><br />

    <div class="autocomplete">
        <input id="subject2" type="text" name="Subject_2" placeholder="Subject 2 (Start Typing)...">
    </div>

    <br /><br />

    <div class="autocomplete">
        <input id="subject3" type="text" name="Subject_3" placeholder="Subject 3 (Start Typing)...">
    </div>

=======
    
>>>>>>> parent of f9f70a1 (cont.)
    <p>
        <input type="submit" value="Submit" />
    </p>



</form>


<script>
<<<<<<< HEAD
    <?php include("autocomplete.php"); ?>;
=======
<?php include("autocomplete.php"); ?>

    
var all_tags = <?php print("$all_subjects"); ?>;
autocomplete(document.getElementById("subject1"), all_tags);
>>>>>>> parent of f9f70a1 (cont.)


    var all_tags = <?php print("$all_subjects"); ?>;
    autocomplete(document.getElementById("subject1"), all_tags);
    autocomplete(document.getElementById("subject2"), all_tags);
    autocomplete(document.getElementById("subject3"), all_tags);
</script>