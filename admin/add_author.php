<?php

if (isset($_SESSION['admin'])) {

    $all_coutries_sql = "SELECT * FROM `country` ORDER BY `country`.`Birth_Country` ASC";
    $all_countries = autocomplete_list($dbconnect, $all_coutries_sql, 'Birth_Country');

    $all_occupations_sql = "SELECT * FROM `career` ORDER BY `career`.`Job_Tag_1` ASC";
    $all_occupations = autocomplete_list($dbconnect, $all_occupations_sql, 'Job_Tag_1');


    $first = "";
    $middle = "";
    $last = "";
    $dob = "";
    $gender_code = "";
    $gender = "";
    $country_1 = "";
    $country_2 = "";
    $occupation_1 = "";
    $occupation_2 = "";

    $country_1_ID = $country_2_ID = $occupation_1_ID = $occupation_2_ID = 0;


    $last_error = $dob_error = $gender_error = $country_1_error = $occupation_1_error = "no-error";

    $last_field = $dob_field = $gender_field = "form-ok";
    $country_1_field = $occupation_1_field = "tag-ok";

    $has_errors = "no";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $first = mysqli_real_escape_string($dbconnect, $_POST['first']);
        $middle = mysqli_real_escape_string($dbconnect, $_POST['middle']);
        $last = mysqli_real_escape_string($dbconnect, $_POST['last']);
        $dob = mysqli_real_escape_string($dbconnect, $_POST['dob']);

        $gender_code = mysqli_real_escape_string(
            $dbconnect,
            $_POST['gender']
        );
        if ($gender_code == "F") {
            $gender = "Female";
        } else if ($gender_code == "M") {
            $gender = "Male";
        } else {
            $gender = "";
        }

        $country_1 = mysqli_real_escape_string($dbconnect, $_POST['country1']);
        $country_2 = mysqli_real_escape_string($dbconnect, $_POST['country2']);
        $occupation_1 = mysqli_real_escape_string($dbconnect, $_POST['occupation1']);
        $occupation_2 = mysqli_real_escape_string($dbconnect, $_POST['occupation2']);


        if ($last == "") {
            $has_errors = "yes";
            $last_error = "error-text";
            $last_field = "form-error";
        }

        $valid_dob = isValidYear($dob);
        if ($dob < 0 or $valid_dob != 1 or !preg_match('/^\d{1,4}$/', $dob)) {
            $has_errors = "yes";
            $dob_error = "error-text";
            $dob_field = "form-error";
        }

        if ($country_1 == "") {
            $has_errors = "yes";
            $country_1_error = "error-text";
            $country_1_field = "tag-error";
        }

        if ($occupation_1 == "") {
            $has_errors = "yes";
            $occupation_1_error = "error-text";
            $occupation_1_field = "tag-error";
        }


        $countryID_1 = get_ID($dbconnect, 'country', 'Country_ID', 'Birth_Country', $country_1);
        $countryID_2 = get_ID($dbconnect, 'country', 'Country_ID', 'Birth_Country', $country_2);
        $occupationID_1 = get_ID($dbconnect, 'career', 'Job_ID', 'Job_Tag_1', $occupation_1);
        $occupationID_2 = get_ID($dbconnect, 'career', 'Job_ID', 'Job_Tag_1', $occupation_2);


    if ($has_errors != "yes"){
        $add_author_sql = "INSERT INTO `authors` (`Author_ID`, `First`, `Last`, `Initial`, `Gender`, `Born`, `Country_1ID`, `Country_2ID`, `Job_1ID`, `Job_2ID`) VALUES (NULL, '$first', '$last', '$middle', '$gender_code', '$dob', '$countryID_1', '$countryID_2',
        '$occupationID_1', '$occupationID_2');";
        $add_author_query = mysqli_query($dbconnect, $add_author_sql);

        $find_author_sql = "SELECT * FROM `authors` WHERE `Last` = '$last'";
        $find_author_query = mysqli_query($dbconnect, $find_author_sql);
        $find_author_rs = mysqli_fetch_assoc($find_author_query);

        $new_authorID = $find_author_rs['Author_ID'];
        echo "New Author Id:" . $new_authorID;

        $author_ID = $new_authorID;

        header('Location: index.php?page=../content/author&authorID=' . $author_ID);
    }
}
}

?>


<h1>Add An Author...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?page=../admin/add_author"); ?>" enctype="multipart/form-data">

    <input class="add-field" type="text" name="first" value="<?php echo
                                                                $first; ?>" placeholder="Author's First Name" />

    <br /><br />

    <input class="add-field" type="text" name="middle" value="<?php echo
                                                                $middle; ?>" placeholder="Author's Middle Name (optional)" />

    <br /><br />

    <div class="<?php echo $last_error; ?>">
        Author's last name cannot be blank
    </div>

    <input class="add-field <?php echo $last_field; ?>" type="text" name="last" value="<?php echo $last; ?>" placeholder="Author's Last Name" />

    <br /><br />

    <select class="adv gender <?php echo $gender_field; ?>" name="gender">

        <?php
        if ($gender_code == "") {

        ?>
            <option value="" selected>
                Gender...
            </option>
        <?php

        } else {

        ?>
            <option value="<?php echo $gender_code; ?>" selected><?php echo $gender; ?>
            </option>
        <?php



        }
        ?>

        <option value="M">Male</option>
        <option value="F">Female</option>

    </select>

    <br /><br />

    <div class="<?php echo $dob_error; ?>">
        Please enter a valid year of birth (modern authors only).
    </div>

    <input class="add-field <?php echo $dob_field; ?>" type="text" name="dob" value="<?php echo $dob; ?>" placeholder="Author's year of birth" />

    <br /><br />

    <div class="<?php echo $country_1_error ?>">
        Please enter at least one country
    </div>

    <div class="autocomplete ">
        <input class="add-field <?php echo $country_1_field; ?>" id="country1" type="text" name="country1" placeholder="Country 1 (Start Typing)...">
    </div>

    <br /><br />

    <div class="autocomplete">
        <input class="add-field" id="country2" type="text" name="country2" placeholder="Country 2 (Start Typing)...">
    </div>

    <br /><br />

    <div class="add-field <?php echo $occupation_1_error ?>">
            Please enter at least one occupation
    </div>

    <div class="autocomplete ">
        <input class="add-field <?php echo $occupation_1_field; ?>" id="occupation1" type="text" name="occupation1" placeholder="Occupation 1 (Required, Start Typing)...">
    </div>

    <br /><br />

    <div class="autocomplete ">
        <input class="add-field <?php $occupation_2_field; ?>" id="occupation2" type="text" name="occupation2" placeholder="Occupation 2">
    </div>

    <br /><br />

    <p>
        <input type="submit" value="Submit" />
    </p>

</form>


<script>
    <?php include("autocomplete.php"); ?>;
    var all_countries = <?php print("$all_countries"); ?>;
    autocomplete(document.getElementById("country1"), all_countries);
    autocomplete(document.getElementById("country2"), all_countries);

    var all_occupations = <?php print("$all_occupations"); ?>;
    autocomplete(document.getElementById("occupation1"), all_occupations);
    autocomplete(document.getElementById("occupation2"), all_occupations);
</script>