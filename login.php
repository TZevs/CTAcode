<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Login</title>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
        </header>
        <div class="container">
            <h2>Login</h2>
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" placeholder="email@example.com" aria-label="Username" name="username" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="inputPassword">Password:</label>
                        <input type="password" class="form-control" placeholder="********" aria-label="Password" name="inputPassword" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col form-btn">
                        <button type="submit">Customer Login</button>
                    </div>
                    <div class="col form-btn">
                        <button type="submit">Admin Login</button>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col form-btn">
                        <a href="register.php">Dont Have an Account? SignUp</a>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>