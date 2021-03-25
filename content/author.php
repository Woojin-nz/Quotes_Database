<?php

if(!isset($_REQUEST['authorID']))
{
    header('Location:index.php');
}

$author_to_find = $_REQUEST['authorID'];

$find_sql ="SELECT * FROM `quotes`
JOIN authors ON(`authors`.`Author_ID` =`quotes`.`Author_ID`) 
WHERE `quotes`.`Author_ID` = $author_to_find;
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$country1 = $find_rs['Country_1ID'];
$country2 = $find_rs['Country_2ID'];

$occupation1 = $find_rs["Job_1ID"];
$occupation2 = $find_rs["Job_2ID"];



// get author name

include("get_author.php");

?>

<br />

<div class="about">
    <h2>
        <?php echo $full_name ?>
    </h2>

    <p><b>Born:</b> <?php echo $find_rs['Born']; ?> </p>

    <p>
        <?php
        // show countries...   
        country_job($dbconnect,$country1,$country2,"Country","Countries","country","Country_ID", "Birth Country")
        ?>
    </p>

    <p>
        <?php
        // show occupation... 
        country_job($dbconnect,$occupation1,$occupation2,"Job","Jobs","career","Job_ID","Job Tag 1")
        ?>
    </p>
</div>

<br />

<?php
// Loop through results and display them...

do{
    
    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/',' ', $find_rs['Quote']);
    
    
    ?>
<div class="results">
    <p>
        <?php echo $quote; ?><br />
    
    </p>
    
    <?php include("show_subjects.php"); ?>
</div>
    
<br />
<?php    

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))
    
    
?>