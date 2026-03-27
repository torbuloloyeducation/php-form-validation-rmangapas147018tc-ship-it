<?php
$name = $email = $gender = $website = $phone = "";
$password = $confirm = "";
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$phoneErr = $passwordErr = $confirmErr = $termsErr = "";
$count = 0;

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $count = isset($_POST['count']) ? $_POST['count'] + 1 : 1;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Min 8 characters";
        }
    }

    if (empty($_POST["confirm"])) {
        $confirmErr = "Confirm password";
    } else {
        $confirm = $_POST["confirm"];
        if ($password !== $confirm) {
            $confirmErr = "Passwords do not match";
        }
    }

    if (!isset($_POST["terms"])) {
        $termsErr = "Agree to terms";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>PHP Form Validation</h2>

    <form method="POST" action="">

        <input type="text" name="name" placeholder="Name" value="<?= $name ?>">
        <span class="error"><?= $nameErr ?></span>

        <input type="text" name="email" placeholder="Email" value="<?= $email ?>">
        <span class="error"><?= $emailErr ?></span>

        <input type="text" name="website" placeholder="Website" value="<?= $website ?>">
        <span class="error"><?= $websiteErr ?></span>

        <input type="text" name="phone" placeholder="Phone" value="<?= $phone ?>">
        <span class="error"><?= $phoneErr ?></span>

        <input type="password" name="password" placeholder="Password">
        <span class="error"><?= $passwordErr ?></span>

        <input type="password" name="confirm" placeholder="Confirm Password">
        <span class="error"><?= $confirmErr ?></span>

        <div class="gender">
            <label><input type="radio" name="gender" value="male" <?= ($gender=="male")?"checked":"" ?>> Male</label>
            <label><input type="radio" name="gender" value="female" <?= ($gender=="female")?"checked":"" ?>> Female</label>
        </div>
        <span class="error"><?= $genderErr ?></span>

        <div class="terms">
            <input type="checkbox" name="terms"> Agree to terms
        </div>
        <span class="error"><?= $termsErr ?></span>

        <input type="hidden" name="count" value="<?= $count ?>">

        <button type="submit">Submit</button>
    </form>

    <p>Submission attempt: <?= $count ?></p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" &&
        empty($nameErr) && empty($emailErr) && empty($genderErr) &&
        empty($phoneErr) && empty($passwordErr) &&
        empty($confirmErr) && empty($termsErr)) {

        echo "<div class='success'>";
        echo "<h3>Success!</h3>";
        echo "Name: $name <br>";
        echo "Email: $email <br>";
        echo "Phone: $phone <br>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>