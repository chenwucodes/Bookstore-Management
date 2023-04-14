<?php
// Include bookDAO file
require_once('./dao/bookDAO.php');
 
// Define variables and initialize with empty values
$title = $author = $stock = $publishDate = $picture = "";
$title_err = $author_err = $stock_err = $date_err = $picture_err = "";
$bookDAO = new bookDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Please enter a valid title.";
    } else{
        $title = $input_title;
    }
    
    // Validate author author
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Please enter an author."; 
    } else{
        $author = $input_author;
    }
    
    // Validate stock
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Please enter the stock amount.";
    } elseif(!ctype_digit($input_stock)){
        $stock_err = "Please enter a positive integer value.";
    } else{
        $stock = $input_stock;
    }

    // Validate publish date
   $input_publish_date = ($_POST["publishDate"]);
   if(empty($input_publish_date)){
        $date_err = "Please enter the publish date.";
    } elseif(!preg_match("/^\d{4}-\d{2}-\d{2}$/", $input_publish_date)){
        $date_err = "Invalid date format. Must be in YYYY-MM-DD format.";
    } elseif($input_publish_date < '2021-01-01' || $input_publish_date > '2023-04-04'){
        $date_err = "Date must be between January 1, 2021 and  April 4, 2023.";
   }  else{
        $publishDate = $input_publish_date;
   }


     // Validate picture
    $picture = $_FILES['picture']['name'];
    if($_FILES['picture']['name']){
        $picture_tmp = $_FILES['picture']['tmp_name'];
        $picture_size = $_FILES['picture']['size'];
        $picture_type = $_FILES['picture']['type'];
        $picture_error = $_FILES['picture']['error'];
        
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = strtolower(pathinfo($picture, PATHINFO_EXTENSION));

        if(!in_array($file_extension, $allowed_extensions)){
            $picture_err = "Please upload a valid image file.";
        }
        
        if($picture_size > 1048576){
            $picture_err = "Image file size must be less than 1 MB.";
        }
        
        if(!$picture_err){
            $upload_path = 'images/' . $picture;
            move_uploaded_file($picture_tmp, $upload_path);
        }
    }
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($author_err) && empty($stock_err) && empty($date_err) && empty($picture_err)){
        $book = new Book($id, $title, $author, $stock, $publishDate, $upload_path);
        $result = $bookDAO->updateBook($book);        
		header("refresh:2; url=index.php");
		echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $bookDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $book = $bookDAO->getBook($id);
                
        if($book){
            // Retrieve individual field value
            $title = $book->getTitle();
            $author = $book->getAuthor();
            $stock = $book->getStock();
            $picture = $book->getPicture();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $bookDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the book record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <textarea name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>"><?php echo $author; ?></textarea>
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stock; ?>">
                            <span class="invalid-feedback"><?php echo $stock_err;?></span>

                        <div class="form-group">
                            <label>Date Published</label>
                            <input type="date" name="publishDate" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>

                       <div class="form-group">
                            <label for="picture">Upload Picture</label>
                            <input type="file" name="picture" class="form-control <?php echo (!empty($picture_err)) ? 'is-invalid' : ''; ?>" >
                        </div>


                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>