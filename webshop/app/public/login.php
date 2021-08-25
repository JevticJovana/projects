<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijavite se</title>
    <?php include("../components/bootstrap.php"); ?>

</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <div class="container mt-5">
        <h1 class="text-center">Prijavite se na vas nalog</h1>
        <h4 class="text-center">Unesite podatke navedene u formi kako biste se prijavili na vas nalog</h4>
    </div>
    <div class="container mt-5">
        <form action="../controllers/UserController.php" method="post" class="neumorphic-form">
            <div class="neumorphic-input-container">
                <input type="text" class="neumorphic-input" name="username" id="username" required="required" aria-describedby="helpId" placeholder="">
                <label for="username" class="neumorphic-label">Korisnicko ime ili email adresa</label>
            </div>
            <div class="form-group">
                <input type="password" class="neumorphic-input" name="password" id="password" required="required" aria-describedby="helpId" placeholder="">
                <label for="password" class="neumorphic-label">Lozinka</label>
            </div>
            <input type="hidden" name="login">
            <p class="form-text text-muted text-center">
                Nemate nalog? Registrujte se <a href="./register.php">ovde</a>.
            </p>
            <button type="submit" class="neumorphic-button w-100">Uloguj se</button>
        </form>
    </div>
</body>

</html>