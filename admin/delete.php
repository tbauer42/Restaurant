<?php 
    require 'database.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM items WHERE id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
        
    }

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
                    
                    <h1 > <strong> Supprimer un item</strong></h1>
                    <br>
                    <form class="form" action="delete.php" method="post" role="form" >
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <p class="alert alert-warning"> Etes vous sur de vouloir supprimer?</p>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-warning"> Oui </button>
                            <a href="index.php" class="btn btn-default">Non</a>
                        </div>
                    </form>
                </div>
            </div>
    </body>
</html>