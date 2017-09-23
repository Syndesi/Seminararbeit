<?php

namespace Base;

use \UbaCO as ChildUbaCO;
use \UbaCOQuery as ChildUbaCOQuery;
use \UbaNO2 as ChildUbaNO2;
use \UbaNO2Query as ChildUbaNO2Query;
use \UbaO3 as ChildUbaO3;
use \UbaO3Query as ChildUbaO3Query;
use \UbaPM10 as ChildUbaPM10;
use \UbaPM10Query as ChildUbaPM10Query;
use \UbaSO2 as ChildUbaSO2;
use \UbaSO2Query as ChildUbaSO2Query;
use \UbaStation as ChildUbaStation;
use \UbaStationQuery as ChildUbaStationQuery;
use \Exception;
use \PDO;
use Map\UbaCOTableMap;
use Map\UbaNO2TableMap;
use Map\UbaO3TableMap;
use Map\UbaPM10TableMap;
use Map\UbaSO2TableMap;
use Map\UbaStationTableMap;
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
 * Base class that represents a row from the 'uba_station' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class UbaStation implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UbaStationTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

    /**
     * The value for the network field.
     *
     * @var        string
     */
    protected $network;

    /**
     * The value for the lat field.
     *
     * @var        double
     */
    protected $lat;

    /**
     * The value for the lng field.
     *
     * @var        double
     */
    protected $lng;

    /**
     * The value for the alt field.
     *
     * @var        double
     */
    protected $alt;

    /**
     * @var        ObjectCollection|ChildUbaO3[] Collection to store aggregation of ChildUbaO3 objects.
     */
    protected $collUbaO3s;
    protected $collUbaO3sPartial;

    /**
     * @var        ObjectCollection|ChildUbaSO2[] Collection to store aggregation of ChildUbaSO2 objects.
     */
    protected $collUbaSO2s;
    protected $collUbaSO2sPartial;

    /**
     * @var        ObjectCollection|ChildUbaPM10[] Collection to store aggregation of ChildUbaPM10 objects.
     */
    protected $collUbaPM10s;
    protected $collUbaPM10sPartial;

    /**
     * @var        ObjectCollection|ChildUbaNO2[] Collection to store aggregation of ChildUbaNO2 objects.
     */
    protected $collUbaNO2s;
    protected $collUbaNO2sPartial;

    /**
     * @var        ObjectCollection|ChildUbaCO[] Collection to store aggregation of ChildUbaCO objects.
     */
    protected $collUbaCos;
    protected $collUbaCosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUbaO3[]
     */
    protected $ubaO3sScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUbaSO2[]
     */
    protected $ubaSO2sScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUbaPM10[]
     */
    protected $ubaPM10sScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUbaNO2[]
     */
    protected $ubaNO2sScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUbaCO[]
     */
    protected $ubaCosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\UbaStation object.
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
     * Compares this with another <code>UbaStation</code> instance.  If
     * <code>obj</code> is an instance of <code>UbaStation</code>, delegates to
     * <code>equals(UbaStation)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UbaStation The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the [network] column value.
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Get the [lat] column value.
     *
     * @return double
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Get the [lng] column value.
     *
     * @return double
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Get the [alt] column value.
     *
     * @return double
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [network] column.
     *
     * @param string $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setNetwork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->network !== $v) {
            $this->network = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_NETWORK] = true;
        }

        return $this;
    } // setNetwork()

    /**
     * Set the value of [lat] column.
     *
     * @param double $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_LAT] = true;
        }

        return $this;
    } // setLat()

    /**
     * Set the value of [lng] column.
     *
     * @param double $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_LNG] = true;
        }

        return $this;
    } // setLng()

    /**
     * Set the value of [alt] column.
     *
     * @param double $v new value
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function setAlt($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->alt !== $v) {
            $this->alt = $v;
            $this->modifiedColumns[UbaStationTableMap::COL_ALT] = true;
        }

        return $this;
    } // setAlt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UbaStationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UbaStationTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UbaStationTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UbaStationTableMap::translateFieldName('Network', TableMap::TYPE_PHPNAME, $indexType)];
            $this->network = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UbaStationTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UbaStationTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UbaStationTableMap::translateFieldName('Alt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->alt = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UbaStationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\UbaStation'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UbaStationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUbaStationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collUbaO3s = null;

            $this->collUbaSO2s = null;

            $this->collUbaPM10s = null;

            $this->collUbaNO2s = null;

            $this->collUbaCos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UbaStation::setDeleted()
     * @see UbaStation::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UbaStationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUbaStationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UbaStationTableMap::DATABASE_NAME);
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
                UbaStationTableMap::addInstanceToPool($this);
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

            if ($this->ubaO3sScheduledForDeletion !== null) {
                if (!$this->ubaO3sScheduledForDeletion->isEmpty()) {
                    \UbaO3Query::create()
                        ->filterByPrimaryKeys($this->ubaO3sScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ubaO3sScheduledForDeletion = null;
                }
            }

            if ($this->collUbaO3s !== null) {
                foreach ($this->collUbaO3s as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ubaSO2sScheduledForDeletion !== null) {
                if (!$this->ubaSO2sScheduledForDeletion->isEmpty()) {
                    \UbaSO2Query::create()
                        ->filterByPrimaryKeys($this->ubaSO2sScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ubaSO2sScheduledForDeletion = null;
                }
            }

            if ($this->collUbaSO2s !== null) {
                foreach ($this->collUbaSO2s as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ubaPM10sScheduledForDeletion !== null) {
                if (!$this->ubaPM10sScheduledForDeletion->isEmpty()) {
                    \UbaPM10Query::create()
                        ->filterByPrimaryKeys($this->ubaPM10sScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ubaPM10sScheduledForDeletion = null;
                }
            }

            if ($this->collUbaPM10s !== null) {
                foreach ($this->collUbaPM10s as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ubaNO2sScheduledForDeletion !== null) {
                if (!$this->ubaNO2sScheduledForDeletion->isEmpty()) {
                    \UbaNO2Query::create()
                        ->filterByPrimaryKeys($this->ubaNO2sScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ubaNO2sScheduledForDeletion = null;
                }
            }

            if ($this->collUbaNO2s !== null) {
                foreach ($this->collUbaNO2s as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ubaCosScheduledForDeletion !== null) {
                if (!$this->ubaCosScheduledForDeletion->isEmpty()) {
                    \UbaCOQuery::create()
                        ->filterByPrimaryKeys($this->ubaCosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ubaCosScheduledForDeletion = null;
                }
            }

            if ($this->collUbaCos !== null) {
                foreach ($this->collUbaCos as $referrerFK) {
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

        $this->modifiedColumns[UbaStationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UbaStationTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UbaStationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_NETWORK)) {
            $modifiedColumns[':p' . $index++]  = 'network';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_LAT)) {
            $modifiedColumns[':p' . $index++]  = 'lat';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_LNG)) {
            $modifiedColumns[':p' . $index++]  = 'lng';
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_ALT)) {
            $modifiedColumns[':p' . $index++]  = 'alt';
        }

        $sql = sprintf(
            'INSERT INTO uba_station (%s) VALUES (%s)',
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
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'network':
                        $stmt->bindValue($identifier, $this->network, PDO::PARAM_STR);
                        break;
                    case 'lat':
                        $stmt->bindValue($identifier, $this->lat, PDO::PARAM_STR);
                        break;
                    case 'lng':
                        $stmt->bindValue($identifier, $this->lng, PDO::PARAM_STR);
                        break;
                    case 'alt':
                        $stmt->bindValue($identifier, $this->alt, PDO::PARAM_STR);
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
        $pos = UbaStationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getCode();
                break;
            case 3:
                return $this->getNetwork();
                break;
            case 4:
                return $this->getLat();
                break;
            case 5:
                return $this->getLng();
                break;
            case 6:
                return $this->getAlt();
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

        if (isset($alreadyDumpedObjects['UbaStation'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UbaStation'][$this->hashCode()] = true;
        $keys = UbaStationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getNetwork(),
            $keys[4] => $this->getLat(),
            $keys[5] => $this->getLng(),
            $keys[6] => $this->getAlt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collUbaO3s) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ubaO3s';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'uba_o3_smws';
                        break;
                    default:
                        $key = 'UbaO3s';
                }

                $result[$key] = $this->collUbaO3s->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUbaSO2s) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ubaSO2s';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'uba_so2_smws';
                        break;
                    default:
                        $key = 'UbaSO2s';
                }

                $result[$key] = $this->collUbaSO2s->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUbaPM10s) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ubaPM10s';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'uba_pm10_smws';
                        break;
                    default:
                        $key = 'UbaPM10s';
                }

                $result[$key] = $this->collUbaPM10s->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUbaNO2s) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ubaNO2s';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'uba_no2_smws';
                        break;
                    default:
                        $key = 'UbaNO2s';
                }

                $result[$key] = $this->collUbaNO2s->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUbaCos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ubaCos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'uba_co_8smws';
                        break;
                    default:
                        $key = 'UbaCos';
                }

                $result[$key] = $this->collUbaCos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\UbaStation
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UbaStationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\UbaStation
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setCode($value);
                break;
            case 3:
                $this->setNetwork($value);
                break;
            case 4:
                $this->setLat($value);
                break;
            case 5:
                $this->setLng($value);
                break;
            case 6:
                $this->setAlt($value);
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
        $keys = UbaStationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCode($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNetwork($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLat($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLng($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAlt($arr[$keys[6]]);
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
     * @return $this|\UbaStation The current object, for fluid interface
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
        $criteria = new Criteria(UbaStationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UbaStationTableMap::COL_ID)) {
            $criteria->add(UbaStationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_NAME)) {
            $criteria->add(UbaStationTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_CODE)) {
            $criteria->add(UbaStationTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_NETWORK)) {
            $criteria->add(UbaStationTableMap::COL_NETWORK, $this->network);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_LAT)) {
            $criteria->add(UbaStationTableMap::COL_LAT, $this->lat);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_LNG)) {
            $criteria->add(UbaStationTableMap::COL_LNG, $this->lng);
        }
        if ($this->isColumnModified(UbaStationTableMap::COL_ALT)) {
            $criteria->add(UbaStationTableMap::COL_ALT, $this->alt);
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
        $criteria = ChildUbaStationQuery::create();
        $criteria->add(UbaStationTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \UbaStation (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
        $copyObj->setNetwork($this->getNetwork());
        $copyObj->setLat($this->getLat());
        $copyObj->setLng($this->getLng());
        $copyObj->setAlt($this->getAlt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getUbaO3s() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUbaO3($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUbaSO2s() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUbaSO2($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUbaPM10s() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUbaPM10($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUbaNO2s() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUbaNO2($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUbaCos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUbaCO($relObj->copy($deepCopy));
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
     * @return \UbaStation Clone of current object.
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
        if ('UbaO3' == $relationName) {
            $this->initUbaO3s();
            return;
        }
        if ('UbaSO2' == $relationName) {
            $this->initUbaSO2s();
            return;
        }
        if ('UbaPM10' == $relationName) {
            $this->initUbaPM10s();
            return;
        }
        if ('UbaNO2' == $relationName) {
            $this->initUbaNO2s();
            return;
        }
        if ('UbaCO' == $relationName) {
            $this->initUbaCos();
            return;
        }
    }

    /**
     * Clears out the collUbaO3s collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUbaO3s()
     */
    public function clearUbaO3s()
    {
        $this->collUbaO3s = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUbaO3s collection loaded partially.
     */
    public function resetPartialUbaO3s($v = true)
    {
        $this->collUbaO3sPartial = $v;
    }

    /**
     * Initializes the collUbaO3s collection.
     *
     * By default this just sets the collUbaO3s collection to an empty array (like clearcollUbaO3s());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUbaO3s($overrideExisting = true)
    {
        if (null !== $this->collUbaO3s && !$overrideExisting) {
            return;
        }

        $collectionClassName = UbaO3TableMap::getTableMap()->getCollectionClassName();

        $this->collUbaO3s = new $collectionClassName;
        $this->collUbaO3s->setModel('\UbaO3');
    }

    /**
     * Gets an array of ChildUbaO3 objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUbaStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUbaO3[] List of ChildUbaO3 objects
     * @throws PropelException
     */
    public function getUbaO3s(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaO3sPartial && !$this->isNew();
        if (null === $this->collUbaO3s || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUbaO3s) {
                // return empty collection
                $this->initUbaO3s();
            } else {
                $collUbaO3s = ChildUbaO3Query::create(null, $criteria)
                    ->filterByUbaStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUbaO3sPartial && count($collUbaO3s)) {
                        $this->initUbaO3s(false);

                        foreach ($collUbaO3s as $obj) {
                            if (false == $this->collUbaO3s->contains($obj)) {
                                $this->collUbaO3s->append($obj);
                            }
                        }

                        $this->collUbaO3sPartial = true;
                    }

                    return $collUbaO3s;
                }

                if ($partial && $this->collUbaO3s) {
                    foreach ($this->collUbaO3s as $obj) {
                        if ($obj->isNew()) {
                            $collUbaO3s[] = $obj;
                        }
                    }
                }

                $this->collUbaO3s = $collUbaO3s;
                $this->collUbaO3sPartial = false;
            }
        }

        return $this->collUbaO3s;
    }

    /**
     * Sets a collection of ChildUbaO3 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ubaO3s A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function setUbaO3s(Collection $ubaO3s, ConnectionInterface $con = null)
    {
        /** @var ChildUbaO3[] $ubaO3sToDelete */
        $ubaO3sToDelete = $this->getUbaO3s(new Criteria(), $con)->diff($ubaO3s);


        $this->ubaO3sScheduledForDeletion = $ubaO3sToDelete;

        foreach ($ubaO3sToDelete as $ubaO3Removed) {
            $ubaO3Removed->setUbaStation(null);
        }

        $this->collUbaO3s = null;
        foreach ($ubaO3s as $ubaO3) {
            $this->addUbaO3($ubaO3);
        }

        $this->collUbaO3s = $ubaO3s;
        $this->collUbaO3sPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UbaO3 objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UbaO3 objects.
     * @throws PropelException
     */
    public function countUbaO3s(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaO3sPartial && !$this->isNew();
        if (null === $this->collUbaO3s || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUbaO3s) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUbaO3s());
            }

            $query = ChildUbaO3Query::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUbaStation($this)
                ->count($con);
        }

        return count($this->collUbaO3s);
    }

    /**
     * Method called to associate a ChildUbaO3 object to this object
     * through the ChildUbaO3 foreign key attribute.
     *
     * @param  ChildUbaO3 $l ChildUbaO3
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function addUbaO3(ChildUbaO3 $l)
    {
        if ($this->collUbaO3s === null) {
            $this->initUbaO3s();
            $this->collUbaO3sPartial = true;
        }

        if (!$this->collUbaO3s->contains($l)) {
            $this->doAddUbaO3($l);

            if ($this->ubaO3sScheduledForDeletion and $this->ubaO3sScheduledForDeletion->contains($l)) {
                $this->ubaO3sScheduledForDeletion->remove($this->ubaO3sScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUbaO3 $ubaO3 The ChildUbaO3 object to add.
     */
    protected function doAddUbaO3(ChildUbaO3 $ubaO3)
    {
        $this->collUbaO3s[]= $ubaO3;
        $ubaO3->setUbaStation($this);
    }

    /**
     * @param  ChildUbaO3 $ubaO3 The ChildUbaO3 object to remove.
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function removeUbaO3(ChildUbaO3 $ubaO3)
    {
        if ($this->getUbaO3s()->contains($ubaO3)) {
            $pos = $this->collUbaO3s->search($ubaO3);
            $this->collUbaO3s->remove($pos);
            if (null === $this->ubaO3sScheduledForDeletion) {
                $this->ubaO3sScheduledForDeletion = clone $this->collUbaO3s;
                $this->ubaO3sScheduledForDeletion->clear();
            }
            $this->ubaO3sScheduledForDeletion[]= clone $ubaO3;
            $ubaO3->setUbaStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collUbaSO2s collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUbaSO2s()
     */
    public function clearUbaSO2s()
    {
        $this->collUbaSO2s = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUbaSO2s collection loaded partially.
     */
    public function resetPartialUbaSO2s($v = true)
    {
        $this->collUbaSO2sPartial = $v;
    }

    /**
     * Initializes the collUbaSO2s collection.
     *
     * By default this just sets the collUbaSO2s collection to an empty array (like clearcollUbaSO2s());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUbaSO2s($overrideExisting = true)
    {
        if (null !== $this->collUbaSO2s && !$overrideExisting) {
            return;
        }

        $collectionClassName = UbaSO2TableMap::getTableMap()->getCollectionClassName();

        $this->collUbaSO2s = new $collectionClassName;
        $this->collUbaSO2s->setModel('\UbaSO2');
    }

    /**
     * Gets an array of ChildUbaSO2 objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUbaStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUbaSO2[] List of ChildUbaSO2 objects
     * @throws PropelException
     */
    public function getUbaSO2s(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaSO2sPartial && !$this->isNew();
        if (null === $this->collUbaSO2s || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUbaSO2s) {
                // return empty collection
                $this->initUbaSO2s();
            } else {
                $collUbaSO2s = ChildUbaSO2Query::create(null, $criteria)
                    ->filterByUbaStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUbaSO2sPartial && count($collUbaSO2s)) {
                        $this->initUbaSO2s(false);

                        foreach ($collUbaSO2s as $obj) {
                            if (false == $this->collUbaSO2s->contains($obj)) {
                                $this->collUbaSO2s->append($obj);
                            }
                        }

                        $this->collUbaSO2sPartial = true;
                    }

                    return $collUbaSO2s;
                }

                if ($partial && $this->collUbaSO2s) {
                    foreach ($this->collUbaSO2s as $obj) {
                        if ($obj->isNew()) {
                            $collUbaSO2s[] = $obj;
                        }
                    }
                }

                $this->collUbaSO2s = $collUbaSO2s;
                $this->collUbaSO2sPartial = false;
            }
        }

        return $this->collUbaSO2s;
    }

    /**
     * Sets a collection of ChildUbaSO2 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ubaSO2s A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function setUbaSO2s(Collection $ubaSO2s, ConnectionInterface $con = null)
    {
        /** @var ChildUbaSO2[] $ubaSO2sToDelete */
        $ubaSO2sToDelete = $this->getUbaSO2s(new Criteria(), $con)->diff($ubaSO2s);


        $this->ubaSO2sScheduledForDeletion = $ubaSO2sToDelete;

        foreach ($ubaSO2sToDelete as $ubaSO2Removed) {
            $ubaSO2Removed->setUbaStation(null);
        }

        $this->collUbaSO2s = null;
        foreach ($ubaSO2s as $ubaSO2) {
            $this->addUbaSO2($ubaSO2);
        }

        $this->collUbaSO2s = $ubaSO2s;
        $this->collUbaSO2sPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UbaSO2 objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UbaSO2 objects.
     * @throws PropelException
     */
    public function countUbaSO2s(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaSO2sPartial && !$this->isNew();
        if (null === $this->collUbaSO2s || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUbaSO2s) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUbaSO2s());
            }

            $query = ChildUbaSO2Query::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUbaStation($this)
                ->count($con);
        }

        return count($this->collUbaSO2s);
    }

    /**
     * Method called to associate a ChildUbaSO2 object to this object
     * through the ChildUbaSO2 foreign key attribute.
     *
     * @param  ChildUbaSO2 $l ChildUbaSO2
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function addUbaSO2(ChildUbaSO2 $l)
    {
        if ($this->collUbaSO2s === null) {
            $this->initUbaSO2s();
            $this->collUbaSO2sPartial = true;
        }

        if (!$this->collUbaSO2s->contains($l)) {
            $this->doAddUbaSO2($l);

            if ($this->ubaSO2sScheduledForDeletion and $this->ubaSO2sScheduledForDeletion->contains($l)) {
                $this->ubaSO2sScheduledForDeletion->remove($this->ubaSO2sScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUbaSO2 $ubaSO2 The ChildUbaSO2 object to add.
     */
    protected function doAddUbaSO2(ChildUbaSO2 $ubaSO2)
    {
        $this->collUbaSO2s[]= $ubaSO2;
        $ubaSO2->setUbaStation($this);
    }

    /**
     * @param  ChildUbaSO2 $ubaSO2 The ChildUbaSO2 object to remove.
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function removeUbaSO2(ChildUbaSO2 $ubaSO2)
    {
        if ($this->getUbaSO2s()->contains($ubaSO2)) {
            $pos = $this->collUbaSO2s->search($ubaSO2);
            $this->collUbaSO2s->remove($pos);
            if (null === $this->ubaSO2sScheduledForDeletion) {
                $this->ubaSO2sScheduledForDeletion = clone $this->collUbaSO2s;
                $this->ubaSO2sScheduledForDeletion->clear();
            }
            $this->ubaSO2sScheduledForDeletion[]= clone $ubaSO2;
            $ubaSO2->setUbaStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collUbaPM10s collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUbaPM10s()
     */
    public function clearUbaPM10s()
    {
        $this->collUbaPM10s = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUbaPM10s collection loaded partially.
     */
    public function resetPartialUbaPM10s($v = true)
    {
        $this->collUbaPM10sPartial = $v;
    }

    /**
     * Initializes the collUbaPM10s collection.
     *
     * By default this just sets the collUbaPM10s collection to an empty array (like clearcollUbaPM10s());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUbaPM10s($overrideExisting = true)
    {
        if (null !== $this->collUbaPM10s && !$overrideExisting) {
            return;
        }

        $collectionClassName = UbaPM10TableMap::getTableMap()->getCollectionClassName();

        $this->collUbaPM10s = new $collectionClassName;
        $this->collUbaPM10s->setModel('\UbaPM10');
    }

    /**
     * Gets an array of ChildUbaPM10 objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUbaStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUbaPM10[] List of ChildUbaPM10 objects
     * @throws PropelException
     */
    public function getUbaPM10s(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaPM10sPartial && !$this->isNew();
        if (null === $this->collUbaPM10s || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUbaPM10s) {
                // return empty collection
                $this->initUbaPM10s();
            } else {
                $collUbaPM10s = ChildUbaPM10Query::create(null, $criteria)
                    ->filterByUbaStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUbaPM10sPartial && count($collUbaPM10s)) {
                        $this->initUbaPM10s(false);

                        foreach ($collUbaPM10s as $obj) {
                            if (false == $this->collUbaPM10s->contains($obj)) {
                                $this->collUbaPM10s->append($obj);
                            }
                        }

                        $this->collUbaPM10sPartial = true;
                    }

                    return $collUbaPM10s;
                }

                if ($partial && $this->collUbaPM10s) {
                    foreach ($this->collUbaPM10s as $obj) {
                        if ($obj->isNew()) {
                            $collUbaPM10s[] = $obj;
                        }
                    }
                }

                $this->collUbaPM10s = $collUbaPM10s;
                $this->collUbaPM10sPartial = false;
            }
        }

        return $this->collUbaPM10s;
    }

    /**
     * Sets a collection of ChildUbaPM10 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ubaPM10s A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function setUbaPM10s(Collection $ubaPM10s, ConnectionInterface $con = null)
    {
        /** @var ChildUbaPM10[] $ubaPM10sToDelete */
        $ubaPM10sToDelete = $this->getUbaPM10s(new Criteria(), $con)->diff($ubaPM10s);


        $this->ubaPM10sScheduledForDeletion = $ubaPM10sToDelete;

        foreach ($ubaPM10sToDelete as $ubaPM10Removed) {
            $ubaPM10Removed->setUbaStation(null);
        }

        $this->collUbaPM10s = null;
        foreach ($ubaPM10s as $ubaPM10) {
            $this->addUbaPM10($ubaPM10);
        }

        $this->collUbaPM10s = $ubaPM10s;
        $this->collUbaPM10sPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UbaPM10 objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UbaPM10 objects.
     * @throws PropelException
     */
    public function countUbaPM10s(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaPM10sPartial && !$this->isNew();
        if (null === $this->collUbaPM10s || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUbaPM10s) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUbaPM10s());
            }

            $query = ChildUbaPM10Query::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUbaStation($this)
                ->count($con);
        }

        return count($this->collUbaPM10s);
    }

    /**
     * Method called to associate a ChildUbaPM10 object to this object
     * through the ChildUbaPM10 foreign key attribute.
     *
     * @param  ChildUbaPM10 $l ChildUbaPM10
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function addUbaPM10(ChildUbaPM10 $l)
    {
        if ($this->collUbaPM10s === null) {
            $this->initUbaPM10s();
            $this->collUbaPM10sPartial = true;
        }

        if (!$this->collUbaPM10s->contains($l)) {
            $this->doAddUbaPM10($l);

            if ($this->ubaPM10sScheduledForDeletion and $this->ubaPM10sScheduledForDeletion->contains($l)) {
                $this->ubaPM10sScheduledForDeletion->remove($this->ubaPM10sScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUbaPM10 $ubaPM10 The ChildUbaPM10 object to add.
     */
    protected function doAddUbaPM10(ChildUbaPM10 $ubaPM10)
    {
        $this->collUbaPM10s[]= $ubaPM10;
        $ubaPM10->setUbaStation($this);
    }

    /**
     * @param  ChildUbaPM10 $ubaPM10 The ChildUbaPM10 object to remove.
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function removeUbaPM10(ChildUbaPM10 $ubaPM10)
    {
        if ($this->getUbaPM10s()->contains($ubaPM10)) {
            $pos = $this->collUbaPM10s->search($ubaPM10);
            $this->collUbaPM10s->remove($pos);
            if (null === $this->ubaPM10sScheduledForDeletion) {
                $this->ubaPM10sScheduledForDeletion = clone $this->collUbaPM10s;
                $this->ubaPM10sScheduledForDeletion->clear();
            }
            $this->ubaPM10sScheduledForDeletion[]= clone $ubaPM10;
            $ubaPM10->setUbaStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collUbaNO2s collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUbaNO2s()
     */
    public function clearUbaNO2s()
    {
        $this->collUbaNO2s = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUbaNO2s collection loaded partially.
     */
    public function resetPartialUbaNO2s($v = true)
    {
        $this->collUbaNO2sPartial = $v;
    }

    /**
     * Initializes the collUbaNO2s collection.
     *
     * By default this just sets the collUbaNO2s collection to an empty array (like clearcollUbaNO2s());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUbaNO2s($overrideExisting = true)
    {
        if (null !== $this->collUbaNO2s && !$overrideExisting) {
            return;
        }

        $collectionClassName = UbaNO2TableMap::getTableMap()->getCollectionClassName();

        $this->collUbaNO2s = new $collectionClassName;
        $this->collUbaNO2s->setModel('\UbaNO2');
    }

    /**
     * Gets an array of ChildUbaNO2 objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUbaStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUbaNO2[] List of ChildUbaNO2 objects
     * @throws PropelException
     */
    public function getUbaNO2s(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaNO2sPartial && !$this->isNew();
        if (null === $this->collUbaNO2s || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUbaNO2s) {
                // return empty collection
                $this->initUbaNO2s();
            } else {
                $collUbaNO2s = ChildUbaNO2Query::create(null, $criteria)
                    ->filterByUbaStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUbaNO2sPartial && count($collUbaNO2s)) {
                        $this->initUbaNO2s(false);

                        foreach ($collUbaNO2s as $obj) {
                            if (false == $this->collUbaNO2s->contains($obj)) {
                                $this->collUbaNO2s->append($obj);
                            }
                        }

                        $this->collUbaNO2sPartial = true;
                    }

                    return $collUbaNO2s;
                }

                if ($partial && $this->collUbaNO2s) {
                    foreach ($this->collUbaNO2s as $obj) {
                        if ($obj->isNew()) {
                            $collUbaNO2s[] = $obj;
                        }
                    }
                }

                $this->collUbaNO2s = $collUbaNO2s;
                $this->collUbaNO2sPartial = false;
            }
        }

        return $this->collUbaNO2s;
    }

    /**
     * Sets a collection of ChildUbaNO2 objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ubaNO2s A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function setUbaNO2s(Collection $ubaNO2s, ConnectionInterface $con = null)
    {
        /** @var ChildUbaNO2[] $ubaNO2sToDelete */
        $ubaNO2sToDelete = $this->getUbaNO2s(new Criteria(), $con)->diff($ubaNO2s);


        $this->ubaNO2sScheduledForDeletion = $ubaNO2sToDelete;

        foreach ($ubaNO2sToDelete as $ubaNO2Removed) {
            $ubaNO2Removed->setUbaStation(null);
        }

        $this->collUbaNO2s = null;
        foreach ($ubaNO2s as $ubaNO2) {
            $this->addUbaNO2($ubaNO2);
        }

        $this->collUbaNO2s = $ubaNO2s;
        $this->collUbaNO2sPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UbaNO2 objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UbaNO2 objects.
     * @throws PropelException
     */
    public function countUbaNO2s(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaNO2sPartial && !$this->isNew();
        if (null === $this->collUbaNO2s || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUbaNO2s) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUbaNO2s());
            }

            $query = ChildUbaNO2Query::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUbaStation($this)
                ->count($con);
        }

        return count($this->collUbaNO2s);
    }

    /**
     * Method called to associate a ChildUbaNO2 object to this object
     * through the ChildUbaNO2 foreign key attribute.
     *
     * @param  ChildUbaNO2 $l ChildUbaNO2
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function addUbaNO2(ChildUbaNO2 $l)
    {
        if ($this->collUbaNO2s === null) {
            $this->initUbaNO2s();
            $this->collUbaNO2sPartial = true;
        }

        if (!$this->collUbaNO2s->contains($l)) {
            $this->doAddUbaNO2($l);

            if ($this->ubaNO2sScheduledForDeletion and $this->ubaNO2sScheduledForDeletion->contains($l)) {
                $this->ubaNO2sScheduledForDeletion->remove($this->ubaNO2sScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUbaNO2 $ubaNO2 The ChildUbaNO2 object to add.
     */
    protected function doAddUbaNO2(ChildUbaNO2 $ubaNO2)
    {
        $this->collUbaNO2s[]= $ubaNO2;
        $ubaNO2->setUbaStation($this);
    }

    /**
     * @param  ChildUbaNO2 $ubaNO2 The ChildUbaNO2 object to remove.
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function removeUbaNO2(ChildUbaNO2 $ubaNO2)
    {
        if ($this->getUbaNO2s()->contains($ubaNO2)) {
            $pos = $this->collUbaNO2s->search($ubaNO2);
            $this->collUbaNO2s->remove($pos);
            if (null === $this->ubaNO2sScheduledForDeletion) {
                $this->ubaNO2sScheduledForDeletion = clone $this->collUbaNO2s;
                $this->ubaNO2sScheduledForDeletion->clear();
            }
            $this->ubaNO2sScheduledForDeletion[]= clone $ubaNO2;
            $ubaNO2->setUbaStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collUbaCos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUbaCos()
     */
    public function clearUbaCos()
    {
        $this->collUbaCos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUbaCos collection loaded partially.
     */
    public function resetPartialUbaCos($v = true)
    {
        $this->collUbaCosPartial = $v;
    }

    /**
     * Initializes the collUbaCos collection.
     *
     * By default this just sets the collUbaCos collection to an empty array (like clearcollUbaCos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUbaCos($overrideExisting = true)
    {
        if (null !== $this->collUbaCos && !$overrideExisting) {
            return;
        }

        $collectionClassName = UbaCOTableMap::getTableMap()->getCollectionClassName();

        $this->collUbaCos = new $collectionClassName;
        $this->collUbaCos->setModel('\UbaCO');
    }

    /**
     * Gets an array of ChildUbaCO objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUbaStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUbaCO[] List of ChildUbaCO objects
     * @throws PropelException
     */
    public function getUbaCos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaCosPartial && !$this->isNew();
        if (null === $this->collUbaCos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUbaCos) {
                // return empty collection
                $this->initUbaCos();
            } else {
                $collUbaCos = ChildUbaCOQuery::create(null, $criteria)
                    ->filterByUbaStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUbaCosPartial && count($collUbaCos)) {
                        $this->initUbaCos(false);

                        foreach ($collUbaCos as $obj) {
                            if (false == $this->collUbaCos->contains($obj)) {
                                $this->collUbaCos->append($obj);
                            }
                        }

                        $this->collUbaCosPartial = true;
                    }

                    return $collUbaCos;
                }

                if ($partial && $this->collUbaCos) {
                    foreach ($this->collUbaCos as $obj) {
                        if ($obj->isNew()) {
                            $collUbaCos[] = $obj;
                        }
                    }
                }

                $this->collUbaCos = $collUbaCos;
                $this->collUbaCosPartial = false;
            }
        }

        return $this->collUbaCos;
    }

    /**
     * Sets a collection of ChildUbaCO objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ubaCos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function setUbaCos(Collection $ubaCos, ConnectionInterface $con = null)
    {
        /** @var ChildUbaCO[] $ubaCosToDelete */
        $ubaCosToDelete = $this->getUbaCos(new Criteria(), $con)->diff($ubaCos);


        $this->ubaCosScheduledForDeletion = $ubaCosToDelete;

        foreach ($ubaCosToDelete as $ubaCORemoved) {
            $ubaCORemoved->setUbaStation(null);
        }

        $this->collUbaCos = null;
        foreach ($ubaCos as $ubaCO) {
            $this->addUbaCO($ubaCO);
        }

        $this->collUbaCos = $ubaCos;
        $this->collUbaCosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UbaCO objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UbaCO objects.
     * @throws PropelException
     */
    public function countUbaCos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUbaCosPartial && !$this->isNew();
        if (null === $this->collUbaCos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUbaCos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUbaCos());
            }

            $query = ChildUbaCOQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUbaStation($this)
                ->count($con);
        }

        return count($this->collUbaCos);
    }

    /**
     * Method called to associate a ChildUbaCO object to this object
     * through the ChildUbaCO foreign key attribute.
     *
     * @param  ChildUbaCO $l ChildUbaCO
     * @return $this|\UbaStation The current object (for fluent API support)
     */
    public function addUbaCO(ChildUbaCO $l)
    {
        if ($this->collUbaCos === null) {
            $this->initUbaCos();
            $this->collUbaCosPartial = true;
        }

        if (!$this->collUbaCos->contains($l)) {
            $this->doAddUbaCO($l);

            if ($this->ubaCosScheduledForDeletion and $this->ubaCosScheduledForDeletion->contains($l)) {
                $this->ubaCosScheduledForDeletion->remove($this->ubaCosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUbaCO $ubaCO The ChildUbaCO object to add.
     */
    protected function doAddUbaCO(ChildUbaCO $ubaCO)
    {
        $this->collUbaCos[]= $ubaCO;
        $ubaCO->setUbaStation($this);
    }

    /**
     * @param  ChildUbaCO $ubaCO The ChildUbaCO object to remove.
     * @return $this|ChildUbaStation The current object (for fluent API support)
     */
    public function removeUbaCO(ChildUbaCO $ubaCO)
    {
        if ($this->getUbaCos()->contains($ubaCO)) {
            $pos = $this->collUbaCos->search($ubaCO);
            $this->collUbaCos->remove($pos);
            if (null === $this->ubaCosScheduledForDeletion) {
                $this->ubaCosScheduledForDeletion = clone $this->collUbaCos;
                $this->ubaCosScheduledForDeletion->clear();
            }
            $this->ubaCosScheduledForDeletion[]= clone $ubaCO;
            $ubaCO->setUbaStation(null);
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
        $this->name = null;
        $this->code = null;
        $this->network = null;
        $this->lat = null;
        $this->lng = null;
        $this->alt = null;
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
            if ($this->collUbaO3s) {
                foreach ($this->collUbaO3s as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUbaSO2s) {
                foreach ($this->collUbaSO2s as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUbaPM10s) {
                foreach ($this->collUbaPM10s as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUbaNO2s) {
                foreach ($this->collUbaNO2s as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUbaCos) {
                foreach ($this->collUbaCos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collUbaO3s = null;
        $this->collUbaSO2s = null;
        $this->collUbaPM10s = null;
        $this->collUbaNO2s = null;
        $this->collUbaCos = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UbaStationTableMap::DEFAULT_STRING_FORMAT);
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
