<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\AddressOwner as ChildAddressOwner;
use Buildings\AddressOwnerQuery as ChildAddressOwnerQuery;
use Buildings\Cart as ChildCart;
use Buildings\CartQuery as ChildCartQuery;
use Buildings\Client as ChildClient;
use Buildings\ClientQuery as ChildClientQuery;
use Buildings\Order as ChildOrder;
use Buildings\OrderQuery as ChildOrderQuery;
use Buildings\Map\AddressOwnerTableMap;
use Buildings\Map\CartTableMap;
use Buildings\Map\ClientTableMap;
use Buildings\Map\OrderTableMap;
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
 * Base class that represents a row from the 'client' table.
 *
 *
 *
 * @package    propel.generator.Buildings.Base
 */
abstract class Client implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Buildings\\Map\\ClientTableMap';


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
    protected $collOrderClients;
    protected $collOrderClientsPartial;

    /**
     * @var        ObjectCollection|ChildCart[] Collection to store aggregation of ChildCart objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildCart> Collection to store aggregation of ChildCart objects.
     */
    protected $collCartClients;
    protected $collCartClientsPartial;

    /**
     * @var        ObjectCollection|ChildAddressOwner[] Collection to store aggregation of ChildAddressOwner objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildAddressOwner> Collection to store aggregation of ChildAddressOwner objects.
     */
    protected $collAddressOwnerClients;
    protected $collAddressOwnerClientsPartial;

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
    protected $orderClientsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCart[]
     * @phpstan-var ObjectCollection&\Traversable<ChildCart>
     */
    protected $cartClientsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAddressOwner[]
     * @phpstan-var ObjectCollection&\Traversable<ChildAddressOwner>
     */
    protected $addressOwnerClientsScheduledForDeletion = null;

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
     * Initializes internal state of Buildings\Base\Client object.
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
     * Compares this with another <code>Client</code> instance.  If
     * <code>obj</code> is an instance of <code>Client</code>, delegates to
     * <code>equals(Client)</code>.  Otherwise, returns <code>false</code>.
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
            $this->modifiedColumns[ClientTableMap::COL_ID] = true;
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
            $this->modifiedColumns[ClientTableMap::COL_USERNAME] = true;
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
            $this->modifiedColumns[ClientTableMap::COL_PASSWORD] = true;
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
            $this->modifiedColumns[ClientTableMap::COL_EMAIL] = true;
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
            $this->modifiedColumns[ClientTableMap::COL_PHONE_NUMBER] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ClientTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ClientTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ClientTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ClientTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ClientTableMap::translateFieldName('PhoneNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone_number = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ClientTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Buildings\\Client'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ClientTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildClientQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collOrderClients = null;

            $this->collCartClients = null;

            $this->collAddressOwnerClients = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Client::setDeleted()
     * @see Client::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ClientTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildClientQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ClientTableMap::DATABASE_NAME);
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
                ClientTableMap::addInstanceToPool($this);
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

            if ($this->orderClientsScheduledForDeletion !== null) {
                if (!$this->orderClientsScheduledForDeletion->isEmpty()) {
                    \Buildings\OrderQuery::create()
                        ->filterByPrimaryKeys($this->orderClientsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderClientsScheduledForDeletion = null;
                }
            }

            if ($this->collOrderClients !== null) {
                foreach ($this->collOrderClients as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cartClientsScheduledForDeletion !== null) {
                if (!$this->cartClientsScheduledForDeletion->isEmpty()) {
                    \Buildings\CartQuery::create()
                        ->filterByPrimaryKeys($this->cartClientsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cartClientsScheduledForDeletion = null;
                }
            }

            if ($this->collCartClients !== null) {
                foreach ($this->collCartClients as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->addressOwnerClientsScheduledForDeletion !== null) {
                if (!$this->addressOwnerClientsScheduledForDeletion->isEmpty()) {
                    \Buildings\AddressOwnerQuery::create()
                        ->filterByPrimaryKeys($this->addressOwnerClientsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->addressOwnerClientsScheduledForDeletion = null;
                }
            }

            if ($this->collAddressOwnerClients !== null) {
                foreach ($this->collAddressOwnerClients as $referrerFK) {
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

        $this->modifiedColumns[ClientTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ClientTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ClientTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ClientTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(ClientTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(ClientTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(ClientTableMap::COL_PHONE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'phone_number';
        }

        $sql = sprintf(
            'INSERT INTO client (%s) VALUES (%s)',
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
        $pos = ClientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['Client'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Client'][$this->hashCode()] = true;
        $keys = ClientTableMap::getFieldNames($keyType);
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
            if (null !== $this->collOrderClients) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'orders';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'orderss';
                        break;
                    default:
                        $key = 'OrderClients';
                }

                $result[$key] = $this->collOrderClients->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCartClients) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'carts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'carts';
                        break;
                    default:
                        $key = 'CartClients';
                }

                $result[$key] = $this->collCartClients->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAddressOwnerClients) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'addressOwners';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'address_owners';
                        break;
                    default:
                        $key = 'AddressOwnerClients';
                }

                $result[$key] = $this->collAddressOwnerClients->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ClientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
        $keys = ClientTableMap::getFieldNames($keyType);

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
        $criteria = new Criteria(ClientTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ClientTableMap::COL_ID)) {
            $criteria->add(ClientTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ClientTableMap::COL_USERNAME)) {
            $criteria->add(ClientTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(ClientTableMap::COL_PASSWORD)) {
            $criteria->add(ClientTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(ClientTableMap::COL_EMAIL)) {
            $criteria->add(ClientTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(ClientTableMap::COL_PHONE_NUMBER)) {
            $criteria->add(ClientTableMap::COL_PHONE_NUMBER, $this->phone_number);
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
        $criteria = ChildClientQuery::create();
        $criteria->add(ClientTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \Buildings\Client (or compatible) type.
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

            foreach ($this->getOrderClients() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderClient($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCartClients() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCartClient($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAddressOwnerClients() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAddressOwnerClient($relObj->copy($deepCopy));
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
     * @return \Buildings\Client Clone of current object.
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
        if ('OrderClient' === $relationName) {
            $this->initOrderClients();
            return;
        }
        if ('CartClient' === $relationName) {
            $this->initCartClients();
            return;
        }
        if ('AddressOwnerClient' === $relationName) {
            $this->initAddressOwnerClients();
            return;
        }
    }

    /**
     * Clears out the collOrderClients collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addOrderClients()
     */
    public function clearOrderClients()
    {
        $this->collOrderClients = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collOrderClients collection loaded partially.
     *
     * @return void
     */
    public function resetPartialOrderClients($v = true): void
    {
        $this->collOrderClientsPartial = $v;
    }

    /**
     * Initializes the collOrderClients collection.
     *
     * By default this just sets the collOrderClients collection to an empty array (like clearcollOrderClients());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderClients(bool $overrideExisting = true): void
    {
        if (null !== $this->collOrderClients && !$overrideExisting) {
            return;
        }

        $collectionClassName = OrderTableMap::getTableMap()->getCollectionClassName();

        $this->collOrderClients = new $collectionClassName;
        $this->collOrderClients->setModel('\Buildings\Order');
    }

    /**
     * Gets an array of ChildOrder objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOrder[] List of ChildOrder objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrder> List of ChildOrder objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getOrderClients(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collOrderClientsPartial && !$this->isNew();
        if (null === $this->collOrderClients || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collOrderClients) {
                    $this->initOrderClients();
                } else {
                    $collectionClassName = OrderTableMap::getTableMap()->getCollectionClassName();

                    $collOrderClients = new $collectionClassName;
                    $collOrderClients->setModel('\Buildings\Order');

                    return $collOrderClients;
                }
            } else {
                $collOrderClients = ChildOrderQuery::create(null, $criteria)
                    ->filterByOrderIdClient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderClientsPartial && count($collOrderClients)) {
                        $this->initOrderClients(false);

                        foreach ($collOrderClients as $obj) {
                            if (false == $this->collOrderClients->contains($obj)) {
                                $this->collOrderClients->append($obj);
                            }
                        }

                        $this->collOrderClientsPartial = true;
                    }

                    return $collOrderClients;
                }

                if ($partial && $this->collOrderClients) {
                    foreach ($this->collOrderClients as $obj) {
                        if ($obj->isNew()) {
                            $collOrderClients[] = $obj;
                        }
                    }
                }

                $this->collOrderClients = $collOrderClients;
                $this->collOrderClientsPartial = false;
            }
        }

        return $this->collOrderClients;
    }

    /**
     * Sets a collection of ChildOrder objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $orderClients A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setOrderClients(Collection $orderClients, ?ConnectionInterface $con = null)
    {
        /** @var ChildOrder[] $orderClientsToDelete */
        $orderClientsToDelete = $this->getOrderClients(new Criteria(), $con)->diff($orderClients);


        $this->orderClientsScheduledForDeletion = $orderClientsToDelete;

        foreach ($orderClientsToDelete as $orderClientRemoved) {
            $orderClientRemoved->setOrderIdClient(null);
        }

        $this->collOrderClients = null;
        foreach ($orderClients as $orderClient) {
            $this->addOrderClient($orderClient);
        }

        $this->collOrderClients = $orderClients;
        $this->collOrderClientsPartial = false;

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
    public function countOrderClients(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collOrderClientsPartial && !$this->isNew();
        if (null === $this->collOrderClients || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderClients) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderClients());
            }

            $query = ChildOrderQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrderIdClient($this)
                ->count($con);
        }

        return count($this->collOrderClients);
    }

    /**
     * Method called to associate a ChildOrder object to this object
     * through the ChildOrder foreign key attribute.
     *
     * @param ChildOrder $l ChildOrder
     * @return $this The current object (for fluent API support)
     */
    public function addOrderClient(ChildOrder $l)
    {
        if ($this->collOrderClients === null) {
            $this->initOrderClients();
            $this->collOrderClientsPartial = true;
        }

        if (!$this->collOrderClients->contains($l)) {
            $this->doAddOrderClient($l);

            if ($this->orderClientsScheduledForDeletion and $this->orderClientsScheduledForDeletion->contains($l)) {
                $this->orderClientsScheduledForDeletion->remove($this->orderClientsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildOrder $orderClient The ChildOrder object to add.
     */
    protected function doAddOrderClient(ChildOrder $orderClient): void
    {
        $this->collOrderClients[]= $orderClient;
        $orderClient->setOrderIdClient($this);
    }

    /**
     * @param ChildOrder $orderClient The ChildOrder object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeOrderClient(ChildOrder $orderClient)
    {
        if ($this->getOrderClients()->contains($orderClient)) {
            $pos = $this->collOrderClients->search($orderClient);
            $this->collOrderClients->remove($pos);
            if (null === $this->orderClientsScheduledForDeletion) {
                $this->orderClientsScheduledForDeletion = clone $this->collOrderClients;
                $this->orderClientsScheduledForDeletion->clear();
            }
            $this->orderClientsScheduledForDeletion[]= $orderClient;
            $orderClient->setOrderIdClient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Client is new, it will return
     * an empty collection; or if this Client has previously
     * been saved, it will retrieve related OrderClients from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Client.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOrder[] List of ChildOrder objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrder}> List of ChildOrder objects
     */
    public function getOrderClientsJoinOrderIdSeller(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderQuery::create(null, $criteria);
        $query->joinWith('OrderIdSeller', $joinBehavior);

        return $this->getOrderClients($query, $con);
    }

    /**
     * Clears out the collCartClients collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addCartClients()
     */
    public function clearCartClients()
    {
        $this->collCartClients = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collCartClients collection loaded partially.
     *
     * @return void
     */
    public function resetPartialCartClients($v = true): void
    {
        $this->collCartClientsPartial = $v;
    }

    /**
     * Initializes the collCartClients collection.
     *
     * By default this just sets the collCartClients collection to an empty array (like clearcollCartClients());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCartClients(bool $overrideExisting = true): void
    {
        if (null !== $this->collCartClients && !$overrideExisting) {
            return;
        }

        $collectionClassName = CartTableMap::getTableMap()->getCollectionClassName();

        $this->collCartClients = new $collectionClassName;
        $this->collCartClients->setModel('\Buildings\Cart');
    }

    /**
     * Gets an array of ChildCart objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCart[] List of ChildCart objects
     * @phpstan-return ObjectCollection&\Traversable<ChildCart> List of ChildCart objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getCartClients(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collCartClientsPartial && !$this->isNew();
        if (null === $this->collCartClients || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collCartClients) {
                    $this->initCartClients();
                } else {
                    $collectionClassName = CartTableMap::getTableMap()->getCollectionClassName();

                    $collCartClients = new $collectionClassName;
                    $collCartClients->setModel('\Buildings\Cart');

                    return $collCartClients;
                }
            } else {
                $collCartClients = ChildCartQuery::create(null, $criteria)
                    ->filterByCartClientId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCartClientsPartial && count($collCartClients)) {
                        $this->initCartClients(false);

                        foreach ($collCartClients as $obj) {
                            if (false == $this->collCartClients->contains($obj)) {
                                $this->collCartClients->append($obj);
                            }
                        }

                        $this->collCartClientsPartial = true;
                    }

                    return $collCartClients;
                }

                if ($partial && $this->collCartClients) {
                    foreach ($this->collCartClients as $obj) {
                        if ($obj->isNew()) {
                            $collCartClients[] = $obj;
                        }
                    }
                }

                $this->collCartClients = $collCartClients;
                $this->collCartClientsPartial = false;
            }
        }

        return $this->collCartClients;
    }

    /**
     * Sets a collection of ChildCart objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $cartClients A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setCartClients(Collection $cartClients, ?ConnectionInterface $con = null)
    {
        /** @var ChildCart[] $cartClientsToDelete */
        $cartClientsToDelete = $this->getCartClients(new Criteria(), $con)->diff($cartClients);


        $this->cartClientsScheduledForDeletion = $cartClientsToDelete;

        foreach ($cartClientsToDelete as $cartClientRemoved) {
            $cartClientRemoved->setCartClientId(null);
        }

        $this->collCartClients = null;
        foreach ($cartClients as $cartClient) {
            $this->addCartClient($cartClient);
        }

        $this->collCartClients = $cartClients;
        $this->collCartClientsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cart objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Cart objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countCartClients(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCartClientsPartial && !$this->isNew();
        if (null === $this->collCartClients || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCartClients) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCartClients());
            }

            $query = ChildCartQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCartClientId($this)
                ->count($con);
        }

        return count($this->collCartClients);
    }

    /**
     * Method called to associate a ChildCart object to this object
     * through the ChildCart foreign key attribute.
     *
     * @param ChildCart $l ChildCart
     * @return $this The current object (for fluent API support)
     */
    public function addCartClient(ChildCart $l)
    {
        if ($this->collCartClients === null) {
            $this->initCartClients();
            $this->collCartClientsPartial = true;
        }

        if (!$this->collCartClients->contains($l)) {
            $this->doAddCartClient($l);

            if ($this->cartClientsScheduledForDeletion and $this->cartClientsScheduledForDeletion->contains($l)) {
                $this->cartClientsScheduledForDeletion->remove($this->cartClientsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCart $cartClient The ChildCart object to add.
     */
    protected function doAddCartClient(ChildCart $cartClient): void
    {
        $this->collCartClients[]= $cartClient;
        $cartClient->setCartClientId($this);
    }

    /**
     * @param ChildCart $cartClient The ChildCart object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeCartClient(ChildCart $cartClient)
    {
        if ($this->getCartClients()->contains($cartClient)) {
            $pos = $this->collCartClients->search($cartClient);
            $this->collCartClients->remove($pos);
            if (null === $this->cartClientsScheduledForDeletion) {
                $this->cartClientsScheduledForDeletion = clone $this->collCartClients;
                $this->cartClientsScheduledForDeletion->clear();
            }
            $this->cartClientsScheduledForDeletion[]= clone $cartClient;
            $cartClient->setCartClientId(null);
        }

        return $this;
    }

    /**
     * Clears out the collAddressOwnerClients collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addAddressOwnerClients()
     */
    public function clearAddressOwnerClients()
    {
        $this->collAddressOwnerClients = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collAddressOwnerClients collection loaded partially.
     *
     * @return void
     */
    public function resetPartialAddressOwnerClients($v = true): void
    {
        $this->collAddressOwnerClientsPartial = $v;
    }

    /**
     * Initializes the collAddressOwnerClients collection.
     *
     * By default this just sets the collAddressOwnerClients collection to an empty array (like clearcollAddressOwnerClients());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAddressOwnerClients(bool $overrideExisting = true): void
    {
        if (null !== $this->collAddressOwnerClients && !$overrideExisting) {
            return;
        }

        $collectionClassName = AddressOwnerTableMap::getTableMap()->getCollectionClassName();

        $this->collAddressOwnerClients = new $collectionClassName;
        $this->collAddressOwnerClients->setModel('\Buildings\AddressOwner');
    }

    /**
     * Gets an array of ChildAddressOwner objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner> List of ChildAddressOwner objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAddressOwnerClients(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collAddressOwnerClientsPartial && !$this->isNew();
        if (null === $this->collAddressOwnerClients || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAddressOwnerClients) {
                    $this->initAddressOwnerClients();
                } else {
                    $collectionClassName = AddressOwnerTableMap::getTableMap()->getCollectionClassName();

                    $collAddressOwnerClients = new $collectionClassName;
                    $collAddressOwnerClients->setModel('\Buildings\AddressOwner');

                    return $collAddressOwnerClients;
                }
            } else {
                $collAddressOwnerClients = ChildAddressOwnerQuery::create(null, $criteria)
                    ->filterByAddressOwnerIdClient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAddressOwnerClientsPartial && count($collAddressOwnerClients)) {
                        $this->initAddressOwnerClients(false);

                        foreach ($collAddressOwnerClients as $obj) {
                            if (false == $this->collAddressOwnerClients->contains($obj)) {
                                $this->collAddressOwnerClients->append($obj);
                            }
                        }

                        $this->collAddressOwnerClientsPartial = true;
                    }

                    return $collAddressOwnerClients;
                }

                if ($partial && $this->collAddressOwnerClients) {
                    foreach ($this->collAddressOwnerClients as $obj) {
                        if ($obj->isNew()) {
                            $collAddressOwnerClients[] = $obj;
                        }
                    }
                }

                $this->collAddressOwnerClients = $collAddressOwnerClients;
                $this->collAddressOwnerClientsPartial = false;
            }
        }

        return $this->collAddressOwnerClients;
    }

    /**
     * Sets a collection of ChildAddressOwner objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $addressOwnerClients A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setAddressOwnerClients(Collection $addressOwnerClients, ?ConnectionInterface $con = null)
    {
        /** @var ChildAddressOwner[] $addressOwnerClientsToDelete */
        $addressOwnerClientsToDelete = $this->getAddressOwnerClients(new Criteria(), $con)->diff($addressOwnerClients);


        $this->addressOwnerClientsScheduledForDeletion = $addressOwnerClientsToDelete;

        foreach ($addressOwnerClientsToDelete as $addressOwnerClientRemoved) {
            $addressOwnerClientRemoved->setAddressOwnerIdClient(null);
        }

        $this->collAddressOwnerClients = null;
        foreach ($addressOwnerClients as $addressOwnerClient) {
            $this->addAddressOwnerClient($addressOwnerClient);
        }

        $this->collAddressOwnerClients = $addressOwnerClients;
        $this->collAddressOwnerClientsPartial = false;

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
    public function countAddressOwnerClients(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collAddressOwnerClientsPartial && !$this->isNew();
        if (null === $this->collAddressOwnerClients || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAddressOwnerClients) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAddressOwnerClients());
            }

            $query = ChildAddressOwnerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAddressOwnerIdClient($this)
                ->count($con);
        }

        return count($this->collAddressOwnerClients);
    }

    /**
     * Method called to associate a ChildAddressOwner object to this object
     * through the ChildAddressOwner foreign key attribute.
     *
     * @param ChildAddressOwner $l ChildAddressOwner
     * @return $this The current object (for fluent API support)
     */
    public function addAddressOwnerClient(ChildAddressOwner $l)
    {
        if ($this->collAddressOwnerClients === null) {
            $this->initAddressOwnerClients();
            $this->collAddressOwnerClientsPartial = true;
        }

        if (!$this->collAddressOwnerClients->contains($l)) {
            $this->doAddAddressOwnerClient($l);

            if ($this->addressOwnerClientsScheduledForDeletion and $this->addressOwnerClientsScheduledForDeletion->contains($l)) {
                $this->addressOwnerClientsScheduledForDeletion->remove($this->addressOwnerClientsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAddressOwner $addressOwnerClient The ChildAddressOwner object to add.
     */
    protected function doAddAddressOwnerClient(ChildAddressOwner $addressOwnerClient): void
    {
        $this->collAddressOwnerClients[]= $addressOwnerClient;
        $addressOwnerClient->setAddressOwnerIdClient($this);
    }

    /**
     * @param ChildAddressOwner $addressOwnerClient The ChildAddressOwner object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeAddressOwnerClient(ChildAddressOwner $addressOwnerClient)
    {
        if ($this->getAddressOwnerClients()->contains($addressOwnerClient)) {
            $pos = $this->collAddressOwnerClients->search($addressOwnerClient);
            $this->collAddressOwnerClients->remove($pos);
            if (null === $this->addressOwnerClientsScheduledForDeletion) {
                $this->addressOwnerClientsScheduledForDeletion = clone $this->collAddressOwnerClients;
                $this->addressOwnerClientsScheduledForDeletion->clear();
            }
            $this->addressOwnerClientsScheduledForDeletion[]= $addressOwnerClient;
            $addressOwnerClient->setAddressOwnerIdClient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Client is new, it will return
     * an empty collection; or if this Client has previously
     * been saved, it will retrieve related AddressOwnerClients from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Client.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner}> List of ChildAddressOwner objects
     */
    public function getAddressOwnerClientsJoinAddressOwnerId(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAddressOwnerQuery::create(null, $criteria);
        $query->joinWith('AddressOwnerId', $joinBehavior);

        return $this->getAddressOwnerClients($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Client is new, it will return
     * an empty collection; or if this Client has previously
     * been saved, it will retrieve related AddressOwnerClients from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Client.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAddressOwner[] List of ChildAddressOwner objects
     * @phpstan-return ObjectCollection&\Traversable<ChildAddressOwner}> List of ChildAddressOwner objects
     */
    public function getAddressOwnerClientsJoinAddressOwnerIdSeller(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAddressOwnerQuery::create(null, $criteria);
        $query->joinWith('AddressOwnerIdSeller', $joinBehavior);

        return $this->getAddressOwnerClients($query, $con);
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
            if ($this->collOrderClients) {
                foreach ($this->collOrderClients as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCartClients) {
                foreach ($this->collCartClients as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAddressOwnerClients) {
                foreach ($this->collAddressOwnerClients as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOrderClients = null;
        $this->collCartClients = null;
        $this->collAddressOwnerClients = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ClientTableMap::DEFAULT_STRING_FORMAT);
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
