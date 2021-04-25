<?php

if(isset($_SESSION['admin'])) {

    $all_authors_sql="SELECT * FROM `authors` ORDER BY `Last` ASC";
    $all_authors_query=mysqli_query($dbconnect,$all_authors_sql);
    $all_authors_rs=mysqli_fetch_assoc($all_authors_query);


    $first = "";
    $middle = "";
    $last = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);

    if($author_ID == "unknown"){
        header('Location: index.php?page=../admin/admin_panel');
    }
    else{
    header('Location: index.php?page=author&authorID='.$author_ID);
    }
    }
}

    ?>


<h1>Admin Panel</h1>

<h2>Quotes</h2>
<p>
    To <a href="index.php?page=../admin/new_quote"> add a quote</a>,
    use the preceding link or the '+' symbol at the top right of the screen.
</p>
<p>
    Quotes can be editied / deleted by searching for a quote and then clicking
    on the 'edit' / 'delete' icons at the bottom right of each quote. 
    If you don't see the icons to edit / delete quotes, it means that you are not logged in.
</p>

<hr />

<h2>Authors...</h2>

<p>Either <a href="index.php?page=../admin/add_author">Add an Author</a>
or choose an author form the dropdown box below to edit / delete an existing author.
</p>

<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/admin_panel");?>">

    <select name="author">
        <option value="unknown" selected>Choose...</option>

        <?php

        do {
            $author_full = $all_authors_rs['Last'].", "
            .$all_authors_rs['First']." ".$all_authors_rs["Inital"];

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

</form>

&nbsp; &nbsp;