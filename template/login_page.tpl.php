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

<?php function drawLoginForm()
{ ?>
    <div>
        <div class="loginform">
            <form action="/actions/login_process.php" method="post">
                <p>If you already have an account:</p>
                <input type="text" id="loginemail" name="loginemail" placeholder="Email">
                <input type="password" id="loginpassword" name="loginpassword" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        </div>
        <?php if (isset($_GET['loginerror'])) { ?>
            <script>
                alert("<?= $_GET['loginerror'] ?>")
            </script>
        <?php }  ?>
    </div>
<?php } ?>

<?php function drawRegisterForm()
{ ?>
    <div>
        <div class="registerform">
            <form action="/actions/register_process.php" method="post">
                <p>If you don't have an account:</p>
                <div class="nameemail">
                    <input type="text" id="registername" name="registername" placeholder="Name">
                    <input type="text" id="registeremail" name="registeremail" placeholder="Email">
                </div>
                <input type="password" id="registerpassword" name="registerpassword" placeholder="Password">
                <input type="submit" value="Register">
            </form>
        </div>
        <?php if (isset($_GET['registererror'])) { ?>
            <script>
                alert("<?= $_GET['registererror'] ?>")
            </script>
        <?php }  ?>
    </div>
<?php } ?>