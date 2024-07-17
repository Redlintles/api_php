<?php

namespace Buildings\Map;

use Buildings\Seller;
use Buildings\SellerQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'seller' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class SellerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.SellerTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'seller';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Seller';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Seller';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Seller';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'seller.id';

    /**
     * the column name for the username field
     */
    public const COL_USERNAME = 'seller.username';

    /**
     * the column name for the password field
     */
    public const COL_PASSWORD = 'seller.password';

    /**
     * the column name for the email field
     */
    public const COL_EMAIL = 'seller.email';

    /**
     * the column name for the phone_number field
     */
    public const COL_PHONE_NUMBER = 'seller.phone_number';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Username', 'Password', 'Email', 'PhoneNumber', ],
        self::TYPE_CAMELNAME     => ['id', 'username', 'password', 'email', 'phoneNumber', ],
        self::TYPE_COLNAME       => [SellerTableMap::COL_ID, SellerTableMap::COL_USERNAME, SellerTableMap::COL_PASSWORD, SellerTableMap::COL_EMAIL, SellerTableMap::COL_PHONE_NUMBER, ],
        self::TYPE_FIELDNAME     => ['id', 'username', 'password', 'email', 'phone_number', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'Username' => 1, 'Password' => 2, 'Email' => 3, 'PhoneNumber' => 4, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'username' => 1, 'password' => 2, 'email' => 3, 'phoneNumber' => 4, ],
        self::TYPE_COLNAME       => [SellerTableMap::COL_ID => 0, SellerTableMap::COL_USERNAME => 1, SellerTableMap::COL_PASSWORD => 2, SellerTableMap::COL_EMAIL => 3, SellerTableMap::COL_PHONE_NUMBER => 4, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'username' => 1, 'password' => 2, 'email' => 3, 'phone_number' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Seller.Id' => 'ID',
        'id' => 'ID',
        'seller.id' => 'ID',
        'SellerTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Username' => 'USERNAME',
        'Seller.Username' => 'USERNAME',
        'username' => 'USERNAME',
        'seller.username' => 'USERNAME',
        'SellerTableMap::COL_USERNAME' => 'USERNAME',
        'COL_USERNAME' => 'USERNAME',
        'Password' => 'PASSWORD',
        'Seller.Password' => 'PASSWORD',
        'password' => 'PASSWORD',
        'seller.password' => 'PASSWORD',
        'SellerTableMap::COL_PASSWORD' => 'PASSWORD',
        'COL_PASSWORD' => 'PASSWORD',
        'Email' => 'EMAIL',
        'Seller.Email' => 'EMAIL',
        'email' => 'EMAIL',
        'seller.email' => 'EMAIL',
        'SellerTableMap::COL_EMAIL' => 'EMAIL',
        'COL_EMAIL' => 'EMAIL',
        'PhoneNumber' => 'PHONE_NUMBER',
        'Seller.PhoneNumber' => 'PHONE_NUMBER',
        'phoneNumber' => 'PHONE_NUMBER',
        'seller.phoneNumber' => 'PHONE_NUMBER',
        'SellerTableMap::COL_PHONE_NUMBER' => 'PHONE_NUMBER',
        'COL_PHONE_NUMBER' => 'PHONE_NUMBER',
        'phone_number' => 'PHONE_NUMBER',
        'seller.phone_number' => 'PHONE_NUMBER',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('seller');
        $this->setPhpName('Seller');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Seller');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 50, '');
        $this->addColumn('password', 'Password', 'VARCHAR', true, 200, '');
        $this->addColumn('email', 'Email', 'VARCHAR', true, 30, '');
        $this->addColumn('phone_number', 'PhoneNumber', 'VARCHAR', true, 15, '');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('OrderSeller', '\\Buildings\\Order', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_seller',
    1 => ':id',
  ),
), 'CASCADE', null, 'OrderSellers', false);
        $this->addRelation('SellerProductSeller', '\\Buildings\\SellerProduct', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_seller',
    1 => ':id',
  ),
), 'CASCADE', null, 'SellerProductSellers', false);
        $this->addRelation('AddressOwnerSeller', '\\Buildings\\AddressOwner', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_seller',
    1 => ':id',
  ),
), 'CASCADE', null, 'AddressOwnerSellers', false);
    }

    /**
     * Method to invalidate the instance pool of all tables related to seller     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool(): void
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        OrderTableMap::clearInstancePool();
        SellerProductTableMap::clearInstancePool();
        AddressOwnerTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? SellerTableMap::CLASS_DEFAULT : SellerTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (Seller object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = SellerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SellerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SellerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SellerTableMap::OM_CLASS;
            /** @var Seller $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SellerTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SellerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SellerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Seller $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SellerTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SellerTableMap::COL_ID);
            $criteria->addSelectColumn(SellerTableMap::COL_USERNAME);
            $criteria->addSelectColumn(SellerTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(SellerTableMap::COL_EMAIL);
            $criteria->addSelectColumn(SellerTableMap::COL_PHONE_NUMBER);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.phone_number');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(SellerTableMap::COL_ID);
            $criteria->removeSelectColumn(SellerTableMap::COL_USERNAME);
            $criteria->removeSelectColumn(SellerTableMap::COL_PASSWORD);
            $criteria->removeSelectColumn(SellerTableMap::COL_EMAIL);
            $criteria->removeSelectColumn(SellerTableMap::COL_PHONE_NUMBER);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.username');
            $criteria->removeSelectColumn($alias . '.password');
            $criteria->removeSelectColumn($alias . '.email');
            $criteria->removeSelectColumn($alias . '.phone_number');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(SellerTableMap::DATABASE_NAME)->getTable(SellerTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Seller or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Seller object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Seller) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SellerTableMap::DATABASE_NAME);
            $criteria->add(SellerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SellerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SellerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SellerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the seller table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return SellerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Seller or Criteria object.
     *
     * @param mixed $criteria Criteria or Seller object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Seller object
        }

        if ($criteria->containsKey(SellerTableMap::COL_ID) && $criteria->keyContainsValue(SellerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SellerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SellerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
