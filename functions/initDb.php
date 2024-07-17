<?php


use Ramsey\Uuid\Uuid;

function createRootPermission()
{
    $root = \Buildings\AdminQuery::create()->findOneByUsername("root");
    if(isset($root)) {
        $permission = new \Buildings\Permission();
        $permission->setAdminId($root->getId());
        $permission->setCreatePermission("1");
        $permission->setReadPermission("1");
        $permission->setUpdatePermission("1");
        $permission->setDeletePermission("1");
        $permission->save();
    }
}

function initRoot()
{
    $adm = \Buildings\AdminQuery::create()->findOneByUsername("root");

    if(!isset($adm)) {

        $apiKey = Uuid::uuid4()->toString();

        echo $apiKey;

        $root = new \Buildings\Admin();
        $root->setUsername("root");
        $root->setPassword(password_hash("root123", PASSWORD_DEFAULT));
        $root->setApiKey(password_hash($apiKey, PASSWORD_DEFAULT));
        $root->save();
        createRootPermission();
    } elseif(isset($adm)) {
        $permission = \Buildings\PermissionQuery::create()->findOneByAdminId($adm->getId());
        if(!isset($permission)) {
            createRootPermission();
        }
    }
}
