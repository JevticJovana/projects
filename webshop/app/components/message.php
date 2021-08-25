<?php include_once("../controllers/SessionController.php"); ?>
<?php if (isset($_SESSION['message'])) : ?>
    <?php if ($_SESSION['message']['status'] == 200) : ?>
        <div class="alert alert-success alert-dissmissible text-center mt-3" role="alert">
            <h4 class="alert-heading">Uspeh</h4>
            <p><?php echo $_SESSION['message']['text']; ?></p>
        </div>
    <?php elseif ($_SESSION['message']['status'] == 500) : ?>
        <div class="alert alert-danger alert-dissmissible text-center mt-3" role="alert">
            <h4 class="alert-heading">Greska</h4>
            <p><?php echo $_SESSION['message']['text']; ?></p>
        </div>
    <?php endif ?>
    <?php unset($_SESSION['message']); ?>
<?php endif ?>