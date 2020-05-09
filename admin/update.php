<?php 
    require 'database.php';
    $nameError = $descriptionError = $priceError =$categoryError = $imageError = $name = $description = $price = $category = $image = "";

    if(!empty($_GET['id']))
    {
        $id =checkInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $name = checkInput($_POST['name']);
        $description = checkInput($_POST['description']);
        $price = checkInput($_POST['price']);
        $category = checkInput($_POST['category']);
        $image = checkInput($_FILES['image']['name']);
        $imagePath = '../images/' . basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess = true;

        if(empty($name))
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($description))
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($price))
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($category))
        {
            $categoryError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image))
        {
            $isImageUpdated = false ;
        }

        else
        {
            $isImageUpdated = true;
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                $imageError = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageError = "le fichier existe déjà";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 5000000)
            {
                $imageError = "Le fichier ne doit pas dépasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }

        }

        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
        {
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ?, WHERE id = ?");
                $statement->execute(array($name,$description,$price,$category,$image,$id)); 
            }
            Database::disconnect();
            header("Location: index.php");
        }
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
                    <div class="col-sm-6">
                        <h1 > <strong> Modifier un item </strong></h1>
                        <br>
                        <form class="form" action="<?php echo 'update.php?id=' . $id; ?>" method="post" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Nom:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                                <span class="help-inline"><?php echo $nameError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                                <span class="help-inline"><?php echo $descriptionError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="price">Prix:</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                                <span class="help-inline"><?php echo $priceError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="category">Categorie:</label>
                                <select class="form-control" name="category" id="category">
                                    <?php
                                        $db= Database::connect();
                                        foreach($db->query('SELECT * FROM categories') as $row)
                                        {
                                            if($row['id'] == $category)
                                                echo '<option selected="selected" value ="' . $row['id'] . '">' . $row['name'] . '</option>';
                                            else
                                            echo '<option value ="' . $row['id'] . '">' . $row['name'] . '</option>';

                                        }
                                        Database::disconnect();
                                    ?>
                                </select>
                                <span class="help-inline"><?php echo $categoryError; ?></span>
                            </div>
                            <div class="form-group">
                                <label> Image:</label>
                                <p><?php echo $image; ?></p>
                                <label for="image">Sélectionner une image:</label>
                                <input type="file" id="image" name="image">
                                <span class="help-inline"><?php echo $imageError; ?></span>
                            </div>
                            <br>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier </button>
                                <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Retour </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </body>
</html>