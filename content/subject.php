<?php
if(isset($_REQUEST['subjectID']))
{
    header('Location: index.php');
}

$subject_to_find = $_REQUEST['subjectID'];

    $sub_sql="SELECT * FROM `subject` WHERE `Subject_ID` = $subject_to_find";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);
?>

<h2>Subject Results (<?php echo $sub_rs['Subject']?>)</h2>

<?php

$find_sql ="SELECT * FROM `quotes`
JOIN authors ON(`authors`.`Author_ID` =`quotes`.`Author_ID`)
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// Loop through results and display them...

do{
    
    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/',' ', $find_rs['Quote']);
    
    include("get_author.php");
    
    ?>
<div class="results">
    <p>
        <?php echo $quote; ?><br />
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID']; 
             ?>">
            <?php echo $full_name; ?>
    </a>
    </p>
    
    <?php include("show_subjects.php"); ?>
</div>
    
<br />
<?php    

} // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))
    
    
?>