<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'message' => '\\Buildings\\Map\\MessageTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Message' => '\\Buildings\\Map\\MessageTableMap',
    ),
  ),
));
