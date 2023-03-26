<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;900&family=Roboto:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ressources/css/admin.css">
    <link rel="icon" type="image/png" href="ressources/images/favicon.png" />
    <title>Admin :: Restaurant Leila</title>
</head>

<body>
    <header>
        <div class="title">
            <h2>Admin 2 - Restaurant Leila</h2>

        </div>
        <nav class="navigation-principale">
            <ul>
                <li class="<?= ($page === 'categories') ? 'actif' : ''; ?>"><a href="categories.php">Catégories</a></li>
                <li class="<?= ($page === 'plats') ? 'actif' : ''; ?>"><a href="plats.php">Plats</a></li>
                <li class="<?= ($page === 'vins') ? 'actif' : ''; ?>"><a href="vins.php">Vins</a></li>
            </ul>
            <?php if (isset($_SESSION['util-courriel'])) : ?>
                <div class="profile-connexion">
                    <div><a href="index.php?action=deconnexion&e=3000" id="test" class="btn btn-supprimer deco">Déconnexion</a></div>
                </div>
            <?php endif; ?>
        </nav>
    </header>