<?php 

class UserModel{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $role;
    public $created_at;
    public $updated_at;
    function __construct($user_data){
        if(isset($user_data['id'])){
            $this->id = $user_data['id'];
        }
        $this->username = $user_data['username'];
        $this->first_name = $user_data['first_name'];
        $this->last_name = $user_data['last_name'];
        $this->email = $user_data['email'];
        $this->password = $user_data['password'];
        if(isset($user_data['role'])){
            $this->role = $user_data['role'];
        }
        if (isset($user_data['created_at'])) {
            $this->created_at = $user_data['created_at'];
        }
        if (isset($user_data['updated_at'])) {
            $this->updated_at = $user_data['updated_at'];
        }
    }
    function save(){
        require "../controllers/DatabaseController.php";
        $query = "INSERT INTO users(username,first_name,last_name,email,password,role) VALUES('{$this->username}','{$this->first_name}','{$this->last_name}','{$this->email}','{$this->password}','{$this->role}')";
        if($database->query($query) === TRUE){
            return $database->insert_id;
        }
        else{
            return -1;
            // return $database->error;
        }
    }
    function update(){
        require "../controllers/DatabaseController.php";

        $query = "UPDATE users SET username = '{$this->username}', first_name = '{$this->first_name}', last_name = '{$this->last_name}',email = '{$this->email}',password = '{$this->password}', updated_at = CURRENT_TIMESTAMP WHERE id = {$this->id}";

        if($database->query($query) === TRUE){
            return 1;
        }
        else{
            return $query;
            return $database->error;
            throw new Exception($database->error);
        }
    }
    static function doesExist($id,$username,$email)
    {
        include("../controllers/DatabaseController.php");
        if($id == null){
            $query = "SELECT * FROM users where (username = '{$username}' OR email = '{$email}')";

        }
        else{
            $query = "SELECT * FROM users where (username = '{$username}' OR email = '{$email}') AND id != {$id}";
        }
        return $database->query($query)->fetch_all();
        if (count($database->query($query)->fetch_all()) == 0){
            return false;
        }
        return true;
    }
    static function getUsername($user_id){
        require "../controllers/DatabaseController.php";

        $query = "SELECT username FROM users WHERE id = {$user_id} LIMIT 1";

        $res = $database->query($query)->fetch_assoc();
        return $res['username'];
    }
    static function getAllUsers(){
        require "../controllers/DatabaseController.php";

        $query = "SELECT * FROM users";

        $results = $database->query($query);
        $users = [];
        while($user_row = $results->fetch_assoc()){
            $user = new UserModel($user_row);
            array_push($users,$user);
        }
        return $users;
    }
    static function getUser($user_id){
        require "../controllers/DatabaseController.php";

        $query = "SELECT * FROM users WHERE id = {$user_id} LIMIT 1";
        try{
            $user = new UserModel($database->query($query)->fetch_assoc());
            return $user;
        }
        catch(Exception $e){
            new Exception("Trazeni korisnik ne postoji u bazi podataka");
        }
    }

}


?>