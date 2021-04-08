<?php

if (isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];

    $find_sql = "SELECT * FROM `quotes`
    JOIN authors ON(`authors`.`Author_ID` =`quotes`.`Author_ID`) 
    WHERE `quotes`.`ID` = $ID";

    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);

    $author_ID = $find_rs['Author_ID'];
    $first = $find_rs['First'];
    $middle = $find_rs['Initial'];
    $last = $find_rs['Last'];

    $current_author = $last . ", " . $first . " " . $middle;

    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');

    $quote = $find_rs['Quote'];
    $notes = $find_rs['Notes'];

    $subject1_ID = $find_rs['Subject1_ID'];
    $subject2_ID = $find_rs['Subject2_ID'];
    $subject3_ID = $find_rs['Subject3_ID'];

    $tag_1_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE `Subject_ID` = $subject1_ID");
    $tag_1 = $tag_1_rs['Subject'];

    $tag_2_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE `Subject_ID` = $subject2_ID");
    $tag_2 = $tag_2_rs['Subject'];

    $tag_3_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE `Subject_ID` = $subject3_ID");
    $tag_3 = $tag_3_rs['Subject'];


    $tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

    $has_errors = "no";

    $quote_error = $tag_1_error = "no-error";
    $quote_field = "form-ok";
    $tag_1_field = "tag-ok";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);
        $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
        $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
        $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
        $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
        $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);




        if ($quote == "Please type your quote here" or $quote == "") {
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

            $editentry_sql = "UPDATE `quotes` SET `Author_ID` = '$author_ID', `Quote` = '$quote', `Notes` = '$notes', `Subject1_ID` = '$subjectID_1', `Subject2_ID` = '$subjectID_2', `Subject3_ID` = '$subjectID_3' WHERE `quotes`.`ID` = $ID;";
            $editentry_query = mysqli_query($dbconnect, $editentry_sql);

            $get_quote_sql = "SELECT * FROM 'quotes' WHERE 'Quote' = '$quote'";
            $get_quote_query = mysqli_query($dbconnect, $get_quote_sql);
            $get_quote_rs = mysqli_fetch_assoc($get_quote_query);

            $quote_ID = $get_quote_rs['ID'];

            header('Location: index.php?page=editquote_success&quote_ID='.$quote_ID);
        }
    }
} else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


<h1>Edit quote...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?page=../admin/editquote&ID=$ID"); ?>" enctype="multipart/form-data">

    <select class="gender" name="author">
        <option value="<?php echo $author_ID; ?>" selected>
            <?php echo $current_author; ?>
        </option>

        <?php

        $all_authors_sql = "SELECT * FROM `authors` ORDER BY `Last` ASC";
        $all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
        $all_authors_rs = mysqli_fetch_assoc($all_authors_query);


        do {

            $author_ID = $all_authors_rs['Author_ID'];
            $first = $all_authors_rs['First'];
            $middle = $all_authors_rs['Initial'];
            $last = $all_authors_rs['Last'];


            $author_full = $last . ", " . $first . " " . $middle;


        ?>

            <option value="<?php echo $author_ID; ?>">
                <?php echo $author_full; ?>
            </option>

        <?php

        } while ($all_authors_rs = mysqli_fetch_assoc($all_authors_query))


        ?>
    </select>

    <br /><br />

    <div class="<?php echo $quote_error; ?>">
        This field cannot be blank
    </div>

    <textarea class="add-field <?php echo $quote_field ?>" name="quote" rows="6"><?php echo $quote; ?></textarea>
    <br /><br />

    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..." />

    <br /><br />

    <div class="<?php echo $tag_1_error; ?>">
        Please enter at least one subject tag
    </div>

    <div class="autocomplete">
        <input class="add-field <?php echo $tag_1_field; ?>" id="subject1" type="text" name="Subject_1" value="<?php echo $tag_1; ?>" placeholder="Subject 1 (Start Typing)...">
    </div>

    <br /><br />

    <div class="autocomplete">
        <input class="add-field" id="subject2" type="text" name="Subject_2" value="<?php echo $tag_2; ?>" placeholder="Subject 2 (Start Typing)...">
    </div>

    <br /><br />

    <div class="autocomplete">
        <input class="add-field" id="subject3" type="text" name="Subject_3" value="<?php echo $tag_3; ?>" placeholder="Subject 3 (Start Typing)...">
    </div>

    <p>
        <input type="submit" value="Submit" />
    </p>



</form>


<script>
    <?php include("autocomplete.php"); ?>;


    var all_tags = <?php print("$all_subjects"); ?>;
    autocomplete(document.getElementById("subject1"), all_tags);
    autocomplete(document.getElementById("subject2"), all_tags);
    autocomplete(document.getElementById("subject3"), all_tags);
</script>