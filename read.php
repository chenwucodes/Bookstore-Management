<?php
// Include bookDAO file
require_once('./dao/bookDAO.php');
$bookDAO = new bookDAO(); 

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
        $publishDate = $book->getPublishDate();
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Title</label>
                        <p><b><?php echo $title; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <p><b><?php echo $author; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <p><b><?php echo $stock; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Publish Date</label>
                        <p><b><?php echo $publishDate; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>Picture</label>
                        <p><img src="<?php echo $book->getPicture(); ?>" alt="Book Picture" style="max-width: 200px; max-height: 200px;"><p>
                    </div>

                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>