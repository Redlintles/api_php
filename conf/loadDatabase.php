<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'address' => '\\Buildings\\Map\\AddressTableMap',
      'address_owner' => '\\Buildings\\Map\\AddressOwnerTableMap',
      'admin' => '\\Buildings\\Map\\AdminTableMap',
      'cart' => '\\Buildings\\Map\\CartTableMap',
      'cart_products' => '\\Buildings\\Map\\CartProductTableMap',
      'category' => '\\Buildings\\Map\\CategoryTableMap',
      'client' => '\\Buildings\\Map\\ClientTableMap',
      'discount' => '\\Buildings\\Map\\DiscountTableMap',
      'order_products' => '\\Buildings\\Map\\OrderProductTableMap',
      'orders' => '\\Buildings\\Map\\OrderTableMap',
      'permission' => '\\Buildings\\Map\\PermissionTableMap',
      'product' => '\\Buildings\\Map\\ProductTableMap',
      'product_category' => '\\Buildings\\Map\\ProductCategoryTableMap',
      'seller' => '\\Buildings\\Map\\SellerTableMap',
      'seller_products' => '\\Buildings\\Map\\SellerProductTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Address' => '\\Buildings\\Map\\AddressTableMap',
      '\\AddressOwner' => '\\Buildings\\Map\\AddressOwnerTableMap',
      '\\Admin' => '\\Buildings\\Map\\AdminTableMap',
      '\\Cart' => '\\Buildings\\Map\\CartTableMap',
      '\\CartProduct' => '\\Buildings\\Map\\CartProductTableMap',
      '\\Category' => '\\Buildings\\Map\\CategoryTableMap',
      '\\Client' => '\\Buildings\\Map\\ClientTableMap',
      '\\Discount' => '\\Buildings\\Map\\DiscountTableMap',
      '\\Order' => '\\Buildings\\Map\\OrderTableMap',
      '\\OrderProduct' => '\\Buildings\\Map\\OrderProductTableMap',
      '\\Permission' => '\\Buildings\\Map\\PermissionTableMap',
      '\\Product' => '\\Buildings\\Map\\ProductTableMap',
      '\\ProductCategory' => '\\Buildings\\Map\\ProductCategoryTableMap',
      '\\Seller' => '\\Buildings\\Map\\SellerTableMap',
      '\\SellerProduct' => '\\Buildings\\Map\\SellerProductTableMap',
    ),
  ),
));
