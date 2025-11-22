<?php
session_start();
require_once __DIR__ . "/config/db.php";

// Messages for each role
$adminMessage = "";
$ownerMessage = "";
$userMessage  = "";

// Handle login submit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["role"])) {
    $role     = $_POST["role"];
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $username = $_POST["username"] ?? "";

    // ---------- ADMIN LOGIN ----------
    if ($role === "admin") {
        // Hardcoded admin credentials
        if ($username === "admin" && $password === "admin123") {
            $_SESSION["admin"] = true;
            header("Location: admin/dashboard.php");
            exit;
        } else {
            $adminMessage = "Invalid admin username or password.";
        }
    }

    // ---------- OWNER LOGIN ----------
    if ($role === "owner") {
        if ($email === "" || $password === "") {
            $ownerMessage = "Please enter email and password.";
        } else {
            $sql = "SELECT * FROM owners WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                // Plain text password check (as per your latest code)
                if ($password === $row["password"]) {
                    if ((int)$row["verified"] === 1) {
                        $_SESSION["owner_id"]   = $row["id"];
                        $_SESSION["owner_name"] = $row["name"];
                        header("Location: owner/dashboard.php");
                        exit;
                    } else {
                        $ownerMessage = "Your account is not approved by admin yet.";
                    }
                } else {
                    $ownerMessage = "Incorrect password.";
                }
            } else {
                $ownerMessage = "No owner account found with this email.";
            }
        }
    }

    // ---------- USER LOGIN (optional / basic) ----------
    if ($role === "user") {
        // Only enable this if you have a `users` table
        // Example logic (you can change table/columns as needed):
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["user_name"] = $user["name"] ?? $user["email"];
                header("Location: user/dashboard.php");
                exit;
            } else {
                $userMessage = "Invalid user email or password.";
            }
        } else {
            $userMessage = "Login error. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EV Smart Assistant – Login</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top, #00e5ff, #00111f 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f5f5f5;
        }
        .login-wrapper {
            width: 900px;
            max-width: 95%;
            background: rgba(3, 15, 30, 0.9);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            display: flex;
            overflow: hidden;
        }
        .login-left {
            flex: 1;
            padding: 30px;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }
        .login-right {
            flex: 1.2;
            padding: 30px;
        }
        .app-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }
        .app-subtitle {
            font-size: 13px;
            color: #a8c5dd;
            margin-bottom: 20px;
        }
        .ev-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 229, 255, 0.1);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            color: #8be9ff;
            margin-bottom: 20px;
        }
        .ev-badge span.icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #00e5ff;
            box-shadow: 0 0 10px #00e5ff;
        }
        .feature-list {
            list-style: none;
            padding: 0;
            margin-top: 10px;
            color: #c6e1ff;
            font-size: 13px;
        }
        .feature-list li {
            margin-bottom: 8px;
        }
        .feature-list li::before {
            content: "• ";
            color: #00e5ff;
        }
        .role-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .role-tab {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            cursor: pointer;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.16);
            font-size: 14px;
            color: #b8c8de;
            transition: all 0.2s ease;
            background: rgba(14, 30, 57, 0.7);
        }
        .role-tab.active {
            background: linear-gradient(135deg, #00e5ff, #00b8d4);
            color: #051622;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(0,229,255,0.6);
            border-color: transparent;
        }
        .form-title {
            font-size: 18px;
            margin-bottom: 4px;
        }
        .form-subtitle {
            font-size: 12px;
            color: #8ba3bf;
            margin-bottom: 15px;
        }
        form {
            margin-top: 10px;
        }
        .field-group {
            margin-bottom: 14px;
        }
        .field-label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
            color: #d7e9ff;
        }
        .field-input {
            width: 100%;
            padding: 10px 11px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(6, 20, 40, 0.9);
            color: #eaf4ff;
            font-size: 13px;
        }
        .field-input:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 0 1px rgba(0,229,255,0.4);
        }
        .login-button {
            width: 100%;
            padding: 10px;
            border-radius: 999px;
            border: none;
            font-size: 14px;
            font-weight: bold;
            color: #03101D;
            background: linear-gradient(135deg, #00e5ff, #00b8d4);
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 10px 25px rgba(0, 229, 255, 0.4);
        }
        .login-button:hover {
            filter: brightness(1.05);
        }
        .message {
            margin-top: 8px;
            font-size: 12px;
        }
        .message.error {
            color: #ff7777;
        }
        .message.success {
            color: #4cd964;
        }
        .hint {
            font-size: 11px;
            color: #6f86a5;
            margin-top: 6px;
        }
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .login-left {
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-left">
        <div class="ev-badge">
            <span class="icon"></span>
            EV Smart Route & Charging Assistant
        </div>
        <div class="app-title">Drive smarter, charge confidently.</div>
        <div class="app-subtitle">
            One login panel for Admin, Station Owners, and Drivers — keep your EV journeys accurate and stress-free.
        </div>

        <ul class="feature-list">
            <li>Owner-verified charging stations only</li>
            <li>Smart range & route feasibility tools</li>
            <li>Admin approval for trusted station data</li>
            <li>Clean, simple dashboard for each role</li>
        </ul>
    </div>

    <div class="login-right">
        <div class="role-tabs">
            <div class="role-tab active" data-role="owner">Owner Login</div>
            <div class="role-tab" data-role="admin">Admin Login</div>
            <div class="role-tab" data-role="user">User Login</div>
        </div>

        <div class="form-title" id="form-title">Owner Login</div>
        <div class="form-subtitle" id="form-subtitle">
            Login as a verified charging station owner to manage your stations.
        </div>

        <form method="post" id="login-form">
            <!-- Hidden role field -->
            <input type="hidden" name="role" id="role-input" value="owner">

            <!-- Admin username (shown only for admin) -->
            <div class="field-group" id="group-username" style="display:none;">
                <label class="field-label" for="username-input">Admin Username</label>
                <input class="field-input" type="text" id="username-input" name="username" placeholder="Enter admin username">
            </div>

            <!-- Email (for owner/user) -->
            <div class="field-group" id="group-email">
                <label class="field-label" for="email-input">Email</label>
                <input class="field-input" type="email" id="email-input" name="email" placeholder="you@example.com">
            </div>

            <!-- Password (for all roles) -->
            <div class="field-group" id="group-password">
                <label class="field-label" for="password-input">Password</label>
                <input class="field-input" type="password" id="password-input" name="password" placeholder="Enter your password">
            </div>

            <button type="submit" class="login-button">Continue</button>

            <!-- Messages per role -->
            <?php if ($ownerMessage !== ""): ?>
                <div class="message error" id="owner-message"><?php echo $ownerMessage; ?></div>
            <?php endif; ?>

            <?php if ($adminMessage !== ""): ?>
                <div class="message error" id="admin-message"><?php echo $adminMessage; ?></div>
            <?php endif; ?>

            <?php if ($userMessage !== ""): ?>
                <div class="message error" id="user-message"><?php echo $userMessage; ?></div>
            <?php endif; ?>

            <div class="hint" id="role-hint">
                Tip: Default admin credentials – <b>admin / admin123</b> (you can change later).
            </div>
        </form>
    </div>
</div>

<script>
// Simple tab switching logic
const tabs          = document.querySelectorAll(".role-tab");
const roleInput     = document.getElementById("role-input");
const formTitle     = document.getElementById("form-title");
const formSubtitle  = document.getElementById("form-subtitle");
const groupUsername = document.getElementById("group-username");
const groupEmail    = document.getElementById("group-email");
const roleHint      = document.getElementById("role-hint");

tabs.forEach(tab => {
    tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");
        const role = tab.getAttribute("data-role");
        roleInput.value = role;

        if (role === "owner") {
            formTitle.textContent    = "Owner Login";
            formSubtitle.textContent = "Login as a verified charging station owner to manage your stations.";
            groupUsername.style.display = "none";
            groupEmail.style.display    = "block";
            roleHint.innerHTML = "Owners must be approved by admin before they can log in.";
        } else if (role === "admin") {
            formTitle.textContent    = "Admin Login";
            formSubtitle.textContent = "Platform admin login to verify owners and monitor station data.";
            groupUsername.style.display = "block";
            groupEmail.style.display    = "none";
            roleHint.innerHTML = "Default admin credentials – <b>admin / admin123</b> (change in code later).";
        } else if (role === "user") {
            formTitle.textContent    = "User Login";
            formSubtitle.textContent = "Login as an EV driver to plan routes and view verified stations.";
            groupUsername.style.display = "none";
            groupEmail.style.display    = "block";
            roleHint.innerHTML = "User accounts require a record in the <b>users</b> table (email + password).";
        }
    });
});
</script>
</body>
</html>
