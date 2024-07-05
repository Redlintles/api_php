<?php


use Ramsey\Uuid\Uuid;

function initRoot()
{
    $adm = \Buildings\AdminQuery::create()->findOneByUsername("root");
    if(!isset($adm)) {
        $root = new \Buildings\Admin();
        $root->setUsername("root");
        $root->setPassword("root123");
        $root->setApiKey(Uuid::uuid4()->toString());
        $root->save();
        $localAdm = \Buildings\AdminQuery::create()->findOneByUsername("root");
        $result = \Buildings\PermissionQuery::create()->findOneByAdminId($localAdm->getId());
        if(!isset($result)) {
            $rootPermission = new \Buildings\Permission();
            $rootPermission->setAdminId($localAdm->getId());
            $rootPermission->setCreate("1");
            $rootPermission->setRead("1");
            $rootPermission->setUpdate("1");
            $rootPermission->setDelete("1");
            $rootPermission->save();
        }
    }
}
