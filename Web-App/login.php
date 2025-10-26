<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure Access</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }

        .waf-warning {
            margin-top: 15px;
            padding: 10px;
            background: #ffeaa7;
            border-radius: 5px;
            border-left: 4px solid #fdcb6e;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please sign in to your account</p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="links">
            <a href="#">Forgot your password?</a>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            echo "<div class='message'>";
            echo "<p><strong>Login attempt recorded for user:</strong> " . htmlspecialchars($username) . "</p>";
            echo "<p><em>Note: This is a demo page. No actual authentication is performed.</em></p>";
            
            // Check if WAF would block this input
            if (preg_match('/(?i)union\s+select/', $username)) {
                echo "<div class='waf-warning'>🚫 This input triggers WAF Rule 1: SQL Injection</div>";
            }
            if (preg_match('/(?i)(<script|onclick|onload|alert\()/', $username)) {
                echo "<div class='waf-warning'>🚫 This input triggers WAF Rule 2: XSS Attack</div>";
            }
            if (preg_match('/(;|\||&|ls|cat|whoami)/', $username)) {
                echo "<div class='waf-warning'>🚫 This input triggers WAF Rule 3: Command Injection</div>";
            }
            if (preg_match('/(\.\.\/|\/etc\/passwd|c:\\\\windows)/', $username)) {
                echo "<div class='waf-warning'>🚫 This input triggers WAF Rule 4: File Inclusion</div>";
            }
            if (strlen($username) > 500) {
                echo "<div class='waf-warning'>🚫 This input triggers WAF Rule 5: Buffer Overflow</div>";
            }
            
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>