<?php
include_once '../core/helpers/session_helper.php'
?>

<h1>Sign up</h1>
<?php flash('register') ?>

<!--<form action="../Http/Controllers/AuthController.php" method="post">-->
<!--    <input type="hidden" name="type" value="register">-->
<!--    <input type="text" name="user_name" placeholder="Full Name">-->
<!--    <input type="text" name="user_email" placeholder="Email">-->
<!--    <input type="text" name="user_uid" placeholder="Username">-->
<!--    <input type="text" name="user_pwd" placeholder="User password">-->
<!--    <input type="text" name="user_pwd_repeat" placeholder="Confirm password">-->
<!---->
<!--    <button type="submit" name="submit">Sign up</button>-->
<!--</form>-->

<form action="/" method="post">
    <input type="hidden" name="type" value="register">
    <div class="mb-3">
        <label for="user_name" class="form-label">Full name</label>
        <input type="text" name="user_name" placeholder="Full Name" class="form-control" id="user_name"
               aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="text" name="user_email" placeholder="Email" class="form-control" id="email"
               aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="uid" class="form-label">User name</label>
        <input type="text" name="user_uid" placeholder="Username" class="form-control" id="uid"
               aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="user_pwd" placeholder="User password" id="password">
    </div>
    <div class="mb-3">
        <label for="password-repeat" class="form-label">Confirm Password</label>
        <input type="password" name="user_pwd_repeat" placeholder="Confirm password" id="password-repeat">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Sign up</button>
</form>