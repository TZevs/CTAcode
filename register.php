<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Register</title>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
        </header>

        <div class="container">
            <h2>Register For an Account</h2>
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" placeholder="Enter Name" aria-label="First name" name="firstname">
                    </div>
                    <div class="col">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" placeholder="Enter Name" aria-label="Last name" name="lastname">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="email">Email Address:</label>
                        <input type="text" class="form-control" placeholder="name@example.com" aria-label="Email Address" name="email">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Date of Birth" name="dob">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="inputPassword">Password:</label>
                        <input type="password" class="form-control" placeholder="********" aria-label="Password" name="inputPassword">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col form-btn">
                        <button type="submit">Sign Up</button>
                    </div>
                    <div class="col form-btn">
                        <a href="login.php">Login</a>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>