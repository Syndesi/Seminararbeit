<?php

namespace Map;

use \DwdWind;
use \DwdWindQuery;
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
 * This class defines the structure of the 'dwd_wind' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DwdWindTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DwdWindTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'dwd_wind';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DwdWind';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DwdWind';

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
    const COL_ID = 'dwd_wind.id';

    /**
     * the column name for the station_id field
     */
    const COL_STATION_ID = 'dwd_wind.station_id';

    /**
     * the column name for the time field
     */
    const COL_TIME = 'dwd_wind.time';

    /**
     * the column name for the quality field
     */
    const COL_QUALITY = 'dwd_wind.quality';

    /**
     * the column name for the f field
     */
    const COL_F = 'dwd_wind.f';

    /**
     * the column name for the d field
     */
    const COL_D = 'dwd_wind.d';

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
        self::TYPE_PHPNAME       => array('Id', 'StationId', 'Time', 'Quality', 'F', 'D', ),
        self::TYPE_CAMELNAME     => array('id', 'stationId', 'time', 'quality', 'f', 'd', ),
        self::TYPE_COLNAME       => array(DwdWindTableMap::COL_ID, DwdWindTableMap::COL_STATION_ID, DwdWindTableMap::COL_TIME, DwdWindTableMap::COL_QUALITY, DwdWindTableMap::COL_F, DwdWindTableMap::COL_D, ),
        self::TYPE_FIELDNAME     => array('id', 'station_id', 'time', 'quality', 'f', 'd', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StationId' => 1, 'Time' => 2, 'Quality' => 3, 'F' => 4, 'D' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'stationId' => 1, 'time' => 2, 'quality' => 3, 'f' => 4, 'd' => 5, ),
        self::TYPE_COLNAME       => array(DwdWindTableMap::COL_ID => 0, DwdWindTableMap::COL_STATION_ID => 1, DwdWindTableMap::COL_TIME => 2, DwdWindTableMap::COL_QUALITY => 3, DwdWindTableMap::COL_F => 4, DwdWindTableMap::COL_D => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'station_id' => 1, 'time' => 2, 'quality' => 3, 'f' => 4, 'd' => 5, ),
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
        $this->setName('dwd_wind');
        $this->setPhpName('DwdWind');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DwdWind');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('station_id', 'StationId', 'INTEGER', 'dwd_station', 'id', true, null, null);
        $this->addColumn('time', 'Time', 'TIMESTAMP', true, null, null);
        $this->addColumn('quality', 'Quality', 'INTEGER', true, null, null);
        $this->addColumn('f', 'F', 'FLOAT', false, null, null);
        $this->addColumn('d', 'D', 'INTEGER', false, null, null);
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
        return $withPrefix ? DwdWindTableMap::CLASS_DEFAULT : DwdWindTableMap::OM_CLASS;
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
     * @return array           (DwdWind object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DwdWindTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DwdWindTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DwdWindTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DwdWindTableMap::OM_CLASS;
            /** @var DwdWind $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DwdWindTableMap::addInstanceToPool($obj, $key);
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
            $key = DwdWindTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DwdWindTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DwdWind $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DwdWindTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DwdWindTableMap::COL_ID);
            $criteria->addSelectColumn(DwdWindTableMap::COL_STATION_ID);
            $criteria->addSelectColumn(DwdWindTableMap::COL_TIME);
            $criteria->addSelectColumn(DwdWindTableMap::COL_QUALITY);
            $criteria->addSelectColumn(DwdWindTableMap::COL_F);
            $criteria->addSelectColumn(DwdWindTableMap::COL_D);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.station_id');
            $criteria->addSelectColumn($alias . '.time');
            $criteria->addSelectColumn($alias . '.quality');
            $criteria->addSelectColumn($alias . '.f');
            $criteria->addSelectColumn($alias . '.d');
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
        return Propel::getServiceContainer()->getDatabaseMap(DwdWindTableMap::DATABASE_NAME)->getTable(DwdWindTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DwdWindTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DwdWindTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DwdWindTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DwdWind or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DwdWind object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdWindTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DwdWind) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DwdWindTableMap::DATABASE_NAME);
            $criteria->add(DwdWindTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DwdWindQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DwdWindTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DwdWindTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the dwd_wind table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DwdWindQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DwdWind or Criteria object.
     *
     * @param mixed               $criteria Criteria or DwdWind object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdWindTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DwdWind object
        }

        if ($criteria->containsKey(DwdWindTableMap::COL_ID) && $criteria->keyContainsValue(DwdWindTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DwdWindTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DwdWindQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DwdWindTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DwdWindTableMap::buildTableMap();
