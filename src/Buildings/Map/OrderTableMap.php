<?php

namespace Buildings\Map;

use Buildings\Order;
use Buildings\OrderQuery;
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
 * This class defines the structure of the 'order' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class OrderTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.OrderTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'order';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Order';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Order';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Order';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'order.id';

    /**
     * the column name for the id_client field
     */
    public const COL_ID_CLIENT = 'order.id_client';

    /**
     * the column name for the id_seller field
     */
    public const COL_ID_SELLER = 'order.id_seller';

    /**
     * the column name for the expires_at field
     */
    public const COL_EXPIRES_AT = 'order.expires_at';

    /**
     * the column name for the type field
     */
    public const COL_TYPE = 'order.type';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'order.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'IdClient', 'IdSeller', 'ExpiresAt', 'Type', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'idClient', 'idSeller', 'expiresAt', 'type', 'updatedAt', ],
        self::TYPE_COLNAME       => [OrderTableMap::COL_ID, OrderTableMap::COL_ID_CLIENT, OrderTableMap::COL_ID_SELLER, OrderTableMap::COL_EXPIRES_AT, OrderTableMap::COL_TYPE, OrderTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'id_client', 'id_seller', 'expires_at', 'type', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'IdClient' => 1, 'IdSeller' => 2, 'ExpiresAt' => 3, 'Type' => 4, 'UpdatedAt' => 5, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'idClient' => 1, 'idSeller' => 2, 'expiresAt' => 3, 'type' => 4, 'updatedAt' => 5, ],
        self::TYPE_COLNAME       => [OrderTableMap::COL_ID => 0, OrderTableMap::COL_ID_CLIENT => 1, OrderTableMap::COL_ID_SELLER => 2, OrderTableMap::COL_EXPIRES_AT => 3, OrderTableMap::COL_TYPE => 4, OrderTableMap::COL_UPDATED_AT => 5, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'id_client' => 1, 'id_seller' => 2, 'expires_at' => 3, 'type' => 4, 'updated_at' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Order.Id' => 'ID',
        'id' => 'ID',
        'order.id' => 'ID',
        'OrderTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'IdClient' => 'ID_CLIENT',
        'Order.IdClient' => 'ID_CLIENT',
        'idClient' => 'ID_CLIENT',
        'order.idClient' => 'ID_CLIENT',
        'OrderTableMap::COL_ID_CLIENT' => 'ID_CLIENT',
        'COL_ID_CLIENT' => 'ID_CLIENT',
        'id_client' => 'ID_CLIENT',
        'order.id_client' => 'ID_CLIENT',
        'IdSeller' => 'ID_SELLER',
        'Order.IdSeller' => 'ID_SELLER',
        'idSeller' => 'ID_SELLER',
        'order.idSeller' => 'ID_SELLER',
        'OrderTableMap::COL_ID_SELLER' => 'ID_SELLER',
        'COL_ID_SELLER' => 'ID_SELLER',
        'id_seller' => 'ID_SELLER',
        'order.id_seller' => 'ID_SELLER',
        'ExpiresAt' => 'EXPIRES_AT',
        'Order.ExpiresAt' => 'EXPIRES_AT',
        'expiresAt' => 'EXPIRES_AT',
        'order.expiresAt' => 'EXPIRES_AT',
        'OrderTableMap::COL_EXPIRES_AT' => 'EXPIRES_AT',
        'COL_EXPIRES_AT' => 'EXPIRES_AT',
        'expires_at' => 'EXPIRES_AT',
        'order.expires_at' => 'EXPIRES_AT',
        'Type' => 'TYPE',
        'Order.Type' => 'TYPE',
        'type' => 'TYPE',
        'order.type' => 'TYPE',
        'OrderTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'UpdatedAt' => 'UPDATED_AT',
        'Order.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'order.updatedAt' => 'UPDATED_AT',
        'OrderTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'order.updated_at' => 'UPDATED_AT',
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
        $this->setName('order');
        $this->setPhpName('Order');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Order');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('id_client', 'IdClient', 'INTEGER', 'client', 'id', false, null, null);
        $this->addForeignKey('id_seller', 'IdSeller', 'INTEGER', 'seller', 'id', false, null, null);
        $this->addColumn('expires_at', 'ExpiresAt', 'DATE', true, null, '2025-01-01');
        $this->addColumn('type', 'Type', 'VARCHAR', true, 10, '');
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('OrderIdClient', '\\Buildings\\Client', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_client',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('OrderIdSeller', '\\Buildings\\Seller', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_seller',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Order', '\\Buildings\\OrderProduct', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_order',
    1 => ':id',
  ),
), 'CASCADE', null, 'Orders', false);
    }

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'timestampable' => ['create_column' => 'updated_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false'],
        ];
    }

    /**
     * Method to invalidate the instance pool of all tables related to order     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool(): void
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        OrderProductTableMap::clearInstancePool();
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
        return $withPrefix ? OrderTableMap::CLASS_DEFAULT : OrderTableMap::OM_CLASS;
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
     * @return array (Order object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = OrderTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderTableMap::OM_CLASS;
            /** @var Order $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderTableMap::addInstanceToPool($obj, $key);
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
            $key = OrderTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Order $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OrderTableMap::COL_ID);
            $criteria->addSelectColumn(OrderTableMap::COL_ID_CLIENT);
            $criteria->addSelectColumn(OrderTableMap::COL_ID_SELLER);
            $criteria->addSelectColumn(OrderTableMap::COL_EXPIRES_AT);
            $criteria->addSelectColumn(OrderTableMap::COL_TYPE);
            $criteria->addSelectColumn(OrderTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.id_client');
            $criteria->addSelectColumn($alias . '.id_seller');
            $criteria->addSelectColumn($alias . '.expires_at');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.updated_at');
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
            $criteria->removeSelectColumn(OrderTableMap::COL_ID);
            $criteria->removeSelectColumn(OrderTableMap::COL_ID_CLIENT);
            $criteria->removeSelectColumn(OrderTableMap::COL_ID_SELLER);
            $criteria->removeSelectColumn(OrderTableMap::COL_EXPIRES_AT);
            $criteria->removeSelectColumn(OrderTableMap::COL_TYPE);
            $criteria->removeSelectColumn(OrderTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.id_client');
            $criteria->removeSelectColumn($alias . '.id_seller');
            $criteria->removeSelectColumn($alias . '.expires_at');
            $criteria->removeSelectColumn($alias . '.type');
            $criteria->removeSelectColumn($alias . '.updated_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(OrderTableMap::DATABASE_NAME)->getTable(OrderTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Order or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Order object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Order) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderTableMap::DATABASE_NAME);
            $criteria->add(OrderTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = OrderQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OrderTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OrderTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return OrderQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Order or Criteria object.
     *
     * @param mixed $criteria Criteria or Order object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Order object
        }

        if ($criteria->containsKey(OrderTableMap::COL_ID) && $criteria->keyContainsValue(OrderTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OrderTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = OrderQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
