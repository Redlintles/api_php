<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\CartProduct as ChildCartProduct;
use Buildings\CartProductQuery as ChildCartProductQuery;
use Buildings\Discount as ChildDiscount;
use Buildings\DiscountQuery as ChildDiscountQuery;
use Buildings\OrderProduct as ChildOrderProduct;
use Buildings\OrderProductQuery as ChildOrderProductQuery;
use Buildings\Product as ChildProduct;
use Buildings\ProductCategory as ChildProductCategory;
use Buildings\ProductCategoryQuery as ChildProductCategoryQuery;
use Buildings\ProductQuery as ChildProductQuery;
use Buildings\SellerProduct as ChildSellerProduct;
use Buildings\SellerProductQuery as ChildSellerProductQuery;
use Buildings\Map\CartProductTableMap;
use Buildings\Map\DiscountTableMap;
use Buildings\Map\OrderProductTableMap;
use Buildings\Map\ProductCategoryTableMap;
use Buildings\Map\ProductTableMap;
use Buildings\Map\SellerProductTableMap;
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
 * Base class that represents a row from the 'product' table.
 *
 *
 *
 * @package    propel.generator.Buildings.Base
 */
abstract class Product implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Buildings\\Map\\ProductTableMap';


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
     * The value for the title field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $title;

    /**
     * The value for the desc field.
     *
     * Note: this column has a database default value of: ''
     * @var        string|null
     */
    protected $desc;

    /**
     * The value for the unity_price field.
     *
     * Note: this column has a database default value of: 1.0
     * @var        double
     */
    protected $unity_price;

    /**
     * The value for the in_stock field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $in_stock;

    /**
     * @var        ObjectCollection|ChildCartProduct[] Collection to store aggregation of ChildCartProduct objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildCartProduct> Collection to store aggregation of ChildCartProduct objects.
     */
    protected $collCartProducts;
    protected $collCartProductsPartial;

    /**
     * @var        ObjectCollection|ChildSellerProduct[] Collection to store aggregation of ChildSellerProduct objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildSellerProduct> Collection to store aggregation of ChildSellerProduct objects.
     */
    protected $collSellerProductProducts;
    protected $collSellerProductProductsPartial;

    /**
     * @var        ObjectCollection|ChildOrderProduct[] Collection to store aggregation of ChildOrderProduct objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildOrderProduct> Collection to store aggregation of ChildOrderProduct objects.
     */
    protected $collOrderProductProducts;
    protected $collOrderProductProductsPartial;

    /**
     * @var        ObjectCollection|ChildDiscount[] Collection to store aggregation of ChildDiscount objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildDiscount> Collection to store aggregation of ChildDiscount objects.
     */
    protected $collDiscountProductProducts;
    protected $collDiscountProductProductsPartial;

    /**
     * @var        ObjectCollection|ChildProductCategory[] Collection to store aggregation of ChildProductCategory objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildProductCategory> Collection to store aggregation of ChildProductCategory objects.
     */
    protected $collProductCategoryProducts;
    protected $collProductCategoryProductsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCartProduct[]
     * @phpstan-var ObjectCollection&\Traversable<ChildCartProduct>
     */
    protected $cartProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSellerProduct[]
     * @phpstan-var ObjectCollection&\Traversable<ChildSellerProduct>
     */
    protected $sellerProductProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildOrderProduct[]
     * @phpstan-var ObjectCollection&\Traversable<ChildOrderProduct>
     */
    protected $orderProductProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDiscount[]
     * @phpstan-var ObjectCollection&\Traversable<ChildDiscount>
     */
    protected $discountProductProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProductCategory[]
     * @phpstan-var ObjectCollection&\Traversable<ChildProductCategory>
     */
    protected $productCategoryProductsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
        $this->title = '';
        $this->desc = '';
        $this->unity_price = 1.0;
        $this->in_stock = 1;
    }

    /**
     * Initializes internal state of Buildings\Base\Product object.
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
     * Compares this with another <code>Product</code> instance.  If
     * <code>obj</code> is an instance of <code>Product</code>, delegates to
     * <code>equals(Product)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [desc] column value.
     *
     * @return string|null
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Get the [unity_price] column value.
     *
     * @return double
     */
    public function getUnityPrice()
    {
        return $this->unity_price;
    }

    /**
     * Get the [in_stock] column value.
     *
     * @return int
     */
    public function getInStock()
    {
        return $this->in_stock;
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
            $this->modifiedColumns[ProductTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [title] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[ProductTableMap::COL_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [desc] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setDesc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->desc !== $v) {
            $this->desc = $v;
            $this->modifiedColumns[ProductTableMap::COL_DESC] = true;
        }

        return $this;
    }

    /**
     * Set the value of [unity_price] column.
     *
     * @param double $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUnityPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->unity_price !== $v) {
            $this->unity_price = $v;
            $this->modifiedColumns[ProductTableMap::COL_UNITY_PRICE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [in_stock] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setInStock($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->in_stock !== $v) {
            $this->in_stock = $v;
            $this->modifiedColumns[ProductTableMap::COL_IN_STOCK] = true;
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
            if ($this->title !== '') {
                return false;
            }

            if ($this->desc !== '') {
                return false;
            }

            if ($this->unity_price !== 1.0) {
                return false;
            }

            if ($this->in_stock !== 1) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductTableMap::translateFieldName('Desc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->desc = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProductTableMap::translateFieldName('UnityPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unity_price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProductTableMap::translateFieldName('InStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->in_stock = (null !== $col) ? (int) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ProductTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Buildings\\Product'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ProductTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCartProducts = null;

            $this->collSellerProductProducts = null;

            $this->collOrderProductProducts = null;

            $this->collDiscountProductProducts = null;

            $this->collProductCategoryProducts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Product::setDeleted()
     * @see Product::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProductQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
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
                ProductTableMap::addInstanceToPool($this);
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

            if ($this->cartProductsScheduledForDeletion !== null) {
                if (!$this->cartProductsScheduledForDeletion->isEmpty()) {
                    \Buildings\CartProductQuery::create()
                        ->filterByPrimaryKeys($this->cartProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cartProductsScheduledForDeletion = null;
                }
            }

            if ($this->collCartProducts !== null) {
                foreach ($this->collCartProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sellerProductProductsScheduledForDeletion !== null) {
                if (!$this->sellerProductProductsScheduledForDeletion->isEmpty()) {
                    \Buildings\SellerProductQuery::create()
                        ->filterByPrimaryKeys($this->sellerProductProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sellerProductProductsScheduledForDeletion = null;
                }
            }

            if ($this->collSellerProductProducts !== null) {
                foreach ($this->collSellerProductProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->orderProductProductsScheduledForDeletion !== null) {
                if (!$this->orderProductProductsScheduledForDeletion->isEmpty()) {
                    \Buildings\OrderProductQuery::create()
                        ->filterByPrimaryKeys($this->orderProductProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderProductProductsScheduledForDeletion = null;
                }
            }

            if ($this->collOrderProductProducts !== null) {
                foreach ($this->collOrderProductProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->discountProductProductsScheduledForDeletion !== null) {
                if (!$this->discountProductProductsScheduledForDeletion->isEmpty()) {
                    \Buildings\DiscountQuery::create()
                        ->filterByPrimaryKeys($this->discountProductProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->discountProductProductsScheduledForDeletion = null;
                }
            }

            if ($this->collDiscountProductProducts !== null) {
                foreach ($this->collDiscountProductProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productCategoryProductsScheduledForDeletion !== null) {
                if (!$this->productCategoryProductsScheduledForDeletion->isEmpty()) {
                    \Buildings\ProductCategoryQuery::create()
                        ->filterByPrimaryKeys($this->productCategoryProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productCategoryProductsScheduledForDeletion = null;
                }
            }

            if ($this->collProductCategoryProducts !== null) {
                foreach ($this->collProductCategoryProducts as $referrerFK) {
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

        $this->modifiedColumns[ProductTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProductTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ProductTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(ProductTableMap::COL_DESC)) {
            $modifiedColumns[':p' . $index++]  = 'desc';
        }
        if ($this->isColumnModified(ProductTableMap::COL_UNITY_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'unity_price';
        }
        if ($this->isColumnModified(ProductTableMap::COL_IN_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'in_stock';
        }

        $sql = sprintf(
            'INSERT INTO product (%s) VALUES (%s)',
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
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);

                        break;
                    case 'desc':
                        $stmt->bindValue($identifier, $this->desc, PDO::PARAM_STR);

                        break;
                    case 'unity_price':
                        $stmt->bindValue($identifier, $this->unity_price, PDO::PARAM_STR);

                        break;
                    case 'in_stock':
                        $stmt->bindValue($identifier, $this->in_stock, PDO::PARAM_INT);

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
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTitle();

            case 2:
                return $this->getDesc();

            case 3:
                return $this->getUnityPrice();

            case 4:
                return $this->getInStock();

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
        if (isset($alreadyDumpedObjects['Product'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Product'][$this->hashCode()] = true;
        $keys = ProductTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getDesc(),
            $keys[3] => $this->getUnityPrice(),
            $keys[4] => $this->getInStock(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCartProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cartProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cart_productss';
                        break;
                    default:
                        $key = 'CartProducts';
                }

                $result[$key] = $this->collCartProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSellerProductProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sellerProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'seller_productss';
                        break;
                    default:
                        $key = 'SellerProductProducts';
                }

                $result[$key] = $this->collSellerProductProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrderProductProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'orderProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'order_productss';
                        break;
                    default:
                        $key = 'OrderProductProducts';
                }

                $result[$key] = $this->collOrderProductProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDiscountProductProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'discounts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'discounts';
                        break;
                    default:
                        $key = 'DiscountProductProducts';
                }

                $result[$key] = $this->collDiscountProductProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProductCategoryProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'productCategories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'product_categories';
                        break;
                    default:
                        $key = 'ProductCategoryProducts';
                }

                $result[$key] = $this->collProductCategoryProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTitle($value);
                break;
            case 2:
                $this->setDesc($value);
                break;
            case 3:
                $this->setUnityPrice($value);
                break;
            case 4:
                $this->setInStock($value);
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
        $keys = ProductTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDesc($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUnityPrice($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setInStock($arr[$keys[4]]);
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
        $criteria = new Criteria(ProductTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductTableMap::COL_ID)) {
            $criteria->add(ProductTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ProductTableMap::COL_TITLE)) {
            $criteria->add(ProductTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(ProductTableMap::COL_DESC)) {
            $criteria->add(ProductTableMap::COL_DESC, $this->desc);
        }
        if ($this->isColumnModified(ProductTableMap::COL_UNITY_PRICE)) {
            $criteria->add(ProductTableMap::COL_UNITY_PRICE, $this->unity_price);
        }
        if ($this->isColumnModified(ProductTableMap::COL_IN_STOCK)) {
            $criteria->add(ProductTableMap::COL_IN_STOCK, $this->in_stock);
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
        $criteria = ChildProductQuery::create();
        $criteria->add(ProductTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \Buildings\Product (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDesc($this->getDesc());
        $copyObj->setUnityPrice($this->getUnityPrice());
        $copyObj->setInStock($this->getInStock());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCartProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCartProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSellerProductProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSellerProductProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrderProductProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderProductProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDiscountProductProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDiscountProductProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProductCategoryProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductCategoryProduct($relObj->copy($deepCopy));
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
     * @return \Buildings\Product Clone of current object.
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
        if ('CartProduct' === $relationName) {
            $this->initCartProducts();
            return;
        }
        if ('SellerProductProduct' === $relationName) {
            $this->initSellerProductProducts();
            return;
        }
        if ('OrderProductProduct' === $relationName) {
            $this->initOrderProductProducts();
            return;
        }
        if ('DiscountProductProduct' === $relationName) {
            $this->initDiscountProductProducts();
            return;
        }
        if ('ProductCategoryProduct' === $relationName) {
            $this->initProductCategoryProducts();
            return;
        }
    }

    /**
     * Clears out the collCartProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addCartProducts()
     */
    public function clearCartProducts()
    {
        $this->collCartProducts = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collCartProducts collection loaded partially.
     *
     * @return void
     */
    public function resetPartialCartProducts($v = true): void
    {
        $this->collCartProductsPartial = $v;
    }

    /**
     * Initializes the collCartProducts collection.
     *
     * By default this just sets the collCartProducts collection to an empty array (like clearcollCartProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCartProducts(bool $overrideExisting = true): void
    {
        if (null !== $this->collCartProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = CartProductTableMap::getTableMap()->getCollectionClassName();

        $this->collCartProducts = new $collectionClassName;
        $this->collCartProducts->setModel('\Buildings\CartProduct');
    }

    /**
     * Gets an array of ChildCartProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCartProduct[] List of ChildCartProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildCartProduct> List of ChildCartProduct objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getCartProducts(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collCartProductsPartial && !$this->isNew();
        if (null === $this->collCartProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collCartProducts) {
                    $this->initCartProducts();
                } else {
                    $collectionClassName = CartProductTableMap::getTableMap()->getCollectionClassName();

                    $collCartProducts = new $collectionClassName;
                    $collCartProducts->setModel('\Buildings\CartProduct');

                    return $collCartProducts;
                }
            } else {
                $collCartProducts = ChildCartProductQuery::create(null, $criteria)
                    ->filterByCartProductIdProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCartProductsPartial && count($collCartProducts)) {
                        $this->initCartProducts(false);

                        foreach ($collCartProducts as $obj) {
                            if (false == $this->collCartProducts->contains($obj)) {
                                $this->collCartProducts->append($obj);
                            }
                        }

                        $this->collCartProductsPartial = true;
                    }

                    return $collCartProducts;
                }

                if ($partial && $this->collCartProducts) {
                    foreach ($this->collCartProducts as $obj) {
                        if ($obj->isNew()) {
                            $collCartProducts[] = $obj;
                        }
                    }
                }

                $this->collCartProducts = $collCartProducts;
                $this->collCartProductsPartial = false;
            }
        }

        return $this->collCartProducts;
    }

    /**
     * Sets a collection of ChildCartProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $cartProducts A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setCartProducts(Collection $cartProducts, ?ConnectionInterface $con = null)
    {
        /** @var ChildCartProduct[] $cartProductsToDelete */
        $cartProductsToDelete = $this->getCartProducts(new Criteria(), $con)->diff($cartProducts);


        $this->cartProductsScheduledForDeletion = $cartProductsToDelete;

        foreach ($cartProductsToDelete as $cartProductRemoved) {
            $cartProductRemoved->setCartProductIdProduct(null);
        }

        $this->collCartProducts = null;
        foreach ($cartProducts as $cartProduct) {
            $this->addCartProduct($cartProduct);
        }

        $this->collCartProducts = $cartProducts;
        $this->collCartProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CartProduct objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related CartProduct objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countCartProducts(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCartProductsPartial && !$this->isNew();
        if (null === $this->collCartProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCartProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCartProducts());
            }

            $query = ChildCartProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCartProductIdProduct($this)
                ->count($con);
        }

        return count($this->collCartProducts);
    }

    /**
     * Method called to associate a ChildCartProduct object to this object
     * through the ChildCartProduct foreign key attribute.
     *
     * @param ChildCartProduct $l ChildCartProduct
     * @return $this The current object (for fluent API support)
     */
    public function addCartProduct(ChildCartProduct $l)
    {
        if ($this->collCartProducts === null) {
            $this->initCartProducts();
            $this->collCartProductsPartial = true;
        }

        if (!$this->collCartProducts->contains($l)) {
            $this->doAddCartProduct($l);

            if ($this->cartProductsScheduledForDeletion and $this->cartProductsScheduledForDeletion->contains($l)) {
                $this->cartProductsScheduledForDeletion->remove($this->cartProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCartProduct $cartProduct The ChildCartProduct object to add.
     */
    protected function doAddCartProduct(ChildCartProduct $cartProduct): void
    {
        $this->collCartProducts[]= $cartProduct;
        $cartProduct->setCartProductIdProduct($this);
    }

    /**
     * @param ChildCartProduct $cartProduct The ChildCartProduct object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeCartProduct(ChildCartProduct $cartProduct)
    {
        if ($this->getCartProducts()->contains($cartProduct)) {
            $pos = $this->collCartProducts->search($cartProduct);
            $this->collCartProducts->remove($pos);
            if (null === $this->cartProductsScheduledForDeletion) {
                $this->cartProductsScheduledForDeletion = clone $this->collCartProducts;
                $this->cartProductsScheduledForDeletion->clear();
            }
            $this->cartProductsScheduledForDeletion[]= clone $cartProduct;
            $cartProduct->setCartProductIdProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related CartProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCartProduct[] List of ChildCartProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildCartProduct}> List of ChildCartProduct objects
     */
    public function getCartProductsJoinCartProductIdCart(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCartProductQuery::create(null, $criteria);
        $query->joinWith('CartProductIdCart', $joinBehavior);

        return $this->getCartProducts($query, $con);
    }

    /**
     * Clears out the collSellerProductProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addSellerProductProducts()
     */
    public function clearSellerProductProducts()
    {
        $this->collSellerProductProducts = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collSellerProductProducts collection loaded partially.
     *
     * @return void
     */
    public function resetPartialSellerProductProducts($v = true): void
    {
        $this->collSellerProductProductsPartial = $v;
    }

    /**
     * Initializes the collSellerProductProducts collection.
     *
     * By default this just sets the collSellerProductProducts collection to an empty array (like clearcollSellerProductProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSellerProductProducts(bool $overrideExisting = true): void
    {
        if (null !== $this->collSellerProductProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = SellerProductTableMap::getTableMap()->getCollectionClassName();

        $this->collSellerProductProducts = new $collectionClassName;
        $this->collSellerProductProducts->setModel('\Buildings\SellerProduct');
    }

    /**
     * Gets an array of ChildSellerProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSellerProduct[] List of ChildSellerProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildSellerProduct> List of ChildSellerProduct objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getSellerProductProducts(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collSellerProductProductsPartial && !$this->isNew();
        if (null === $this->collSellerProductProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSellerProductProducts) {
                    $this->initSellerProductProducts();
                } else {
                    $collectionClassName = SellerProductTableMap::getTableMap()->getCollectionClassName();

                    $collSellerProductProducts = new $collectionClassName;
                    $collSellerProductProducts->setModel('\Buildings\SellerProduct');

                    return $collSellerProductProducts;
                }
            } else {
                $collSellerProductProducts = ChildSellerProductQuery::create(null, $criteria)
                    ->filterBySellerProductIdProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSellerProductProductsPartial && count($collSellerProductProducts)) {
                        $this->initSellerProductProducts(false);

                        foreach ($collSellerProductProducts as $obj) {
                            if (false == $this->collSellerProductProducts->contains($obj)) {
                                $this->collSellerProductProducts->append($obj);
                            }
                        }

                        $this->collSellerProductProductsPartial = true;
                    }

                    return $collSellerProductProducts;
                }

                if ($partial && $this->collSellerProductProducts) {
                    foreach ($this->collSellerProductProducts as $obj) {
                        if ($obj->isNew()) {
                            $collSellerProductProducts[] = $obj;
                        }
                    }
                }

                $this->collSellerProductProducts = $collSellerProductProducts;
                $this->collSellerProductProductsPartial = false;
            }
        }

        return $this->collSellerProductProducts;
    }

    /**
     * Sets a collection of ChildSellerProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $sellerProductProducts A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setSellerProductProducts(Collection $sellerProductProducts, ?ConnectionInterface $con = null)
    {
        /** @var ChildSellerProduct[] $sellerProductProductsToDelete */
        $sellerProductProductsToDelete = $this->getSellerProductProducts(new Criteria(), $con)->diff($sellerProductProducts);


        $this->sellerProductProductsScheduledForDeletion = $sellerProductProductsToDelete;

        foreach ($sellerProductProductsToDelete as $sellerProductProductRemoved) {
            $sellerProductProductRemoved->setSellerProductIdProduct(null);
        }

        $this->collSellerProductProducts = null;
        foreach ($sellerProductProducts as $sellerProductProduct) {
            $this->addSellerProductProduct($sellerProductProduct);
        }

        $this->collSellerProductProducts = $sellerProductProducts;
        $this->collSellerProductProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SellerProduct objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related SellerProduct objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countSellerProductProducts(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collSellerProductProductsPartial && !$this->isNew();
        if (null === $this->collSellerProductProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSellerProductProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSellerProductProducts());
            }

            $query = ChildSellerProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySellerProductIdProduct($this)
                ->count($con);
        }

        return count($this->collSellerProductProducts);
    }

    /**
     * Method called to associate a ChildSellerProduct object to this object
     * through the ChildSellerProduct foreign key attribute.
     *
     * @param ChildSellerProduct $l ChildSellerProduct
     * @return $this The current object (for fluent API support)
     */
    public function addSellerProductProduct(ChildSellerProduct $l)
    {
        if ($this->collSellerProductProducts === null) {
            $this->initSellerProductProducts();
            $this->collSellerProductProductsPartial = true;
        }

        if (!$this->collSellerProductProducts->contains($l)) {
            $this->doAddSellerProductProduct($l);

            if ($this->sellerProductProductsScheduledForDeletion and $this->sellerProductProductsScheduledForDeletion->contains($l)) {
                $this->sellerProductProductsScheduledForDeletion->remove($this->sellerProductProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSellerProduct $sellerProductProduct The ChildSellerProduct object to add.
     */
    protected function doAddSellerProductProduct(ChildSellerProduct $sellerProductProduct): void
    {
        $this->collSellerProductProducts[]= $sellerProductProduct;
        $sellerProductProduct->setSellerProductIdProduct($this);
    }

    /**
     * @param ChildSellerProduct $sellerProductProduct The ChildSellerProduct object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeSellerProductProduct(ChildSellerProduct $sellerProductProduct)
    {
        if ($this->getSellerProductProducts()->contains($sellerProductProduct)) {
            $pos = $this->collSellerProductProducts->search($sellerProductProduct);
            $this->collSellerProductProducts->remove($pos);
            if (null === $this->sellerProductProductsScheduledForDeletion) {
                $this->sellerProductProductsScheduledForDeletion = clone $this->collSellerProductProducts;
                $this->sellerProductProductsScheduledForDeletion->clear();
            }
            $this->sellerProductProductsScheduledForDeletion[]= clone $sellerProductProduct;
            $sellerProductProduct->setSellerProductIdProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related SellerProductProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSellerProduct[] List of ChildSellerProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildSellerProduct}> List of ChildSellerProduct objects
     */
    public function getSellerProductProductsJoinSellerProductIdSeller(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSellerProductQuery::create(null, $criteria);
        $query->joinWith('SellerProductIdSeller', $joinBehavior);

        return $this->getSellerProductProducts($query, $con);
    }

    /**
     * Clears out the collOrderProductProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addOrderProductProducts()
     */
    public function clearOrderProductProducts()
    {
        $this->collOrderProductProducts = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collOrderProductProducts collection loaded partially.
     *
     * @return void
     */
    public function resetPartialOrderProductProducts($v = true): void
    {
        $this->collOrderProductProductsPartial = $v;
    }

    /**
     * Initializes the collOrderProductProducts collection.
     *
     * By default this just sets the collOrderProductProducts collection to an empty array (like clearcollOrderProductProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderProductProducts(bool $overrideExisting = true): void
    {
        if (null !== $this->collOrderProductProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = OrderProductTableMap::getTableMap()->getCollectionClassName();

        $this->collOrderProductProducts = new $collectionClassName;
        $this->collOrderProductProducts->setModel('\Buildings\OrderProduct');
    }

    /**
     * Gets an array of ChildOrderProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOrderProduct[] List of ChildOrderProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrderProduct> List of ChildOrderProduct objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getOrderProductProducts(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collOrderProductProductsPartial && !$this->isNew();
        if (null === $this->collOrderProductProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collOrderProductProducts) {
                    $this->initOrderProductProducts();
                } else {
                    $collectionClassName = OrderProductTableMap::getTableMap()->getCollectionClassName();

                    $collOrderProductProducts = new $collectionClassName;
                    $collOrderProductProducts->setModel('\Buildings\OrderProduct');

                    return $collOrderProductProducts;
                }
            } else {
                $collOrderProductProducts = ChildOrderProductQuery::create(null, $criteria)
                    ->filterByOrderProductIdProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderProductProductsPartial && count($collOrderProductProducts)) {
                        $this->initOrderProductProducts(false);

                        foreach ($collOrderProductProducts as $obj) {
                            if (false == $this->collOrderProductProducts->contains($obj)) {
                                $this->collOrderProductProducts->append($obj);
                            }
                        }

                        $this->collOrderProductProductsPartial = true;
                    }

                    return $collOrderProductProducts;
                }

                if ($partial && $this->collOrderProductProducts) {
                    foreach ($this->collOrderProductProducts as $obj) {
                        if ($obj->isNew()) {
                            $collOrderProductProducts[] = $obj;
                        }
                    }
                }

                $this->collOrderProductProducts = $collOrderProductProducts;
                $this->collOrderProductProductsPartial = false;
            }
        }

        return $this->collOrderProductProducts;
    }

    /**
     * Sets a collection of ChildOrderProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $orderProductProducts A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setOrderProductProducts(Collection $orderProductProducts, ?ConnectionInterface $con = null)
    {
        /** @var ChildOrderProduct[] $orderProductProductsToDelete */
        $orderProductProductsToDelete = $this->getOrderProductProducts(new Criteria(), $con)->diff($orderProductProducts);


        $this->orderProductProductsScheduledForDeletion = $orderProductProductsToDelete;

        foreach ($orderProductProductsToDelete as $orderProductProductRemoved) {
            $orderProductProductRemoved->setOrderProductIdProduct(null);
        }

        $this->collOrderProductProducts = null;
        foreach ($orderProductProducts as $orderProductProduct) {
            $this->addOrderProductProduct($orderProductProduct);
        }

        $this->collOrderProductProducts = $orderProductProducts;
        $this->collOrderProductProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrderProduct objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related OrderProduct objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countOrderProductProducts(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collOrderProductProductsPartial && !$this->isNew();
        if (null === $this->collOrderProductProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderProductProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderProductProducts());
            }

            $query = ChildOrderProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrderProductIdProduct($this)
                ->count($con);
        }

        return count($this->collOrderProductProducts);
    }

    /**
     * Method called to associate a ChildOrderProduct object to this object
     * through the ChildOrderProduct foreign key attribute.
     *
     * @param ChildOrderProduct $l ChildOrderProduct
     * @return $this The current object (for fluent API support)
     */
    public function addOrderProductProduct(ChildOrderProduct $l)
    {
        if ($this->collOrderProductProducts === null) {
            $this->initOrderProductProducts();
            $this->collOrderProductProductsPartial = true;
        }

        if (!$this->collOrderProductProducts->contains($l)) {
            $this->doAddOrderProductProduct($l);

            if ($this->orderProductProductsScheduledForDeletion and $this->orderProductProductsScheduledForDeletion->contains($l)) {
                $this->orderProductProductsScheduledForDeletion->remove($this->orderProductProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildOrderProduct $orderProductProduct The ChildOrderProduct object to add.
     */
    protected function doAddOrderProductProduct(ChildOrderProduct $orderProductProduct): void
    {
        $this->collOrderProductProducts[]= $orderProductProduct;
        $orderProductProduct->setOrderProductIdProduct($this);
    }

    /**
     * @param ChildOrderProduct $orderProductProduct The ChildOrderProduct object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeOrderProductProduct(ChildOrderProduct $orderProductProduct)
    {
        if ($this->getOrderProductProducts()->contains($orderProductProduct)) {
            $pos = $this->collOrderProductProducts->search($orderProductProduct);
            $this->collOrderProductProducts->remove($pos);
            if (null === $this->orderProductProductsScheduledForDeletion) {
                $this->orderProductProductsScheduledForDeletion = clone $this->collOrderProductProducts;
                $this->orderProductProductsScheduledForDeletion->clear();
            }
            $this->orderProductProductsScheduledForDeletion[]= clone $orderProductProduct;
            $orderProductProduct->setOrderProductIdProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related OrderProductProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOrderProduct[] List of ChildOrderProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrderProduct}> List of ChildOrderProduct objects
     */
    public function getOrderProductProductsJoinOrderProductIdOrder(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderProductQuery::create(null, $criteria);
        $query->joinWith('OrderProductIdOrder', $joinBehavior);

        return $this->getOrderProductProducts($query, $con);
    }

    /**
     * Clears out the collDiscountProductProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addDiscountProductProducts()
     */
    public function clearDiscountProductProducts()
    {
        $this->collDiscountProductProducts = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collDiscountProductProducts collection loaded partially.
     *
     * @return void
     */
    public function resetPartialDiscountProductProducts($v = true): void
    {
        $this->collDiscountProductProductsPartial = $v;
    }

    /**
     * Initializes the collDiscountProductProducts collection.
     *
     * By default this just sets the collDiscountProductProducts collection to an empty array (like clearcollDiscountProductProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDiscountProductProducts(bool $overrideExisting = true): void
    {
        if (null !== $this->collDiscountProductProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = DiscountTableMap::getTableMap()->getCollectionClassName();

        $this->collDiscountProductProducts = new $collectionClassName;
        $this->collDiscountProductProducts->setModel('\Buildings\Discount');
    }

    /**
     * Gets an array of ChildDiscount objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDiscount[] List of ChildDiscount objects
     * @phpstan-return ObjectCollection&\Traversable<ChildDiscount> List of ChildDiscount objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getDiscountProductProducts(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collDiscountProductProductsPartial && !$this->isNew();
        if (null === $this->collDiscountProductProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDiscountProductProducts) {
                    $this->initDiscountProductProducts();
                } else {
                    $collectionClassName = DiscountTableMap::getTableMap()->getCollectionClassName();

                    $collDiscountProductProducts = new $collectionClassName;
                    $collDiscountProductProducts->setModel('\Buildings\Discount');

                    return $collDiscountProductProducts;
                }
            } else {
                $collDiscountProductProducts = ChildDiscountQuery::create(null, $criteria)
                    ->filterByDiscountIdProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDiscountProductProductsPartial && count($collDiscountProductProducts)) {
                        $this->initDiscountProductProducts(false);

                        foreach ($collDiscountProductProducts as $obj) {
                            if (false == $this->collDiscountProductProducts->contains($obj)) {
                                $this->collDiscountProductProducts->append($obj);
                            }
                        }

                        $this->collDiscountProductProductsPartial = true;
                    }

                    return $collDiscountProductProducts;
                }

                if ($partial && $this->collDiscountProductProducts) {
                    foreach ($this->collDiscountProductProducts as $obj) {
                        if ($obj->isNew()) {
                            $collDiscountProductProducts[] = $obj;
                        }
                    }
                }

                $this->collDiscountProductProducts = $collDiscountProductProducts;
                $this->collDiscountProductProductsPartial = false;
            }
        }

        return $this->collDiscountProductProducts;
    }

    /**
     * Sets a collection of ChildDiscount objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $discountProductProducts A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setDiscountProductProducts(Collection $discountProductProducts, ?ConnectionInterface $con = null)
    {
        /** @var ChildDiscount[] $discountProductProductsToDelete */
        $discountProductProductsToDelete = $this->getDiscountProductProducts(new Criteria(), $con)->diff($discountProductProducts);


        $this->discountProductProductsScheduledForDeletion = $discountProductProductsToDelete;

        foreach ($discountProductProductsToDelete as $discountProductProductRemoved) {
            $discountProductProductRemoved->setDiscountIdProduct(null);
        }

        $this->collDiscountProductProducts = null;
        foreach ($discountProductProducts as $discountProductProduct) {
            $this->addDiscountProductProduct($discountProductProduct);
        }

        $this->collDiscountProductProducts = $discountProductProducts;
        $this->collDiscountProductProductsPartial = false;

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
    public function countDiscountProductProducts(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collDiscountProductProductsPartial && !$this->isNew();
        if (null === $this->collDiscountProductProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDiscountProductProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDiscountProductProducts());
            }

            $query = ChildDiscountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDiscountIdProduct($this)
                ->count($con);
        }

        return count($this->collDiscountProductProducts);
    }

    /**
     * Method called to associate a ChildDiscount object to this object
     * through the ChildDiscount foreign key attribute.
     *
     * @param ChildDiscount $l ChildDiscount
     * @return $this The current object (for fluent API support)
     */
    public function addDiscountProductProduct(ChildDiscount $l)
    {
        if ($this->collDiscountProductProducts === null) {
            $this->initDiscountProductProducts();
            $this->collDiscountProductProductsPartial = true;
        }

        if (!$this->collDiscountProductProducts->contains($l)) {
            $this->doAddDiscountProductProduct($l);

            if ($this->discountProductProductsScheduledForDeletion and $this->discountProductProductsScheduledForDeletion->contains($l)) {
                $this->discountProductProductsScheduledForDeletion->remove($this->discountProductProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDiscount $discountProductProduct The ChildDiscount object to add.
     */
    protected function doAddDiscountProductProduct(ChildDiscount $discountProductProduct): void
    {
        $this->collDiscountProductProducts[]= $discountProductProduct;
        $discountProductProduct->setDiscountIdProduct($this);
    }

    /**
     * @param ChildDiscount $discountProductProduct The ChildDiscount object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeDiscountProductProduct(ChildDiscount $discountProductProduct)
    {
        if ($this->getDiscountProductProducts()->contains($discountProductProduct)) {
            $pos = $this->collDiscountProductProducts->search($discountProductProduct);
            $this->collDiscountProductProducts->remove($pos);
            if (null === $this->discountProductProductsScheduledForDeletion) {
                $this->discountProductProductsScheduledForDeletion = clone $this->collDiscountProductProducts;
                $this->discountProductProductsScheduledForDeletion->clear();
            }
            $this->discountProductProductsScheduledForDeletion[]= $discountProductProduct;
            $discountProductProduct->setDiscountIdProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related DiscountProductProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDiscount[] List of ChildDiscount objects
     * @phpstan-return ObjectCollection&\Traversable<ChildDiscount}> List of ChildDiscount objects
     */
    public function getDiscountProductProductsJoinDiscountIdCategory(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDiscountQuery::create(null, $criteria);
        $query->joinWith('DiscountIdCategory', $joinBehavior);

        return $this->getDiscountProductProducts($query, $con);
    }

    /**
     * Clears out the collProductCategoryProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addProductCategoryProducts()
     */
    public function clearProductCategoryProducts()
    {
        $this->collProductCategoryProducts = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collProductCategoryProducts collection loaded partially.
     *
     * @return void
     */
    public function resetPartialProductCategoryProducts($v = true): void
    {
        $this->collProductCategoryProductsPartial = $v;
    }

    /**
     * Initializes the collProductCategoryProducts collection.
     *
     * By default this just sets the collProductCategoryProducts collection to an empty array (like clearcollProductCategoryProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductCategoryProducts(bool $overrideExisting = true): void
    {
        if (null !== $this->collProductCategoryProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = ProductCategoryTableMap::getTableMap()->getCollectionClassName();

        $this->collProductCategoryProducts = new $collectionClassName;
        $this->collProductCategoryProducts->setModel('\Buildings\ProductCategory');
    }

    /**
     * Gets an array of ChildProductCategory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProductCategory[] List of ChildProductCategory objects
     * @phpstan-return ObjectCollection&\Traversable<ChildProductCategory> List of ChildProductCategory objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getProductCategoryProducts(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collProductCategoryProductsPartial && !$this->isNew();
        if (null === $this->collProductCategoryProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collProductCategoryProducts) {
                    $this->initProductCategoryProducts();
                } else {
                    $collectionClassName = ProductCategoryTableMap::getTableMap()->getCollectionClassName();

                    $collProductCategoryProducts = new $collectionClassName;
                    $collProductCategoryProducts->setModel('\Buildings\ProductCategory');

                    return $collProductCategoryProducts;
                }
            } else {
                $collProductCategoryProducts = ChildProductCategoryQuery::create(null, $criteria)
                    ->filterByProductCategoryIdProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductCategoryProductsPartial && count($collProductCategoryProducts)) {
                        $this->initProductCategoryProducts(false);

                        foreach ($collProductCategoryProducts as $obj) {
                            if (false == $this->collProductCategoryProducts->contains($obj)) {
                                $this->collProductCategoryProducts->append($obj);
                            }
                        }

                        $this->collProductCategoryProductsPartial = true;
                    }

                    return $collProductCategoryProducts;
                }

                if ($partial && $this->collProductCategoryProducts) {
                    foreach ($this->collProductCategoryProducts as $obj) {
                        if ($obj->isNew()) {
                            $collProductCategoryProducts[] = $obj;
                        }
                    }
                }

                $this->collProductCategoryProducts = $collProductCategoryProducts;
                $this->collProductCategoryProductsPartial = false;
            }
        }

        return $this->collProductCategoryProducts;
    }

    /**
     * Sets a collection of ChildProductCategory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $productCategoryProducts A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setProductCategoryProducts(Collection $productCategoryProducts, ?ConnectionInterface $con = null)
    {
        /** @var ChildProductCategory[] $productCategoryProductsToDelete */
        $productCategoryProductsToDelete = $this->getProductCategoryProducts(new Criteria(), $con)->diff($productCategoryProducts);


        $this->productCategoryProductsScheduledForDeletion = $productCategoryProductsToDelete;

        foreach ($productCategoryProductsToDelete as $productCategoryProductRemoved) {
            $productCategoryProductRemoved->setProductCategoryIdProduct(null);
        }

        $this->collProductCategoryProducts = null;
        foreach ($productCategoryProducts as $productCategoryProduct) {
            $this->addProductCategoryProduct($productCategoryProduct);
        }

        $this->collProductCategoryProducts = $productCategoryProducts;
        $this->collProductCategoryProductsPartial = false;

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
    public function countProductCategoryProducts(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collProductCategoryProductsPartial && !$this->isNew();
        if (null === $this->collProductCategoryProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductCategoryProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductCategoryProducts());
            }

            $query = ChildProductCategoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProductCategoryIdProduct($this)
                ->count($con);
        }

        return count($this->collProductCategoryProducts);
    }

    /**
     * Method called to associate a ChildProductCategory object to this object
     * through the ChildProductCategory foreign key attribute.
     *
     * @param ChildProductCategory $l ChildProductCategory
     * @return $this The current object (for fluent API support)
     */
    public function addProductCategoryProduct(ChildProductCategory $l)
    {
        if ($this->collProductCategoryProducts === null) {
            $this->initProductCategoryProducts();
            $this->collProductCategoryProductsPartial = true;
        }

        if (!$this->collProductCategoryProducts->contains($l)) {
            $this->doAddProductCategoryProduct($l);

            if ($this->productCategoryProductsScheduledForDeletion and $this->productCategoryProductsScheduledForDeletion->contains($l)) {
                $this->productCategoryProductsScheduledForDeletion->remove($this->productCategoryProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildProductCategory $productCategoryProduct The ChildProductCategory object to add.
     */
    protected function doAddProductCategoryProduct(ChildProductCategory $productCategoryProduct): void
    {
        $this->collProductCategoryProducts[]= $productCategoryProduct;
        $productCategoryProduct->setProductCategoryIdProduct($this);
    }

    /**
     * @param ChildProductCategory $productCategoryProduct The ChildProductCategory object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeProductCategoryProduct(ChildProductCategory $productCategoryProduct)
    {
        if ($this->getProductCategoryProducts()->contains($productCategoryProduct)) {
            $pos = $this->collProductCategoryProducts->search($productCategoryProduct);
            $this->collProductCategoryProducts->remove($pos);
            if (null === $this->productCategoryProductsScheduledForDeletion) {
                $this->productCategoryProductsScheduledForDeletion = clone $this->collProductCategoryProducts;
                $this->productCategoryProductsScheduledForDeletion->clear();
            }
            $this->productCategoryProductsScheduledForDeletion[]= clone $productCategoryProduct;
            $productCategoryProduct->setProductCategoryIdProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related ProductCategoryProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProductCategory[] List of ChildProductCategory objects
     * @phpstan-return ObjectCollection&\Traversable<ChildProductCategory}> List of ChildProductCategory objects
     */
    public function getProductCategoryProductsJoinProductCategoryIdCategory(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProductCategoryQuery::create(null, $criteria);
        $query->joinWith('ProductCategoryIdCategory', $joinBehavior);

        return $this->getProductCategoryProducts($query, $con);
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
        $this->title = null;
        $this->desc = null;
        $this->unity_price = null;
        $this->in_stock = null;
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
            if ($this->collCartProducts) {
                foreach ($this->collCartProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSellerProductProducts) {
                foreach ($this->collSellerProductProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrderProductProducts) {
                foreach ($this->collOrderProductProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDiscountProductProducts) {
                foreach ($this->collDiscountProductProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProductCategoryProducts) {
                foreach ($this->collProductCategoryProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCartProducts = null;
        $this->collSellerProductProducts = null;
        $this->collOrderProductProducts = null;
        $this->collDiscountProductProducts = null;
        $this->collProductCategoryProducts = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductTableMap::DEFAULT_STRING_FORMAT);
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
