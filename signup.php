<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Step 1</title>
    <link rel="stylesheet" href="signup.css">
    <script>
        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;

            if (!name || !email || !password) {
                alert("All fields are required.");
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (password.length < 6 || password.length > 255) {
                alert("Password must be between 6 and 255 characters.");
                return false;
            }

            if (name.length > 100) {
                alert("Name is too long.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <img src="VFlogo.png" class="img1" width="160px" height="80px" alt="logo">
    <h2>Signup</h2>

    <form action="signup_process.php" method="post" onsubmit="return validateForm()">
        <div class="form-step step-1 active">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required maxlength="100" pattern="^[a-zA-Z\s\.\-']+$">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required maxlength="255">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required minlength="6" maxlength="255">

            <button type="submit" class="btn next-btn">Next</button>
        </div>

        <div class="extra-links">
            <p style="font-size: 14px; color: #4cc5b7; margin-top: 10px;">
                Already have an account?
                <a style="color: white; text-decoration: underline;" href="login.php">Login</a>
            </p>
        </div>
    </form>
</div>

</body>
</html>
