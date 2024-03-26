<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/desktop.css" />
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
            <h2 class="text-center">Register For an Account</h2>

            <form action="signup.php" method="POST">
                <div class="form-group">
                    <input type="text" placeholder="First Name *" name="firstname" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Middle Name" name="middlename" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Last Name *" name="lastname" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Email Address *" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="date" placeholder="Date of Birth *" name="dob" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Passsword *" name="input_password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm Password *" name="confirm_password" class="form-control">
                </div>
                <div class="form-btn">
                    <input type="submit" value="Register" name="submit" class="btn btn-warning">
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>