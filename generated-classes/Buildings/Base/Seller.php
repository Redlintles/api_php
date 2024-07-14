<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\AddressOwner as ChildAddressOwner;
use Buildings\AddressOwnerQuery as ChildAddressOwnerQuery;
use Buildings\Order as ChildOrder;
use Buildings\OrderQuery as ChildOrderQuery;
use Buildings\Seller as ChildSeller;
use Buildings\SellerProduct as ChildSellerProduct;
use Buildings\SellerProductQuery as ChildSellerProductQuery;
use Buildings\SellerQuery as ChildSellerQuery;
use Buildings\Map\AddressOwnerTableMap;
use Buildings\Map\OrderTableMap;
use Buildings\Map\SellerProductTableMap;
use Buildings\Map\SellerTableMap;
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
 * Base class that represents a row from the 'seller' table.
 *
 *
 *
 * @package    propel.generator.Buildings.Base
 */
abstract class Seller implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Buildings\\Map\\SellerTableMap';


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
     * The value for the username field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $email;

    /**
     * The value for the phone_number field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $phone_number;

    /**
     * @var        ObjectCollection|ChildOrder[] Collection to store aggregation of ChildOrder objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildOrder> Collection to store aggregation of ChildOrder objects.
     */
    protected $collOrderSellers;
    protected $collOrderSellersPartial;

    /**
     * @var        ObjectCollection|ChildSellerProduct[] Collection to store aggregation of ChildSellerProduct objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildSellerProduct> Collection to store aggregation of ChildSellerProduct objects.
     */
    protected $collSellerProductSellers;
    protected $collSellerProductSellersPartial;

    /**
     * @var        ObjectCollection|ChildAddressOwner[] Collection to store aggregation of ChildAddressOwner objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildAddressOwner> Collection to store aggregation of ChildAddressOwner objects.
     */
    protected $collAddressOwnerSellers;
    protected $collAddressOwnerSellersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildOrder[]
     * @phpstan-var ObjectCollection&\Traversable<ChildOrder>
     */
    protected $orderSellersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSellerProduct[]
     * @phpstan-var ObjectCollection&\Traversable<ChildSellerProduct>
     */
    protected $sellerProductSellersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAddressOwner[]
     * @phpstan-var ObjectCollection&\Traversable<ChildAddressOwner>
     */
    protected $addressOwnerSellersScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
        $this->username = '';
        $this->password = '';
        $this->email = '';
        $this->phone_number = '';
    }

    /**
     * Initializes internal state of Buildings\Base\Seller object.
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
     * Compares this with another <code>Seller</code> instance.  If
     * <code>obj</code> is an instance of <code>Seller</code>, delegates to
     * <code>equals(Seller)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [phone_number] column value.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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
            $this->modifiedColumns[SellerTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [username] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[SellerTableMap::COL_USERNAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [password] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[SellerTableMap::COL_PASSWORD] = true;
        }

        return $this;
    }

    /**
     * Set the value of [email] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[SellerTableMap::COL_EMAIL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [phone_number] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setPhoneNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone_number !== $v) {
            $this->phone_number = $v;
            $this->modifiedColumns[SellerTableMap::COL_PHONE_NUMBER] = true;
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
            if ($this->username !== '') {
                return false;
            }

            if ($this->password !== '') {
                return false;
            }

            if ($this->email !== '') {
                return false;
            }

            if ($this->phone_number !== '') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SellerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SellerTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SellerTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SellerTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SellerTableMap::translateFieldName('PhoneNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone_number = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SellerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Buildings\\Seller'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SellerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSellerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collOrderSellers = null;

            $this->collSellerProductSellers = null;

            $this->collAddressOwnerSellers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Seller::setDeleted()
     * @see Seller::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSellerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
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
                SellerTableMap::addInstanceToPool($this);
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

            if ($this->orderSellersScheduledForDeletion !== null) {
                if (!$this->orderSellersScheduledForDeletion->isEmpty()) {
                    \Buildings\OrderQuery::create()
                        ->filterByPrimaryKeys($this->orderSellersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderSellersScheduledForDeletion = null;
                }
            }

            if ($this->collOrderSellers !== null) {
                foreach ($this->collOrderSellers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sellerProductSellersScheduledForDeletion !== null) {
                if (!$this->sellerProductSellersScheduledForDeletion->isEmpty()) {
                    \Buildings\SellerProductQuery::create()
                        ->filterByPrimaryKeys($this->sellerProductSellersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sellerProductSellersScheduledForDeletion = null;
                }
            }

            if ($this->collSellerProductSellers !== null) {
                foreach ($this->collSellerProductSellers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->addressOwnerSellersScheduledForDeletion !== null) {
                if (!$this->addressOwnerSellersScheduledForDeletion->isEmpty()) {
                    \Buildings\AddressOwnerQuery::create()
                        ->filterByPrimaryKeys($this->addressOwnerSellersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->addressOwnerSellersScheduledForDeletion = null;
                }
            }

            if ($this->collAddressOwnerSellers !== null) {
                foreach ($this->collAddressOwnerSellers as $referrerFK) {
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

        $this->modifiedColumns[SellerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SellerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SellerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SellerTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(SellerTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(SellerTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(SellerTableMap::COL_PHONE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'phone_number';
        }

        $sql = sprintf(
            'INSERT INTO seller (%s) VALUES (%s)',
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
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);

                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);

                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);

                        break;
                    case 'phone_number':
                        $stmt->bindValue($identifier, $this->phone_number, PDO::PARAM_STR);

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
        $pos = SellerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUsername();

            case 2:
                return $this->getPassword();

            case 3:
                return $this->getEmail();

            case 4:
                return $this->getPhoneNumber();

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
        if (isset($alreadyDumpedObjects['Seller'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Seller'][$this->hashCode()] = true;
        $keys = SellerTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getPhoneNumber(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collOrderSellers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'orders';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'orderss';
                        break;
                    default:
                        $key = 'OrderSellers';
                }

                $result[$key] = $this->collOrderSellers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSellerProductSellers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sellerProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'seller_productss';
                        break;
                    default:
                        $key = 'SellerProductSellers';
                }

                $result[$key] = $this->collSellerProductSellers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAddressOwnerSellers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'addressOwners';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'address_owners';
                        break;
                    default:
                        $key = 'AddressOwnerSellers';
                }

                $result[$key] = $this->collAddressOwnerSellers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = SellerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setUsername($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setPhoneNumber($value);
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
        $keys = SellerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPassword($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPhoneNumber($arr[$keys[4]]);
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
        $criteria = new Criteria(SellerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SellerTableMap::COL_ID)) {
            $criteria->add(SellerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SellerTableMap::COL_USERNAME)) {
            $criteria->add(SellerTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(SellerTableMap::COL_PASSWORD)) {
            $criteria->add(SellerTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(SellerTableMap::COL_EMAIL)) {
            $criteria->add(SellerTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(SellerTableMap::COL_PHONE_NUMBER)) {
            $criteria->add(SellerTableMap::COL_PHONE_NUMBER, $this->phone_number);
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
        $criteria = ChildSellerQuery::create();
        $criteria->add(SellerTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \Buildings\Seller (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPhoneNumber($this->getPhoneNumber());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOrderSellers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderSeller($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSellerProductSellers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSellerProductSeller($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAddressOwnerSellers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAddressOwnerSeller($relObj->copy($deepCopy));
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
     * @return \Buildings\Seller Clone of current object.
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
        if ('OrderSeller' === $relationName) {
            $this->initOrderSellers();
            return;
        }
        if ('SellerProductSeller' === $relationName) {
            $this->initSellerProductSellers();
            return;
        }
        if ('AddressOwnerSeller' === $relationName) {
            $this->initAddressOwnerSellers();
            return;
        }
    }

    /**
     * Clears out the collOrderSellers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addOrderSellers()
     */
    public function clearOrderSellers()
    {
        $this->collOrderSellers = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collOrderSellers collection loaded partially.
     *
     * @return void
     */
    public function resetPartialOrderSellers($v = true): void
    {
        $this->collOrderSellersPartial = $v;
    }

    /**
     * Initializes the collOrderSellers collection.
     *
     * By default this just sets the collOrderSellers collection to an empty array (like clearcollOrderSellers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderSellers(bool $overrideExisting = true): void
    {
        if (null !== $this->collOrderSellers && !$overrideExisting) {
            return;
        }

        $collectionClassName = OrderTableMap::getTableMap()->getCollectionClassName();

        $this->collOrderSellers = new $collectionClassName;
        $this->collOrderSellers->setModel('\Buildings\Order');
    }

    /**
     * Gets an array of ChildOrder objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSeller is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOrder[] List of ChildOrder objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrder> List of ChildOrder objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getOrderSellers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collOrderSellersPartial && !$this->isNew();
        if (null === $this->collOrderSellers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collOrderSellers) {
                    $this->initOrderSellers();
                } else {
                    $collectionClassName = OrderTableMap::getTableMap()->getCollectionClassName();

                    $collOrderSellers = new $collectionClassName;
                    $collOrderSellers->setModel('\Buildings\Order');

                    return $collOrderSellers;
                }
            } else {
                $collOrderSellers = ChildOrderQuery::create(null, $criteria)
                    ->filterByOrderIdSeller($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderSellersPartial && count($collOrderSellers)) {
                        $this->initOrderSellers(false);

                        foreach ($collOrderSellers as $obj) {
                            if (false == $this->collOrderSellers->contains($obj)) {
                                $this->collOrderSellers->append($obj);
                            }
                        }

                        $this->collOrderSellersPartial = true;
                    }

                    return $collOrderSellers;
                }

                if ($partial && $this->collOrderSellers) {
                    foreach ($this->collOrderSellers as $obj) {
                        if ($obj->isNew()) {
                            $collOrderSellers[] = $obj;
                        }
                    }
                }

                $this->collOrderSellers = $collOrderSellers;
                $this->collOrderSellersPartial = false;
            }
        }

        return $this->collOrderSellers;
    }

    /**
     * Sets a collection of ChildOrder objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $orderSellers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setOrderSellers(Collection $orderSellers, ?ConnectionInterface $con = null)
    {
        /** @var ChildOrder[] $orderSellersToDelete */
        $orderSellersToDelete = $this->getOrderSellers(new Criteria(), $con)->diff($orderSellers);


        $this->orderSellersScheduledForDeletion = $orderSellersToDelete;

        foreach ($orderSellersToDelete as $orderSellerRemoved) {
            $orderSellerRemoved->setOrderIdSeller(null);
        }

        $this->collOrderSellers = null;
        foreach ($orderSellers as $orderSeller) {
            $this->addOrderSeller($orderSeller);
        }

        $this->collOrderSellers = $orderSellers;
        $this->collOrderSellersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Order objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Order objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countOrderSellers(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collOrderSellersPartial && !$this->isNew();
        if (null === $this->collOrderSellers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderSellers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderSellers());
            }

            $query = ChildOrderQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrderIdSeller($this)
                ->count($con);
        }

        return count($this->collOrderSellers);
    }

    /**
     * Method called to associate a ChildOrder object to this object
     * through the ChildOrder foreign key attribute.
     *
     * @param ChildOrder $l ChildOrder
     * @return $this The current object (for fluent API support)
     */
    public function addOrderSeller(ChildOrder $l)
    {
        if ($this->collOrderSellers === null) {
            $this->initOrderSellers();
            $this->collOrderSellersPartial = true;
        }

        if (!$this->collOrderSellers->contains($l)) {
            $this->doAddOrderSeller($l);

            if ($this->orderSellersScheduledForDeletion and $this->orderSellersScheduledForDeletion->contains($l)) {
                $this->orderSellersScheduledForDeletion->remove($this->orderSellersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildOrder $orderSeller The ChildOrder object to add.
     */
    protected function doAddOrderSeller(ChildOrder $orderSeller): void
    {
        $this->collOrderSellers[]= $orderSeller;
        $orderSeller->setOrderIdSeller($this);
    }

    /**
     * @param ChildOrder $orderSeller The ChildOrder object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeOrderSeller(ChildOrder $orderSeller)
    {
        if ($this->getOrderSellers()->contains($orderSeller)) {
            $pos = $this->collOrderSellers->search($orderSeller);
            $this->collOrderSellers->remove($pos);
            if (null === $this->orderSellersScheduledForDeletion) {
                $this->orderSellersScheduledForDeletion = clone $this->collOrderSellers;
                $this->orderSellersScheduledForDeletion->clear();
            }
            $this->orderSellersScheduledForDeletion[]= $orderSeller;
            $orderSeller->setOrderIdSeller(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Seller is new, it will return
     * an empty collection; or if this Seller has previously
     * been saved, it will retrieve related OrderSellers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Seller.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOrder[] List of ChildOrder objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrder}> List of ChildOrder objects
     */
    public function getOrderSellersJoinOrderIdClient(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderQuery::create(null, $criteria);
        $query->joinWith('OrderIdClient', $joinBehavior);

        return $this->getOrderSellers($query, $con);
    }

    /**
     * Clears out the collSellerProductSellers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addSellerProductSellers()
     */
    public function clearSellerProductSellers()
    {
        $this->collSellerProductSellers = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collSellerProductSellers collection loaded partially.
     *
     * @return void
     */
    public function resetPartialSellerProductSellers($v = true): void
    {
        $this->collSellerProductSellersPartial = $v;
    }

    /**
     * Initializes the collSellerProductSellers collection.
     *
     * By default this just sets the collSellerProductSellers collection to an empty array (like clearcollSellerProductSellers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSellerProductSellers(bool $overrideExisting = true): void
    {
        if (null !== $this->collSellerProductSellers && !$overrideExisting) {
            return;
        }

        $collectionClassName = SellerProductTableMap::getTableMap()->getCollectionClassName();

        $this->collSellerProductSellers = new $collectionClassName;
        $this->collSellerProductSellers->setModel('\Buildings\SellerProduct');
    }

    /**
     * Gets an array of ChildSellerProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSeller is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSellerProduct[] List of ChildSellerProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildSellerProduct> List of ChildSellerProduct objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getSellerProductSellers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collSellerProductSellersPartial && !$this->isNew();
        if (null === $this->collSellerProductSellers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSellerProductSellers) {
                    $this->initSellerProductSellers();
                } else {
                    $collectionClassName = SellerProductTableMap::getTableMap()->getCollectionClassName();

                    $collSellerProductSellers = new $collectionClassName;
                    $collSellerProductSellers->setModel('\Buildings\SellerProduct');

                    return $collSellerProductSellers;
                }
            } else {
                $collSellerProductSellers = ChildSellerProductQuery::create(null, $criteria)
                    ->filterBySellerProductIdSeller($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSellerProductSellersPartial && count($collSellerProductSellers)) {
                        $this->initSellerProductSellers(false);

                        foreach ($collSellerProductSellers as $obj) {
                            if (false == $this->collSellerProductSellers->contains($obj)) {
                                $this->collSellerProductSellers->append($obj);
                            }
                        }

                        $this->collSellerProductSellersPartial = true;
                    }

                    return $collSellerProductSellers;
                }

                if ($partial && $this->collSellerProductSellers) {
                    foreach ($this->collSellerProductSellers as $obj) {
                        if ($obj->isNew()) {
                            $collSellerProductSellers[] = $obj;
                        }
                    }
                }

                $this->collSellerProductSellers = $collSellerProductSellers;
                $this->collSellerProductSellersPartial = false;
            }
        }

        return $this->collSellerProductSellers;
    }

    /**
     * Sets a collection of ChildSellerProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $sellerProductSellers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setSellerProductSellers(Collection $sellerProductSellers, ?ConnectionInterface $con = null)
    {
        /** @var ChildSellerProduct[] $sellerProductSellersToDelete */
        $sellerProductSellersToDelete = $this->getSellerProductSellers(new Criteria(), $con)->diff($sellerProductSellers);


        $this->sellerProductSellersScheduledForDeletion = $sellerProductSellersToDelete;

        foreach ($sellerProductSellersToDelete as $sellerProductSellerRemoved) {
            $sellerProductSellerRemoved->setSellerProductIdSeller(null);
        }

        $this->collSellerProductSellers = null;
        foreach ($sellerProductSellers as $sellerProductSeller) {
            $this->addSellerProductSeller($sellerProductSeller);
        }

        $this->collSellerProductSellers = $sellerProductSellers;
        $this->collSellerProductSellersPartial = false;

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
    public function countSellerProductSellers(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collSellerProductSellersPartial && !$this->isNew();
        if (null === $this->collSellerProductSellers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSellerProductSellers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSellerProductSellers());
            }

            $query = ChildSellerProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySellerProductIdSeller($this)
                ->count($con);
        }

        return count($this->collSellerProductSellers);
    }

    /**
     * Method called to associate a ChildSellerProduct object to this object
     * through the ChildSellerProduct foreign key attribute.
     *
     * @param ChildSellerProduct $l ChildSellerProduct
     * @return $this The current object (for fluent API support)
     */
    public function addSellerProductSeller(ChildSellerProduct $l)
    {
        if ($this->collSellerProductSellers === null) {
            $this->initSellerProductSellers();
            $this->collSellerProductSellersPartial = true;
        }

        if (!$this->collSellerProductSellers->contains($l)) {
            $this->doAddSellerProductSeller($l);

            if ($this->sellerProductSellersScheduledForDeletion and $this->sellerProductSellersScheduledForDeletion->contains($l)) {
                $this->sellerProductSellersScheduledForDeletion->remove($this->sellerProductSellersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSellerProduct $sellerProductSeller The ChildSellerProduct object to add.
     */
    protected function doAddSellerProductSeller(ChildSellerProduct $sellerProductSeller): void
    {
        $this->collSellerProductSellers[]= $sellerProductSeller;
        $sellerProductSeller->setSellerProductIdSeller($this);
    }

    /**
     * @param ChildSellerProduct $sellerProductSeller The ChildSellerProduct object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeSellerProductSeller(ChildSellerProduct $sellerProductSeller)
    {
        if ($this->getSellerProductSellers()->contains($sellerProductSeller)) {
            $pos = $this->collSellerProductSellers->search($sellerProductSeller);
            $this->collSellerProductSellers->remove($pos);
            if (null === $this->sellerProductSellersScheduledForDeletion) {
                $this->sellerProductSellersScheduledForDeletion = clone $this->collSellerProductSellers;
                $this->sellerProductSellersScheduledForDeletion->clear();
            }
            $this->sellerProductSellersScheduledForDeletion[]= clone $sellerProductSeller;
            $sellerProductSeller->setSellerProductIdSeller(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Seller is new, it will return
     * an empty collection; or if this Seller has previously
     * been saved, it will retrieve related SellerProductSellers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Seller.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSellerProduct[] List of ChildSellerProduct objects
     * @phpstan-return ObjectCollection&\Traversable<ChildSellerProduct}> List of ChildSellerProduct objects
     */
    public function getSellerProductSellersJoinSellerProductIdProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSellerProductQuery::create(null, $criteria);
        $query->joinWith('SellerProductIdProduct', $joinBehavior);

        return $this->getSellerProductSellers($query, $con);
    }

    /**
     * Clears out the collAddressOwnerSellers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addAddressOwnerSellers()
     */
    public function clearAddressOwnerSellers()
    {
        $this->collAddressOwnerSellers = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collAddressOwnerSellers collection loaded partially.
     *
     * @return void
     */
    public function resetPartialAddressOwnerSellers($v = true): void
    {
        $this->collAddressOwnerSellersPartial = $v;
    }

    /**
     * Initializes the collAddressOwnerSellers collection.
     *
     * By default this just sets the collAddressOwnerSellers collection to an empty array (like clearcollAddressOwnerSellers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAddressOwnerSellers(bool $overrideExisting = true): void
    {
        if (null !== $this->collAddressOwnerSellers && !$overrideExisting) {
            return;
        }

        $collectionClassName = AddressOwnerTableMap::getTableMap()->getCollectionClassName();

        $this->collAddressOwnerSellers = new $collectionClassName;
        $this->collAddressOwnerSellers->setModel('\Buildings\AddressOwner');
    }

    /**
     * Gets an array of ChildAddressOwner objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSeller is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner> List of ChildAddressOwner objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAddressOwnerSellers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collAddressOwnerSellersPartial && !$this->isNew();
        if (null === $this->collAddressOwnerSellers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAddressOwnerSellers) {
                    $this->initAddressOwnerSellers();
                } else {
                    $collectionClassName = AddressOwnerTableMap::getTableMap()->getCollectionClassName();

                    $collAddressOwnerSellers = new $collectionClassName;
                    $collAddressOwnerSellers->setModel('\Buildings\AddressOwner');

                    return $collAddressOwnerSellers;
                }
            } else {
                $collAddressOwnerSellers = ChildAddressOwnerQuery::create(null, $criteria)
                    ->filterByAddressOwnerIdSeller($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAddressOwnerSellersPartial && count($collAddressOwnerSellers)) {
                        $this->initAddressOwnerSellers(false);

                        foreach ($collAddressOwnerSellers as $obj) {
                            if (false == $this->collAddressOwnerSellers->contains($obj)) {
                                $this->collAddressOwnerSellers->append($obj);
                            }
                        }

                        $this->collAddressOwnerSellersPartial = true;
                    }

                    return $collAddressOwnerSellers;
                }

                if ($partial && $this->collAddressOwnerSellers) {
                    foreach ($this->collAddressOwnerSellers as $obj) {
                        if ($obj->isNew()) {
                            $collAddressOwnerSellers[] = $obj;
                        }
                    }
                }

                $this->collAddressOwnerSellers = $collAddressOwnerSellers;
                $this->collAddressOwnerSellersPartial = false;
            }
        }

        return $this->collAddressOwnerSellers;
    }

    /**
     * Sets a collection of ChildAddressOwner objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $addressOwnerSellers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setAddressOwnerSellers(Collection $addressOwnerSellers, ?ConnectionInterface $con = null)
    {
        /** @var ChildAddressOwner[] $addressOwnerSellersToDelete */
        $addressOwnerSellersToDelete = $this->getAddressOwnerSellers(new Criteria(), $con)->diff($addressOwnerSellers);


        $this->addressOwnerSellersScheduledForDeletion = $addressOwnerSellersToDelete;

        foreach ($addressOwnerSellersToDelete as $addressOwnerSellerRemoved) {
            $addressOwnerSellerRemoved->setAddressOwnerIdSeller(null);
        }

        $this->collAddressOwnerSellers = null;
        foreach ($addressOwnerSellers as $addressOwnerSeller) {
            $this->addAddressOwnerSeller($addressOwnerSeller);
        }

        $this->collAddressOwnerSellers = $addressOwnerSellers;
        $this->collAddressOwnerSellersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AddressOwner objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related AddressOwner objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countAddressOwnerSellers(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collAddressOwnerSellersPartial && !$this->isNew();
        if (null === $this->collAddressOwnerSellers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAddressOwnerSellers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAddressOwnerSellers());
            }

            $query = ChildAddressOwnerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAddressOwnerIdSeller($this)
                ->count($con);
        }

        return count($this->collAddressOwnerSellers);
    }

    /**
     * Method called to associate a ChildAddressOwner object to this object
     * through the ChildAddressOwner foreign key attribute.
     *
     * @param ChildAddressOwner $l ChildAddressOwner
     * @return $this The current object (for fluent API support)
     */
    public function addAddressOwnerSeller(ChildAddressOwner $l)
    {
        if ($this->collAddressOwnerSellers === null) {
            $this->initAddressOwnerSellers();
            $this->collAddressOwnerSellersPartial = true;
        }

        if (!$this->collAddressOwnerSellers->contains($l)) {
            $this->doAddAddressOwnerSeller($l);

            if ($this->addressOwnerSellersScheduledForDeletion and $this->addressOwnerSellersScheduledForDeletion->contains($l)) {
                $this->addressOwnerSellersScheduledForDeletion->remove($this->addressOwnerSellersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAddressOwner $addressOwnerSeller The ChildAddressOwner object to add.
     */
    protected function doAddAddressOwnerSeller(ChildAddressOwner $addressOwnerSeller): void
    {
        $this->collAddressOwnerSellers[]= $addressOwnerSeller;
        $addressOwnerSeller->setAddressOwnerIdSeller($this);
    }

    /**
     * @param ChildAddressOwner $addressOwnerSeller The ChildAddressOwner object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeAddressOwnerSeller(ChildAddressOwner $addressOwnerSeller)
    {
        if ($this->getAddressOwnerSellers()->contains($addressOwnerSeller)) {
            $pos = $this->collAddressOwnerSellers->search($addressOwnerSeller);
            $this->collAddressOwnerSellers->remove($pos);
            if (null === $this->addressOwnerSellersScheduledForDeletion) {
                $this->addressOwnerSellersScheduledForDeletion = clone $this->collAddressOwnerSellers;
                $this->addressOwnerSellersScheduledForDeletion->clear();
            }
            $this->addressOwnerSellersScheduledForDeletion[]= $addressOwnerSeller;
            $addressOwnerSeller->setAddressOwnerIdSeller(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Seller is new, it will return
     * an empty collection; or if this Seller has previously
     * been saved, it will retrieve related AddressOwnerSellers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Seller.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner}> List of ChildAddressOwner objects
     */
    public function getAddressOwnerSellersJoinAddressOwnerId(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAddressOwnerQuery::create(null, $criteria);
        $query->joinWith('AddressOwnerId', $joinBehavior);

        return $this->getAddressOwnerSellers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Seller is new, it will return
     * an empty collection; or if this Seller has previously
     * been saved, it will retrieve related AddressOwnerSellers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Seller.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner}> List of ChildAddressOwner objects
     */
    public function getAddressOwnerSellersJoinAddressOwnerIdClient(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAddressOwnerQuery::create(null, $criteria);
        $query->joinWith('AddressOwnerIdClient', $joinBehavior);

        return $this->getAddressOwnerSellers($query, $con);
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
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->phone_number = null;
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
            if ($this->collOrderSellers) {
                foreach ($this->collOrderSellers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSellerProductSellers) {
                foreach ($this->collSellerProductSellers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAddressOwnerSellers) {
                foreach ($this->collAddressOwnerSellers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOrderSellers = null;
        $this->collSellerProductSellers = null;
        $this->collAddressOwnerSellers = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SellerTableMap::DEFAULT_STRING_FORMAT);
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