<?php
require 'config.php';

 	 	
$erreurs=[];
if(isset($_POST["connecter"])){
    $mail =$_POST["mail"];
    $password = $_POST["motPasse"];

    if(empty($mail)){
        $erreurs['email'] = "Veuillez saisir votre adresse mail";
    }
     if(empty($password)){
        $erreurs['password'] = "Veuillez saisir votre mot de passe";
    }
    if(empty($erreurs)){
        $req = $pdo->prepare("SELECT * FROM utilisateur WHERE mailUser = ? AND password = ?");
        $req->execute([$mail, $password]);
        $resultat =$req->fetchAll(PDO::FETCH_ASSOC);
    if(count($resultat)>0){
        header("Location:index.php");
    }else{
       $erreurs['userExiste'] = "Email ou  mot de passe incorrect";
    }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    flex-direction: column;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(255, 102, 178, 0.3);
    width: 400px;
    text-align: center;
}

form label {
    font-size: 16px;
    color: #333;
    display: block;
    margin-bottom: 8px;
    text-align: left;
}

form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.erreur {
    color: red;
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    text-align: left;
}

form button {
    background-color:  #ff66b2;
    color: white;
    border: none;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 5px;
    width: 100%;
    transition: 0.3s;
}

form button:hover {
    background-color:#ff66b2;
}

.register-link {
    margin-top: 15px;
    font-size: 14px;
    color: #333;
}

.register-link a {
    color: #ff66b2;
    text-decoration: none;
    font-weight: bold;
    
}

.register-link a:hover {
    text-decoration: underline;
}


    </style>
</head>
<body>
    <?php if(!empty($erreurs)):
         foreach($erreurs as $erreur=>$ere):?>
           <p><?=$ere?></p>
     <?php endforeach; 
      endif; ?>
<form method="POST" action="">
        <div class="form-group">
            <label for="mail">Email :</label>
            <input type="email" id="mail" name="mail" value="" >
        </div>
        <div class="form-group">
            <label for="motPasse">Mot de passe :</label>
            <input type="password" id="motPasse" name="motPasse" >
        </div>
        <button type="submit" name="connecter">Se connecter</button>
    </form>
    <div class="register-link">
        <p>Pas de compte ? <a href="register.php">Inscrivez-vous</a></p>
    </div>

</body>
</html>
