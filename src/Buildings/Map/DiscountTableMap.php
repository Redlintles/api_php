<?php

namespace Buildings\Map;

use Buildings\Discount;
use Buildings\DiscountQuery;
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
 * This class defines the structure of the 'discount' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DiscountTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Buildings.Map.DiscountTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'discount';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Discount';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Buildings\\Discount';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Buildings.Discount';

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
    public const COL_ID = 'discount.id';

    /**
     * the column name for the type field
     */
    public const COL_TYPE = 'discount.type';

    /**
     * the column name for the id_product field
     */
    public const COL_ID_PRODUCT = 'discount.id_product';

    /**
     * the column name for the id_category field
     */
    public const COL_ID_CATEGORY = 'discount.id_category';

    /**
     * the column name for the percent field
     */
    public const COL_PERCENT = 'discount.percent';

    /**
     * the column name for the start_at field
     */
    public const COL_START_AT = 'discount.start_at';

    /**
     * the column name for the expires_at field
     */
    public const COL_EXPIRES_AT = 'discount.expires_at';

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
        self::TYPE_PHPNAME       => ['Id', 'Type', 'IdProduct', 'IdCategory', 'Percent', 'StartAt', 'ExpiresAt', ],
        self::TYPE_CAMELNAME     => ['id', 'type', 'idProduct', 'idCategory', 'percent', 'startAt', 'expiresAt', ],
        self::TYPE_COLNAME       => [DiscountTableMap::COL_ID, DiscountTableMap::COL_TYPE, DiscountTableMap::COL_ID_PRODUCT, DiscountTableMap::COL_ID_CATEGORY, DiscountTableMap::COL_PERCENT, DiscountTableMap::COL_START_AT, DiscountTableMap::COL_EXPIRES_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'type', 'id_product', 'id_category', 'percent', 'start_at', 'expires_at', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Type' => 1, 'IdProduct' => 2, 'IdCategory' => 3, 'Percent' => 4, 'StartAt' => 5, 'ExpiresAt' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'type' => 1, 'idProduct' => 2, 'idCategory' => 3, 'percent' => 4, 'startAt' => 5, 'expiresAt' => 6, ],
        self::TYPE_COLNAME       => [DiscountTableMap::COL_ID => 0, DiscountTableMap::COL_TYPE => 1, DiscountTableMap::COL_ID_PRODUCT => 2, DiscountTableMap::COL_ID_CATEGORY => 3, DiscountTableMap::COL_PERCENT => 4, DiscountTableMap::COL_START_AT => 5, DiscountTableMap::COL_EXPIRES_AT => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'type' => 1, 'id_product' => 2, 'id_category' => 3, 'percent' => 4, 'start_at' => 5, 'expires_at' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Discount.Id' => 'ID',
        'id' => 'ID',
        'discount.id' => 'ID',
        'DiscountTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Type' => 'TYPE',
        'Discount.Type' => 'TYPE',
        'type' => 'TYPE',
        'discount.type' => 'TYPE',
        'DiscountTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'IdProduct' => 'ID_PRODUCT',
        'Discount.IdProduct' => 'ID_PRODUCT',
        'idProduct' => 'ID_PRODUCT',
        'discount.idProduct' => 'ID_PRODUCT',
        'DiscountTableMap::COL_ID_PRODUCT' => 'ID_PRODUCT',
        'COL_ID_PRODUCT' => 'ID_PRODUCT',
        'id_product' => 'ID_PRODUCT',
        'discount.id_product' => 'ID_PRODUCT',
        'IdCategory' => 'ID_CATEGORY',
        'Discount.IdCategory' => 'ID_CATEGORY',
        'idCategory' => 'ID_CATEGORY',
        'discount.idCategory' => 'ID_CATEGORY',
        'DiscountTableMap::COL_ID_CATEGORY' => 'ID_CATEGORY',
        'COL_ID_CATEGORY' => 'ID_CATEGORY',
        'id_category' => 'ID_CATEGORY',
        'discount.id_category' => 'ID_CATEGORY',
        'Percent' => 'PERCENT',
        'Discount.Percent' => 'PERCENT',
        'percent' => 'PERCENT',
        'discount.percent' => 'PERCENT',
        'DiscountTableMap::COL_PERCENT' => 'PERCENT',
        'COL_PERCENT' => 'PERCENT',
        'StartAt' => 'START_AT',
        'Discount.StartAt' => 'START_AT',
        'startAt' => 'START_AT',
        'discount.startAt' => 'START_AT',
        'DiscountTableMap::COL_START_AT' => 'START_AT',
        'COL_START_AT' => 'START_AT',
        'start_at' => 'START_AT',
        'discount.start_at' => 'START_AT',
        'ExpiresAt' => 'EXPIRES_AT',
        'Discount.ExpiresAt' => 'EXPIRES_AT',
        'expiresAt' => 'EXPIRES_AT',
        'discount.expiresAt' => 'EXPIRES_AT',
        'DiscountTableMap::COL_EXPIRES_AT' => 'EXPIRES_AT',
        'COL_EXPIRES_AT' => 'EXPIRES_AT',
        'expires_at' => 'EXPIRES_AT',
        'discount.expires_at' => 'EXPIRES_AT',
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
        $this->setName('discount');
        $this->setPhpName('Discount');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Buildings\\Discount');
        $this->setPackage('Buildings');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 1, null);
        $this->addForeignKey('id_product', 'IdProduct', 'INTEGER', 'product', 'id', false, null, null);
        $this->addForeignKey('id_category', 'IdCategory', 'INTEGER', 'category', 'id', false, null, null);
        $this->addColumn('percent', 'Percent', 'INTEGER', true, null, 1);
        $this->addColumn('start_at', 'StartAt', 'TIMESTAMP', true, null, '2024-01-01 00:00:00');
        $this->addColumn('expires_at', 'ExpiresAt', 'TIMESTAMP', true, null, '2024-01-01 00:00:00');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('DiscountProduct', '\\Buildings\\Product', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_product',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('DiscountCategory', '\\Buildings\\Category', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_category',
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
        return $withPrefix ? DiscountTableMap::CLASS_DEFAULT : DiscountTableMap::OM_CLASS;
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
     * @return array (Discount object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = DiscountTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DiscountTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DiscountTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DiscountTableMap::OM_CLASS;
            /** @var Discount $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DiscountTableMap::addInstanceToPool($obj, $key);
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
            $key = DiscountTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DiscountTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Discount $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DiscountTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DiscountTableMap::COL_ID);
            $criteria->addSelectColumn(DiscountTableMap::COL_TYPE);
            $criteria->addSelectColumn(DiscountTableMap::COL_ID_PRODUCT);
            $criteria->addSelectColumn(DiscountTableMap::COL_ID_CATEGORY);
            $criteria->addSelectColumn(DiscountTableMap::COL_PERCENT);
            $criteria->addSelectColumn(DiscountTableMap::COL_START_AT);
            $criteria->addSelectColumn(DiscountTableMap::COL_EXPIRES_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.id_product');
            $criteria->addSelectColumn($alias . '.id_category');
            $criteria->addSelectColumn($alias . '.percent');
            $criteria->addSelectColumn($alias . '.start_at');
            $criteria->addSelectColumn($alias . '.expires_at');
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
            $criteria->removeSelectColumn(DiscountTableMap::COL_ID);
            $criteria->removeSelectColumn(DiscountTableMap::COL_TYPE);
            $criteria->removeSelectColumn(DiscountTableMap::COL_ID_PRODUCT);
            $criteria->removeSelectColumn(DiscountTableMap::COL_ID_CATEGORY);
            $criteria->removeSelectColumn(DiscountTableMap::COL_PERCENT);
            $criteria->removeSelectColumn(DiscountTableMap::COL_START_AT);
            $criteria->removeSelectColumn(DiscountTableMap::COL_EXPIRES_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.type');
            $criteria->removeSelectColumn($alias . '.id_product');
            $criteria->removeSelectColumn($alias . '.id_category');
            $criteria->removeSelectColumn($alias . '.percent');
            $criteria->removeSelectColumn($alias . '.start_at');
            $criteria->removeSelectColumn($alias . '.expires_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(DiscountTableMap::DATABASE_NAME)->getTable(DiscountTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Discount or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Discount object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DiscountTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Buildings\Discount) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DiscountTableMap::DATABASE_NAME);
            $criteria->add(DiscountTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DiscountQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DiscountTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DiscountTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the discount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return DiscountQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Discount or Criteria object.
     *
     * @param mixed $criteria Criteria or Discount object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DiscountTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Discount object
        }

        if ($criteria->containsKey(DiscountTableMap::COL_ID) && $criteria->keyContainsValue(DiscountTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DiscountTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DiscountQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
