<?php
// Gestion de la session
session_start();

// Vérifier si on a droit d'afficher cette page
// Donc : si l'utilisateur n'est pas connecté, il faut le rediriger vers
// la page de conenxion avec un message approprié
if (!isset($_SESSION['util-courriel'])) {
    header('Location: index.php?e=4000');
}

// Manipulation du contenu dans la BD
$cnx = mysqli_connect('localhost', 'root', '', 'leila');
mysqli_set_charset($cnx, 'utf8');

// Opérations changement de données 
if (isset($_GET['op'])) {
    $operation = $_GET['op'];
    switch ($operation) {
            // Création
        case 'ajout':
            $nom = $_POST['nom'];
            $type = $_POST['type'];
            mysqli_query($cnx, "INSERT INTO categorie VALUES (0, '$nom', '$type')");
            break;
            // Modification
        case 'modification':
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $type = $_POST['type'];
            mysqli_query($cnx, "UPDATE categorie SET nom='$nom', type='$type' WHERE id=$id");
            break;
            // Supression
        case 'suppression':
            $id = $_POST['id'];
            mysqli_query($cnx, "DELETE FROM categorie WHERE id=$id");
            break;
    }
}

// Opération LECTURE (READ/SELECT)
// On obtient un jeu d'enregistrements contenant tous les éléments de la BD
$resultat = mysqli_query($cnx, "SELECT *  FROM plat ORDER BY `prix`, id");

$resultatCat = mysqli_query($cnx, "SELECT *  FROM categorie ORDER BY id ");


$page = 'plats';
include('inclusions/entete.inc.php');
?>
<section class="liste-enregistrements">
    <h2><code>Catégories</code></h2>
    <header>
        <span>id</span>
        <span>nom</span>
        <span>Catégories</span>
        <span class="action"></span>
    </header>
    <div class="data">
        <!-- Formulaire pour ajout d'un élément dans la BD (INSERT) -->
        <form class="nouveau" action="?op=ajout" method="post">
            <span></span>
            <span><input type="text" name="nom" value=""></span>
            <span>
                <select name="type">
                    <?php while($categorie = mysqli_fetch_assoc($resultatCat)) : ?>
                        <option value="<?= $categorie['nom'] ?>"><?= $categorie['nom'] ?></option>
                    <?php endwhile; ?>
                </select>
            </span>
            <span class="action">
                <button type="submit" class="btn btn-ajouter btn-plein">ajouter</button>
            </span>
        </form>

        <!-- 
                Gabarit de formulaire pour affichage/modification/suppression 
                d'un élément de la BD.
            -->
        <?php

        while ($enreg = mysqli_fetch_assoc($resultat)) :
            //print_r($enreg); // Pour débogage
        ?>
            <form method="post">
                <span><input readonly type="text" name="id" value="<?= $enreg['id']; ?>"></span>
                <span><input type="text" name="nom" value="<?= $enreg['nom']; ?>"></span>
                <span>
                    <select name="categorie_id">
                        <?php
                        $query = "SELECT DISTINCT categorie.id, categorie.nom FROM categorie LEFT JOIN plat ON categorie.id = plat.categorie_id AND plat.id = " . $enreg['id'];
                        $result = mysqli_query($cnx, $query);
                        while ($row = mysqli_fetch_assoc($result)) :
                            $selected = ($enreg['categorie_id'] == $row['id']) ? 'selected' : '';
                        ?>
                            <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['nom'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </span>
                <span class="action">
                    <button type="submit" formaction="?op=modification" class="btn btn-modifier">modifier</button>
                    <button type="submit" formaction="?op=suppression" class="btn btn-supprimer">supprimer</button>
                </span>
            </form>
        <?php endwhile; ?>
    </div>


</section>


<?php
include('inclusions/pied2page.inc.php');
?>