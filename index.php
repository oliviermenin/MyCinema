<?php include "bdd.php";
$database = new Database();
$genres = $database->getAllGenres();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cinema</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h1>Bienvenue sur ma MyCinema</h1>
    <form action="search.php" method="POST">
        <label for="">Nom du film :</label>
        <input type="text" name="movieName" id="" placeholder="Entrer le nom du film">

        <label for="">Nom du distributeur :</label>
        <input type="text" name="distributor" id="" placeholder="Entrer le nom du distributeur">
        <label for="genre">Genre:</label>

        <select name="genre" id="genre">
            <option value="">Choisissez le genre</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="search-button">Recherche</button>
    </form>

    <form action="user.php" method="POST">
        <button type="submit" name="user">Gérer les abonnements</button>
    </form>
</body>

</html>