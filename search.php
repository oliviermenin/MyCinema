"
<?php
include "bdd.php";
include "navigation.php";
class SearchMovie extends Database
{
    private $movieName;
    private $distributor;
    private $genre;
    public function __construct($movieName = NULL, $distributor = NULL, $genre = NULL)
    {
        parent::__construct();
        $this->movieName = $movieName;
        $this->distributor = $distributor;
        $this->movieName = $genre;
        if (isset($_POST["movieName"]) || isset($_POST["distributor"]) || isset($_POST["genre"])) {
            $this->movieName = $_POST["movieName"];
            $this->distributor = $_POST["distributor"];
            $this->genre = $_POST["genre"];
        }
    }

    public function displayMovieName()
    {
        $req = $this->link->prepare("SELECT title FROM movie WHERE title LIKE :title");
        $req->bindValue(":title", '%' . $this->movieName . '%');
        $req->execute();
        $movies = $req->fetchAll();

        echo "<h3>Liste des films</h3>";
        foreach ($movies as $movie) {
            echo $movie["title"] . "<br>";
        }
    }

    public function displayDistributor()
    {
        $req = $this->link->prepare("SELECT name FROM distributor WHERE name LIKE :distributor");
        $req->bindValue(":distributor", '%' . $this->distributor . '%');
        $req->execute();
        $distributors = $req->fetchAll();

        echo "<h3>Liste des distributeurs</h3>";
        foreach ($distributors as $distri) {
            echo $distri["name"] . "<br>";
        }
    }

    public function displayGenre()
    {
        $req = $this->link->prepare("SELECT genre.id, genre.name, movie_genre.id_movie, movie_genre.id_genre, movie.title FROM genre INNER JOIN movie_genre ON genre.id = movie_genre.id_genre INNER JOIN movie ON movie_genre.id_movie = movie.id WHERE movie_genre.id_genre = :idgenre");
        $req->bindParam(":idgenre", $this->genre, PDO::PARAM_INT);
        $req->execute();
        $genres = $req->fetchAll();
        // print_r($genres);

        echo "<h3>Genre selectionné     :</h3>";

        foreach ($genres as $moviebygenre) {
            // echo "<h3>Films pour la catégorie " . $moviebygenre["name"] . "</h3>";
            echo $moviebygenre["title"] . "<br>";
        }


    }

}

$search = new SearchMovie();
$search->displayMovieName();
$search->displayDistributor();
$search->displayGenre();
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
</body>

</html>