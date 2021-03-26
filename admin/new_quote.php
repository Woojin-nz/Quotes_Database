<?php

if(isset($_SESSION['admin'])) {

    $all_authors_sql="SELECT * FROM `authors` ORDER BY `Last` ASC";
    $all_authors_query=mysqli_query($dbconnect,$all_authors_sql);
    $all_authors_rs=mysqli_fetch_assoc($all_authors_query);


    $first = "";
    $middle = "";
    $last = "";

}

else {

    $login_error = "Please login to access this page";
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


<h1> Add a Quote </h1>
<p><i>
    To add a quote, first select the author, then press the 'next' button. If the author is not in the list, please choose the 'New Author' option.
    To quickly find an author, clink in the box below and start typing their <b>last</b> name.
</i></p>


<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/new_quote");?>">

    <div>
        <b>Quote Quthor:</b> &nbsp;

        
    <select>
        <option value="unknown" selected>New Author</option>

        <?php

        do {
            
            $author_full = $all_authors_rs['Last'].",
            ".$all_authors_rs['First']." ".$all_authors_rs["Initial"];

        ?>

        <option value="<?php echo $all_authors_rs['Author_ID']; ?>">
            <?php echo $author_full; ?>
        </option>


        <?php
        
        }
        while($all_authors_rs=mysqli_fetch_assoc($all_authors_query))


        ?>
    </select>
        
    &nbsp;

    <input class="short" type="submit" name="quote_author"
    value="Next..." />
    
    </div>  

</form>

&nbsp;