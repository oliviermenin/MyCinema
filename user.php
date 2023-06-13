<?php
include "bdd.php";
include "navigation.php";

class DisplayUsers extends Database
{
    private $user;
    private $deleteMembership;
    private $modifyMembership;

    private $idMembership;

    public function __construct($user = NULL)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function displayUsers()
    {
        if (isset($_POST["user"])) {
            $req = $this->link->prepare("SELECT membership.id_user, user.firstname, user.lastname, subscription.id, subscription.name FROM user INNER JOIN membership ON membership.id_user = user.id INNER JOIN subscription ON membership.id_subscription = subscription.id ORDER BY user.firstname");
            $req->execute();
            $users = $req->fetchAll();

            $reqMembership = $this->link->prepare("SELECT id, name FROM subscription");
            $reqMembership->execute();
            $membership = $reqMembership->fetchAll();

            echo "<h3>Liste des membres :</h3>";
            foreach ($users as $user) {
                echo "<p>ID : " . $user["id_user"] . "</p>";
                echo "<p>Nom : " . $user["firstname"] . "</p>";
                echo "<p>Prénom : " . $user["lastname"] . "</p>";
                echo "<p>Abonnement : " . $user["name"] . "</p>";

                ?>
                <form action="user.php" method="POST">
                    <input type="hidden" name="modifyUser" value="<?php echo $user['id_user']; ?>">
                    <select name="membership_<?php echo $user['id_user']; ?>" id="membership_<?php echo $user['id_user']; ?>">
                        <option value="">Modifier l'abonnement</option>
                        <?php foreach ($membership as $member): ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo $member['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="modify">Modifier</button>
                    <button type="submit" name="delete">Supprimer l'abonnement</button>
                </form>
                <?php
            }
        }
    }

    public function deleteMembership()
    {
        if (isset($_POST["delete"])) {
            $this->deleteMembership = $_POST["delete"];

            $reqLog = $this->link->prepare("DELETE FROM membership_log WHERE id_membership IN (SELECT id FROM membership WHERE id_user = :deleteMembership)");
            $reqLog->bindParam(":deleteMembership", $this->deleteMembership, PDO::PARAM_INT);
            $reqLog->execute();

            $req = $this->link->prepare("DELETE FROM membership WHERE membership.id_user = :deleteMembership");
            $req->bindParam(":deleteMembership", $this->deleteMembership, PDO::PARAM_INT);
            $req->execute();
            echo "Utilisateur supprimé !";
        }
    }

    public function updateMembership()
    {
        if (isset($_POST["modify"])) {
            $this->modifyMembership = $_POST["modifyUser"];
            $membershipId = $_POST["membership_" . $this->modifyMembership];

            if (!empty($membershipId)) {
                $req = $this->link->prepare("UPDATE membership SET id_subscription = :idMembership WHERE id_user = :modifyMembership");
                $req->bindParam(":idMembership", $membershipId, PDO::PARAM_INT);
                $req->bindParam(":modifyMembership", $this->modifyMembership, PDO::PARAM_INT);
                $req->execute();
                echo "Abonnement modifié !";
            } else {
                echo "Veuillez sélectionner un abonnement.";
            }
        }
    }
}

$displayUsers = new DisplayUsers();
$displayUsers->displayUsers();
$displayUsers->deleteMembership();
$displayUsers->updateMembership();
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