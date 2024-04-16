<?php

function getListsByUserId(PDO $pdo, int $userId):array
{
    $query = $pdo->prepare("SELECT list.*, category.name as category_name, 
                            category.icon as category_icon 
                            FROM list
                            JOIN category ON category.id = list.category_id 
                            WHERE user_id = :user_id");
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $query->execute();
    $lists = $query->fetchAll(PDO::FETCH_ASSOC);

    return $lists;
}

function saveList(PDO $pdo, string $title, int $userId, int $categoryId, int $id=null):int|bool
{
    if ($id) {
        // UPDATE
    } else {
        // INSERT
        $query = $pdo->prepare("INSERT INTO list (title, category_id, user_id)
                                VALUES (:title, :category_id, :user_id)");
    }
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);

    $res = $query->execute();
    if ($res) {
        if ($id) {
            return $id;
        } else {
            return $pdo->lastInsertId();
        }
    } else {
        return false;
    }
}