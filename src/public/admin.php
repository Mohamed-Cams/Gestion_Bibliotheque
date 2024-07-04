<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./open-book-svgrepo-com.svg" alt="Bootstrap" width="50" height="54" />
                </a>
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="add-book.php">Ajout Livre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <form action="search.php" method="get" style="width: 100%; max-width: 30rem">

            <div class="input-group my-5">
                <input type="text" class="form-control" name="key" placeholder="Rechercher livre..."
                    aria-label="Rechercher livre..." aria-describedby="basic-addon2">

                <button class="input-group-text
		                 btn btn-primary" id="basic-addon2">
                    <img src="./search-svgrepo-com.svg" width="20">

                </button>
            </div>
        </form>
        <h4>Liste de livre</h4>
        <table class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Author</th>
                    <th>Anné_Pub</th>
                    <th>Genre</th>
                    <th>Exemplaire</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


    </div>
</body>

</html>