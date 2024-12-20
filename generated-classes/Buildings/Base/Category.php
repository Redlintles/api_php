<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Category as ChildCategory;
use Buildings\CategoryQuery as ChildCategoryQuery;
use Buildings\Discount as ChildDiscount;
use Buildings\DiscountQuery as ChildDiscountQuery;
use Buildings\ProductCategory as ChildProductCategory;
use Buildings\ProductCategoryQuery as ChildProductCategoryQuery;
use Buildings\Map\CategoryTableMap;
use Buildings\Map\DiscountTableMap;
use Buildings\Map\ProductCategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'category' table.
 *
 *
 *
 * @package    propel.generator.Buildings.Base
 */
abstract class Category implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Buildings\\Map\\CategoryTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $name;

    /**
     * @var        ObjectCollection|ChildDiscount[] Collection to store aggregation of ChildDiscount objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildDiscount> Collection to store aggregation of ChildDiscount objects.
     */
    protected $collDiscountCategories;
    protected $collDiscountCategoriesPartial;

    /**
     * @var        ObjectCollection|ChildProductCategory[] Collection to store aggregation of ChildProductCategory objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildProductCategory> Collection to store aggregation of ChildProductCategory objects.
     */
    protected $collProductCategoryCategories;
    protected $collProductCategoryCategoriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDiscount[]
     * @phpstan-var ObjectCollection&\Traversable<ChildDiscount>
     */
    protected $discountCategoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProductCategory[]
     * @phpstan-var ObjectCollection&\Traversable<ChildProductCategory>
     */
    protected $productCategoryCategoriesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
        $this->name = '';
    }

    /**
     * Initializes internal state of Buildings\Base\Category object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Category</code> instance.  If
     * <code>obj</code> is an instance of <code>Category</code>, delegates to
     * <code>equals(Category)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CategoryTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CategoryTableMap::COL_NAME] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
            if ($this->name !== '') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CategoryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CategoryTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = CategoryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Buildings\\Category'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CategoryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCategoryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDiscountCategories = null;

            $this->collProductCategoryCategories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Category::setDeleted()
     * @see Category::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCategoryQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CategoryTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->discountCategoriesScheduledForDeletion !== null) {
                if (!$this->discountCategoriesScheduledForDeletion->isEmpty()) {
                    \Buildings\DiscountQuery::create()
                        ->filterByPrimaryKeys($this->discountCategoriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->discountCategoriesScheduledForDeletion = null;
                }
            }

            if ($this->collDiscountCategories !== null) {
                foreach ($this->collDiscountCategories as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productCategoryCategoriesScheduledForDeletion !== null) {
                if (!$this->productCategoryCategoriesScheduledForDeletion->isEmpty()) {
                    \Buildings\ProductCategoryQuery::create()
                        ->filterByPrimaryKeys($this->productCategoryCategoriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productCategoryCategoriesScheduledForDeletion = null;
                }
            }

            if ($this->collProductCategoryCategories !== null) {
                foreach ($this->collProductCategoryCategories as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[CategoryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CategoryTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CategoryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CategoryTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO category (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);

                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getName();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Category'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Category'][$this->hashCode()] = true;
        $keys = CategoryTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collDiscountCategories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'discounts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'discounts';
                        break;
                    default:
                        $key = 'DiscountCategories';
                }

                $result[$key] = $this->collDiscountCategories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProductCategoryCategories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'productCategories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'product_categories';
                        break;
                    default:
                        $key = 'ProductCategoryCategories';
                }

                $result[$key] = $this->collProductCategoryCategories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CategoryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(CategoryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CategoryTableMap::COL_ID)) {
            $criteria->add(CategoryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CategoryTableMap::COL_NAME)) {
            $criteria->add(CategoryTableMap::COL_NAME, $this->name);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildCategoryQuery::create();
        $criteria->add(CategoryTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Buildings\Category (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDiscountCategories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDiscountCategory($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProductCategoryCategories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductCategoryCategory($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Buildings\Category Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('DiscountCategory' === $relationName) {
            $this->initDiscountCategories();
            return;
        }
        if ('ProductCategoryCategory' === $relationName) {
            $this->initProductCategoryCategories();
            return;
        }
    }

    /**
     * Clears out the collDiscountCategories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addDiscountCategories()
     */
    public function clearDiscountCategories()
    {
        $this->collDiscountCategories = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collDiscountCategories collection loaded partially.
     *
     * @return void
     */
    public function resetPartialDiscountCategories($v = true): void
    {
        $this->collDiscountCategoriesPartial = $v;
    }

    /**
     * Initializes the collDiscountCategories collection.
     *
     * By default this just sets the collDiscountCategories collection to an empty array (like clearcollDiscountCategories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDiscountCategories(bool $overrideExisting = true): void
    {
        if (null !== $this->collDiscountCategories && !$overrideExisting) {
            return;
        }

        $collectionClassName = DiscountTableMap::getTableMap()->getCollectionClassName();

        $this->collDiscountCategories = new $collectionClassName;
        $this->collDiscountCategories->setModel('\Buildings\Discount');
    }

    /**
     * Gets an array of ChildDiscount objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDiscount[] List of ChildDiscount objects
     * @phpstan-return ObjectCollection&\Traversable<ChildDiscount> List of ChildDiscount objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getDiscountCategories(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collDiscountCategoriesPartial && !$this->isNew();
        if (null === $this->collDiscountCategories || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDiscountCategories) {
                    $this->initDiscountCategories();
                } else {
                    $collectionClassName = DiscountTableMap::getTableMap()->getCollectionClassName();

                    $collDiscountCategories = new $collectionClassName;
                    $collDiscountCategories->setModel('\Buildings\Discount');

                    return $collDiscountCategories;
                }
            } else {
                $collDiscountCategories = ChildDiscountQuery::create(null, $criteria)
                    ->filterByDiscountIdCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDiscountCategoriesPartial && count($collDiscountCategories)) {
                        $this->initDiscountCategories(false);

                        foreach ($collDiscountCategories as $obj) {
                            if (false == $this->collDiscountCategories->contains($obj)) {
                                $this->collDiscountCategories->append($obj);
                            }
                        }

                        $this->collDiscountCategoriesPartial = true;
                    }

                    return $collDiscountCategories;
                }

                if ($partial && $this->collDiscountCategories) {
                    foreach ($this->collDiscountCategories as $obj) {
                        if ($obj->isNew()) {
                            $collDiscountCategories[] = $obj;
                        }
                    }
                }

                $this->collDiscountCategories = $collDiscountCategories;
                $this->collDiscountCategoriesPartial = false;
            }
        }

        return $this->collDiscountCategories;
    }

    /**
     * Sets a collection of ChildDiscount objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $discountCategories A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setDiscountCategories(Collection $discountCategories, ?ConnectionInterface $con = null)
    {
        /** @var ChildDiscount[] $discountCategoriesToDelete */
        $discountCategoriesToDelete = $this->getDiscountCategories(new Criteria(), $con)->diff($discountCategories);


        $this->discountCategoriesScheduledForDeletion = $discountCategoriesToDelete;

        foreach ($discountCategoriesToDelete as $discountCategoryRemoved) {
            $discountCategoryRemoved->setDiscountIdCategory(null);
        }

        $this->collDiscountCategories = null;
        foreach ($discountCategories as $discountCategory) {
            $this->addDiscountCategory($discountCategory);
        }

        $this->collDiscountCategories = $discountCategories;
        $this->collDiscountCategoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Discount objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Discount objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countDiscountCategories(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collDiscountCategoriesPartial && !$this->isNew();
        if (null === $this->collDiscountCategories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDiscountCategories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDiscountCategories());
            }

            $query = ChildDiscountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDiscountIdCategory($this)
                ->count($con);
        }

        return count($this->collDiscountCategories);
    }

    /**
     * Method called to associate a ChildDiscount object to this object
     * through the ChildDiscount foreign key attribute.
     *
     * @param ChildDiscount $l ChildDiscount
     * @return $this The current object (for fluent API support)
     */
    public function addDiscountCategory(ChildDiscount $l)
    {
        if ($this->collDiscountCategories === null) {
            $this->initDiscountCategories();
            $this->collDiscountCategoriesPartial = true;
        }

        if (!$this->collDiscountCategories->contains($l)) {
            $this->doAddDiscountCategory($l);

            if ($this->discountCategoriesScheduledForDeletion and $this->discountCategoriesScheduledForDeletion->contains($l)) {
                $this->discountCategoriesScheduledForDeletion->remove($this->discountCategoriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDiscount $discountCategory The ChildDiscount object to add.
     */
    protected function doAddDiscountCategory(ChildDiscount $discountCategory): void
    {
        $this->collDiscountCategories[]= $discountCategory;
        $discountCategory->setDiscountIdCategory($this);
    }

    /**
     * @param ChildDiscount $discountCategory The ChildDiscount object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeDiscountCategory(ChildDiscount $discountCategory)
    {
        if ($this->getDiscountCategories()->contains($discountCategory)) {
            $pos = $this->collDiscountCategories->search($discountCategory);
            $this->collDiscountCategories->remove($pos);
            if (null === $this->discountCategoriesScheduledForDeletion) {
                $this->discountCategoriesScheduledForDeletion = clone $this->collDiscountCategories;
                $this->discountCategoriesScheduledForDeletion->clear();
            }
            $this->discountCategoriesScheduledForDeletion[]= $discountCategory;
            $discountCategory->setDiscountIdCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Category is new, it will return
     * an empty collection; or if this Category has previously
     * been saved, it will retrieve related DiscountCategories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Category.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDiscount[] List of ChildDiscount objects
     * @phpstan-return ObjectCollection&\Traversable<ChildDiscount}> List of ChildDiscount objects
     */
    public function getDiscountCategoriesJoinDiscountIdProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDiscountQuery::create(null, $criteria);
        $query->joinWith('DiscountIdProduct', $joinBehavior);

        return $this->getDiscountCategories($query, $con);
    }

    /**
     * Clears out the collProductCategoryCategories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addProductCategoryCategories()
     */
    public function clearProductCategoryCategories()
    {
        $this->collProductCategoryCategories = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collProductCategoryCategories collection loaded partially.
     *
     * @return void
     */
    public function resetPartialProductCategoryCategories($v = true): void
    {
        $this->collProductCategoryCategoriesPartial = $v;
    }

    /**
     * Initializes the collProductCategoryCategories collection.
     *
     * By default this just sets the collProductCategoryCategories collection to an empty array (like clearcollProductCategoryCategories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductCategoryCategories(bool $overrideExisting = true): void
    {
        if (null !== $this->collProductCategoryCategories && !$overrideExisting) {
            return;
        }

        $collectionClassName = ProductCategoryTableMap::getTableMap()->getCollectionClassName();

        $this->collProductCategoryCategories = new $collectionClassName;
        $this->collProductCategoryCategories->setModel('\Buildings\ProductCategory');
    }

    /**
     * Gets an array of ChildProductCategory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProductCategory[] List of ChildProductCategory objects
     * @phpstan-return ObjectCollection&\Traversable<ChildProductCategory> List of ChildProductCategory objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getProductCategoryCategories(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collProductCategoryCategoriesPartial && !$this->isNew();
        if (null === $this->collProductCategoryCategories || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collProductCategoryCategories) {
                    $this->initProductCategoryCategories();
                } else {
                    $collectionClassName = ProductCategoryTableMap::getTableMap()->getCollectionClassName();

                    $collProductCategoryCategories = new $collectionClassName;
                    $collProductCategoryCategories->setModel('\Buildings\ProductCategory');

                    return $collProductCategoryCategories;
                }
            } else {
                $collProductCategoryCategories = ChildProductCategoryQuery::create(null, $criteria)
                    ->filterByProductCategoryIdCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductCategoryCategoriesPartial && count($collProductCategoryCategories)) {
                        $this->initProductCategoryCategories(false);

                        foreach ($collProductCategoryCategories as $obj) {
                            if (false == $this->collProductCategoryCategories->contains($obj)) {
                                $this->collProductCategoryCategories->append($obj);
                            }
                        }

                        $this->collProductCategoryCategoriesPartial = true;
                    }

                    return $collProductCategoryCategories;
                }

                if ($partial && $this->collProductCategoryCategories) {
                    foreach ($this->collProductCategoryCategories as $obj) {
                        if ($obj->isNew()) {
                            $collProductCategoryCategories[] = $obj;
                        }
                    }
                }

                $this->collProductCategoryCategories = $collProductCategoryCategories;
                $this->collProductCategoryCategoriesPartial = false;
            }
        }

        return $this->collProductCategoryCategories;
    }

    /**
     * Sets a collection of ChildProductCategory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $productCategoryCategories A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setProductCategoryCategories(Collection $productCategoryCategories, ?ConnectionInterface $con = null)
    {
        /** @var ChildProductCategory[] $productCategoryCategoriesToDelete */
        $productCategoryCategoriesToDelete = $this->getProductCategoryCategories(new Criteria(), $con)->diff($productCategoryCategories);


        $this->productCategoryCategoriesScheduledForDeletion = $productCategoryCategoriesToDelete;

        foreach ($productCategoryCategoriesToDelete as $productCategoryCategoryRemoved) {
            $productCategoryCategoryRemoved->setProductCategoryIdCategory(null);
        }

        $this->collProductCategoryCategories = null;
        foreach ($productCategoryCategories as $productCategoryCategory) {
            $this->addProductCategoryCategory($productCategoryCategory);
        }

        $this->collProductCategoryCategories = $productCategoryCategories;
        $this->collProductCategoryCategoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProductCategory objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related ProductCategory objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countProductCategoryCategories(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collProductCategoryCategoriesPartial && !$this->isNew();
        if (null === $this->collProductCategoryCategories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductCategoryCategories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductCategoryCategories());
            }

            $query = ChildProductCategoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProductCategoryIdCategory($this)
                ->count($con);
        }

        return count($this->collProductCategoryCategories);
    }

    /**
     * Method called to associate a ChildProductCategory object to this object
     * through the ChildProductCategory foreign key attribute.
     *
     * @param ChildProductCategory $l ChildProductCategory
     * @return $this The current object (for fluent API support)
     */
    public function addProductCategoryCategory(ChildProductCategory $l)
    {
        if ($this->collProductCategoryCategories === null) {
            $this->initProductCategoryCategories();
            $this->collProductCategoryCategoriesPartial = true;
        }

        if (!$this->collProductCategoryCategories->contains($l)) {
            $this->doAddProductCategoryCategory($l);

            if ($this->productCategoryCategoriesScheduledForDeletion and $this->productCategoryCategoriesScheduledForDeletion->contains($l)) {
                $this->productCategoryCategoriesScheduledForDeletion->remove($this->productCategoryCategoriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildProductCategory $productCategoryCategory The ChildProductCategory object to add.
     */
    protected function doAddProductCategoryCategory(ChildProductCategory $productCategoryCategory): void
    {
        $this->collProductCategoryCategories[]= $productCategoryCategory;
        $productCategoryCategory->setProductCategoryIdCategory($this);
    }

    /**
     * @param ChildProductCategory $productCategoryCategory The ChildProductCategory object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeProductCategoryCategory(ChildProductCategory $productCategoryCategory)
    {
        if ($this->getProductCategoryCategories()->contains($productCategoryCategory)) {
            $pos = $this->collProductCategoryCategories->search($productCategoryCategory);
            $this->collProductCategoryCategories->remove($pos);
            if (null === $this->productCategoryCategoriesScheduledForDeletion) {
                $this->productCategoryCategoriesScheduledForDeletion = clone $this->collProductCategoryCategories;
                $this->productCategoryCategoriesScheduledForDeletion->clear();
            }
            $this->productCategoryCategoriesScheduledForDeletion[]= clone $productCategoryCategory;
            $productCategoryCategory->setProductCategoryIdCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Category is new, it will return
     * an empty collection; or if this Category has previously
     * been saved, it will retrieve related ProductCategoryCategories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Category.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProductCategory[] List of ChildProductCategory objects
     * @phpstan-return ObjectCollection&\Traversable<ChildProductCategory}> List of ChildProductCategory objects
     */
    public function getProductCategoryCategoriesJoinProductCategoryIdProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProductCategoryQuery::create(null, $criteria);
        $query->joinWith('ProductCategoryIdProduct', $joinBehavior);

        return $this->getProductCategoryCategories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collDiscountCategories) {
                foreach ($this->collDiscountCategories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProductCategoryCategories) {
                foreach ($this->collProductCategoryCategories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDiscountCategories = null;
        $this->collProductCategoryCategories = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CategoryTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
