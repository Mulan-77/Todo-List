<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo_list</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

$dsn = "mysql:dbname=todo;host=localhost:3306";
$username = "root";
$password = "";
 
try {
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    $pdo = new PDO($dsn, $username, $password, $options);
 
    echo 'Connexion réussie ! <br>';

} catch (PDOException $error) {
    echo "Il y a une erreur : " . $error->getMessage();
}
?>

<?php 
    if (!empty($_POST['name']) && !empty($_POST(['email']))) {

        // 3) Assainir les donnée cad empecher l'insertion de scripts, balises ou de sql
        $todo = htmlspecialchars(($_POST['Todo']));
        
    } 

    if(isset($_POST['submit'])){
        $todo = $_POST['Todo'];


        $sql = "INSERT INTO todos (titre) VALUES (?)";

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$todo]);
        
        if ($result) {
            echo "Le Todo a bien était enregistrer" . '<br>';
        } else {
            echo "Il y a eu une erreur lors de la création du Todo : " . $result->errorInfo();
        }
    }

   
    $stmt = $pdo->prepare('SELECT * FROM todos');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


    
<h1> Ma Todo_list</h1>
<form method="Post">
    <div id="todo">

    <input name="Todo" type="text" placeholder="Ici votre Todo" required>

    <input id=submit type="submit" name="submit">
</form>

<?php if($error == true): ?>
    <p><?$error?></p>
<?php endif ?>

<?php
    if (!empty($result)): ?>
        
    <div class="todos">
        <?php foreach ($result as $list) : ?>
            <div>
                <h2><?=$list['titre']?></h2>
                <input type="checkbox" name="check" id="check">
            </div>
        <?php endforeach ?>
    </div>
    
<?php endif ?>




</body>
</html>

