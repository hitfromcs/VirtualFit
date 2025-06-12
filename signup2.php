<?php
$email = isset($_GET['email']) ? htmlspecialchars(trim($_GET['email'])) : '';
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid access. No user specified.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Signup - Step 2</title>
    <link rel="stylesheet" href="signup.css" />
</head>
<body>
    <div class="container">
        <img src="VFlogo.png" class="img1" width="160px" height="80px" alt="logo" />
        <h2>Signup</h2>

        <form id="signupForm" action="signup2_process.php" method="post">
            <input type="hidden" name="email" value="<?php echo $email; ?>" />

            <div class="form-step step-2 active">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label for="height">Height</label>
                <div class="height-group">
                    <input type="number" id="height-feet" name="height_feet" min="1" max="6" placeholder="Feet" required />
                    <input type="number" id="height-inches" name="height_inches" min="0" max="11" placeholder="Inches" required />
                </div>

                <label for="waist">Waist Size (inches)</label>
                <input type="number" id="waist" name="waist" min="28" max="38" required />

                <label for="chest">Chest Size (inches)</label>
                <input type="number" id="chest" name="chest" min="34" max="48" required />

                <label>Skin Tone</label>
                <div class="skin-tone-options">
                    <input type="radio" id="light" name="skin_tone" value="light" required />
                    <label for="light" class="skin-tone light"></label>

                    <input type="radio" id="dark" name="skin_tone" value="dark" />
                    <label for="dark" class="skin-tone dark"></label>
                </div>

                <div class="btn-container">
                    <button type="button" class="btn back-btn" onclick="window.history.back()">Back</button>
                    <button type="submit" class="btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
