<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion(2);
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle('default');
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=localhost;dbname=api_php;port=3307',
  'user' => 'root',
  'password' => 'Itsumade@1997',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$serviceContainer->setConnectionManager($manager);
$serviceContainer->setDefaultDatasource('default');
require_once __DIR__ . '/./loadDatabase.php';
