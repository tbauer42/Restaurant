<?php
    require'database.php';
    
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.image, items.name, items.description, items.price, categories.name AS category
                                FROM items LEFT JOIN categories ON items.category = categories.id
                                WHERE items.id = ?');

    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();


    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!DOCTYPE html>
<html>
        <head>
            <title>Burger Soin</title>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1"> 
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" >
            <link rel="stylesheet" href="../css/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>

        <body>

            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Soin <span class="glyphicon glyphicon-cutlery"></span></h1>

            <div class="container admin">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 > <strong> voir un item </strong></h1>
                        <br>
                        <form>
                            <div class="form-group">
                                <label for="">Nom:</label> <?php echo ' ' . $item['name']; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Description:</label> <?php echo ' ' . $item['description']; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Prix:</label> <?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' €'; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Catégorie:</label> <?php echo ' ' . $item['category']; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Image:</label> <?php echo ' ' . $item['image']; ?>
                            </div>
                        </form>

                        <div class="form-actions">
                            <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>



                    </div>
                            <div class="col-sm-6 site">
                                <div class="thumbnail">
                                    <img src="<?php echo '../images/' . $item['image'];?>" alt="">
                                    <div class="price"><?php echo number_format((float)$item['price'],2,'.',''). ' €'; ?></div>
                                    <div class="caption">
                                        <h4><?php echo $item['name']; ?></h4>
                                        <p><?php echo  $item['description']; ?></p>
                                        <a href="#" class="btn btn-order" role="button"> <span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                                    </div>
                                </div>
                            </div>
                    
                
                    </div> 

            </div>

        </body>


        
</html>
