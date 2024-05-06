<?php

require_once 'templates/header.php';
require_once 'lib/pdo.php';
require_once 'lib/list.php';
require_once 'lib/category.php';

$categoryId = null;
if (isset($_SESSION['user'])) {
    if (isset($_GET['category'])) {
        $categoryId = (int)$_GET['category'];
    }
    $lists = getListsByUserId($pdo, $_SESSION['user']['id'], $categoryId);
}

$categories = getCategories($pdo);
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Mes listes</h1>
        <?php if (isUserConnected()) { ?>
            <a href="ajout-modification-liste.php" class="btn btn-primary">Ajouter une liste</a>
        <?php } ?>
        <form method="get">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">Toutes</option>
                <?php foreach($categories as $category) { ?>
                    <option <?=((int)$category['id'] === $categoryId ? 'selected="selected"': '' )?> value="<?=$category['id']?>"><?=$category['name']?></option>
                <?php } ?>

            </select>
        </form>
    </div>

    <div class="row">

    
        <?php if (isUserConnected()) { 
            if ($lists) {
                foreach ($lists as $list) { ?>
                    <div class="col-md-4 my-2">
                        <div class="card w-100">
                            <div class="card-header d-flex align-items-center justify-content-evenly">
                                <i class="bi bi-card-checklist"></i>
                                <h3 class="card-title"><?=$list['title'] ?></h3>
                            </div>
                            <div class="card-body d-flex flex-column ">
                                <?php $items = getListItems($pdo, $list['id']); ?>
                                <?php if ($items) { ?>
                                <ul class="list-group">
                                    <?php foreach ($items as $item) { ?>
                                        <li class="list-group-item"><a class="me-2" href="ajout-modification-liste.php?id=<?=$list['id']?>&action=updateStatusListItem&redirect=list&item_id=<?=$item['id'] ?>&status=<?=!$item['status'] ?>"><i class="bi bi-check-circle<?=($item['status'] ? '-fill' : '')?>"></i></a> <?= $item['name'] ?></li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                                <div class="d-flex justify-content-between align-items-end mt-2">
                                    <a href="ajout-modification-liste.php?id=<?=$list['id'] ?>" class="btn btn-primary">Voir la liste</a>
                                    <span class="badge rounded-pill text-bg-primary">
                                        <i class="bi <?=$list['category_icon']?>"></i>
                                        <?=$list['category_name']?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Aucune liste</p>
            <?php } ?>

        <?php } else { ?>
            <p>Pour consulter vos listes, vous devez être connecté:</p>
            <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
        <?php } ?>
    </div>

</div>


<?php require_once __DIR__ . "/templates/footer.php" ?>