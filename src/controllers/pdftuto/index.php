
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Emprunts</title>
</head>
<body>
<form action="genere_emprunts_pdf.php" method="post">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID Emprunt</th>
            <th>ID Livre</th>
            <th>Email Emprunteur</th>
            <th>Date d'emprunt</th>
            <th>Date de retour prévue</th>
            <th>Date de retour</th>
            <th>État</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($emprunts as $emprunt) : ?>
            <tr>
                <td><?= isset($emprunt['id']) ? htmlspecialchars($emprunt['id']) : '' ?></td>
                <td><?= isset($emprunt['fk_livre']) ? htmlspecialchars($emprunt['fk_livre']) : '' ?></td>
                <td><?= isset($emprunt['fk_utilisateur']) ? htmlspecialchars($emprunt['fk_utilisateur']) : '' ?></td>
                <td><?= isset($emprunt['date_emprunt']) ? htmlspecialchars($emprunt['date_emprunt']) : '' ?></td>
                <td><?= isset($emprunt['date_retour_prevue']) ? htmlspecialchars($emprunt['date_retour_prevue']) : '' ?></td>
                <td><?= isset($emprunt['date_retour']) ? htmlspecialchars($emprunt['date_retour']) : 'Non rendu' ?></td>
                <td>
                    <?php
                    if ($emprunt['date_retour'] === null) {
                        echo 'Pas encore rendu';
                    } else {
                        $date_retour_max = date('Y-m-d H:i:s', strtotime($emprunt['date_emprunt'] . ' + 30 days'));
                        if ($emprunt['date_retour'] < $emprunt['date_retour_prevue']) {
                            echo 'Rendu avant délai';
                        } elseif ($emprunt['date_retour'] > $emprunt['date_retour_prevue']) {
                            echo 'Rendu après délai';
                        } else {
                            echo 'Rendu à temps';
                        }
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <input type="submit" value="Générer PDF">
</form>
</body>
</html>
