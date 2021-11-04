<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- Navigation -->
    <?php include_once('header.php'); ?>

    <!-- Inclusion du formulaire de connexion -->
    <?php include_once('login.php'); ?>
        <h1>Site de Recettes !</h1>

        <!-- Si l'utilisateur existe, on affiche les recettes -->
        <?php if(isset($loggedUser)): ?>
            <?php foreach(get_recipes($recipes, $limit) as $recipe) : ?>
                <article>
                    <h3><?php echo $recipe['title']; ?></h3>
                    <div><?php echo $recipe['recipe']; ?></div>
                    <i><?php echo display_author($recipe['author'], $users); ?></i>
                </article>
            <?php endforeach ?>
        <?php endif; ?>
    </div>

    <?php
        try
        {
            // On se connecte à MySQL
            $mysqlClient = new PDO('mysql:host=localhost;dbname=recipes;charset=utf8', 'root', 'root');
        }
        catch(Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage());
        }

        // Si tout va bien, on peut continuer

        // On récupère tout le contenu de la table recipes
        $sqlQuery = 'SELECT * FROM recipe';
        $recipesStatement = $mysqlClient->prepare($sqlQuery);
        $recipesStatement->execute();
        $recipes = $recipesStatement->fetchAll();

        // On affiche chaque recette une à une
        foreach ($recipes as $recipe) {
        ?>
            <p><?php echo $recipe['title']; ?></p>
            <p><?php echo $recipe['creation_date']; ?></p>
            <p><?php echo $recipe['ingredients']; ?></p>
            <p><?php echo $recipe['instructions']; ?></p>
                    <?php
        }
        ?>


    <?php include_once('footer.php'); ?>
</body>
</html>