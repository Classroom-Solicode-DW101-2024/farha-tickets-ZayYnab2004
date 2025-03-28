<?php
require 'config.php';
$erreurs=[];
if(isset($_POST['submit'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hpassword=password_hash($password , PASSWORD_DEFAULT);
    $idUser=substr(uniqid(),-4);
    if(!empty($firstname) && !empty($lastname ) && !empty($email) && !empty($password) && !empty($confirm_password) && $password==$confirm_password && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=$pdo->prepare("Select * from utilisateur where mailUser= :email");
        $check_email->bindParam( ':email',$email);
        $check_email->execute();
        if($check_email->rowCount()==0){
        $insert_client=$pdo->prepare("insert into utilisateur(idUser,nomUser,prenomUser,mailUser,password) values(:idUser,:nomUser,:prenomUser,:mailUser,:password)");
        $insert_client->bindParam(':idUser',$idUser) ;
        $insert_client->bindParam(':prenomUser',$firstname) ;
        $insert_client->bindParam(':nomUser',$lastname) ;
        $insert_client->bindParam(':mailUser',$email);
        $insert_client->bindParam(':password',$hpassword);
        $insert_client->execute();
        }
    }else {
        if(empty($firstname)){
            $erreurs['firstname']="fill in the firstname";
        }
        if(empty($lastname)){
            $erreurs['lastname']="fill in the lastname";
        }
        if(empty($email)){
            $erreurs['email']="fill in the email";
        }
        
        if (empty($password)) {
            $erreurs['password'] = "fill in the password";
        }
        if ($password !== $confirm_password) {
            $erreurs['password'] = "Passwords do not match";
        }
       
    }
};
 	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      body {
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
    background-color: #f7f7f7;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.auth-form {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: border 0.3s ease;
}

input:focus {
    border-color: #ff66b2; /* لون وردي جذاب */
    box-shadow: 0 0 5px rgba(255, 102, 178, 0.3);
}

button {
    width: 100%;
    background-color: #ff66b2;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #ff3385;
}

.erreur {
    color: red;
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    display: block;
    text-align: center;
}


    </style>
</head>
<body>
<form action="register.php" method="POST" class="auth-form">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" >
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" >
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" >
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" >
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" >
        </div>
        <button type="submit" name="submit">Register</button>
    </form>
    <?php
   if(count($erreurs) > 0){
    foreach($erreurs as $erreur){
        echo "<span class='erreur'>" . $erreur . "</span><br>";
    }
}
  ?>
  
</body>
</html>
