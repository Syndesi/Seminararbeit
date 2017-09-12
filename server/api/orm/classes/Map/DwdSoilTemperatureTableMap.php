<?php

namespace Map;

use \DwdSoilTemperature;
use \DwdSoilTemperatureQuery;
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
 * This class defines the structure of the 'dwd_soil_temperature' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DwdSoilTemperatureTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DwdSoilTemperatureTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'dwd_soil_temperature';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DwdSoilTemperature';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DwdSoilTemperature';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'dwd_soil_temperature.id';

    /**
     * the column name for the station_id field
     */
    const COL_STATION_ID = 'dwd_soil_temperature.station_id';

    /**
     * the column name for the time field
     */
    const COL_TIME = 'dwd_soil_temperature.time';

    /**
     * the column name for the quality field
     */
    const COL_QUALITY = 'dwd_soil_temperature.quality';

    /**
     * the column name for the v_te002 field
     */
    const COL_V_TE002 = 'dwd_soil_temperature.v_te002';

    /**
     * the column name for the v_te005 field
     */
    const COL_V_TE005 = 'dwd_soil_temperature.v_te005';

    /**
     * the column name for the v_te010 field
     */
    const COL_V_TE010 = 'dwd_soil_temperature.v_te010';

    /**
     * the column name for the v_te020 field
     */
    const COL_V_TE020 = 'dwd_soil_temperature.v_te020';

    /**
     * the column name for the v_te050 field
     */
    const COL_V_TE050 = 'dwd_soil_temperature.v_te050';

    /**
     * the column name for the v_te100 field
     */
    const COL_V_TE100 = 'dwd_soil_temperature.v_te100';

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
        self::TYPE_PHPNAME       => array('Id', 'StationId', 'Time', 'Quality', 'VTe002', 'VTe005', 'VTe010', 'VTe020', 'VTe050', 'VTe100', ),
        self::TYPE_CAMELNAME     => array('id', 'stationId', 'time', 'quality', 'vTe002', 'vTe005', 'vTe010', 'vTe020', 'vTe050', 'vTe100', ),
        self::TYPE_COLNAME       => array(DwdSoilTemperatureTableMap::COL_ID, DwdSoilTemperatureTableMap::COL_STATION_ID, DwdSoilTemperatureTableMap::COL_TIME, DwdSoilTemperatureTableMap::COL_QUALITY, DwdSoilTemperatureTableMap::COL_V_TE002, DwdSoilTemperatureTableMap::COL_V_TE005, DwdSoilTemperatureTableMap::COL_V_TE010, DwdSoilTemperatureTableMap::COL_V_TE020, DwdSoilTemperatureTableMap::COL_V_TE050, DwdSoilTemperatureTableMap::COL_V_TE100, ),
        self::TYPE_FIELDNAME     => array('id', 'station_id', 'time', 'quality', 'v_te002', 'v_te005', 'v_te010', 'v_te020', 'v_te050', 'v_te100', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StationId' => 1, 'Time' => 2, 'Quality' => 3, 'VTe002' => 4, 'VTe005' => 5, 'VTe010' => 6, 'VTe020' => 7, 'VTe050' => 8, 'VTe100' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'stationId' => 1, 'time' => 2, 'quality' => 3, 'vTe002' => 4, 'vTe005' => 5, 'vTe010' => 6, 'vTe020' => 7, 'vTe050' => 8, 'vTe100' => 9, ),
        self::TYPE_COLNAME       => array(DwdSoilTemperatureTableMap::COL_ID => 0, DwdSoilTemperatureTableMap::COL_STATION_ID => 1, DwdSoilTemperatureTableMap::COL_TIME => 2, DwdSoilTemperatureTableMap::COL_QUALITY => 3, DwdSoilTemperatureTableMap::COL_V_TE002 => 4, DwdSoilTemperatureTableMap::COL_V_TE005 => 5, DwdSoilTemperatureTableMap::COL_V_TE010 => 6, DwdSoilTemperatureTableMap::COL_V_TE020 => 7, DwdSoilTemperatureTableMap::COL_V_TE050 => 8, DwdSoilTemperatureTableMap::COL_V_TE100 => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'station_id' => 1, 'time' => 2, 'quality' => 3, 'v_te002' => 4, 'v_te005' => 5, 'v_te010' => 6, 'v_te020' => 7, 'v_te050' => 8, 'v_te100' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('dwd_soil_temperature');
        $this->setPhpName('DwdSoilTemperature');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DwdSoilTemperature');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('station_id', 'StationId', 'INTEGER', 'dwd_station', 'id', true, null, null);
        $this->addColumn('time', 'Time', 'TIMESTAMP', true, null, null);
        $this->addColumn('quality', 'Quality', 'INTEGER', true, null, null);
        $this->addColumn('v_te002', 'VTe002', 'FLOAT', false, null, null);
        $this->addColumn('v_te005', 'VTe005', 'FLOAT', false, null, null);
        $this->addColumn('v_te010', 'VTe010', 'FLOAT', false, null, null);
        $this->addColumn('v_te020', 'VTe020', 'FLOAT', false, null, null);
        $this->addColumn('v_te050', 'VTe050', 'FLOAT', false, null, null);
        $this->addColumn('v_te100', 'VTe100', 'FLOAT', false, null, null);
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
        return $withPrefix ? DwdSoilTemperatureTableMap::CLASS_DEFAULT : DwdSoilTemperatureTableMap::OM_CLASS;
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
     * @return array           (DwdSoilTemperature object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DwdSoilTemperatureTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DwdSoilTemperatureTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DwdSoilTemperatureTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DwdSoilTemperatureTableMap::OM_CLASS;
            /** @var DwdSoilTemperature $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DwdSoilTemperatureTableMap::addInstanceToPool($obj, $key);
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
            $key = DwdSoilTemperatureTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DwdSoilTemperatureTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DwdSoilTemperature $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DwdSoilTemperatureTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_ID);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_STATION_ID);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_TIME);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_QUALITY);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE002);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE005);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE010);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE020);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE050);
            $criteria->addSelectColumn(DwdSoilTemperatureTableMap::COL_V_TE100);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.station_id');
            $criteria->addSelectColumn($alias . '.time');
            $criteria->addSelectColumn($alias . '.quality');
            $criteria->addSelectColumn($alias . '.v_te002');
            $criteria->addSelectColumn($alias . '.v_te005');
            $criteria->addSelectColumn($alias . '.v_te010');
            $criteria->addSelectColumn($alias . '.v_te020');
            $criteria->addSelectColumn($alias . '.v_te050');
            $criteria->addSelectColumn($alias . '.v_te100');
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
        return Propel::getServiceContainer()->getDatabaseMap(DwdSoilTemperatureTableMap::DATABASE_NAME)->getTable(DwdSoilTemperatureTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DwdSoilTemperatureTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DwdSoilTemperatureTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DwdSoilTemperatureTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DwdSoilTemperature or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DwdSoilTemperature object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSoilTemperatureTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DwdSoilTemperature) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DwdSoilTemperatureTableMap::DATABASE_NAME);
            $criteria->add(DwdSoilTemperatureTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DwdSoilTemperatureQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DwdSoilTemperatureTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DwdSoilTemperatureTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the dwd_soil_temperature table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DwdSoilTemperatureQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DwdSoilTemperature or Criteria object.
     *
     * @param mixed               $criteria Criteria or DwdSoilTemperature object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSoilTemperatureTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DwdSoilTemperature object
        }

        if ($criteria->containsKey(DwdSoilTemperatureTableMap::COL_ID) && $criteria->keyContainsValue(DwdSoilTemperatureTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DwdSoilTemperatureTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DwdSoilTemperatureQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DwdSoilTemperatureTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DwdSoilTemperatureTableMap::buildTableMap();
