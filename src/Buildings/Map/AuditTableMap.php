<?php

namespace Buildings\Map;

use Buildings\Audit;
use Buildings\AuditQuery;
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
 * This class defines the structure of the 'audit' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AuditTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.AuditTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'audit';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Audit';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Audit';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Audit';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'audit.id';

    /**
     * the column name for the operation_executor field
     */
    public const COL_OPERATION_EXECUTOR = 'audit.operation_executor';

    /**
     * the column name for the operation_type field
     */
    public const COL_OPERATION_TYPE = 'audit.operation_type';

    /**
     * the column name for the operation_route field
     */
    public const COL_OPERATION_ROUTE = 'audit.operation_route';

    /**
     * the column name for the operation_data_string field
     */
    public const COL_OPERATION_DATA_STRING = 'audit.operation_data_string';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'audit.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'audit.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'OperationExecutor', 'OperationType', 'OperationRoute', 'OperationDataString', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'operationExecutor', 'operationType', 'operationRoute', 'operationDataString', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [AuditTableMap::COL_ID, AuditTableMap::COL_OPERATION_EXECUTOR, AuditTableMap::COL_OPERATION_TYPE, AuditTableMap::COL_OPERATION_ROUTE, AuditTableMap::COL_OPERATION_DATA_STRING, AuditTableMap::COL_CREATED_AT, AuditTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'operation_executor', 'operation_type', 'operation_route', 'operation_data_string', 'created_at', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'OperationExecutor' => 1, 'OperationType' => 2, 'OperationRoute' => 3, 'OperationDataString' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'operationExecutor' => 1, 'operationType' => 2, 'operationRoute' => 3, 'operationDataString' => 4, 'createdAt' => 5, 'updatedAt' => 6, ],
        self::TYPE_COLNAME       => [AuditTableMap::COL_ID => 0, AuditTableMap::COL_OPERATION_EXECUTOR => 1, AuditTableMap::COL_OPERATION_TYPE => 2, AuditTableMap::COL_OPERATION_ROUTE => 3, AuditTableMap::COL_OPERATION_DATA_STRING => 4, AuditTableMap::COL_CREATED_AT => 5, AuditTableMap::COL_UPDATED_AT => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'operation_executor' => 1, 'operation_type' => 2, 'operation_route' => 3, 'operation_data_string' => 4, 'created_at' => 5, 'updated_at' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Audit.Id' => 'ID',
        'id' => 'ID',
        'audit.id' => 'ID',
        'AuditTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'OperationExecutor' => 'OPERATION_EXECUTOR',
        'Audit.OperationExecutor' => 'OPERATION_EXECUTOR',
        'operationExecutor' => 'OPERATION_EXECUTOR',
        'audit.operationExecutor' => 'OPERATION_EXECUTOR',
        'AuditTableMap::COL_OPERATION_EXECUTOR' => 'OPERATION_EXECUTOR',
        'COL_OPERATION_EXECUTOR' => 'OPERATION_EXECUTOR',
        'operation_executor' => 'OPERATION_EXECUTOR',
        'audit.operation_executor' => 'OPERATION_EXECUTOR',
        'OperationType' => 'OPERATION_TYPE',
        'Audit.OperationType' => 'OPERATION_TYPE',
        'operationType' => 'OPERATION_TYPE',
        'audit.operationType' => 'OPERATION_TYPE',
        'AuditTableMap::COL_OPERATION_TYPE' => 'OPERATION_TYPE',
        'COL_OPERATION_TYPE' => 'OPERATION_TYPE',
        'operation_type' => 'OPERATION_TYPE',
        'audit.operation_type' => 'OPERATION_TYPE',
        'OperationRoute' => 'OPERATION_ROUTE',
        'Audit.OperationRoute' => 'OPERATION_ROUTE',
        'operationRoute' => 'OPERATION_ROUTE',
        'audit.operationRoute' => 'OPERATION_ROUTE',
        'AuditTableMap::COL_OPERATION_ROUTE' => 'OPERATION_ROUTE',
        'COL_OPERATION_ROUTE' => 'OPERATION_ROUTE',
        'operation_route' => 'OPERATION_ROUTE',
        'audit.operation_route' => 'OPERATION_ROUTE',
        'OperationDataString' => 'OPERATION_DATA_STRING',
        'Audit.OperationDataString' => 'OPERATION_DATA_STRING',
        'operationDataString' => 'OPERATION_DATA_STRING',
        'audit.operationDataString' => 'OPERATION_DATA_STRING',
        'AuditTableMap::COL_OPERATION_DATA_STRING' => 'OPERATION_DATA_STRING',
        'COL_OPERATION_DATA_STRING' => 'OPERATION_DATA_STRING',
        'operation_data_string' => 'OPERATION_DATA_STRING',
        'audit.operation_data_string' => 'OPERATION_DATA_STRING',
        'CreatedAt' => 'CREATED_AT',
        'Audit.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'audit.createdAt' => 'CREATED_AT',
        'AuditTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'audit.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Audit.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'audit.updatedAt' => 'UPDATED_AT',
        'AuditTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'audit.updated_at' => 'UPDATED_AT',
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
        $this->setName('audit');
        $this->setPhpName('Audit');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Audit');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('operation_executor', 'OperationExecutor', 'VARCHAR', true, 50, '');
        $this->addColumn('operation_type', 'OperationType', 'VARCHAR', true, 10, '');
        $this->addColumn('operation_route', 'OperationRoute', 'VARCHAR', true, 50, '');
        $this->addColumn('operation_data_string', 'OperationDataString', 'VARCHAR', true, 80, '');
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
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
            'timestampable' => ['create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false'],
        ];
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
        return $withPrefix ? AuditTableMap::CLASS_DEFAULT : AuditTableMap::OM_CLASS;
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
     * @return array (Audit object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AuditTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuditTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuditTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuditTableMap::OM_CLASS;
            /** @var Audit $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuditTableMap::addInstanceToPool($obj, $key);
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
            $key = AuditTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuditTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Audit $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuditTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AuditTableMap::COL_ID);
            $criteria->addSelectColumn(AuditTableMap::COL_OPERATION_EXECUTOR);
            $criteria->addSelectColumn(AuditTableMap::COL_OPERATION_TYPE);
            $criteria->addSelectColumn(AuditTableMap::COL_OPERATION_ROUTE);
            $criteria->addSelectColumn(AuditTableMap::COL_OPERATION_DATA_STRING);
            $criteria->addSelectColumn(AuditTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AuditTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.operation_executor');
            $criteria->addSelectColumn($alias . '.operation_type');
            $criteria->addSelectColumn($alias . '.operation_route');
            $criteria->addSelectColumn($alias . '.operation_data_string');
            $criteria->addSelectColumn($alias . '.created_at');
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
            $criteria->removeSelectColumn(AuditTableMap::COL_ID);
            $criteria->removeSelectColumn(AuditTableMap::COL_OPERATION_EXECUTOR);
            $criteria->removeSelectColumn(AuditTableMap::COL_OPERATION_TYPE);
            $criteria->removeSelectColumn(AuditTableMap::COL_OPERATION_ROUTE);
            $criteria->removeSelectColumn(AuditTableMap::COL_OPERATION_DATA_STRING);
            $criteria->removeSelectColumn(AuditTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(AuditTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.operation_executor');
            $criteria->removeSelectColumn($alias . '.operation_type');
            $criteria->removeSelectColumn($alias . '.operation_route');
            $criteria->removeSelectColumn($alias . '.operation_data_string');
            $criteria->removeSelectColumn($alias . '.created_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(AuditTableMap::DATABASE_NAME)->getTable(AuditTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Audit or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Audit object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuditTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Audit) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuditTableMap::DATABASE_NAME);
            $criteria->add(AuditTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AuditQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuditTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuditTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the audit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AuditQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Audit or Criteria object.
     *
     * @param mixed $criteria Criteria or Audit object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuditTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Audit object
        }

        if ($criteria->containsKey(AuditTableMap::COL_ID) && $criteria->keyContainsValue(AuditTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AuditTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AuditQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
