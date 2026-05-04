<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>

    <!-- 
    Dans le terminal WSL : php -S localhost:8000
    puis dans le navigateur : http://localhost:8000/frontend/views/assurance/filter-assurance.php
    -->

    <?php
    # VARIABLES
    
    $txt_add_button = "Ajouter une tâche";

    ?>

    <?php @include_once "../../components/navigation-bar.php"; ?>

    <form class="filter" method="GET">

        <label for="name">Nom de l'assurance</label>
        <input type="text" id="name" name="name" placeholder="Entrez le nom de l'assurance">

        <button class="submit_filter" type="submit">Rechercher</button>

    </form>

    <?php @include "../../components/add-button.php"; ?>

</body>