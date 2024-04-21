<?php declare(strict_types = 1); ?>

<?php function drawLoginHeader() { ?>
    <header id="login-header">
        <a href="/">
            <img src="svg/logo_large.svg" alt="Trinted Logo" id="logo">
        </a>
    </header>
<?php } ?>

<?php function drawWelcomeText() { ?>
    <div class="welcometext">
        <h1>Welcome to</h1>
        <h1 id="title">TRINTED</h1>
    </div>
<?php } ?>

<?php function drawLoginForm() { ?>
    <div class="loginform">
        <form>
            <p>If you already have an account:</p>
            <input type="text" id="loginemail" name="loginemail" placeholder="Email">
            <input type="password" id="loginpassword" name="loginpassword" placeholder="Password">
            <input type="submit" value="Login">
        </form>
    </div>
<?php } ?>

<?php function drawRegisterForm() { ?>
    <div class="registerform">
        <p>If you don't have an account:</p>
        <form>
            <div class="nameemail">
                <input type="text" id="registername" name="registername" placeholder="Name">
                <input type="text" id="registeremail" name="registeremail" placeholder="Email">
            </div>
            <input type="password" id="registerpassword" name="registerpassword" placeholder="Password">
            <input type="submit" value="Register">
        </form>
    </div>
<?php } ?>
