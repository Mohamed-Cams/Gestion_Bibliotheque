<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="./open-book-svgrepo-com.svg" alt="Bootstrap" width="50" height="54" />
            </a>
        </nav>
        <form action="php/add-book.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">

            <h1 class="text-center pb-5 display-4 fs-3">
                Ajout de livre
            </h1>

            <div class="mb-3">
                <label class="form-label">
                    Titre Livre
                </label>
                <input type="text" class="form-control" value="" name="book_title">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Anné_Pub
                </label>
                <input type="text" class="form-control" value="" name="book_description">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Auteur
                </label>
                <input type="text" class="form-control" value="" name="book_title">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Genre
                </label>
                <select name="book_genrer" class="form-control">
                    <option value="0">
                        Selectionné un genre
                    </option>
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Couverture
                </label>
                <input type="file" class="form-control" name="book_cover">
            </div>

            <button type="submit" class="btn btn-primary">
                Ajouter</button>
        </form>
    </div>
</body>

</html>