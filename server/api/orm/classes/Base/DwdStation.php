<?php

namespace Base;

use \DwdAirTemperature as ChildDwdAirTemperature;
use \DwdAirTemperatureQuery as ChildDwdAirTemperatureQuery;
use \DwdCloudines as ChildDwdCloudines;
use \DwdCloudinesQuery as ChildDwdCloudinesQuery;
use \DwdPrecipitation as ChildDwdPrecipitation;
use \DwdPrecipitationQuery as ChildDwdPrecipitationQuery;
use \DwdPressure as ChildDwdPressure;
use \DwdPressureQuery as ChildDwdPressureQuery;
use \DwdSoilTemperature as ChildDwdSoilTemperature;
use \DwdSoilTemperatureQuery as ChildDwdSoilTemperatureQuery;
use \DwdSolar as ChildDwdSolar;
use \DwdSolarQuery as ChildDwdSolarQuery;
use \DwdStation as ChildDwdStation;
use \DwdStationQuery as ChildDwdStationQuery;
use \DwdSun as ChildDwdSun;
use \DwdSunQuery as ChildDwdSunQuery;
use \DwdWind as ChildDwdWind;
use \DwdWindQuery as ChildDwdWindQuery;
use \Exception;
use \PDO;
use Map\DwdAirTemperatureTableMap;
use Map\DwdCloudinesTableMap;
use Map\DwdPrecipitationTableMap;
use Map\DwdPressureTableMap;
use Map\DwdSoilTemperatureTableMap;
use Map\DwdSolarTableMap;
use Map\DwdStationTableMap;
use Map\DwdSunTableMap;
use Map\DwdWindTableMap;
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
 * Base class that represents a row from the 'dwd_station' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class DwdStation implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\DwdStationTableMap';


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
     * @var        ObjectCollection|ChildDwdAirTemperature[] Collection to store aggregation of ChildDwdAirTemperature objects.
     */
    protected $collDwdAirTemperatures;
    protected $collDwdAirTemperaturesPartial;

    /**
     * @var        ObjectCollection|ChildDwdCloudines[] Collection to store aggregation of ChildDwdCloudines objects.
     */
    protected $collDwdCloudiness;
    protected $collDwdCloudinessPartial;

    /**
     * @var        ObjectCollection|ChildDwdPrecipitation[] Collection to store aggregation of ChildDwdPrecipitation objects.
     */
    protected $collDwdPrecipitations;
    protected $collDwdPrecipitationsPartial;

    /**
     * @var        ObjectCollection|ChildDwdPressure[] Collection to store aggregation of ChildDwdPressure objects.
     */
    protected $collDwdPressures;
    protected $collDwdPressuresPartial;

    /**
     * @var        ObjectCollection|ChildDwdSoilTemperature[] Collection to store aggregation of ChildDwdSoilTemperature objects.
     */
    protected $collDwdSoilTemperatures;
    protected $collDwdSoilTemperaturesPartial;

    /**
     * @var        ObjectCollection|ChildDwdSolar[] Collection to store aggregation of ChildDwdSolar objects.
     */
    protected $collDwdSolars;
    protected $collDwdSolarsPartial;

    /**
     * @var        ObjectCollection|ChildDwdSun[] Collection to store aggregation of ChildDwdSun objects.
     */
    protected $collDwdSuns;
    protected $collDwdSunsPartial;

    /**
     * @var        ObjectCollection|ChildDwdWind[] Collection to store aggregation of ChildDwdWind objects.
     */
    protected $collDwdWinds;
    protected $collDwdWindsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdAirTemperature[]
     */
    protected $dwdAirTemperaturesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdCloudines[]
     */
    protected $dwdCloudinessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdPrecipitation[]
     */
    protected $dwdPrecipitationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdPressure[]
     */
    protected $dwdPressuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdSoilTemperature[]
     */
    protected $dwdSoilTemperaturesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdSolar[]
     */
    protected $dwdSolarsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdSun[]
     */
    protected $dwdSunsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDwdWind[]
     */
    protected $dwdWindsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\DwdStation object.
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
     * Compares this with another <code>DwdStation</code> instance.  If
     * <code>obj</code> is an instance of <code>DwdStation</code>, delegates to
     * <code>equals(DwdStation)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|DwdStation The current object, for fluid interface
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
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DwdStationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[DwdStationTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [lat] column.
     *
     * @param double $v new value
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[DwdStationTableMap::COL_LAT] = true;
        }

        return $this;
    } // setLat()

    /**
     * Set the value of [lng] column.
     *
     * @param double $v new value
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[DwdStationTableMap::COL_LNG] = true;
        }

        return $this;
    } // setLng()

    /**
     * Set the value of [alt] column.
     *
     * @param double $v new value
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function setAlt($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->alt !== $v) {
            $this->alt = $v;
            $this->modifiedColumns[DwdStationTableMap::COL_ALT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DwdStationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DwdStationTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DwdStationTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DwdStationTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DwdStationTableMap::translateFieldName('Alt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->alt = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = DwdStationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DwdStation'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(DwdStationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDwdStationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDwdAirTemperatures = null;

            $this->collDwdCloudiness = null;

            $this->collDwdPrecipitations = null;

            $this->collDwdPressures = null;

            $this->collDwdSoilTemperatures = null;

            $this->collDwdSolars = null;

            $this->collDwdSuns = null;

            $this->collDwdWinds = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see DwdStation::setDeleted()
     * @see DwdStation::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdStationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDwdStationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdStationTableMap::DATABASE_NAME);
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
                DwdStationTableMap::addInstanceToPool($this);
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

            if ($this->dwdAirTemperaturesScheduledForDeletion !== null) {
                if (!$this->dwdAirTemperaturesScheduledForDeletion->isEmpty()) {
                    \DwdAirTemperatureQuery::create()
                        ->filterByPrimaryKeys($this->dwdAirTemperaturesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdAirTemperaturesScheduledForDeletion = null;
                }
            }

            if ($this->collDwdAirTemperatures !== null) {
                foreach ($this->collDwdAirTemperatures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdCloudinessScheduledForDeletion !== null) {
                if (!$this->dwdCloudinessScheduledForDeletion->isEmpty()) {
                    \DwdCloudinesQuery::create()
                        ->filterByPrimaryKeys($this->dwdCloudinessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdCloudinessScheduledForDeletion = null;
                }
            }

            if ($this->collDwdCloudiness !== null) {
                foreach ($this->collDwdCloudiness as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdPrecipitationsScheduledForDeletion !== null) {
                if (!$this->dwdPrecipitationsScheduledForDeletion->isEmpty()) {
                    \DwdPrecipitationQuery::create()
                        ->filterByPrimaryKeys($this->dwdPrecipitationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdPrecipitationsScheduledForDeletion = null;
                }
            }

            if ($this->collDwdPrecipitations !== null) {
                foreach ($this->collDwdPrecipitations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdPressuresScheduledForDeletion !== null) {
                if (!$this->dwdPressuresScheduledForDeletion->isEmpty()) {
                    \DwdPressureQuery::create()
                        ->filterByPrimaryKeys($this->dwdPressuresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdPressuresScheduledForDeletion = null;
                }
            }

            if ($this->collDwdPressures !== null) {
                foreach ($this->collDwdPressures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdSoilTemperaturesScheduledForDeletion !== null) {
                if (!$this->dwdSoilTemperaturesScheduledForDeletion->isEmpty()) {
                    \DwdSoilTemperatureQuery::create()
                        ->filterByPrimaryKeys($this->dwdSoilTemperaturesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdSoilTemperaturesScheduledForDeletion = null;
                }
            }

            if ($this->collDwdSoilTemperatures !== null) {
                foreach ($this->collDwdSoilTemperatures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdSolarsScheduledForDeletion !== null) {
                if (!$this->dwdSolarsScheduledForDeletion->isEmpty()) {
                    \DwdSolarQuery::create()
                        ->filterByPrimaryKeys($this->dwdSolarsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdSolarsScheduledForDeletion = null;
                }
            }

            if ($this->collDwdSolars !== null) {
                foreach ($this->collDwdSolars as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdSunsScheduledForDeletion !== null) {
                if (!$this->dwdSunsScheduledForDeletion->isEmpty()) {
                    \DwdSunQuery::create()
                        ->filterByPrimaryKeys($this->dwdSunsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdSunsScheduledForDeletion = null;
                }
            }

            if ($this->collDwdSuns !== null) {
                foreach ($this->collDwdSuns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dwdWindsScheduledForDeletion !== null) {
                if (!$this->dwdWindsScheduledForDeletion->isEmpty()) {
                    \DwdWindQuery::create()
                        ->filterByPrimaryKeys($this->dwdWindsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dwdWindsScheduledForDeletion = null;
                }
            }

            if ($this->collDwdWinds !== null) {
                foreach ($this->collDwdWinds as $referrerFK) {
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

        $this->modifiedColumns[DwdStationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DwdStationTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DwdStationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_LAT)) {
            $modifiedColumns[':p' . $index++]  = 'lat';
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_LNG)) {
            $modifiedColumns[':p' . $index++]  = 'lng';
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_ALT)) {
            $modifiedColumns[':p' . $index++]  = 'alt';
        }

        $sql = sprintf(
            'INSERT INTO dwd_station (%s) VALUES (%s)',
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
        $pos = DwdStationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getLat();
                break;
            case 3:
                return $this->getLng();
                break;
            case 4:
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

        if (isset($alreadyDumpedObjects['DwdStation'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['DwdStation'][$this->hashCode()] = true;
        $keys = DwdStationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getLat(),
            $keys[3] => $this->getLng(),
            $keys[4] => $this->getAlt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collDwdAirTemperatures) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdAirTemperatures';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_air_temperatures';
                        break;
                    default:
                        $key = 'DwdAirTemperatures';
                }

                $result[$key] = $this->collDwdAirTemperatures->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdCloudiness) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdCloudiness';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_cloudiness';
                        break;
                    default:
                        $key = 'DwdCloudiness';
                }

                $result[$key] = $this->collDwdCloudiness->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdPrecipitations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdPrecipitations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_precipitations';
                        break;
                    default:
                        $key = 'DwdPrecipitations';
                }

                $result[$key] = $this->collDwdPrecipitations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdPressures) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdPressures';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_pressures';
                        break;
                    default:
                        $key = 'DwdPressures';
                }

                $result[$key] = $this->collDwdPressures->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdSoilTemperatures) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdSoilTemperatures';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_soil_temperatures';
                        break;
                    default:
                        $key = 'DwdSoilTemperatures';
                }

                $result[$key] = $this->collDwdSoilTemperatures->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdSolars) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdSolars';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_solars';
                        break;
                    default:
                        $key = 'DwdSolars';
                }

                $result[$key] = $this->collDwdSolars->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdSuns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdSuns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_suns';
                        break;
                    default:
                        $key = 'DwdSuns';
                }

                $result[$key] = $this->collDwdSuns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDwdWinds) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dwdWinds';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dwd_winds';
                        break;
                    default:
                        $key = 'DwdWinds';
                }

                $result[$key] = $this->collDwdWinds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\DwdStation
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DwdStationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\DwdStation
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
                $this->setLat($value);
                break;
            case 3:
                $this->setLng($value);
                break;
            case 4:
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
        $keys = DwdStationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLat($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLng($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAlt($arr[$keys[4]]);
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
     * @return $this|\DwdStation The current object, for fluid interface
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
        $criteria = new Criteria(DwdStationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DwdStationTableMap::COL_ID)) {
            $criteria->add(DwdStationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_NAME)) {
            $criteria->add(DwdStationTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_LAT)) {
            $criteria->add(DwdStationTableMap::COL_LAT, $this->lat);
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_LNG)) {
            $criteria->add(DwdStationTableMap::COL_LNG, $this->lng);
        }
        if ($this->isColumnModified(DwdStationTableMap::COL_ALT)) {
            $criteria->add(DwdStationTableMap::COL_ALT, $this->alt);
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
        $criteria = ChildDwdStationQuery::create();
        $criteria->add(DwdStationTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \DwdStation (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setLat($this->getLat());
        $copyObj->setLng($this->getLng());
        $copyObj->setAlt($this->getAlt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDwdAirTemperatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdAirTemperature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdCloudiness() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdCloudines($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdPrecipitations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdPrecipitation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdPressures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdPressure($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdSoilTemperatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdSoilTemperature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdSolars() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdSolar($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdSuns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdSun($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDwdWinds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDwdWind($relObj->copy($deepCopy));
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
     * @return \DwdStation Clone of current object.
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
        if ('DwdAirTemperature' == $relationName) {
            $this->initDwdAirTemperatures();
            return;
        }
        if ('DwdCloudines' == $relationName) {
            $this->initDwdCloudiness();
            return;
        }
        if ('DwdPrecipitation' == $relationName) {
            $this->initDwdPrecipitations();
            return;
        }
        if ('DwdPressure' == $relationName) {
            $this->initDwdPressures();
            return;
        }
        if ('DwdSoilTemperature' == $relationName) {
            $this->initDwdSoilTemperatures();
            return;
        }
        if ('DwdSolar' == $relationName) {
            $this->initDwdSolars();
            return;
        }
        if ('DwdSun' == $relationName) {
            $this->initDwdSuns();
            return;
        }
        if ('DwdWind' == $relationName) {
            $this->initDwdWinds();
            return;
        }
    }

    /**
     * Clears out the collDwdAirTemperatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdAirTemperatures()
     */
    public function clearDwdAirTemperatures()
    {
        $this->collDwdAirTemperatures = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdAirTemperatures collection loaded partially.
     */
    public function resetPartialDwdAirTemperatures($v = true)
    {
        $this->collDwdAirTemperaturesPartial = $v;
    }

    /**
     * Initializes the collDwdAirTemperatures collection.
     *
     * By default this just sets the collDwdAirTemperatures collection to an empty array (like clearcollDwdAirTemperatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdAirTemperatures($overrideExisting = true)
    {
        if (null !== $this->collDwdAirTemperatures && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdAirTemperatureTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdAirTemperatures = new $collectionClassName;
        $this->collDwdAirTemperatures->setModel('\DwdAirTemperature');
    }

    /**
     * Gets an array of ChildDwdAirTemperature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdAirTemperature[] List of ChildDwdAirTemperature objects
     * @throws PropelException
     */
    public function getDwdAirTemperatures(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdAirTemperaturesPartial && !$this->isNew();
        if (null === $this->collDwdAirTemperatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdAirTemperatures) {
                // return empty collection
                $this->initDwdAirTemperatures();
            } else {
                $collDwdAirTemperatures = ChildDwdAirTemperatureQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdAirTemperaturesPartial && count($collDwdAirTemperatures)) {
                        $this->initDwdAirTemperatures(false);

                        foreach ($collDwdAirTemperatures as $obj) {
                            if (false == $this->collDwdAirTemperatures->contains($obj)) {
                                $this->collDwdAirTemperatures->append($obj);
                            }
                        }

                        $this->collDwdAirTemperaturesPartial = true;
                    }

                    return $collDwdAirTemperatures;
                }

                if ($partial && $this->collDwdAirTemperatures) {
                    foreach ($this->collDwdAirTemperatures as $obj) {
                        if ($obj->isNew()) {
                            $collDwdAirTemperatures[] = $obj;
                        }
                    }
                }

                $this->collDwdAirTemperatures = $collDwdAirTemperatures;
                $this->collDwdAirTemperaturesPartial = false;
            }
        }

        return $this->collDwdAirTemperatures;
    }

    /**
     * Sets a collection of ChildDwdAirTemperature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdAirTemperatures A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdAirTemperatures(Collection $dwdAirTemperatures, ConnectionInterface $con = null)
    {
        /** @var ChildDwdAirTemperature[] $dwdAirTemperaturesToDelete */
        $dwdAirTemperaturesToDelete = $this->getDwdAirTemperatures(new Criteria(), $con)->diff($dwdAirTemperatures);


        $this->dwdAirTemperaturesScheduledForDeletion = $dwdAirTemperaturesToDelete;

        foreach ($dwdAirTemperaturesToDelete as $dwdAirTemperatureRemoved) {
            $dwdAirTemperatureRemoved->setDwdStation(null);
        }

        $this->collDwdAirTemperatures = null;
        foreach ($dwdAirTemperatures as $dwdAirTemperature) {
            $this->addDwdAirTemperature($dwdAirTemperature);
        }

        $this->collDwdAirTemperatures = $dwdAirTemperatures;
        $this->collDwdAirTemperaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdAirTemperature objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdAirTemperature objects.
     * @throws PropelException
     */
    public function countDwdAirTemperatures(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdAirTemperaturesPartial && !$this->isNew();
        if (null === $this->collDwdAirTemperatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdAirTemperatures) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdAirTemperatures());
            }

            $query = ChildDwdAirTemperatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdAirTemperatures);
    }

    /**
     * Method called to associate a ChildDwdAirTemperature object to this object
     * through the ChildDwdAirTemperature foreign key attribute.
     *
     * @param  ChildDwdAirTemperature $l ChildDwdAirTemperature
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdAirTemperature(ChildDwdAirTemperature $l)
    {
        if ($this->collDwdAirTemperatures === null) {
            $this->initDwdAirTemperatures();
            $this->collDwdAirTemperaturesPartial = true;
        }

        if (!$this->collDwdAirTemperatures->contains($l)) {
            $this->doAddDwdAirTemperature($l);

            if ($this->dwdAirTemperaturesScheduledForDeletion and $this->dwdAirTemperaturesScheduledForDeletion->contains($l)) {
                $this->dwdAirTemperaturesScheduledForDeletion->remove($this->dwdAirTemperaturesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdAirTemperature $dwdAirTemperature The ChildDwdAirTemperature object to add.
     */
    protected function doAddDwdAirTemperature(ChildDwdAirTemperature $dwdAirTemperature)
    {
        $this->collDwdAirTemperatures[]= $dwdAirTemperature;
        $dwdAirTemperature->setDwdStation($this);
    }

    /**
     * @param  ChildDwdAirTemperature $dwdAirTemperature The ChildDwdAirTemperature object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdAirTemperature(ChildDwdAirTemperature $dwdAirTemperature)
    {
        if ($this->getDwdAirTemperatures()->contains($dwdAirTemperature)) {
            $pos = $this->collDwdAirTemperatures->search($dwdAirTemperature);
            $this->collDwdAirTemperatures->remove($pos);
            if (null === $this->dwdAirTemperaturesScheduledForDeletion) {
                $this->dwdAirTemperaturesScheduledForDeletion = clone $this->collDwdAirTemperatures;
                $this->dwdAirTemperaturesScheduledForDeletion->clear();
            }
            $this->dwdAirTemperaturesScheduledForDeletion[]= clone $dwdAirTemperature;
            $dwdAirTemperature->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdCloudiness collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdCloudiness()
     */
    public function clearDwdCloudiness()
    {
        $this->collDwdCloudiness = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdCloudiness collection loaded partially.
     */
    public function resetPartialDwdCloudiness($v = true)
    {
        $this->collDwdCloudinessPartial = $v;
    }

    /**
     * Initializes the collDwdCloudiness collection.
     *
     * By default this just sets the collDwdCloudiness collection to an empty array (like clearcollDwdCloudiness());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdCloudiness($overrideExisting = true)
    {
        if (null !== $this->collDwdCloudiness && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdCloudinesTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdCloudiness = new $collectionClassName;
        $this->collDwdCloudiness->setModel('\DwdCloudines');
    }

    /**
     * Gets an array of ChildDwdCloudines objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdCloudines[] List of ChildDwdCloudines objects
     * @throws PropelException
     */
    public function getDwdCloudiness(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdCloudinessPartial && !$this->isNew();
        if (null === $this->collDwdCloudiness || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdCloudiness) {
                // return empty collection
                $this->initDwdCloudiness();
            } else {
                $collDwdCloudiness = ChildDwdCloudinesQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdCloudinessPartial && count($collDwdCloudiness)) {
                        $this->initDwdCloudiness(false);

                        foreach ($collDwdCloudiness as $obj) {
                            if (false == $this->collDwdCloudiness->contains($obj)) {
                                $this->collDwdCloudiness->append($obj);
                            }
                        }

                        $this->collDwdCloudinessPartial = true;
                    }

                    return $collDwdCloudiness;
                }

                if ($partial && $this->collDwdCloudiness) {
                    foreach ($this->collDwdCloudiness as $obj) {
                        if ($obj->isNew()) {
                            $collDwdCloudiness[] = $obj;
                        }
                    }
                }

                $this->collDwdCloudiness = $collDwdCloudiness;
                $this->collDwdCloudinessPartial = false;
            }
        }

        return $this->collDwdCloudiness;
    }

    /**
     * Sets a collection of ChildDwdCloudines objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdCloudiness A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdCloudiness(Collection $dwdCloudiness, ConnectionInterface $con = null)
    {
        /** @var ChildDwdCloudines[] $dwdCloudinessToDelete */
        $dwdCloudinessToDelete = $this->getDwdCloudiness(new Criteria(), $con)->diff($dwdCloudiness);


        $this->dwdCloudinessScheduledForDeletion = $dwdCloudinessToDelete;

        foreach ($dwdCloudinessToDelete as $dwdCloudinesRemoved) {
            $dwdCloudinesRemoved->setDwdStation(null);
        }

        $this->collDwdCloudiness = null;
        foreach ($dwdCloudiness as $dwdCloudines) {
            $this->addDwdCloudines($dwdCloudines);
        }

        $this->collDwdCloudiness = $dwdCloudiness;
        $this->collDwdCloudinessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdCloudines objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdCloudines objects.
     * @throws PropelException
     */
    public function countDwdCloudiness(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdCloudinessPartial && !$this->isNew();
        if (null === $this->collDwdCloudiness || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdCloudiness) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdCloudiness());
            }

            $query = ChildDwdCloudinesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdCloudiness);
    }

    /**
     * Method called to associate a ChildDwdCloudines object to this object
     * through the ChildDwdCloudines foreign key attribute.
     *
     * @param  ChildDwdCloudines $l ChildDwdCloudines
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdCloudines(ChildDwdCloudines $l)
    {
        if ($this->collDwdCloudiness === null) {
            $this->initDwdCloudiness();
            $this->collDwdCloudinessPartial = true;
        }

        if (!$this->collDwdCloudiness->contains($l)) {
            $this->doAddDwdCloudines($l);

            if ($this->dwdCloudinessScheduledForDeletion and $this->dwdCloudinessScheduledForDeletion->contains($l)) {
                $this->dwdCloudinessScheduledForDeletion->remove($this->dwdCloudinessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdCloudines $dwdCloudines The ChildDwdCloudines object to add.
     */
    protected function doAddDwdCloudines(ChildDwdCloudines $dwdCloudines)
    {
        $this->collDwdCloudiness[]= $dwdCloudines;
        $dwdCloudines->setDwdStation($this);
    }

    /**
     * @param  ChildDwdCloudines $dwdCloudines The ChildDwdCloudines object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdCloudines(ChildDwdCloudines $dwdCloudines)
    {
        if ($this->getDwdCloudiness()->contains($dwdCloudines)) {
            $pos = $this->collDwdCloudiness->search($dwdCloudines);
            $this->collDwdCloudiness->remove($pos);
            if (null === $this->dwdCloudinessScheduledForDeletion) {
                $this->dwdCloudinessScheduledForDeletion = clone $this->collDwdCloudiness;
                $this->dwdCloudinessScheduledForDeletion->clear();
            }
            $this->dwdCloudinessScheduledForDeletion[]= clone $dwdCloudines;
            $dwdCloudines->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdPrecipitations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdPrecipitations()
     */
    public function clearDwdPrecipitations()
    {
        $this->collDwdPrecipitations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdPrecipitations collection loaded partially.
     */
    public function resetPartialDwdPrecipitations($v = true)
    {
        $this->collDwdPrecipitationsPartial = $v;
    }

    /**
     * Initializes the collDwdPrecipitations collection.
     *
     * By default this just sets the collDwdPrecipitations collection to an empty array (like clearcollDwdPrecipitations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdPrecipitations($overrideExisting = true)
    {
        if (null !== $this->collDwdPrecipitations && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdPrecipitationTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdPrecipitations = new $collectionClassName;
        $this->collDwdPrecipitations->setModel('\DwdPrecipitation');
    }

    /**
     * Gets an array of ChildDwdPrecipitation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdPrecipitation[] List of ChildDwdPrecipitation objects
     * @throws PropelException
     */
    public function getDwdPrecipitations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdPrecipitationsPartial && !$this->isNew();
        if (null === $this->collDwdPrecipitations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdPrecipitations) {
                // return empty collection
                $this->initDwdPrecipitations();
            } else {
                $collDwdPrecipitations = ChildDwdPrecipitationQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdPrecipitationsPartial && count($collDwdPrecipitations)) {
                        $this->initDwdPrecipitations(false);

                        foreach ($collDwdPrecipitations as $obj) {
                            if (false == $this->collDwdPrecipitations->contains($obj)) {
                                $this->collDwdPrecipitations->append($obj);
                            }
                        }

                        $this->collDwdPrecipitationsPartial = true;
                    }

                    return $collDwdPrecipitations;
                }

                if ($partial && $this->collDwdPrecipitations) {
                    foreach ($this->collDwdPrecipitations as $obj) {
                        if ($obj->isNew()) {
                            $collDwdPrecipitations[] = $obj;
                        }
                    }
                }

                $this->collDwdPrecipitations = $collDwdPrecipitations;
                $this->collDwdPrecipitationsPartial = false;
            }
        }

        return $this->collDwdPrecipitations;
    }

    /**
     * Sets a collection of ChildDwdPrecipitation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdPrecipitations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdPrecipitations(Collection $dwdPrecipitations, ConnectionInterface $con = null)
    {
        /** @var ChildDwdPrecipitation[] $dwdPrecipitationsToDelete */
        $dwdPrecipitationsToDelete = $this->getDwdPrecipitations(new Criteria(), $con)->diff($dwdPrecipitations);


        $this->dwdPrecipitationsScheduledForDeletion = $dwdPrecipitationsToDelete;

        foreach ($dwdPrecipitationsToDelete as $dwdPrecipitationRemoved) {
            $dwdPrecipitationRemoved->setDwdStation(null);
        }

        $this->collDwdPrecipitations = null;
        foreach ($dwdPrecipitations as $dwdPrecipitation) {
            $this->addDwdPrecipitation($dwdPrecipitation);
        }

        $this->collDwdPrecipitations = $dwdPrecipitations;
        $this->collDwdPrecipitationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdPrecipitation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdPrecipitation objects.
     * @throws PropelException
     */
    public function countDwdPrecipitations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdPrecipitationsPartial && !$this->isNew();
        if (null === $this->collDwdPrecipitations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdPrecipitations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdPrecipitations());
            }

            $query = ChildDwdPrecipitationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdPrecipitations);
    }

    /**
     * Method called to associate a ChildDwdPrecipitation object to this object
     * through the ChildDwdPrecipitation foreign key attribute.
     *
     * @param  ChildDwdPrecipitation $l ChildDwdPrecipitation
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdPrecipitation(ChildDwdPrecipitation $l)
    {
        if ($this->collDwdPrecipitations === null) {
            $this->initDwdPrecipitations();
            $this->collDwdPrecipitationsPartial = true;
        }

        if (!$this->collDwdPrecipitations->contains($l)) {
            $this->doAddDwdPrecipitation($l);

            if ($this->dwdPrecipitationsScheduledForDeletion and $this->dwdPrecipitationsScheduledForDeletion->contains($l)) {
                $this->dwdPrecipitationsScheduledForDeletion->remove($this->dwdPrecipitationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdPrecipitation $dwdPrecipitation The ChildDwdPrecipitation object to add.
     */
    protected function doAddDwdPrecipitation(ChildDwdPrecipitation $dwdPrecipitation)
    {
        $this->collDwdPrecipitations[]= $dwdPrecipitation;
        $dwdPrecipitation->setDwdStation($this);
    }

    /**
     * @param  ChildDwdPrecipitation $dwdPrecipitation The ChildDwdPrecipitation object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdPrecipitation(ChildDwdPrecipitation $dwdPrecipitation)
    {
        if ($this->getDwdPrecipitations()->contains($dwdPrecipitation)) {
            $pos = $this->collDwdPrecipitations->search($dwdPrecipitation);
            $this->collDwdPrecipitations->remove($pos);
            if (null === $this->dwdPrecipitationsScheduledForDeletion) {
                $this->dwdPrecipitationsScheduledForDeletion = clone $this->collDwdPrecipitations;
                $this->dwdPrecipitationsScheduledForDeletion->clear();
            }
            $this->dwdPrecipitationsScheduledForDeletion[]= clone $dwdPrecipitation;
            $dwdPrecipitation->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdPressures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdPressures()
     */
    public function clearDwdPressures()
    {
        $this->collDwdPressures = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdPressures collection loaded partially.
     */
    public function resetPartialDwdPressures($v = true)
    {
        $this->collDwdPressuresPartial = $v;
    }

    /**
     * Initializes the collDwdPressures collection.
     *
     * By default this just sets the collDwdPressures collection to an empty array (like clearcollDwdPressures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdPressures($overrideExisting = true)
    {
        if (null !== $this->collDwdPressures && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdPressureTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdPressures = new $collectionClassName;
        $this->collDwdPressures->setModel('\DwdPressure');
    }

    /**
     * Gets an array of ChildDwdPressure objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdPressure[] List of ChildDwdPressure objects
     * @throws PropelException
     */
    public function getDwdPressures(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdPressuresPartial && !$this->isNew();
        if (null === $this->collDwdPressures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdPressures) {
                // return empty collection
                $this->initDwdPressures();
            } else {
                $collDwdPressures = ChildDwdPressureQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdPressuresPartial && count($collDwdPressures)) {
                        $this->initDwdPressures(false);

                        foreach ($collDwdPressures as $obj) {
                            if (false == $this->collDwdPressures->contains($obj)) {
                                $this->collDwdPressures->append($obj);
                            }
                        }

                        $this->collDwdPressuresPartial = true;
                    }

                    return $collDwdPressures;
                }

                if ($partial && $this->collDwdPressures) {
                    foreach ($this->collDwdPressures as $obj) {
                        if ($obj->isNew()) {
                            $collDwdPressures[] = $obj;
                        }
                    }
                }

                $this->collDwdPressures = $collDwdPressures;
                $this->collDwdPressuresPartial = false;
            }
        }

        return $this->collDwdPressures;
    }

    /**
     * Sets a collection of ChildDwdPressure objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdPressures A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdPressures(Collection $dwdPressures, ConnectionInterface $con = null)
    {
        /** @var ChildDwdPressure[] $dwdPressuresToDelete */
        $dwdPressuresToDelete = $this->getDwdPressures(new Criteria(), $con)->diff($dwdPressures);


        $this->dwdPressuresScheduledForDeletion = $dwdPressuresToDelete;

        foreach ($dwdPressuresToDelete as $dwdPressureRemoved) {
            $dwdPressureRemoved->setDwdStation(null);
        }

        $this->collDwdPressures = null;
        foreach ($dwdPressures as $dwdPressure) {
            $this->addDwdPressure($dwdPressure);
        }

        $this->collDwdPressures = $dwdPressures;
        $this->collDwdPressuresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdPressure objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdPressure objects.
     * @throws PropelException
     */
    public function countDwdPressures(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdPressuresPartial && !$this->isNew();
        if (null === $this->collDwdPressures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdPressures) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdPressures());
            }

            $query = ChildDwdPressureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdPressures);
    }

    /**
     * Method called to associate a ChildDwdPressure object to this object
     * through the ChildDwdPressure foreign key attribute.
     *
     * @param  ChildDwdPressure $l ChildDwdPressure
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdPressure(ChildDwdPressure $l)
    {
        if ($this->collDwdPressures === null) {
            $this->initDwdPressures();
            $this->collDwdPressuresPartial = true;
        }

        if (!$this->collDwdPressures->contains($l)) {
            $this->doAddDwdPressure($l);

            if ($this->dwdPressuresScheduledForDeletion and $this->dwdPressuresScheduledForDeletion->contains($l)) {
                $this->dwdPressuresScheduledForDeletion->remove($this->dwdPressuresScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdPressure $dwdPressure The ChildDwdPressure object to add.
     */
    protected function doAddDwdPressure(ChildDwdPressure $dwdPressure)
    {
        $this->collDwdPressures[]= $dwdPressure;
        $dwdPressure->setDwdStation($this);
    }

    /**
     * @param  ChildDwdPressure $dwdPressure The ChildDwdPressure object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdPressure(ChildDwdPressure $dwdPressure)
    {
        if ($this->getDwdPressures()->contains($dwdPressure)) {
            $pos = $this->collDwdPressures->search($dwdPressure);
            $this->collDwdPressures->remove($pos);
            if (null === $this->dwdPressuresScheduledForDeletion) {
                $this->dwdPressuresScheduledForDeletion = clone $this->collDwdPressures;
                $this->dwdPressuresScheduledForDeletion->clear();
            }
            $this->dwdPressuresScheduledForDeletion[]= clone $dwdPressure;
            $dwdPressure->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdSoilTemperatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdSoilTemperatures()
     */
    public function clearDwdSoilTemperatures()
    {
        $this->collDwdSoilTemperatures = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdSoilTemperatures collection loaded partially.
     */
    public function resetPartialDwdSoilTemperatures($v = true)
    {
        $this->collDwdSoilTemperaturesPartial = $v;
    }

    /**
     * Initializes the collDwdSoilTemperatures collection.
     *
     * By default this just sets the collDwdSoilTemperatures collection to an empty array (like clearcollDwdSoilTemperatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdSoilTemperatures($overrideExisting = true)
    {
        if (null !== $this->collDwdSoilTemperatures && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdSoilTemperatureTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdSoilTemperatures = new $collectionClassName;
        $this->collDwdSoilTemperatures->setModel('\DwdSoilTemperature');
    }

    /**
     * Gets an array of ChildDwdSoilTemperature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdSoilTemperature[] List of ChildDwdSoilTemperature objects
     * @throws PropelException
     */
    public function getDwdSoilTemperatures(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSoilTemperaturesPartial && !$this->isNew();
        if (null === $this->collDwdSoilTemperatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdSoilTemperatures) {
                // return empty collection
                $this->initDwdSoilTemperatures();
            } else {
                $collDwdSoilTemperatures = ChildDwdSoilTemperatureQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdSoilTemperaturesPartial && count($collDwdSoilTemperatures)) {
                        $this->initDwdSoilTemperatures(false);

                        foreach ($collDwdSoilTemperatures as $obj) {
                            if (false == $this->collDwdSoilTemperatures->contains($obj)) {
                                $this->collDwdSoilTemperatures->append($obj);
                            }
                        }

                        $this->collDwdSoilTemperaturesPartial = true;
                    }

                    return $collDwdSoilTemperatures;
                }

                if ($partial && $this->collDwdSoilTemperatures) {
                    foreach ($this->collDwdSoilTemperatures as $obj) {
                        if ($obj->isNew()) {
                            $collDwdSoilTemperatures[] = $obj;
                        }
                    }
                }

                $this->collDwdSoilTemperatures = $collDwdSoilTemperatures;
                $this->collDwdSoilTemperaturesPartial = false;
            }
        }

        return $this->collDwdSoilTemperatures;
    }

    /**
     * Sets a collection of ChildDwdSoilTemperature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdSoilTemperatures A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdSoilTemperatures(Collection $dwdSoilTemperatures, ConnectionInterface $con = null)
    {
        /** @var ChildDwdSoilTemperature[] $dwdSoilTemperaturesToDelete */
        $dwdSoilTemperaturesToDelete = $this->getDwdSoilTemperatures(new Criteria(), $con)->diff($dwdSoilTemperatures);


        $this->dwdSoilTemperaturesScheduledForDeletion = $dwdSoilTemperaturesToDelete;

        foreach ($dwdSoilTemperaturesToDelete as $dwdSoilTemperatureRemoved) {
            $dwdSoilTemperatureRemoved->setDwdStation(null);
        }

        $this->collDwdSoilTemperatures = null;
        foreach ($dwdSoilTemperatures as $dwdSoilTemperature) {
            $this->addDwdSoilTemperature($dwdSoilTemperature);
        }

        $this->collDwdSoilTemperatures = $dwdSoilTemperatures;
        $this->collDwdSoilTemperaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdSoilTemperature objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdSoilTemperature objects.
     * @throws PropelException
     */
    public function countDwdSoilTemperatures(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSoilTemperaturesPartial && !$this->isNew();
        if (null === $this->collDwdSoilTemperatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdSoilTemperatures) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdSoilTemperatures());
            }

            $query = ChildDwdSoilTemperatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdSoilTemperatures);
    }

    /**
     * Method called to associate a ChildDwdSoilTemperature object to this object
     * through the ChildDwdSoilTemperature foreign key attribute.
     *
     * @param  ChildDwdSoilTemperature $l ChildDwdSoilTemperature
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdSoilTemperature(ChildDwdSoilTemperature $l)
    {
        if ($this->collDwdSoilTemperatures === null) {
            $this->initDwdSoilTemperatures();
            $this->collDwdSoilTemperaturesPartial = true;
        }

        if (!$this->collDwdSoilTemperatures->contains($l)) {
            $this->doAddDwdSoilTemperature($l);

            if ($this->dwdSoilTemperaturesScheduledForDeletion and $this->dwdSoilTemperaturesScheduledForDeletion->contains($l)) {
                $this->dwdSoilTemperaturesScheduledForDeletion->remove($this->dwdSoilTemperaturesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdSoilTemperature $dwdSoilTemperature The ChildDwdSoilTemperature object to add.
     */
    protected function doAddDwdSoilTemperature(ChildDwdSoilTemperature $dwdSoilTemperature)
    {
        $this->collDwdSoilTemperatures[]= $dwdSoilTemperature;
        $dwdSoilTemperature->setDwdStation($this);
    }

    /**
     * @param  ChildDwdSoilTemperature $dwdSoilTemperature The ChildDwdSoilTemperature object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdSoilTemperature(ChildDwdSoilTemperature $dwdSoilTemperature)
    {
        if ($this->getDwdSoilTemperatures()->contains($dwdSoilTemperature)) {
            $pos = $this->collDwdSoilTemperatures->search($dwdSoilTemperature);
            $this->collDwdSoilTemperatures->remove($pos);
            if (null === $this->dwdSoilTemperaturesScheduledForDeletion) {
                $this->dwdSoilTemperaturesScheduledForDeletion = clone $this->collDwdSoilTemperatures;
                $this->dwdSoilTemperaturesScheduledForDeletion->clear();
            }
            $this->dwdSoilTemperaturesScheduledForDeletion[]= clone $dwdSoilTemperature;
            $dwdSoilTemperature->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdSolars collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdSolars()
     */
    public function clearDwdSolars()
    {
        $this->collDwdSolars = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdSolars collection loaded partially.
     */
    public function resetPartialDwdSolars($v = true)
    {
        $this->collDwdSolarsPartial = $v;
    }

    /**
     * Initializes the collDwdSolars collection.
     *
     * By default this just sets the collDwdSolars collection to an empty array (like clearcollDwdSolars());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdSolars($overrideExisting = true)
    {
        if (null !== $this->collDwdSolars && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdSolarTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdSolars = new $collectionClassName;
        $this->collDwdSolars->setModel('\DwdSolar');
    }

    /**
     * Gets an array of ChildDwdSolar objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdSolar[] List of ChildDwdSolar objects
     * @throws PropelException
     */
    public function getDwdSolars(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSolarsPartial && !$this->isNew();
        if (null === $this->collDwdSolars || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdSolars) {
                // return empty collection
                $this->initDwdSolars();
            } else {
                $collDwdSolars = ChildDwdSolarQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdSolarsPartial && count($collDwdSolars)) {
                        $this->initDwdSolars(false);

                        foreach ($collDwdSolars as $obj) {
                            if (false == $this->collDwdSolars->contains($obj)) {
                                $this->collDwdSolars->append($obj);
                            }
                        }

                        $this->collDwdSolarsPartial = true;
                    }

                    return $collDwdSolars;
                }

                if ($partial && $this->collDwdSolars) {
                    foreach ($this->collDwdSolars as $obj) {
                        if ($obj->isNew()) {
                            $collDwdSolars[] = $obj;
                        }
                    }
                }

                $this->collDwdSolars = $collDwdSolars;
                $this->collDwdSolarsPartial = false;
            }
        }

        return $this->collDwdSolars;
    }

    /**
     * Sets a collection of ChildDwdSolar objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdSolars A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdSolars(Collection $dwdSolars, ConnectionInterface $con = null)
    {
        /** @var ChildDwdSolar[] $dwdSolarsToDelete */
        $dwdSolarsToDelete = $this->getDwdSolars(new Criteria(), $con)->diff($dwdSolars);


        $this->dwdSolarsScheduledForDeletion = $dwdSolarsToDelete;

        foreach ($dwdSolarsToDelete as $dwdSolarRemoved) {
            $dwdSolarRemoved->setDwdStation(null);
        }

        $this->collDwdSolars = null;
        foreach ($dwdSolars as $dwdSolar) {
            $this->addDwdSolar($dwdSolar);
        }

        $this->collDwdSolars = $dwdSolars;
        $this->collDwdSolarsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdSolar objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdSolar objects.
     * @throws PropelException
     */
    public function countDwdSolars(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSolarsPartial && !$this->isNew();
        if (null === $this->collDwdSolars || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdSolars) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdSolars());
            }

            $query = ChildDwdSolarQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdSolars);
    }

    /**
     * Method called to associate a ChildDwdSolar object to this object
     * through the ChildDwdSolar foreign key attribute.
     *
     * @param  ChildDwdSolar $l ChildDwdSolar
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdSolar(ChildDwdSolar $l)
    {
        if ($this->collDwdSolars === null) {
            $this->initDwdSolars();
            $this->collDwdSolarsPartial = true;
        }

        if (!$this->collDwdSolars->contains($l)) {
            $this->doAddDwdSolar($l);

            if ($this->dwdSolarsScheduledForDeletion and $this->dwdSolarsScheduledForDeletion->contains($l)) {
                $this->dwdSolarsScheduledForDeletion->remove($this->dwdSolarsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdSolar $dwdSolar The ChildDwdSolar object to add.
     */
    protected function doAddDwdSolar(ChildDwdSolar $dwdSolar)
    {
        $this->collDwdSolars[]= $dwdSolar;
        $dwdSolar->setDwdStation($this);
    }

    /**
     * @param  ChildDwdSolar $dwdSolar The ChildDwdSolar object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdSolar(ChildDwdSolar $dwdSolar)
    {
        if ($this->getDwdSolars()->contains($dwdSolar)) {
            $pos = $this->collDwdSolars->search($dwdSolar);
            $this->collDwdSolars->remove($pos);
            if (null === $this->dwdSolarsScheduledForDeletion) {
                $this->dwdSolarsScheduledForDeletion = clone $this->collDwdSolars;
                $this->dwdSolarsScheduledForDeletion->clear();
            }
            $this->dwdSolarsScheduledForDeletion[]= clone $dwdSolar;
            $dwdSolar->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdSuns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdSuns()
     */
    public function clearDwdSuns()
    {
        $this->collDwdSuns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdSuns collection loaded partially.
     */
    public function resetPartialDwdSuns($v = true)
    {
        $this->collDwdSunsPartial = $v;
    }

    /**
     * Initializes the collDwdSuns collection.
     *
     * By default this just sets the collDwdSuns collection to an empty array (like clearcollDwdSuns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdSuns($overrideExisting = true)
    {
        if (null !== $this->collDwdSuns && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdSunTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdSuns = new $collectionClassName;
        $this->collDwdSuns->setModel('\DwdSun');
    }

    /**
     * Gets an array of ChildDwdSun objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdSun[] List of ChildDwdSun objects
     * @throws PropelException
     */
    public function getDwdSuns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSunsPartial && !$this->isNew();
        if (null === $this->collDwdSuns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdSuns) {
                // return empty collection
                $this->initDwdSuns();
            } else {
                $collDwdSuns = ChildDwdSunQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdSunsPartial && count($collDwdSuns)) {
                        $this->initDwdSuns(false);

                        foreach ($collDwdSuns as $obj) {
                            if (false == $this->collDwdSuns->contains($obj)) {
                                $this->collDwdSuns->append($obj);
                            }
                        }

                        $this->collDwdSunsPartial = true;
                    }

                    return $collDwdSuns;
                }

                if ($partial && $this->collDwdSuns) {
                    foreach ($this->collDwdSuns as $obj) {
                        if ($obj->isNew()) {
                            $collDwdSuns[] = $obj;
                        }
                    }
                }

                $this->collDwdSuns = $collDwdSuns;
                $this->collDwdSunsPartial = false;
            }
        }

        return $this->collDwdSuns;
    }

    /**
     * Sets a collection of ChildDwdSun objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdSuns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdSuns(Collection $dwdSuns, ConnectionInterface $con = null)
    {
        /** @var ChildDwdSun[] $dwdSunsToDelete */
        $dwdSunsToDelete = $this->getDwdSuns(new Criteria(), $con)->diff($dwdSuns);


        $this->dwdSunsScheduledForDeletion = $dwdSunsToDelete;

        foreach ($dwdSunsToDelete as $dwdSunRemoved) {
            $dwdSunRemoved->setDwdStation(null);
        }

        $this->collDwdSuns = null;
        foreach ($dwdSuns as $dwdSun) {
            $this->addDwdSun($dwdSun);
        }

        $this->collDwdSuns = $dwdSuns;
        $this->collDwdSunsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdSun objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdSun objects.
     * @throws PropelException
     */
    public function countDwdSuns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdSunsPartial && !$this->isNew();
        if (null === $this->collDwdSuns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdSuns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdSuns());
            }

            $query = ChildDwdSunQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdSuns);
    }

    /**
     * Method called to associate a ChildDwdSun object to this object
     * through the ChildDwdSun foreign key attribute.
     *
     * @param  ChildDwdSun $l ChildDwdSun
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdSun(ChildDwdSun $l)
    {
        if ($this->collDwdSuns === null) {
            $this->initDwdSuns();
            $this->collDwdSunsPartial = true;
        }

        if (!$this->collDwdSuns->contains($l)) {
            $this->doAddDwdSun($l);

            if ($this->dwdSunsScheduledForDeletion and $this->dwdSunsScheduledForDeletion->contains($l)) {
                $this->dwdSunsScheduledForDeletion->remove($this->dwdSunsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdSun $dwdSun The ChildDwdSun object to add.
     */
    protected function doAddDwdSun(ChildDwdSun $dwdSun)
    {
        $this->collDwdSuns[]= $dwdSun;
        $dwdSun->setDwdStation($this);
    }

    /**
     * @param  ChildDwdSun $dwdSun The ChildDwdSun object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdSun(ChildDwdSun $dwdSun)
    {
        if ($this->getDwdSuns()->contains($dwdSun)) {
            $pos = $this->collDwdSuns->search($dwdSun);
            $this->collDwdSuns->remove($pos);
            if (null === $this->dwdSunsScheduledForDeletion) {
                $this->dwdSunsScheduledForDeletion = clone $this->collDwdSuns;
                $this->dwdSunsScheduledForDeletion->clear();
            }
            $this->dwdSunsScheduledForDeletion[]= clone $dwdSun;
            $dwdSun->setDwdStation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDwdWinds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDwdWinds()
     */
    public function clearDwdWinds()
    {
        $this->collDwdWinds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDwdWinds collection loaded partially.
     */
    public function resetPartialDwdWinds($v = true)
    {
        $this->collDwdWindsPartial = $v;
    }

    /**
     * Initializes the collDwdWinds collection.
     *
     * By default this just sets the collDwdWinds collection to an empty array (like clearcollDwdWinds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDwdWinds($overrideExisting = true)
    {
        if (null !== $this->collDwdWinds && !$overrideExisting) {
            return;
        }

        $collectionClassName = DwdWindTableMap::getTableMap()->getCollectionClassName();

        $this->collDwdWinds = new $collectionClassName;
        $this->collDwdWinds->setModel('\DwdWind');
    }

    /**
     * Gets an array of ChildDwdWind objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDwdStation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDwdWind[] List of ChildDwdWind objects
     * @throws PropelException
     */
    public function getDwdWinds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdWindsPartial && !$this->isNew();
        if (null === $this->collDwdWinds || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDwdWinds) {
                // return empty collection
                $this->initDwdWinds();
            } else {
                $collDwdWinds = ChildDwdWindQuery::create(null, $criteria)
                    ->filterByDwdStation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDwdWindsPartial && count($collDwdWinds)) {
                        $this->initDwdWinds(false);

                        foreach ($collDwdWinds as $obj) {
                            if (false == $this->collDwdWinds->contains($obj)) {
                                $this->collDwdWinds->append($obj);
                            }
                        }

                        $this->collDwdWindsPartial = true;
                    }

                    return $collDwdWinds;
                }

                if ($partial && $this->collDwdWinds) {
                    foreach ($this->collDwdWinds as $obj) {
                        if ($obj->isNew()) {
                            $collDwdWinds[] = $obj;
                        }
                    }
                }

                $this->collDwdWinds = $collDwdWinds;
                $this->collDwdWindsPartial = false;
            }
        }

        return $this->collDwdWinds;
    }

    /**
     * Sets a collection of ChildDwdWind objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dwdWinds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function setDwdWinds(Collection $dwdWinds, ConnectionInterface $con = null)
    {
        /** @var ChildDwdWind[] $dwdWindsToDelete */
        $dwdWindsToDelete = $this->getDwdWinds(new Criteria(), $con)->diff($dwdWinds);


        $this->dwdWindsScheduledForDeletion = $dwdWindsToDelete;

        foreach ($dwdWindsToDelete as $dwdWindRemoved) {
            $dwdWindRemoved->setDwdStation(null);
        }

        $this->collDwdWinds = null;
        foreach ($dwdWinds as $dwdWind) {
            $this->addDwdWind($dwdWind);
        }

        $this->collDwdWinds = $dwdWinds;
        $this->collDwdWindsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DwdWind objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DwdWind objects.
     * @throws PropelException
     */
    public function countDwdWinds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDwdWindsPartial && !$this->isNew();
        if (null === $this->collDwdWinds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDwdWinds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDwdWinds());
            }

            $query = ChildDwdWindQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDwdStation($this)
                ->count($con);
        }

        return count($this->collDwdWinds);
    }

    /**
     * Method called to associate a ChildDwdWind object to this object
     * through the ChildDwdWind foreign key attribute.
     *
     * @param  ChildDwdWind $l ChildDwdWind
     * @return $this|\DwdStation The current object (for fluent API support)
     */
    public function addDwdWind(ChildDwdWind $l)
    {
        if ($this->collDwdWinds === null) {
            $this->initDwdWinds();
            $this->collDwdWindsPartial = true;
        }

        if (!$this->collDwdWinds->contains($l)) {
            $this->doAddDwdWind($l);

            if ($this->dwdWindsScheduledForDeletion and $this->dwdWindsScheduledForDeletion->contains($l)) {
                $this->dwdWindsScheduledForDeletion->remove($this->dwdWindsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDwdWind $dwdWind The ChildDwdWind object to add.
     */
    protected function doAddDwdWind(ChildDwdWind $dwdWind)
    {
        $this->collDwdWinds[]= $dwdWind;
        $dwdWind->setDwdStation($this);
    }

    /**
     * @param  ChildDwdWind $dwdWind The ChildDwdWind object to remove.
     * @return $this|ChildDwdStation The current object (for fluent API support)
     */
    public function removeDwdWind(ChildDwdWind $dwdWind)
    {
        if ($this->getDwdWinds()->contains($dwdWind)) {
            $pos = $this->collDwdWinds->search($dwdWind);
            $this->collDwdWinds->remove($pos);
            if (null === $this->dwdWindsScheduledForDeletion) {
                $this->dwdWindsScheduledForDeletion = clone $this->collDwdWinds;
                $this->dwdWindsScheduledForDeletion->clear();
            }
            $this->dwdWindsScheduledForDeletion[]= clone $dwdWind;
            $dwdWind->setDwdStation(null);
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
            if ($this->collDwdAirTemperatures) {
                foreach ($this->collDwdAirTemperatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdCloudiness) {
                foreach ($this->collDwdCloudiness as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdPrecipitations) {
                foreach ($this->collDwdPrecipitations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdPressures) {
                foreach ($this->collDwdPressures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdSoilTemperatures) {
                foreach ($this->collDwdSoilTemperatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdSolars) {
                foreach ($this->collDwdSolars as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdSuns) {
                foreach ($this->collDwdSuns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDwdWinds) {
                foreach ($this->collDwdWinds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDwdAirTemperatures = null;
        $this->collDwdCloudiness = null;
        $this->collDwdPrecipitations = null;
        $this->collDwdPressures = null;
        $this->collDwdSoilTemperatures = null;
        $this->collDwdSolars = null;
        $this->collDwdSuns = null;
        $this->collDwdWinds = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DwdStationTableMap::DEFAULT_STRING_FORMAT);
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
