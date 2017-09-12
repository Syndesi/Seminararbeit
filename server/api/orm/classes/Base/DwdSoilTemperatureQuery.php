<?php

namespace Base;

use \DwdSoilTemperature as ChildDwdSoilTemperature;
use \DwdSoilTemperatureQuery as ChildDwdSoilTemperatureQuery;
use \Exception;
use \PDO;
use Map\DwdSoilTemperatureTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dwd_soil_temperature' table.
 *
 *
 *
 * @method     ChildDwdSoilTemperatureQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDwdSoilTemperatureQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildDwdSoilTemperatureQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildDwdSoilTemperatureQuery orderByQuality($order = Criteria::ASC) Order by the quality column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe002($order = Criteria::ASC) Order by the v_te002 column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe005($order = Criteria::ASC) Order by the v_te005 column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe010($order = Criteria::ASC) Order by the v_te010 column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe020($order = Criteria::ASC) Order by the v_te020 column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe050($order = Criteria::ASC) Order by the v_te050 column
 * @method     ChildDwdSoilTemperatureQuery orderByVTe100($order = Criteria::ASC) Order by the v_te100 column
 *
 * @method     ChildDwdSoilTemperatureQuery groupById() Group by the id column
 * @method     ChildDwdSoilTemperatureQuery groupByStationId() Group by the station_id column
 * @method     ChildDwdSoilTemperatureQuery groupByTime() Group by the time column
 * @method     ChildDwdSoilTemperatureQuery groupByQuality() Group by the quality column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe002() Group by the v_te002 column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe005() Group by the v_te005 column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe010() Group by the v_te010 column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe020() Group by the v_te020 column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe050() Group by the v_te050 column
 * @method     ChildDwdSoilTemperatureQuery groupByVTe100() Group by the v_te100 column
 *
 * @method     ChildDwdSoilTemperatureQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDwdSoilTemperatureQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDwdSoilTemperatureQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDwdSoilTemperatureQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDwdSoilTemperatureQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDwdSoilTemperatureQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDwdSoilTemperatureQuery leftJoinDwdStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdSoilTemperatureQuery rightJoinDwdStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdSoilTemperatureQuery innerJoinDwdStation($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdStation relation
 *
 * @method     ChildDwdSoilTemperatureQuery joinWithDwdStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdStation relation
 *
 * @method     ChildDwdSoilTemperatureQuery leftJoinWithDwdStation() Adds a LEFT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdSoilTemperatureQuery rightJoinWithDwdStation() Adds a RIGHT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdSoilTemperatureQuery innerJoinWithDwdStation() Adds a INNER JOIN clause and with to the query using the DwdStation relation
 *
 * @method     \DwdStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDwdSoilTemperature findOne(ConnectionInterface $con = null) Return the first ChildDwdSoilTemperature matching the query
 * @method     ChildDwdSoilTemperature findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDwdSoilTemperature matching the query, or a new ChildDwdSoilTemperature object populated from the query conditions when no match is found
 *
 * @method     ChildDwdSoilTemperature findOneById(int $id) Return the first ChildDwdSoilTemperature filtered by the id column
 * @method     ChildDwdSoilTemperature findOneByStationId(int $station_id) Return the first ChildDwdSoilTemperature filtered by the station_id column
 * @method     ChildDwdSoilTemperature findOneByTime(string $time) Return the first ChildDwdSoilTemperature filtered by the time column
 * @method     ChildDwdSoilTemperature findOneByQuality(int $quality) Return the first ChildDwdSoilTemperature filtered by the quality column
 * @method     ChildDwdSoilTemperature findOneByVTe002(double $v_te002) Return the first ChildDwdSoilTemperature filtered by the v_te002 column
 * @method     ChildDwdSoilTemperature findOneByVTe005(double $v_te005) Return the first ChildDwdSoilTemperature filtered by the v_te005 column
 * @method     ChildDwdSoilTemperature findOneByVTe010(double $v_te010) Return the first ChildDwdSoilTemperature filtered by the v_te010 column
 * @method     ChildDwdSoilTemperature findOneByVTe020(double $v_te020) Return the first ChildDwdSoilTemperature filtered by the v_te020 column
 * @method     ChildDwdSoilTemperature findOneByVTe050(double $v_te050) Return the first ChildDwdSoilTemperature filtered by the v_te050 column
 * @method     ChildDwdSoilTemperature findOneByVTe100(double $v_te100) Return the first ChildDwdSoilTemperature filtered by the v_te100 column *

 * @method     ChildDwdSoilTemperature requirePk($key, ConnectionInterface $con = null) Return the ChildDwdSoilTemperature by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOne(ConnectionInterface $con = null) Return the first ChildDwdSoilTemperature matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdSoilTemperature requireOneById(int $id) Return the first ChildDwdSoilTemperature filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByStationId(int $station_id) Return the first ChildDwdSoilTemperature filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByTime(string $time) Return the first ChildDwdSoilTemperature filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByQuality(int $quality) Return the first ChildDwdSoilTemperature filtered by the quality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe002(double $v_te002) Return the first ChildDwdSoilTemperature filtered by the v_te002 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe005(double $v_te005) Return the first ChildDwdSoilTemperature filtered by the v_te005 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe010(double $v_te010) Return the first ChildDwdSoilTemperature filtered by the v_te010 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe020(double $v_te020) Return the first ChildDwdSoilTemperature filtered by the v_te020 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe050(double $v_te050) Return the first ChildDwdSoilTemperature filtered by the v_te050 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSoilTemperature requireOneByVTe100(double $v_te100) Return the first ChildDwdSoilTemperature filtered by the v_te100 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdSoilTemperature[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDwdSoilTemperature objects based on current ModelCriteria
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findById(int $id) Return ChildDwdSoilTemperature objects filtered by the id column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByStationId(int $station_id) Return ChildDwdSoilTemperature objects filtered by the station_id column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByTime(string $time) Return ChildDwdSoilTemperature objects filtered by the time column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByQuality(int $quality) Return ChildDwdSoilTemperature objects filtered by the quality column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe002(double $v_te002) Return ChildDwdSoilTemperature objects filtered by the v_te002 column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe005(double $v_te005) Return ChildDwdSoilTemperature objects filtered by the v_te005 column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe010(double $v_te010) Return ChildDwdSoilTemperature objects filtered by the v_te010 column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe020(double $v_te020) Return ChildDwdSoilTemperature objects filtered by the v_te020 column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe050(double $v_te050) Return ChildDwdSoilTemperature objects filtered by the v_te050 column
 * @method     ChildDwdSoilTemperature[]|ObjectCollection findByVTe100(double $v_te100) Return ChildDwdSoilTemperature objects filtered by the v_te100 column
 * @method     ChildDwdSoilTemperature[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DwdSoilTemperatureQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DwdSoilTemperatureQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DwdSoilTemperature', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDwdSoilTemperatureQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDwdSoilTemperatureQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDwdSoilTemperatureQuery) {
            return $criteria;
        }
        $query = new ChildDwdSoilTemperatureQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDwdSoilTemperature|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DwdSoilTemperatureTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DwdSoilTemperatureTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDwdSoilTemperature A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, quality, v_te002, v_te005, v_te010, v_te020, v_te050, v_te100 FROM dwd_soil_temperature WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDwdSoilTemperature $obj */
            $obj = new ChildDwdSoilTemperature();
            $obj->hydrate($row);
            DwdSoilTemperatureTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDwdSoilTemperature|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the station_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStationId(1234); // WHERE station_id = 1234
     * $query->filterByStationId(array(12, 34)); // WHERE station_id IN (12, 34)
     * $query->filterByStationId(array('min' => 12)); // WHERE station_id > 12
     * </code>
     *
     * @see       filterByDwdStation()
     *
     * @param     mixed $stationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_STATION_ID, $stationId, $comparison);
    }

    /**
     * Filter the query on the time column
     *
     * Example usage:
     * <code>
     * $query->filterByTime('2011-03-14'); // WHERE time = '2011-03-14'
     * $query->filterByTime('now'); // WHERE time = '2011-03-14'
     * $query->filterByTime(array('max' => 'yesterday')); // WHERE time > '2011-03-13'
     * </code>
     *
     * @param     mixed $time The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_TIME, $time, $comparison);
    }

    /**
     * Filter the query on the quality column
     *
     * Example usage:
     * <code>
     * $query->filterByQuality(1234); // WHERE quality = 1234
     * $query->filterByQuality(array(12, 34)); // WHERE quality IN (12, 34)
     * $query->filterByQuality(array('min' => 12)); // WHERE quality > 12
     * </code>
     *
     * @param     mixed $quality The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByQuality($quality = null, $comparison = null)
    {
        if (is_array($quality)) {
            $useMinMax = false;
            if (isset($quality['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_QUALITY, $quality['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quality['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_QUALITY, $quality['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_QUALITY, $quality, $comparison);
    }

    /**
     * Filter the query on the v_te002 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe002(1234); // WHERE v_te002 = 1234
     * $query->filterByVTe002(array(12, 34)); // WHERE v_te002 IN (12, 34)
     * $query->filterByVTe002(array('min' => 12)); // WHERE v_te002 > 12
     * </code>
     *
     * @param     mixed $vTe002 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe002($vTe002 = null, $comparison = null)
    {
        if (is_array($vTe002)) {
            $useMinMax = false;
            if (isset($vTe002['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE002, $vTe002['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe002['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE002, $vTe002['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE002, $vTe002, $comparison);
    }

    /**
     * Filter the query on the v_te005 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe005(1234); // WHERE v_te005 = 1234
     * $query->filterByVTe005(array(12, 34)); // WHERE v_te005 IN (12, 34)
     * $query->filterByVTe005(array('min' => 12)); // WHERE v_te005 > 12
     * </code>
     *
     * @param     mixed $vTe005 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe005($vTe005 = null, $comparison = null)
    {
        if (is_array($vTe005)) {
            $useMinMax = false;
            if (isset($vTe005['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE005, $vTe005['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe005['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE005, $vTe005['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE005, $vTe005, $comparison);
    }

    /**
     * Filter the query on the v_te010 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe010(1234); // WHERE v_te010 = 1234
     * $query->filterByVTe010(array(12, 34)); // WHERE v_te010 IN (12, 34)
     * $query->filterByVTe010(array('min' => 12)); // WHERE v_te010 > 12
     * </code>
     *
     * @param     mixed $vTe010 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe010($vTe010 = null, $comparison = null)
    {
        if (is_array($vTe010)) {
            $useMinMax = false;
            if (isset($vTe010['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE010, $vTe010['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe010['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE010, $vTe010['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE010, $vTe010, $comparison);
    }

    /**
     * Filter the query on the v_te020 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe020(1234); // WHERE v_te020 = 1234
     * $query->filterByVTe020(array(12, 34)); // WHERE v_te020 IN (12, 34)
     * $query->filterByVTe020(array('min' => 12)); // WHERE v_te020 > 12
     * </code>
     *
     * @param     mixed $vTe020 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe020($vTe020 = null, $comparison = null)
    {
        if (is_array($vTe020)) {
            $useMinMax = false;
            if (isset($vTe020['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE020, $vTe020['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe020['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE020, $vTe020['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE020, $vTe020, $comparison);
    }

    /**
     * Filter the query on the v_te050 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe050(1234); // WHERE v_te050 = 1234
     * $query->filterByVTe050(array(12, 34)); // WHERE v_te050 IN (12, 34)
     * $query->filterByVTe050(array('min' => 12)); // WHERE v_te050 > 12
     * </code>
     *
     * @param     mixed $vTe050 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe050($vTe050 = null, $comparison = null)
    {
        if (is_array($vTe050)) {
            $useMinMax = false;
            if (isset($vTe050['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE050, $vTe050['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe050['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE050, $vTe050['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE050, $vTe050, $comparison);
    }

    /**
     * Filter the query on the v_te100 column
     *
     * Example usage:
     * <code>
     * $query->filterByVTe100(1234); // WHERE v_te100 = 1234
     * $query->filterByVTe100(array(12, 34)); // WHERE v_te100 IN (12, 34)
     * $query->filterByVTe100(array('min' => 12)); // WHERE v_te100 > 12
     * </code>
     *
     * @param     mixed $vTe100 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByVTe100($vTe100 = null, $comparison = null)
    {
        if (is_array($vTe100)) {
            $useMinMax = false;
            if (isset($vTe100['min'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE100, $vTe100['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vTe100['max'])) {
                $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE100, $vTe100['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_V_TE100, $vTe100, $comparison);
    }

    /**
     * Filter the query by a related \DwdStation object
     *
     * @param \DwdStation|ObjectCollection $dwdStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function filterByDwdStation($dwdStation, $comparison = null)
    {
        if ($dwdStation instanceof \DwdStation) {
            return $this
                ->addUsingAlias(DwdSoilTemperatureTableMap::COL_STATION_ID, $dwdStation->getId(), $comparison);
        } elseif ($dwdStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DwdSoilTemperatureTableMap::COL_STATION_ID, $dwdStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDwdStation() only accepts arguments of type \DwdStation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdStation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function joinDwdStation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdStation');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DwdStation');
        }

        return $this;
    }

    /**
     * Use the DwdStation relation DwdStation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdStationQuery A secondary query class using the current class as primary query
     */
    public function useDwdStationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdStation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdStation', '\DwdStationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDwdSoilTemperature $dwdSoilTemperature Object to remove from the list of results
     *
     * @return $this|ChildDwdSoilTemperatureQuery The current query, for fluid interface
     */
    public function prune($dwdSoilTemperature = null)
    {
        if ($dwdSoilTemperature) {
            $this->addUsingAlias(DwdSoilTemperatureTableMap::COL_ID, $dwdSoilTemperature->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dwd_soil_temperature table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSoilTemperatureTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DwdSoilTemperatureTableMap::clearInstancePool();
            DwdSoilTemperatureTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSoilTemperatureTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DwdSoilTemperatureTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DwdSoilTemperatureTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DwdSoilTemperatureTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DwdSoilTemperatureQuery
