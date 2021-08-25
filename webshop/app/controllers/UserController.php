<?php 
    include('./DatabaseController.php');
    include('./SessionController.php');
    include('../models/UserModel.php');
    if(isset($_POST['login'])){
        if($_POST['username'] == "" || $_POST['password'] == ""){
            setMessage('Molimo unesite sve podatke',500);
            header('location: ../public/login.php');
        }
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = "SELECT * FROM users where (username = '{$username}' OR email = '{$username}') AND password = '{$password}' LIMIT 1";
        $result = $database->query($query);
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            $_SESSION['user']['uid'] = $user['id'];
            $_SESSION['user']['username'] = $user['username'];
            $_SESSION['user']['role'] = $user['role'];
            if($user['role'] == 'buyer'){
                header("location: ../public/home.php");
            }
            if ($user['role'] == 'seller') {
                header("location: ../public/seller.php");
            }
            if ($user['role'] == 'admin') {
                header("location: ../public/admin.php");
            }
        }
        else{
            setMessage('Pogresna lozinka ili korisnicko ime. Promenite podatke i pokusajte ponovo',500);
            header("location: ../public/login.php");
        }
    }
    if(isset($_POST['register'])){
        if($_POST['role'] == null){
            setMessage("Molimo odaberite tip korisnika kog registrujete",500);
            header("location:../public/register.php");
            return;
        }
		
		if($_POST['confirm_password'] !== $_POST['password']) {
			setMessage("Molimo unesite ispravnu potvrdu lozinke",500);
            header("location:../public/register.php");
            return;
		}
		
        $user_data = [];
        $user_data['username'] = $_POST['username'];
        $user_data['first_name'] = $_POST['first_name'];
        $user_data['last_name'] = $_POST['last_name'];
        $user_data['email'] = $_POST['email'];
        $user_data['password'] = md5($_POST['password']);
        $user_data['role'] = $_POST['role'];
        $userModelInstance = new UserModel($user_data);
        $exists = UserModel::doesExist(null,$userModelInstance->username,$userModelInstance->email);
        if(!$exists){
            $user_id = $userModelInstance->save();

            if($user_id == -1){
                setMessage("Doslo je do greske prilikom kreiranja naloga.",500);
                header("location:../index.php");
                return;
            }

            $_SESSION['user']['uid'] = $user_id;
            $_SESSION['user']['username'] = $userModelInstance->username;
            $_SESSION['user']['role'] = $userModelInstance->role;
            setMessage("Uspesna registracija! Dobro dosli!",200);
            if($userModelInstance->role == 'buyer'){
                header('location: ../public/home.php');
                return;
            }
            if($userModelInstance->role == 'seller'){
                header('location: ../public/seller.php');
                return;
            }
            if($userModelInstance->role == 'admin'){
                header("location: ../public/admin.php");
                return;
            }
        }
        else{
            setMessage("Korisnik sa ovim korisnickim imenom ili email adresom vec postoji. Odaberite novo korisnicko ime ili email adresu i pokusajte ponovo.",500);
            header("location:../public/register.php");
        }
    }
    if(isset($_GET['find_user'])){
        $user_id = $_GET['user_id'];
        $status = [];
        // echo $user_id;
        // return;
        try{
            $user = UserModel::getUser($user_id);
            $status['status'] = 200;
            $status['message'] = "Korisnik je pronadjen";
            $status['response'] = $user;
        }
        catch(Exception $e){
            $status['status'] = 200;
            $status['message'] = "Korisnik nije pronadjen";
            $status['response'] = $e->getMessage();    
        }
        finally{
            echo json_encode($status);
        }
    }
    if(isset($_POST['edit_user'])){
        $response = [];
        $user_id = $_POST['id'];
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $_POST['password'] = md5($_POST['password']);
        if($username == "" || $first_name == "" || $last_name == "" || $email == ""){
            $response['status']['status'] = 500;
            $response['status']['message'] = "Nisu popunjeni svi podaci. Popunite podatke i pokusajte ponovo";
            echo json_encode($response);
            return;
        }
        $userExists = false;

        $userExists = UserModel::doesExist($user_id,$username,$email);
        if($userExists){
            $response['status']['status'] = 500;
            $response['status']['message'] = "Korisnik sa ovim korisnickim imenom ili email adresom vec postoji";
            echo json_encode($response);
            return;
        }
        else{
            try{
                $user = new UserModel($_POST);
                $res = $user->update();
                $response['status']['status'] = 200;
                $response['status']['message'] = "Korisnik je uspesno izmenjen";
                echo json_encode($response);
                return;
            }
            catch(Exception){
                // echo $database->error;
                $response['status']['status'] = 500;
                $response['status']['message'] = $database->error;
                json_encode($response);
                return;
            }
        }
    }   
    if(isset($_POST['remove_user'])){
        $user_id = $_POST['user_id'];
        try{
            $query = "DELETE FROM users WHERE user_id = {$user_id}";
            $database->query($query);
            $response['status']['status'] = 200;
            $response['status']['message'] = "Korisnik je uspesno uklonjen iz baze podataka";
            echo json_encode($response);
        }
        catch(Exception){
            $response['status']['status'] = 500;
            $response['status']['message'] = $database->error;
            echo json_encode($response);
        }
    }
?>