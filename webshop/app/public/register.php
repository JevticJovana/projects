<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijavite se</title>
    <?php include("../components/bootstrap.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/message.php");?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <div class="container mt-5">
        <h1 class="text-center">Prijavite se na vas nalog</h1>
        <h4 class="text-center">Unesite podatke navedene u formi kako biste se prijavili na vas nalog</h4>
    </div>
    <div class="container mt-5">
        <form action="../controllers/UserController.php" method="post" class="neumorphic-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="neumorphic-input-container">
                        <input type="text" class="neumorphic-input" required="required" name="first_name" id="first_name" aria-describedby="helpId" placeholder="">
                        <label class="neumorphic-label" for="first_name">Ime</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="neumorphic-input-container">
                        <input type="text" class="neumorphic-input" required="required" name="last_name" id="first_name" aria-describedby="helpId" placeholder="">
                        <label class="neumorphic-label" for="last_name">Prezime</label>
                    </div>
                </div>
            </div>
            <div class="neumorphic-input-container">
                <input type="text" name="username" id="username" class="neumorphic-input" required="required" placeholder="" aria-describedby="helpId">
                <label class="neumorphic-label" for="username">Korisnicko ime</label>
            </div>
            <div class="neumorphic-input-container">
                <input type="text" name="email" id="email" class="neumorphic-input" required="required" placeholder="adresa@provajder.com" aria-describedby="helpId">
                <label class="neumorphic-label" for="email">Email adresa</label>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="neumorphic-input-container">
                        <input type="password" class="neumorphic-input" required="required" name="password" id="password" aria-describedby="helpId" placeholder="">
                        <label class="neumorphic-label" for="password">Lozinka</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="neumorphic-input-container">
                        <input type="password" class="neumorphic-input" required="required" name="confirm_password" id="confirm_password" aria-describedby="helpId" placeholder="">
                        <label class="neumorphic-label" for="confirm_password">Potvrda lozinke</label>
                    </div>
                </div>
            </div>
            <h5 class="text-center">Registrujem se kao</h5>
            <div class="neumorphic-input-container radio">
                <div class="wrapper shadow-custom">
                    <input type="radio" name="role" id="option-1" value="buyer" class="hiddenRadio">
                    <input type="radio" name="role" id="option-2" value="seller" class="hiddenRadio">
                    <label for="option-1" class="option option-1 shadow-custom" >
                        <div class="dot"></div>
                        <span>Kupac</span>
                    </label>
                    <label for="option-2" class="option option-2 shadow-custom">
                        <div class="dot"></div>
                        <span>Prodavac</span>
                    </label>
                </div>
            </div>
            
            <input type="hidden" name="register">
            <p class="form-text text-muted text-center">
                Vec imate nalog? Prijavite se <a href="./login.php">ovde</a>.
            </p>
            <button type="submit" class="neumorphic-button w-100">Registruj se</button>
        </form>
    </div>
</body>

</html>