<?php

namespace Map;

use \DwdAirTemperature;
use \DwdAirTemperatureQuery;
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
 * This class defines the structure of the 'dwd_air_temperature' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DwdAirTemperatureTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DwdAirTemperatureTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'dwd_air_temperature';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DwdAirTemperature';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DwdAirTemperature';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'dwd_air_temperature.id';

    /**
     * the column name for the station_id field
     */
    const COL_STATION_ID = 'dwd_air_temperature.station_id';

    /**
     * the column name for the time field
     */
    const COL_TIME = 'dwd_air_temperature.time';

    /**
     * the column name for the quality field
     */
    const COL_QUALITY = 'dwd_air_temperature.quality';

    /**
     * the column name for the tt_tu field
     */
    const COL_TT_TU = 'dwd_air_temperature.tt_tu';

    /**
     * the column name for the rf_tu field
     */
    const COL_RF_TU = 'dwd_air_temperature.rf_tu';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'StationId', 'Time', 'Quality', 'TtTu', 'RfTu', ),
        self::TYPE_CAMELNAME     => array('id', 'stationId', 'time', 'quality', 'ttTu', 'rfTu', ),
        self::TYPE_COLNAME       => array(DwdAirTemperatureTableMap::COL_ID, DwdAirTemperatureTableMap::COL_STATION_ID, DwdAirTemperatureTableMap::COL_TIME, DwdAirTemperatureTableMap::COL_QUALITY, DwdAirTemperatureTableMap::COL_TT_TU, DwdAirTemperatureTableMap::COL_RF_TU, ),
        self::TYPE_FIELDNAME     => array('id', 'station_id', 'time', 'quality', 'tt_tu', 'rf_tu', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StationId' => 1, 'Time' => 2, 'Quality' => 3, 'TtTu' => 4, 'RfTu' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'stationId' => 1, 'time' => 2, 'quality' => 3, 'ttTu' => 4, 'rfTu' => 5, ),
        self::TYPE_COLNAME       => array(DwdAirTemperatureTableMap::COL_ID => 0, DwdAirTemperatureTableMap::COL_STATION_ID => 1, DwdAirTemperatureTableMap::COL_TIME => 2, DwdAirTemperatureTableMap::COL_QUALITY => 3, DwdAirTemperatureTableMap::COL_TT_TU => 4, DwdAirTemperatureTableMap::COL_RF_TU => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'station_id' => 1, 'time' => 2, 'quality' => 3, 'tt_tu' => 4, 'rf_tu' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('dwd_air_temperature');
        $this->setPhpName('DwdAirTemperature');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DwdAirTemperature');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('station_id', 'StationId', 'INTEGER', 'dwd_station', 'id', true, null, null);
        $this->addColumn('time', 'Time', 'TIMESTAMP', true, null, null);
        $this->addColumn('quality', 'Quality', 'INTEGER', true, null, null);
        $this->addColumn('tt_tu', 'TtTu', 'FLOAT', false, null, null);
        $this->addColumn('rf_tu', 'RfTu', 'FLOAT', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('DwdStation', '\\DwdStation', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':station_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? DwdAirTemperatureTableMap::CLASS_DEFAULT : DwdAirTemperatureTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (DwdAirTemperature object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DwdAirTemperatureTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DwdAirTemperatureTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DwdAirTemperatureTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DwdAirTemperatureTableMap::OM_CLASS;
            /** @var DwdAirTemperature $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DwdAirTemperatureTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = DwdAirTemperatureTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DwdAirTemperatureTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DwdAirTemperature $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DwdAirTemperatureTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_ID);
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_STATION_ID);
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_TIME);
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_QUALITY);
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_TT_TU);
            $criteria->addSelectColumn(DwdAirTemperatureTableMap::COL_RF_TU);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.station_id');
            $criteria->addSelectColumn($alias . '.time');
            $criteria->addSelectColumn($alias . '.quality');
            $criteria->addSelectColumn($alias . '.tt_tu');
            $criteria->addSelectColumn($alias . '.rf_tu');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(DwdAirTemperatureTableMap::DATABASE_NAME)->getTable(DwdAirTemperatureTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DwdAirTemperatureTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DwdAirTemperatureTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DwdAirTemperatureTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DwdAirTemperature or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DwdAirTemperature object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdAirTemperatureTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DwdAirTemperature) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DwdAirTemperatureTableMap::DATABASE_NAME);
            $criteria->add(DwdAirTemperatureTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DwdAirTemperatureQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DwdAirTemperatureTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DwdAirTemperatureTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the dwd_air_temperature table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DwdAirTemperatureQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DwdAirTemperature or Criteria object.
     *
     * @param mixed               $criteria Criteria or DwdAirTemperature object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdAirTemperatureTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DwdAirTemperature object
        }

        if ($criteria->containsKey(DwdAirTemperatureTableMap::COL_ID) && $criteria->keyContainsValue(DwdAirTemperatureTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DwdAirTemperatureTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DwdAirTemperatureQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DwdAirTemperatureTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DwdAirTemperatureTableMap::buildTableMap();
