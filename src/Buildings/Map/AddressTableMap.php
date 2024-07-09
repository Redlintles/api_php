<?php

namespace Buildings\Map;

use Buildings\Address;
use Buildings\AddressQuery;
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
 * This class defines the structure of the 'address' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AddressTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.AddressTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'address';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Address';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Address';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Address';

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
    public const COL_ID = 'address.id';

    /**
     * the column name for the country field
     */
    public const COL_COUNTRY = 'address.country';

    /**
     * the column name for the state field
     */
    public const COL_STATE = 'address.state';

    /**
     * the column name for the city field
     */
    public const COL_CITY = 'address.city';

    /**
     * the column name for the neighborhood field
     */
    public const COL_NEIGHBORHOOD = 'address.neighborhood';

    /**
     * the column name for the street field
     */
    public const COL_STREET = 'address.street';

    /**
     * the column name for the number field
     */
    public const COL_NUMBER = 'address.number';

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
        self::TYPE_PHPNAME       => ['Id', 'Country', 'State', 'City', 'Neighborhood', 'Street', 'Number', ],
        self::TYPE_CAMELNAME     => ['id', 'country', 'state', 'city', 'neighborhood', 'street', 'number', ],
        self::TYPE_COLNAME       => [AddressTableMap::COL_ID, AddressTableMap::COL_COUNTRY, AddressTableMap::COL_STATE, AddressTableMap::COL_CITY, AddressTableMap::COL_NEIGHBORHOOD, AddressTableMap::COL_STREET, AddressTableMap::COL_NUMBER, ],
        self::TYPE_FIELDNAME     => ['id', 'country', 'state', 'city', 'neighborhood', 'street', 'number', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Country' => 1, 'State' => 2, 'City' => 3, 'Neighborhood' => 4, 'Street' => 5, 'Number' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'country' => 1, 'state' => 2, 'city' => 3, 'neighborhood' => 4, 'street' => 5, 'number' => 6, ],
        self::TYPE_COLNAME       => [AddressTableMap::COL_ID => 0, AddressTableMap::COL_COUNTRY => 1, AddressTableMap::COL_STATE => 2, AddressTableMap::COL_CITY => 3, AddressTableMap::COL_NEIGHBORHOOD => 4, AddressTableMap::COL_STREET => 5, AddressTableMap::COL_NUMBER => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'country' => 1, 'state' => 2, 'city' => 3, 'neighborhood' => 4, 'street' => 5, 'number' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Address.Id' => 'ID',
        'id' => 'ID',
        'address.id' => 'ID',
        'AddressTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Country' => 'COUNTRY',
        'Address.Country' => 'COUNTRY',
        'country' => 'COUNTRY',
        'address.country' => 'COUNTRY',
        'AddressTableMap::COL_COUNTRY' => 'COUNTRY',
        'COL_COUNTRY' => 'COUNTRY',
        'State' => 'STATE',
        'Address.State' => 'STATE',
        'state' => 'STATE',
        'address.state' => 'STATE',
        'AddressTableMap::COL_STATE' => 'STATE',
        'COL_STATE' => 'STATE',
        'City' => 'CITY',
        'Address.City' => 'CITY',
        'city' => 'CITY',
        'address.city' => 'CITY',
        'AddressTableMap::COL_CITY' => 'CITY',
        'COL_CITY' => 'CITY',
        'Neighborhood' => 'NEIGHBORHOOD',
        'Address.Neighborhood' => 'NEIGHBORHOOD',
        'neighborhood' => 'NEIGHBORHOOD',
        'address.neighborhood' => 'NEIGHBORHOOD',
        'AddressTableMap::COL_NEIGHBORHOOD' => 'NEIGHBORHOOD',
        'COL_NEIGHBORHOOD' => 'NEIGHBORHOOD',
        'Street' => 'STREET',
        'Address.Street' => 'STREET',
        'street' => 'STREET',
        'address.street' => 'STREET',
        'AddressTableMap::COL_STREET' => 'STREET',
        'COL_STREET' => 'STREET',
        'Number' => 'NUMBER',
        'Address.Number' => 'NUMBER',
        'number' => 'NUMBER',
        'address.number' => 'NUMBER',
        'AddressTableMap::COL_NUMBER' => 'NUMBER',
        'COL_NUMBER' => 'NUMBER',
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
        $this->setName('address');
        $this->setPhpName('Address');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Address');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('country', 'Country', 'VARCHAR', true, 30, '');
        $this->addColumn('state', 'State', 'VARCHAR', true, 2, '');
        $this->addColumn('city', 'City', 'VARCHAR', true, 20, '');
        $this->addColumn('neighborhood', 'Neighborhood', 'VARCHAR', true, 20, '');
        $this->addColumn('street', 'Street', 'VARCHAR', true, 30, '');
        $this->addColumn('number', 'Number', 'INTEGER', true, null, 1);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('AddressOwnerAddress', '\\Buildings\\AddressOwner', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_address',
    1 => ':id',
  ),
), 'CASCADE', null, 'AddressOwnerAddresses', false);
    }

    /**
     * Method to invalidate the instance pool of all tables related to address     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool(): void
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
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
        return $withPrefix ? AddressTableMap::CLASS_DEFAULT : AddressTableMap::OM_CLASS;
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
     * @return array (Address object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AddressTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AddressTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AddressTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AddressTableMap::OM_CLASS;
            /** @var Address $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AddressTableMap::addInstanceToPool($obj, $key);
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
            $key = AddressTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AddressTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Address $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AddressTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AddressTableMap::COL_ID);
            $criteria->addSelectColumn(AddressTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(AddressTableMap::COL_STATE);
            $criteria->addSelectColumn(AddressTableMap::COL_CITY);
            $criteria->addSelectColumn(AddressTableMap::COL_NEIGHBORHOOD);
            $criteria->addSelectColumn(AddressTableMap::COL_STREET);
            $criteria->addSelectColumn(AddressTableMap::COL_NUMBER);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.country');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.neighborhood');
            $criteria->addSelectColumn($alias . '.street');
            $criteria->addSelectColumn($alias . '.number');
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
            $criteria->removeSelectColumn(AddressTableMap::COL_ID);
            $criteria->removeSelectColumn(AddressTableMap::COL_COUNTRY);
            $criteria->removeSelectColumn(AddressTableMap::COL_STATE);
            $criteria->removeSelectColumn(AddressTableMap::COL_CITY);
            $criteria->removeSelectColumn(AddressTableMap::COL_NEIGHBORHOOD);
            $criteria->removeSelectColumn(AddressTableMap::COL_STREET);
            $criteria->removeSelectColumn(AddressTableMap::COL_NUMBER);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.country');
            $criteria->removeSelectColumn($alias . '.state');
            $criteria->removeSelectColumn($alias . '.city');
            $criteria->removeSelectColumn($alias . '.neighborhood');
            $criteria->removeSelectColumn($alias . '.street');
            $criteria->removeSelectColumn($alias . '.number');
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
        return Propel::getServiceContainer()->getDatabaseMap(AddressTableMap::DATABASE_NAME)->getTable(AddressTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Address or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Address object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Address) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AddressTableMap::DATABASE_NAME);
            $criteria->add(AddressTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AddressQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AddressTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AddressTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AddressQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Address or Criteria object.
     *
     * @param mixed $criteria Criteria or Address object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Address object
        }

        if ($criteria->containsKey(AddressTableMap::COL_ID) && $criteria->keyContainsValue(AddressTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AddressTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AddressQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
