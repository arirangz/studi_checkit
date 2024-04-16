<?php 

require_once __DIR__ . "/templates/header.php"; 
require_once 'lib/pdo.php';
require_once 'lib/list.php';
require_once 'lib/category.php';

if (!isUserConnected()) {
    header('Location: login.php');
}

$categories = getCategories($pdo);

$errorsList = [];

// Le formulaire d'ajout/modif de liste a été envoyé
if (isset($_POST['saveList'])) {
    if (!empty($_POST['title'])) {
        $res = saveList($pdo, $_POST['title'], (int)$_SESSION['user']['id'], $_POST['category_id']);
        if ($res) {
            header('Location: ajout-modification-liste.php?id=' . $res);
        } else {
            // erreur
            $errorsList[] = "La liste n'a pas été enregistrée";
        }
    } else {
        // erreur
        $errorsList[] = "Le titre est obligatoire";
    }
}
  


?>

<div class="container col-xxl-8">
    <h1>Liste</h1>

    <?php foreach ($errorsList as $error) { ?>
        <div class="alert alert-danger">
            <?=$error; ?>
        </div>
    <?php } ?>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?php if (isset($_GET['id'])) { ?>
                        Modifier la liste
                    <?php } else { ?>
                        Ajouter une liste
                    <?php } ?>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category['id'] ?>"><?=$category['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Enregistrer" name="saveList" class="btn btn-primary">
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . "/templates/footer.php" ?>