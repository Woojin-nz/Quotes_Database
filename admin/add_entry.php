<?php

if(isset($_SESSION['admin'])) {

    $author_ID = $_SESSION['Add_Quote'];

    if($author_ID=="unknown" ) {

    $all_coutries_sql ="SELECT * FROM `country` ORDER BY `country`.`Birth Country` ASC";
    $all_countries = autocomplete_list($dbconnect, $all_coutries_sql, 'Birth Country');

    $all_occupations_sql = "SELECT * FROM `career` ORDER BY `career`.`Job Tag 1` ASC";
    $all_occupations = autocomplete_list($dbconnect, $all_occupations_sql,'Job Tag 1');
    

    $first = "";
    $middle = "";
    $last = "";
    $dob = "";
    $gender_code= "";
    $gender = "";
    $country_1 = "";
    $country_2 = "";
    $occupation_1 = "";
    $occupation_2 = "";

    $country_1_ID = $country_2_ID = $occupation_1_ID = $occupation_2_ID = 0;


    $last_error = $dob_error = $gender_error = $country_1_error = $occupation_1_error = "no-error";

    $last_field = $dob_field = $gender_field = "form-ok";
    $country_1_field = $occupation_1_field = "tag-ok";


    }
    
    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');
    
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
    $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
    $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
    $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
    $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);

    
    
    
    if ($quote == "Please type your quote here") {
        $has_errors= "yes";
        $quote_error = "error-text";
        $quote_field = "form-error";
        }
    
    if ($tag_1 == "") {
        $has_errors= "yes";
        $tag_1_error = "error-text";
        $tag_1_field = "form-error";
        }    
    
}    
    
    
}



else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


<h1>Add quote...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>"
enctype="multipart/form-data">




    <?php

    if ($author_ID == "unknown") {
    ?>

    <input class="add-field" type="text" name="first" value="<?php echo
    $first; ?>" placeholder = "Author's First Name" />

    <br /><br />

    <input class="add-field" type="text" name="middle" value="<?php echo
    $middle; ?>" placeholder = "Author's Middle Name (optional)" />

    <br /><br />
    
    <div class="<?php echo $last_error; ?>"> 
        Author's last name cannot be blank
    </div>

    <input class="add-field <?php echo $last_field; ?>" type="text"
    name="last" value="<?php echo $last; ?>" placeholder="Author's Last Name"
    />

    <br /><br/>

    <select class="adv <?php echo $gender_field; ?>" name="gender">

        <?php
        if($gender_code =="") {

            ?>
                <option value="" selected>
                    Gender...
                </option>
        <?php

        }

        else {

            ?>
                <option value="<?php echo $gender_code;?>" selected><?php echo $gender; ?>
                </option>
        <?php



        }
        ?>
    
        <option value="M">Male</option>
        <option value="F">Female</option>

    </select>

    <br/><br/>

    <div class="<?php echo $dob_error; ?>">
            Author's Date of Birth cannot be blank
    </div>

    <input class="add-field <?php echo $dob_field; ?>" type="text"
    name="dob" value="<?php echo $dob; ?>" placeholder="Author's date of birth" />

    <br/><br/>

    <div class="<?php echo $country_1_error ?>">
        Please enter at least one country
    </div>

    <div class="autocomplete ">
        <input class="<?php $country_1_field; ?>" id="country1" type="text"
        name="country1" placeholder="Country 1 (Start Typing)...">
    </div>

    <br/><br/>

    <div class="autocomplete">
        <input id="country2" type="text" name="country2" placeholder="Country 2 (Start Typing)...">
    </div>

    <br/><br/>
    
    <div class="<?php echo $occupation_1_error ?>">
        Please enter at least one occupation
    </div>

    <div class="autocomplete ">
        <input class="<?php $occupation_1_field; ?>" id="occupation1" type="text"
        name="occupation1" placeholder="Occupation 1 (Required, Start Typing)...">
    </div>

    <br/><br/>

    <?php 
    }

    ?>



    <div class="<?php echo $quote_error; ?>">
        This field cannot be blank
    </div>
    
    <textarea class="add-field <?php echo $quote_field?>" name="quote"
    rows="6"><?php echo $quote; ?></textarea>
    <br/><br />
    
    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..."/>
    
    <br/><br />
    
    <div class="<?php echo $tag_1_error; ?>">
        Please enter at least one subject tag
    </div>
    
    <div class="autocomplete">
        <input class="<?php echo $tag_1_field; ?>" id="subject1" type="text"
        name="Subject_1" value="<?php echo $tag_1; ?>" placeholder="Subject 1 (Start Typing)...">
    </div>

    <br/><br />
    
    <div class="autocomplete">
        <input id="subject2" type="text"
        name="Subject_2" value="<?php echo $tag_2; ?>" placeholder="Subject 2 (Start Typing)...">
    </div>

    <br/><br />

    <div class="autocomplete">
        <input id="subject3" type="text"
        name="Subject_3" value="<?php echo $tag_3; ?>" placeholder="Subject 3 (Start Typing)...">
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

var all_countries = <?php print("$all_countries"); ?>;
autocomplete(document.getElementById("country1"), all_countries);
autocomplete(document.getElementById("country2"), all_countries);

var all_occupations = <?php print("$all_occupations"); ?>;
autocomplete(document.getElementById("occupation1"), all_occupations);
autocomplete(document.getElementById("occupation2"), all_occupations);


</script>

