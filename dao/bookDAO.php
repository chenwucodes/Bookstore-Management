<?php
require_once('abstractDAO.php');
require_once('./model/book.php');

class bookDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getbook($bookId){
        $query = 'SELECT * FROM books WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $book = new book($temp['id'],$temp['title'], $temp['author'], $temp['stock'], $temp['publishDate'], $temp['picture']);
            $result->free();
            return $book;
        }
        $result->free();
        return false;
    }


    public function getbooks(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM books');
        $books = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new book object, and add it to the array.
                $book = new book($row['id'], $row['title'], $row['author'], $row['stock'], $row['publishDate'], $row['picture']);
                $books[] = $book;
            }
            $result->free();
            return $books;
        }
        $result->free();
        return false;
    }   
    
    public function addbook($book){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO books (title, author, stock, publishDate, picture) VALUES (?,?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $title = $book->getTitle();
			        $author = $book->getAuthor();
			        $stock = $book->getStock();
                    $publishDate = $book->getPublishDate();
                    $picture = $book->getPicture();
                  
			        $stmt->bind_param('ssiss', 
				        $title,
				        $author,
				        $stock,
                        $publishDate,
                        $picture

			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $book->getTitle() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updatebook($book){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE books SET title=?, author=?, stock=?, publishDate=?, picture=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $book->getId();
                    $title = $book->getTitle();
			        $author = $book->getAuthor();
			        $stock = $book->getStock();
                    $publishDate = $book->getPublishDate();
                    $picture = $book->getPicture();
                  
			        $stmt->bind_param('ssissi', 
				        $title,
				        $author,
				        $stock,
                        $publishDate,
                        $picture,
                        $id
                       
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $book->getTitle() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deletebook($bookId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM books WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $bookId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>