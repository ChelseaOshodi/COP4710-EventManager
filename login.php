<?php
    include_once 'header.php';
?>

<div class="box">
    <?php
        $message = null;
        if(isset($_GET["error"])) {
            if ($_GET["error"] == "empty_input") {
                $message = "<p style='color:red'>You must fill in all fields.<br><br></p>";
            }
            if ($_GET["error"] == "no_user") {
                $message =  "<p style='color:red'>Email not found.<br><br></p>";
            }
            if ($_GET["error"] == "incorrect_password") {
                $message =  "<p style='color:red'>Incorrect password.<br><br></p>";
            }
            if ($_GET["error"] == "none") {
                $message =  "<p style='color:blue'>Sign up successful. Please, log in.<br><br></p>";
            }
        }   
    ?>

    <form action="include/login-include.php" class="form5" method="post">
        <div>
            <p class="heading2-L">Log In</p>
            <div class="error5">
                <span class="error5">
                    <?php
                        if (!is_null($message)) {
                               echo $message;
                        }
                    ?>
                </span>
            </div>
            <label>
                <span class="label5">Email</span>
                <input class="input5" type="text" name="email">
            </label>

            <label>
                <span class="label5">Password</span>
                <input class="input5" type="password" name="password">
            </label>

            <button class="button5" type="submit" name="submit">Log In</button>
        </div>
    </form>
</div>


<?php
    include_once 'footer.php';
?>