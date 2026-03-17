<?php
$dsn = 'mysql:host=localhost;dbname=zoo_arcadia';
$username = 'root';
$password = 'root';
try{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Get users 
    $query = "SELECT * FROM users";
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //Show users
    foreach($users as $user){
        echo "id_user : " . $user['idUser'] . "<br>";
        echo "<br>";
        echo "u_last_name : " . $user['surname'] . "<br>";
        echo "<br>";
        echo "u_first_name : " . $user['name'] . "<br>";
        echo "<br>";
        echo "email : " . $user['email'] . "<br>";
        echo "<br>";
    }
}
catch (PDOException $e){
    echo "Erreur de connexion à la base de données : ". $e->getMessage();
}
?>