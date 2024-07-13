<?php

namespace Buildings\Map;

use Buildings\Permission;
use Buildings\PermissionQuery;
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
 * This class defines the structure of the 'permission' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PermissionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.PermissionTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'permission';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Permission';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Permission';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Permission';

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
    public const COL_ID = 'permission.id';

    /**
     * the column name for the admin_id field
     */
    public const COL_ADMIN_ID = 'permission.admin_id';

    /**
     * the column name for the create_permission field
     */
    public const COL_CREATE_PERMISSION = 'permission.create_permission';

    /**
     * the column name for the read_permission field
     */
    public const COL_READ_PERMISSION = 'permission.read_permission';

    /**
     * the column name for the update_permission field
     */
    public const COL_UPDATE_PERMISSION = 'permission.update_permission';

    /**
     * the column name for the delete_permission field
     */
    public const COL_DELETE_PERMISSION = 'permission.delete_permission';

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
        self::TYPE_PHPNAME       => ['Id', 'AdminId', 'CreatePermission', 'ReadPermission', 'UpdatePermission', 'DeletePermission', ],
        self::TYPE_CAMELNAME     => ['id', 'adminId', 'createPermission', 'readPermission', 'updatePermission', 'deletePermission', ],
        self::TYPE_COLNAME       => [PermissionTableMap::COL_ID, PermissionTableMap::COL_ADMIN_ID, PermissionTableMap::COL_CREATE_PERMISSION, PermissionTableMap::COL_READ_PERMISSION, PermissionTableMap::COL_UPDATE_PERMISSION, PermissionTableMap::COL_DELETE_PERMISSION, ],
        self::TYPE_FIELDNAME     => ['id', 'admin_id', 'create_permission', 'read_permission', 'update_permission', 'delete_permission', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'AdminId' => 1, 'CreatePermission' => 2, 'ReadPermission' => 3, 'UpdatePermission' => 4, 'DeletePermission' => 5, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'adminId' => 1, 'createPermission' => 2, 'readPermission' => 3, 'updatePermission' => 4, 'deletePermission' => 5, ],
        self::TYPE_COLNAME       => [PermissionTableMap::COL_ID => 0, PermissionTableMap::COL_ADMIN_ID => 1, PermissionTableMap::COL_CREATE_PERMISSION => 2, PermissionTableMap::COL_READ_PERMISSION => 3, PermissionTableMap::COL_UPDATE_PERMISSION => 4, PermissionTableMap::COL_DELETE_PERMISSION => 5, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'admin_id' => 1, 'create_permission' => 2, 'read_permission' => 3, 'update_permission' => 4, 'delete_permission' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Permission.Id' => 'ID',
        'id' => 'ID',
        'permission.id' => 'ID',
        'PermissionTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'AdminId' => 'ADMIN_ID',
        'Permission.AdminId' => 'ADMIN_ID',
        'adminId' => 'ADMIN_ID',
        'permission.adminId' => 'ADMIN_ID',
        'PermissionTableMap::COL_ADMIN_ID' => 'ADMIN_ID',
        'COL_ADMIN_ID' => 'ADMIN_ID',
        'admin_id' => 'ADMIN_ID',
        'permission.admin_id' => 'ADMIN_ID',
        'CreatePermission' => 'CREATE_PERMISSION',
        'Permission.CreatePermission' => 'CREATE_PERMISSION',
        'createPermission' => 'CREATE_PERMISSION',
        'permission.createPermission' => 'CREATE_PERMISSION',
        'PermissionTableMap::COL_CREATE_PERMISSION' => 'CREATE_PERMISSION',
        'COL_CREATE_PERMISSION' => 'CREATE_PERMISSION',
        'create_permission' => 'CREATE_PERMISSION',
        'permission.create_permission' => 'CREATE_PERMISSION',
        'ReadPermission' => 'READ_PERMISSION',
        'Permission.ReadPermission' => 'READ_PERMISSION',
        'readPermission' => 'READ_PERMISSION',
        'permission.readPermission' => 'READ_PERMISSION',
        'PermissionTableMap::COL_READ_PERMISSION' => 'READ_PERMISSION',
        'COL_READ_PERMISSION' => 'READ_PERMISSION',
        'read_permission' => 'READ_PERMISSION',
        'permission.read_permission' => 'READ_PERMISSION',
        'UpdatePermission' => 'UPDATE_PERMISSION',
        'Permission.UpdatePermission' => 'UPDATE_PERMISSION',
        'updatePermission' => 'UPDATE_PERMISSION',
        'permission.updatePermission' => 'UPDATE_PERMISSION',
        'PermissionTableMap::COL_UPDATE_PERMISSION' => 'UPDATE_PERMISSION',
        'COL_UPDATE_PERMISSION' => 'UPDATE_PERMISSION',
        'update_permission' => 'UPDATE_PERMISSION',
        'permission.update_permission' => 'UPDATE_PERMISSION',
        'DeletePermission' => 'DELETE_PERMISSION',
        'Permission.DeletePermission' => 'DELETE_PERMISSION',
        'deletePermission' => 'DELETE_PERMISSION',
        'permission.deletePermission' => 'DELETE_PERMISSION',
        'PermissionTableMap::COL_DELETE_PERMISSION' => 'DELETE_PERMISSION',
        'COL_DELETE_PERMISSION' => 'DELETE_PERMISSION',
        'delete_permission' => 'DELETE_PERMISSION',
        'permission.delete_permission' => 'DELETE_PERMISSION',
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
        $this->setName('permission');
        $this->setPhpName('Permission');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Permission');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('admin_id', 'AdminId', 'INTEGER', 'admin', 'id', false, null, null);
        $this->addColumn('create_permission', 'CreatePermission', 'INTEGER', true, null, 0);
        $this->addColumn('read_permission', 'ReadPermission', 'INTEGER', true, null, 0);
        $this->addColumn('update_permission', 'UpdatePermission', 'INTEGER', true, null, 0);
        $this->addColumn('delete_permission', 'DeletePermission', 'INTEGER', true, null, 0);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('PermissionAdminId', '\\Buildings\\Admin', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':admin_id',
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
        return $withPrefix ? PermissionTableMap::CLASS_DEFAULT : PermissionTableMap::OM_CLASS;
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
     * @return array (Permission object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PermissionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PermissionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PermissionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PermissionTableMap::OM_CLASS;
            /** @var Permission $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PermissionTableMap::addInstanceToPool($obj, $key);
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
            $key = PermissionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PermissionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Permission $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PermissionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PermissionTableMap::COL_ID);
            $criteria->addSelectColumn(PermissionTableMap::COL_ADMIN_ID);
            $criteria->addSelectColumn(PermissionTableMap::COL_CREATE_PERMISSION);
            $criteria->addSelectColumn(PermissionTableMap::COL_READ_PERMISSION);
            $criteria->addSelectColumn(PermissionTableMap::COL_UPDATE_PERMISSION);
            $criteria->addSelectColumn(PermissionTableMap::COL_DELETE_PERMISSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.admin_id');
            $criteria->addSelectColumn($alias . '.create_permission');
            $criteria->addSelectColumn($alias . '.read_permission');
            $criteria->addSelectColumn($alias . '.update_permission');
            $criteria->addSelectColumn($alias . '.delete_permission');
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
            $criteria->removeSelectColumn(PermissionTableMap::COL_ID);
            $criteria->removeSelectColumn(PermissionTableMap::COL_ADMIN_ID);
            $criteria->removeSelectColumn(PermissionTableMap::COL_CREATE_PERMISSION);
            $criteria->removeSelectColumn(PermissionTableMap::COL_READ_PERMISSION);
            $criteria->removeSelectColumn(PermissionTableMap::COL_UPDATE_PERMISSION);
            $criteria->removeSelectColumn(PermissionTableMap::COL_DELETE_PERMISSION);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.admin_id');
            $criteria->removeSelectColumn($alias . '.create_permission');
            $criteria->removeSelectColumn($alias . '.read_permission');
            $criteria->removeSelectColumn($alias . '.update_permission');
            $criteria->removeSelectColumn($alias . '.delete_permission');
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
        return Propel::getServiceContainer()->getDatabaseMap(PermissionTableMap::DATABASE_NAME)->getTable(PermissionTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Permission or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Permission object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Permission) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);
            $criteria->add(PermissionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PermissionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PermissionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PermissionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PermissionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Permission or Criteria object.
     *
     * @param mixed $criteria Criteria or Permission object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Permission object
        }

        if ($criteria->containsKey(PermissionTableMap::COL_ID) && $criteria->keyContainsValue(PermissionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PermissionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PermissionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
