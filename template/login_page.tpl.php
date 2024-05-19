<?php

declare(strict_types=1); ?>

<?php function drawLoginHeader()
{ ?>
    <header id="login-header">
        <a href="/">
            <img src="/svg/logo_large.svg" alt="Trinted Logo" id="logo">
        </a>
    </header>
<?php } ?>

<?php function drawWelcomeText()
{ ?>
    <div class="welcometext">
        <h1>Welcome to</h1>
        <h1 id="title">TRINTED</h1>
    </div>
<?php } ?>

<?php function drawLoginForm(Request $request)
{ ?>
    <div>
        <div class="loginform">
            <form action="/actions/action_login.php" method="post">
                <p>If you already have an account:</p>
                <input type="text" id="login-email" name="login-email" placeholder="Email">
                <input type="password" id="login-password" name="login-password" placeholder="Password">
                <input type="hidden" name="csrf" value="<?= $request->getSession()->getCsrf() ?>">
                <input type="submit" value="Login">
            </form>
        </div>
        <?php if ($request->get('login-error') != null) { ?>
            <script>
                alert("<?= $request->get('login-error') ?>")
            </script>
        <?php }  ?>
    </div>
<?php } ?>

<?php function drawRegisterForm(Request $request)
{ ?>
    <div>
        <div class="registerform">
            <form action="/actions/action_register.php" method="post">
                <p>If you don't have an account:</p>
                <div class="nameemail">
                    <input type="text" id="register-name" name="register-name" placeholder="Name">
                    <input type="text" id="register-email" name="register-email" placeholder="Email">
                </div>
                <input type="password" id="register-password" name="register-password" placeholder="Password">
                <input type="hidden" name="csrf" value="<?= $request->getSession()->getCsrf() ?>">
                <input type="submit" value="Register">
            </form>
        </div>
        <?php if ($request->get('register-error') != null) { ?>
            <script>
                alert("<?= $request->get('register-error') ?>")
            </script>
        <?php }  ?>
    </div>
<?php } ?>