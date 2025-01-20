<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-header img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .form-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            font-family: 'Helvetica', Arial, sans-serif;
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            font-size: 14px;
            color: #555555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #ff0000;
            font-size: 14px;
            margin-bottom: 15px;
        }

        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <form action="9087654321.php" method="post">
        <!-- Logo and Title -->
        <div class="form-header">
            <img src="images/ilogo.svg" alt="Logo">
            <h2>Portal Des Admins</h2>
        </div>

        <!-- Display Errors -->
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php } ?>

        <!-- Email Field -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Entrer votre email" required>

        <!-- Password Field -->
        <label for="password">Mot De Passe</label>
        <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>

        <!-- Submit Button -->
        <button type="submit">Se Connecter</button>
    </form>

    
</body>
</html>
