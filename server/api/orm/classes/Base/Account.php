<?php

namespace Base;

use \Account as ChildAccount;
use \AccountAuthorized as ChildAccountAuthorized;
use \AccountAuthorizedQuery as ChildAccountAuthorizedQuery;
use \AccountQuery as ChildAccountQuery;
use \AccountVerification as ChildAccountVerification;
use \AccountVerificationQuery as ChildAccountVerificationQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AccountAuthorizedTableMap;
use Map\AccountTableMap;
use Map\AccountVerificationTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'account' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Account implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AccountTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the forename field.
     *
     * @var        string
     */
    protected $forename;

    /**
     * The value for the surname field.
     *
     * @var        string
     */
    protected $surname;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the email_verified field.
     *
     * @var        boolean
     */
    protected $email_verified;

    /**
     * The value for the hash field.
     *
     * @var        string
     */
    protected $hash;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildAccountAuthorized[] Collection to store aggregation of ChildAccountAuthorized objects.
     */
    protected $collAccountAuthorizeds;
    protected $collAccountAuthorizedsPartial;

    /**
     * @var        ObjectCollection|ChildAccountVerification[] Collection to store aggregation of ChildAccountVerification objects.
     */
    protected $collAccountVerifications;
    protected $collAccountVerificationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccountAuthorized[]
     */
    protected $accountAuthorizedsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccountVerification[]
     */
    protected $accountVerificationsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Account object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Account</code> instance.  If
     * <code>obj</code> is an instance of <code>Account</code>, delegates to
     * <code>equals(Account)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
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
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Account The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
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
     * Get the [forename] column value.
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Get the [surname] column value.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
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
     * Get the [email_verified] column value.
     *
     * @return boolean
     */
    public function getEmailVerified()
    {
        return $this->email_verified;
    }

    /**
     * Get the [email_verified] column value.
     *
     * @return boolean
     */
    public function isEmailVerified()
    {
        return $this->getEmailVerified();
    }

    /**
     * Get the [hash] column value.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AccountTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [forename] column.
     *
     * @param string $v new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setForename($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->forename !== $v) {
            $this->forename = $v;
            $this->modifiedColumns[AccountTableMap::COL_FORENAME] = true;
        }

        return $this;
    } // setForename()

    /**
     * Set the value of [surname] column.
     *
     * @param string $v new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setSurname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->surname !== $v) {
            $this->surname = $v;
            $this->modifiedColumns[AccountTableMap::COL_SURNAME] = true;
        }

        return $this;
    } // setSurname()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[AccountTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Sets the value of the [email_verified] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setEmailVerified($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->email_verified !== $v) {
            $this->email_verified = $v;
            $this->modifiedColumns[AccountTableMap::COL_EMAIL_VERIFIED] = true;
        }

        return $this;
    } // setEmailVerified()

    /**
     * Set the value of [hash] column.
     *
     * @param string $v new value
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hash !== $v) {
            $this->hash = $v;
            $this->modifiedColumns[AccountTableMap::COL_HASH] = true;
        }

        return $this;
    } // setHash()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AccountTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Account The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AccountTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AccountTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AccountTableMap::translateFieldName('Forename', TableMap::TYPE_PHPNAME, $indexType)];
            $this->forename = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AccountTableMap::translateFieldName('Surname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->surname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AccountTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AccountTableMap::translateFieldName('EmailVerified', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_verified = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AccountTableMap::translateFieldName('Hash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AccountTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AccountTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = AccountTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Account'), 0, $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccountTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAccountQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAccountAuthorizeds = null;

            $this->collAccountVerifications = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Account::setDeleted()
     * @see Account::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAccountQuery::create()
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
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(AccountTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(AccountTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AccountTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                AccountTableMap::addInstanceToPool($this);
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
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
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

            if ($this->accountAuthorizedsScheduledForDeletion !== null) {
                if (!$this->accountAuthorizedsScheduledForDeletion->isEmpty()) {
                    \AccountAuthorizedQuery::create()
                        ->filterByPrimaryKeys($this->accountAuthorizedsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountAuthorizedsScheduledForDeletion = null;
                }
            }

            if ($this->collAccountAuthorizeds !== null) {
                foreach ($this->collAccountAuthorizeds as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->accountVerificationsScheduledForDeletion !== null) {
                if (!$this->accountVerificationsScheduledForDeletion->isEmpty()) {
                    \AccountVerificationQuery::create()
                        ->filterByPrimaryKeys($this->accountVerificationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountVerificationsScheduledForDeletion = null;
                }
            }

            if ($this->collAccountVerifications !== null) {
                foreach ($this->collAccountVerifications as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[AccountTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AccountTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AccountTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(AccountTableMap::COL_FORENAME)) {
            $modifiedColumns[':p' . $index++]  = 'forename';
        }
        if ($this->isColumnModified(AccountTableMap::COL_SURNAME)) {
            $modifiedColumns[':p' . $index++]  = 'surname';
        }
        if ($this->isColumnModified(AccountTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(AccountTableMap::COL_EMAIL_VERIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'email_verified';
        }
        if ($this->isColumnModified(AccountTableMap::COL_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'hash';
        }
        if ($this->isColumnModified(AccountTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(AccountTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO account (%s) VALUES (%s)',
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
                    case 'forename':
                        $stmt->bindValue($identifier, $this->forename, PDO::PARAM_STR);
                        break;
                    case 'surname':
                        $stmt->bindValue($identifier, $this->surname, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'email_verified':
                        $stmt->bindValue($identifier, (int) $this->email_verified, PDO::PARAM_INT);
                        break;
                    case 'hash':
                        $stmt->bindValue($identifier, $this->hash, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AccountTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getForename();
                break;
            case 2:
                return $this->getSurname();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getEmailVerified();
                break;
            case 5:
                return $this->getHash();
                break;
            case 6:
                return $this->getCreatedAt();
                break;
            case 7:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Account'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Account'][$this->hashCode()] = true;
        $keys = AccountTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getForename(),
            $keys[2] => $this->getSurname(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getEmailVerified(),
            $keys[5] => $this->getHash(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAccountAuthorizeds) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accountAuthorizeds';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'account_authorizeds';
                        break;
                    default:
                        $key = 'AccountAuthorizeds';
                }

                $result[$key] = $this->collAccountAuthorizeds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAccountVerifications) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accountVerifications';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'account_verifications';
                        break;
                    default:
                        $key = 'AccountVerifications';
                }

                $result[$key] = $this->collAccountVerifications->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Account
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AccountTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Account
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setForename($value);
                break;
            case 2:
                $this->setSurname($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setEmailVerified($value);
                break;
            case 5:
                $this->setHash($value);
                break;
            case 6:
                $this->setCreatedAt($value);
                break;
            case 7:
                $this->setUpdatedAt($value);
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
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = AccountTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setForename($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSurname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEmailVerified($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setHash($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCreatedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUpdatedAt($arr[$keys[7]]);
        }
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
     * @return $this|\Account The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
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
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AccountTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AccountTableMap::COL_ID)) {
            $criteria->add(AccountTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AccountTableMap::COL_FORENAME)) {
            $criteria->add(AccountTableMap::COL_FORENAME, $this->forename);
        }
        if ($this->isColumnModified(AccountTableMap::COL_SURNAME)) {
            $criteria->add(AccountTableMap::COL_SURNAME, $this->surname);
        }
        if ($this->isColumnModified(AccountTableMap::COL_EMAIL)) {
            $criteria->add(AccountTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(AccountTableMap::COL_EMAIL_VERIFIED)) {
            $criteria->add(AccountTableMap::COL_EMAIL_VERIFIED, $this->email_verified);
        }
        if ($this->isColumnModified(AccountTableMap::COL_HASH)) {
            $criteria->add(AccountTableMap::COL_HASH, $this->hash);
        }
        if ($this->isColumnModified(AccountTableMap::COL_CREATED_AT)) {
            $criteria->add(AccountTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(AccountTableMap::COL_UPDATED_AT)) {
            $criteria->add(AccountTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildAccountQuery::create();
        $criteria->add(AccountTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
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
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Account (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setForename($this->getForename());
        $copyObj->setSurname($this->getSurname());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setEmailVerified($this->getEmailVerified());
        $copyObj->setHash($this->getHash());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccountAuthorizeds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccountAuthorized($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAccountVerifications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccountVerification($relObj->copy($deepCopy));
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
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Account Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
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
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AccountAuthorized' == $relationName) {
            $this->initAccountAuthorizeds();
            return;
        }
        if ('AccountVerification' == $relationName) {
            $this->initAccountVerifications();
            return;
        }
    }

    /**
     * Clears out the collAccountAuthorizeds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccountAuthorizeds()
     */
    public function clearAccountAuthorizeds()
    {
        $this->collAccountAuthorizeds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccountAuthorizeds collection loaded partially.
     */
    public function resetPartialAccountAuthorizeds($v = true)
    {
        $this->collAccountAuthorizedsPartial = $v;
    }

    /**
     * Initializes the collAccountAuthorizeds collection.
     *
     * By default this just sets the collAccountAuthorizeds collection to an empty array (like clearcollAccountAuthorizeds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccountAuthorizeds($overrideExisting = true)
    {
        if (null !== $this->collAccountAuthorizeds && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccountAuthorizedTableMap::getTableMap()->getCollectionClassName();

        $this->collAccountAuthorizeds = new $collectionClassName;
        $this->collAccountAuthorizeds->setModel('\AccountAuthorized');
    }

    /**
     * Gets an array of ChildAccountAuthorized objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAccount is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccountAuthorized[] List of ChildAccountAuthorized objects
     * @throws PropelException
     */
    public function getAccountAuthorizeds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountAuthorizedsPartial && !$this->isNew();
        if (null === $this->collAccountAuthorizeds || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccountAuthorizeds) {
                // return empty collection
                $this->initAccountAuthorizeds();
            } else {
                $collAccountAuthorizeds = ChildAccountAuthorizedQuery::create(null, $criteria)
                    ->filterByAccount($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccountAuthorizedsPartial && count($collAccountAuthorizeds)) {
                        $this->initAccountAuthorizeds(false);

                        foreach ($collAccountAuthorizeds as $obj) {
                            if (false == $this->collAccountAuthorizeds->contains($obj)) {
                                $this->collAccountAuthorizeds->append($obj);
                            }
                        }

                        $this->collAccountAuthorizedsPartial = true;
                    }

                    return $collAccountAuthorizeds;
                }

                if ($partial && $this->collAccountAuthorizeds) {
                    foreach ($this->collAccountAuthorizeds as $obj) {
                        if ($obj->isNew()) {
                            $collAccountAuthorizeds[] = $obj;
                        }
                    }
                }

                $this->collAccountAuthorizeds = $collAccountAuthorizeds;
                $this->collAccountAuthorizedsPartial = false;
            }
        }

        return $this->collAccountAuthorizeds;
    }

    /**
     * Sets a collection of ChildAccountAuthorized objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accountAuthorizeds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAccount The current object (for fluent API support)
     */
    public function setAccountAuthorizeds(Collection $accountAuthorizeds, ConnectionInterface $con = null)
    {
        /** @var ChildAccountAuthorized[] $accountAuthorizedsToDelete */
        $accountAuthorizedsToDelete = $this->getAccountAuthorizeds(new Criteria(), $con)->diff($accountAuthorizeds);


        $this->accountAuthorizedsScheduledForDeletion = $accountAuthorizedsToDelete;

        foreach ($accountAuthorizedsToDelete as $accountAuthorizedRemoved) {
            $accountAuthorizedRemoved->setAccount(null);
        }

        $this->collAccountAuthorizeds = null;
        foreach ($accountAuthorizeds as $accountAuthorized) {
            $this->addAccountAuthorized($accountAuthorized);
        }

        $this->collAccountAuthorizeds = $accountAuthorizeds;
        $this->collAccountAuthorizedsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccountAuthorized objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccountAuthorized objects.
     * @throws PropelException
     */
    public function countAccountAuthorizeds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountAuthorizedsPartial && !$this->isNew();
        if (null === $this->collAccountAuthorizeds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccountAuthorizeds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccountAuthorizeds());
            }

            $query = ChildAccountAuthorizedQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccount($this)
                ->count($con);
        }

        return count($this->collAccountAuthorizeds);
    }

    /**
     * Method called to associate a ChildAccountAuthorized object to this object
     * through the ChildAccountAuthorized foreign key attribute.
     *
     * @param  ChildAccountAuthorized $l ChildAccountAuthorized
     * @return $this|\Account The current object (for fluent API support)
     */
    public function addAccountAuthorized(ChildAccountAuthorized $l)
    {
        if ($this->collAccountAuthorizeds === null) {
            $this->initAccountAuthorizeds();
            $this->collAccountAuthorizedsPartial = true;
        }

        if (!$this->collAccountAuthorizeds->contains($l)) {
            $this->doAddAccountAuthorized($l);

            if ($this->accountAuthorizedsScheduledForDeletion and $this->accountAuthorizedsScheduledForDeletion->contains($l)) {
                $this->accountAuthorizedsScheduledForDeletion->remove($this->accountAuthorizedsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccountAuthorized $accountAuthorized The ChildAccountAuthorized object to add.
     */
    protected function doAddAccountAuthorized(ChildAccountAuthorized $accountAuthorized)
    {
        $this->collAccountAuthorizeds[]= $accountAuthorized;
        $accountAuthorized->setAccount($this);
    }

    /**
     * @param  ChildAccountAuthorized $accountAuthorized The ChildAccountAuthorized object to remove.
     * @return $this|ChildAccount The current object (for fluent API support)
     */
    public function removeAccountAuthorized(ChildAccountAuthorized $accountAuthorized)
    {
        if ($this->getAccountAuthorizeds()->contains($accountAuthorized)) {
            $pos = $this->collAccountAuthorizeds->search($accountAuthorized);
            $this->collAccountAuthorizeds->remove($pos);
            if (null === $this->accountAuthorizedsScheduledForDeletion) {
                $this->accountAuthorizedsScheduledForDeletion = clone $this->collAccountAuthorizeds;
                $this->accountAuthorizedsScheduledForDeletion->clear();
            }
            $this->accountAuthorizedsScheduledForDeletion[]= clone $accountAuthorized;
            $accountAuthorized->setAccount(null);
        }

        return $this;
    }

    /**
     * Clears out the collAccountVerifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccountVerifications()
     */
    public function clearAccountVerifications()
    {
        $this->collAccountVerifications = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccountVerifications collection loaded partially.
     */
    public function resetPartialAccountVerifications($v = true)
    {
        $this->collAccountVerificationsPartial = $v;
    }

    /**
     * Initializes the collAccountVerifications collection.
     *
     * By default this just sets the collAccountVerifications collection to an empty array (like clearcollAccountVerifications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccountVerifications($overrideExisting = true)
    {
        if (null !== $this->collAccountVerifications && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccountVerificationTableMap::getTableMap()->getCollectionClassName();

        $this->collAccountVerifications = new $collectionClassName;
        $this->collAccountVerifications->setModel('\AccountVerification');
    }

    /**
     * Gets an array of ChildAccountVerification objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAccount is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccountVerification[] List of ChildAccountVerification objects
     * @throws PropelException
     */
    public function getAccountVerifications(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountVerificationsPartial && !$this->isNew();
        if (null === $this->collAccountVerifications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccountVerifications) {
                // return empty collection
                $this->initAccountVerifications();
            } else {
                $collAccountVerifications = ChildAccountVerificationQuery::create(null, $criteria)
                    ->filterByAccount($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccountVerificationsPartial && count($collAccountVerifications)) {
                        $this->initAccountVerifications(false);

                        foreach ($collAccountVerifications as $obj) {
                            if (false == $this->collAccountVerifications->contains($obj)) {
                                $this->collAccountVerifications->append($obj);
                            }
                        }

                        $this->collAccountVerificationsPartial = true;
                    }

                    return $collAccountVerifications;
                }

                if ($partial && $this->collAccountVerifications) {
                    foreach ($this->collAccountVerifications as $obj) {
                        if ($obj->isNew()) {
                            $collAccountVerifications[] = $obj;
                        }
                    }
                }

                $this->collAccountVerifications = $collAccountVerifications;
                $this->collAccountVerificationsPartial = false;
            }
        }

        return $this->collAccountVerifications;
    }

    /**
     * Sets a collection of ChildAccountVerification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accountVerifications A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAccount The current object (for fluent API support)
     */
    public function setAccountVerifications(Collection $accountVerifications, ConnectionInterface $con = null)
    {
        /** @var ChildAccountVerification[] $accountVerificationsToDelete */
        $accountVerificationsToDelete = $this->getAccountVerifications(new Criteria(), $con)->diff($accountVerifications);


        $this->accountVerificationsScheduledForDeletion = $accountVerificationsToDelete;

        foreach ($accountVerificationsToDelete as $accountVerificationRemoved) {
            $accountVerificationRemoved->setAccount(null);
        }

        $this->collAccountVerifications = null;
        foreach ($accountVerifications as $accountVerification) {
            $this->addAccountVerification($accountVerification);
        }

        $this->collAccountVerifications = $accountVerifications;
        $this->collAccountVerificationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccountVerification objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccountVerification objects.
     * @throws PropelException
     */
    public function countAccountVerifications(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountVerificationsPartial && !$this->isNew();
        if (null === $this->collAccountVerifications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccountVerifications) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccountVerifications());
            }

            $query = ChildAccountVerificationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccount($this)
                ->count($con);
        }

        return count($this->collAccountVerifications);
    }

    /**
     * Method called to associate a ChildAccountVerification object to this object
     * through the ChildAccountVerification foreign key attribute.
     *
     * @param  ChildAccountVerification $l ChildAccountVerification
     * @return $this|\Account The current object (for fluent API support)
     */
    public function addAccountVerification(ChildAccountVerification $l)
    {
        if ($this->collAccountVerifications === null) {
            $this->initAccountVerifications();
            $this->collAccountVerificationsPartial = true;
        }

        if (!$this->collAccountVerifications->contains($l)) {
            $this->doAddAccountVerification($l);

            if ($this->accountVerificationsScheduledForDeletion and $this->accountVerificationsScheduledForDeletion->contains($l)) {
                $this->accountVerificationsScheduledForDeletion->remove($this->accountVerificationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccountVerification $accountVerification The ChildAccountVerification object to add.
     */
    protected function doAddAccountVerification(ChildAccountVerification $accountVerification)
    {
        $this->collAccountVerifications[]= $accountVerification;
        $accountVerification->setAccount($this);
    }

    /**
     * @param  ChildAccountVerification $accountVerification The ChildAccountVerification object to remove.
     * @return $this|ChildAccount The current object (for fluent API support)
     */
    public function removeAccountVerification(ChildAccountVerification $accountVerification)
    {
        if ($this->getAccountVerifications()->contains($accountVerification)) {
            $pos = $this->collAccountVerifications->search($accountVerification);
            $this->collAccountVerifications->remove($pos);
            if (null === $this->accountVerificationsScheduledForDeletion) {
                $this->accountVerificationsScheduledForDeletion = clone $this->collAccountVerifications;
                $this->accountVerificationsScheduledForDeletion->clear();
            }
            $this->accountVerificationsScheduledForDeletion[]= clone $accountVerification;
            $accountVerification->setAccount(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->forename = null;
        $this->surname = null;
        $this->email = null;
        $this->email_verified = null;
        $this->hash = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAccountAuthorizeds) {
                foreach ($this->collAccountAuthorizeds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAccountVerifications) {
                foreach ($this->collAccountVerifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAccountAuthorizeds = null;
        $this->collAccountVerifications = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AccountTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAccount The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AccountTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
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

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}