<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Account</title>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
            <nav class="header-navbar">
                <ul class="header-navbar-list">
                    <li class="header-navbar-list-item"><a href="index.php">Home</a></li>
                    <li class="header-navbar-list-item"><a href="wallets.php">Wallets</a></li>
                    <li class="header-navbar-list-item"><a href="transaction.php">Transactions</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item item-active"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2>Account Details</h2>
            <form method="POST" action="">
                <div class="register-form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="register-form-input" id="firstname" name="firstname" readonly placeholder="">
                </div>
                <div class="register-form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="register-form-input" id="lastname" name="lastname" readonly placeholder="">
                </div>
                <div class="register-form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="text" class="register-form-input" id="dob" name="dob" readonly placeholder="">
                </div>
                <div class="register-form-group">
                    <label for="email">Email Address:</label>
                    <input type="text" class="register-form-input" id="email" name="email" placeholder="">
                </div>
                <div class="register-form-group">
                    <label for="inputPassword">Password:</label>
                    <input type="password" class="register-form-input" id="inputPassword" name="inputPassword">
                    <p>Must be 8-20 characters long.</p>
                </div>
                <div class="row g-3">
                    <div class="col form-btn">
                        <button type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>