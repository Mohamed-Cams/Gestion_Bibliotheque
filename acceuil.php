<?php
ini_set('memory_limit', '262144M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/./controllers/AuthController.php';

$authController = new AuthController();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $mdp = $_POST['mdp'];
  echo $email;
  echo $mdp;
  $error = $authController->login($email, $mdp); // Capturer l'éventuelle erreur
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acceuil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url('./Images/cropped-3840-2160-1341970.png') no-repeat;
        background-size: cover;
        background-position: center;
    }

    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 20px 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 99;
    }

    .navigation a {
        position: relative;
        font-size: 1.1em;
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        margin-left: 40px;
    }

    .navigation a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 100%;
        height: 3px;
        background: #fff;
        border-radius: 5px;
        transform-origin: right;
        transform: scaleX(0);
        transition: transform .5s;
    }

    .navigation a:hover::after {
        transform-origin: left;
        transform: scaleX(1);
    }

    .navigation .btnLogin-popup {
        width: 130px;
        height: 50px;
        background: transparent;
        border: 2px solid #fff;
        cursor: pointer;
        font-size: 1.1em;
        color: #fff;
        font-weight: 500;
        margin-left: 40px;
    }


    .navigation .btnLogin-popup:hover {
        background: #fff;
        color: #162938;
    }

    .wrapper {
        position: relative;
        width: 400px;
        height: 440px;
        background: transparent;
        border: 2px solid rbga(255, 255, 255, .5);
        border-radius: 20px;
        box-shadow: 0 0 30px rgba(0, 0, 0, .5);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        transform: scale(0);
        transition: transform .5s ease, height .2s ease;
        backdrop-filter: 20px;
    }

    .wrapper.active-popup {
        transform: scale(1);
    }

    .wrapper .form-box {
        width: 100%;
        padding: 40px;
    }

    .wrapper .icon-close {
        position: absolute;
        top: 0;
        right: 0;
        width: 45px;
        height: 45px;
        background: #162938;
        font-size: 2em;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom-left-radius: 20px;
        cursor: pointer;
        z-index: 1;
    }

    .form-box h2 {
        font-size: 2em;
        color: #fff;
        text-align: center;
    }

    .input-box {
        position: relative;
        width: 100%;
        height: 50px;
        border-bottom: 2px solid #162938;
        margin: 30px 0;
    }

    .input-box label {
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        font-size: 1em;
        color: #fff;
        font-weight: 500;
        pointer-events: none;
        transition: .5s;
    }

    .input-box input:focus~label,
    .input-box input:valid~label {
        top: -5px;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        font-size: 1em;
        color: #fff;
        font-weight: 600;
        padding: 0 35px 0 5px;
    }

    .input-box .icon {
        position: absolute;
        right: 8px;
        font-size: 1.2em;
        color: #162938;
        line-height: 57px;
    }

    .btn {
        width: 100%;
        height: 45px;
        background: #162938;
        border: none;
        outline: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1em;
        color: #fff;
        font-weight: 500;
    }

    .logophrase {
        font-size: 2em;
        color: #fff;
        user-select: none;
    }

    .logo {
        height: 50px;
        width: 50px;
    }
    </style>
</head>
</head>

<body>
    <header>
        <img src="./Images/open-book-svgrepo-com.svg" class="logo" alt="">
        <h2 class="logophrase">Booky</h2>
        <nav class="navigation">
            <a href=""><img src="./Images/facebook.svg" alt=""></a>
            <a href=""><img src="./Images/instagram.svg" alt=""></a>
            <a href=""><img src="./Images/twitter-x.svg" alt=""></a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="wrapper active-popup">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail-outline"></ion-icon>
                    </span>
                    <input type="email" name="email" required>
                    <label for="">email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </span>
                    <input type="password" name="mdp" required>
                    <label for="">Mot de pass</label>
                </div>
                <button type="submit" class="btn">login</button>
            </form>
        </div>
    </div>

    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>