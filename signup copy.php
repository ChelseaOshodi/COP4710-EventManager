<?php
    include_once 'header.php';
?>

<div class="box">
    <?php
        $message = null;
        if(isset($_GET["error"])) {
            if ($_GET["error"] == "empty_input") {
                $message =  "<p style='color:red'>You must fill in all fields.<br><br></p>";
            }
            if ($_GET["error"] == "invalid_email") {
                $message =  "<p style='color:red'>Invalid Email. Please try again.<br><br></p>";
            }  
            if ($_GET["error"] == "password_mismatch") {
                $message =  "<p style='color:red'>Passwords do not match.<br><br></p>";
            }
            if ($_GET["error"] == "email_exists") {
                $message =  "<p style='color:red'>Account with entered email already exists.<br><br></p>";
            }
            if ($_GET["error"] == "bad_stmt") {
                $message =  "<p style='color:red'>Database error. Please try again.<br><br></p>";
            }        
            if ($_GET["error"] == "none") {
                $message =  "<p style='color:blue'>Sign up successful. Pleaes, log in.<br><br></p>";
            }
        } 
    ?>

    <form action="superAdmin-signup.php" class="form5" method="post">
        <div>
            <p class="heading2">Sign Up</p></br>
            <div class="error5">
                <span class="error5">
                    <?php
                        if (!is_null($message)) {
                            echo "\n";
                            echo $message;
                        }
                    ?>
                </span>
            </div>
            <label>
                <span class="label5">Full Name</span>
                <input class="input5" type="text" name="fullName">
            </label>

            <label>
                <span class="label5">Email</span>
                <input class="input5" type="text" name="email">
            </label>

            <label>
                <span class="label5">Password</span>
                <input class="input5" type="password" name="uPassword">
            </label>
            
            <label>
                <span class="label5">Confirm Password</span>
                <input class="input5" type="password" name="passwordConfirm">
            </label>

            <label>
                <span class="label5">School Name</span>
                <input class="input5" type="text" name="schoolName">
            </label>

            <button class="button5" type="submit" name="submit">Sign Up</button>
        </div>
    </form>
</div>

