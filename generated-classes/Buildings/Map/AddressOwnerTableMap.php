<?php

namespace Buildings\Map;

use Buildings\AddressOwner;
use Buildings\AddressOwnerQuery;
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
 * This class defines the structure of the 'address_owner' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AddressOwnerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.AddressOwnerTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'address_owner';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'AddressOwner';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\AddressOwner';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.AddressOwner';

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
    public const COL_ID = 'address_owner.id';

    /**
     * the column name for the id_address field
     */
    public const COL_ID_ADDRESS = 'address_owner.id_address';

    /**
     * the column name for the id_client field
     */
    public const COL_ID_CLIENT = 'address_owner.id_client';

    /**
     * the column name for the id_seller field
     */
    public const COL_ID_SELLER = 'address_owner.id_seller';

    /**
     * the column name for the type field
     */
    public const COL_TYPE = 'address_owner.type';

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
        self::TYPE_PHPNAME       => ['Id', 'IdAddress', 'IdClient', 'IdSeller', 'Type', ],
        self::TYPE_CAMELNAME     => ['id', 'idAddress', 'idClient', 'idSeller', 'type', ],
        self::TYPE_COLNAME       => [AddressOwnerTableMap::COL_ID, AddressOwnerTableMap::COL_ID_ADDRESS, AddressOwnerTableMap::COL_ID_CLIENT, AddressOwnerTableMap::COL_ID_SELLER, AddressOwnerTableMap::COL_TYPE, ],
        self::TYPE_FIELDNAME     => ['id', 'id_address', 'id_client', 'id_seller', 'type', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'IdAddress' => 1, 'IdClient' => 2, 'IdSeller' => 3, 'Type' => 4, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'idAddress' => 1, 'idClient' => 2, 'idSeller' => 3, 'type' => 4, ],
        self::TYPE_COLNAME       => [AddressOwnerTableMap::COL_ID => 0, AddressOwnerTableMap::COL_ID_ADDRESS => 1, AddressOwnerTableMap::COL_ID_CLIENT => 2, AddressOwnerTableMap::COL_ID_SELLER => 3, AddressOwnerTableMap::COL_TYPE => 4, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'id_address' => 1, 'id_client' => 2, 'id_seller' => 3, 'type' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'AddressOwner.Id' => 'ID',
        'id' => 'ID',
        'addressOwner.id' => 'ID',
        'AddressOwnerTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'address_owner.id' => 'ID',
        'IdAddress' => 'ID_ADDRESS',
        'AddressOwner.IdAddress' => 'ID_ADDRESS',
        'idAddress' => 'ID_ADDRESS',
        'addressOwner.idAddress' => 'ID_ADDRESS',
        'AddressOwnerTableMap::COL_ID_ADDRESS' => 'ID_ADDRESS',
        'COL_ID_ADDRESS' => 'ID_ADDRESS',
        'id_address' => 'ID_ADDRESS',
        'address_owner.id_address' => 'ID_ADDRESS',
        'IdClient' => 'ID_CLIENT',
        'AddressOwner.IdClient' => 'ID_CLIENT',
        'idClient' => 'ID_CLIENT',
        'addressOwner.idClient' => 'ID_CLIENT',
        'AddressOwnerTableMap::COL_ID_CLIENT' => 'ID_CLIENT',
        'COL_ID_CLIENT' => 'ID_CLIENT',
        'id_client' => 'ID_CLIENT',
        'address_owner.id_client' => 'ID_CLIENT',
        'IdSeller' => 'ID_SELLER',
        'AddressOwner.IdSeller' => 'ID_SELLER',
        'idSeller' => 'ID_SELLER',
        'addressOwner.idSeller' => 'ID_SELLER',
        'AddressOwnerTableMap::COL_ID_SELLER' => 'ID_SELLER',
        'COL_ID_SELLER' => 'ID_SELLER',
        'id_seller' => 'ID_SELLER',
        'address_owner.id_seller' => 'ID_SELLER',
        'Type' => 'TYPE',
        'AddressOwner.Type' => 'TYPE',
        'type' => 'TYPE',
        'addressOwner.type' => 'TYPE',
        'AddressOwnerTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'address_owner.type' => 'TYPE',
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
        $this->setName('address_owner');
        $this->setPhpName('AddressOwner');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\AddressOwner');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('id_address', 'IdAddress', 'INTEGER', 'address', 'id', true, null, 1);
        $this->addForeignKey('id_client', 'IdClient', 'INTEGER', 'client', 'id', false, null, null);
        $this->addForeignKey('id_seller', 'IdSeller', 'INTEGER', 'seller', 'id', false, null, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 10, '');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('AddressOwnerId', '\\Buildings\\Address', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_address',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('AddressOwnerIdClient', '\\Buildings\\Client', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_client',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('AddressOwnerIdSeller', '\\Buildings\\Seller', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_seller',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
        return $withPrefix ? AddressOwnerTableMap::CLASS_DEFAULT : AddressOwnerTableMap::OM_CLASS;
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
     * @return array (AddressOwner object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AddressOwnerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AddressOwnerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AddressOwnerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AddressOwnerTableMap::OM_CLASS;
            /** @var AddressOwner $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AddressOwnerTableMap::addInstanceToPool($obj, $key);
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
            $key = AddressOwnerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AddressOwnerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AddressOwner $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AddressOwnerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AddressOwnerTableMap::COL_ID);
            $criteria->addSelectColumn(AddressOwnerTableMap::COL_ID_ADDRESS);
            $criteria->addSelectColumn(AddressOwnerTableMap::COL_ID_CLIENT);
            $criteria->addSelectColumn(AddressOwnerTableMap::COL_ID_SELLER);
            $criteria->addSelectColumn(AddressOwnerTableMap::COL_TYPE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.id_address');
            $criteria->addSelectColumn($alias . '.id_client');
            $criteria->addSelectColumn($alias . '.id_seller');
            $criteria->addSelectColumn($alias . '.type');
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
            $criteria->removeSelectColumn(AddressOwnerTableMap::COL_ID);
            $criteria->removeSelectColumn(AddressOwnerTableMap::COL_ID_ADDRESS);
            $criteria->removeSelectColumn(AddressOwnerTableMap::COL_ID_CLIENT);
            $criteria->removeSelectColumn(AddressOwnerTableMap::COL_ID_SELLER);
            $criteria->removeSelectColumn(AddressOwnerTableMap::COL_TYPE);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.id_address');
            $criteria->removeSelectColumn($alias . '.id_client');
            $criteria->removeSelectColumn($alias . '.id_seller');
            $criteria->removeSelectColumn($alias . '.type');
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
        return Propel::getServiceContainer()->getDatabaseMap(AddressOwnerTableMap::DATABASE_NAME)->getTable(AddressOwnerTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AddressOwner or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or AddressOwner object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AddressOwnerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\AddressOwner) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AddressOwnerTableMap::DATABASE_NAME);
            $criteria->add(AddressOwnerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AddressOwnerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AddressOwnerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AddressOwnerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the address_owner table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AddressOwnerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AddressOwner or Criteria object.
     *
     * @param mixed $criteria Criteria or AddressOwner object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressOwnerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AddressOwner object
        }

        if ($criteria->containsKey(AddressOwnerTableMap::COL_ID) && $criteria->keyContainsValue(AddressOwnerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AddressOwnerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AddressOwnerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
