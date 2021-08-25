<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php include("../components/bootstrap.php"); ?>
</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../controllers/DatabaseController.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>
    <h1 class="text-center mt-5">Pregled korisnika</h1>

    <?php
    require "../models/UserModel.php";
    $users = UserModel::getAllUsers();
    ?>

    <div class="container mt-5">
        <div class="users-container">
            <?php foreach ($users as $user) : ?>
                <?php if($user->username != "admin"):?>
                <div class="user shadow-custom">
                    <div class="user-icon shadow-custom">
                        <i class='fas fa-user'></i>
                    </div>
                    <div class="user-info">
                        <p class="font-weight-bold"><?php echo $user->username; ?></p>
                        <p><?php echo $user->first_name . " " .  $user->last_name; ?></p>
                        <p class=>Nalog kreiran: <?php echo $user->created_at; ?></p>
                    </div>
                    <div class="user-actions">
                        <div class="delete-user">
                            <button class="neumorphic-button " id="uid-<?php echo $user->id ?>" data-toggle="modal" data-target="#removeUserModal">Ukloni korisnika</button>
                        </div>
                        <div class="edit-user">
                            <button class="neumorphic-button " id="uid-<?php echo $user->id ?>" data-toggle="modal" data-target="#editModal" onclick="getUserData(<?php echo $user->id; ?>)">Izmeni korisnika</button>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>

    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-default px-5 py-3 br-2">
                <div class="modal-header">
                    <h5 class="modal-title">Izmena korisnika</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="neumorphic-form">
                        <div id="alert-placeholder"></div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="first_name" id="first_name" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="first_name">Ime</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="last_name" id="last_name" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="last_name">Prezime</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="username" id="username" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="username">Korisnicko ime</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="email">Email adresa</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" type = "password" required="required" type="text" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="password">Lozinka</label>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="neumorphic-button px-5 py-3 mr-5 border-animate-warning" data-dismiss="modal">Otkazi</button>
                    <button type="button" class="neumorphic-button px-5 py-3 ml-5 border-animate-danger" onclick="editSubmit()">Potvrdi</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content bg-default px-5 py-3 br-2">
                <div class="modal-header">
                    <h5 class="modal-title">Potvrda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="remove-alert-placeholder"></div>
                    <p class="text-center">Brisanjem korisnika onemogucava se njegovo prijavljivanje kao i koriscenje. Svi podaci povezani sa nalogom bice takodje obrisani. <br><b>Obrisi korisnika?</b></p>
                    <input type="hidden" name="" id="remove_user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="neumorphic-button px-5 py-3 mr-5 border-animate-warning" data-dismiss="modal">Otkazi</button>
                    <button type="button" class="neumorphic-button px-5 py-3 ml-5 border-animate-danger" onclick="confirmRemoveUser()">Potvrdi</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../resources/js/admin.js"></script>
</body>

</html>