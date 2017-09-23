<?php

namespace Base;

use \DwdPrecipitation as ChildDwdPrecipitation;
use \DwdPrecipitationQuery as ChildDwdPrecipitationQuery;
use \Exception;
use \PDO;
use Map\DwdPrecipitationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dwd_precipitation' table.
 *
 *
 *
 * @method     ChildDwdPrecipitationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDwdPrecipitationQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildDwdPrecipitationQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildDwdPrecipitationQuery orderByQuality($order = Criteria::ASC) Order by the quality column
 * @method     ChildDwdPrecipitationQuery orderByR1($order = Criteria::ASC) Order by the r1 column
 * @method     ChildDwdPrecipitationQuery orderByRsInd($order = Criteria::ASC) Order by the rs_ind column
 * @method     ChildDwdPrecipitationQuery orderByWrtr($order = Criteria::ASC) Order by the wrtr column
 *
 * @method     ChildDwdPrecipitationQuery groupById() Group by the id column
 * @method     ChildDwdPrecipitationQuery groupByStationId() Group by the station_id column
 * @method     ChildDwdPrecipitationQuery groupByTime() Group by the time column
 * @method     ChildDwdPrecipitationQuery groupByQuality() Group by the quality column
 * @method     ChildDwdPrecipitationQuery groupByR1() Group by the r1 column
 * @method     ChildDwdPrecipitationQuery groupByRsInd() Group by the rs_ind column
 * @method     ChildDwdPrecipitationQuery groupByWrtr() Group by the wrtr column
 *
 * @method     ChildDwdPrecipitationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDwdPrecipitationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDwdPrecipitationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDwdPrecipitationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDwdPrecipitationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDwdPrecipitationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDwdPrecipitationQuery leftJoinDwdStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdPrecipitationQuery rightJoinDwdStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdPrecipitationQuery innerJoinDwdStation($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdStation relation
 *
 * @method     ChildDwdPrecipitationQuery joinWithDwdStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdStation relation
 *
 * @method     ChildDwdPrecipitationQuery leftJoinWithDwdStation() Adds a LEFT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdPrecipitationQuery rightJoinWithDwdStation() Adds a RIGHT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdPrecipitationQuery innerJoinWithDwdStation() Adds a INNER JOIN clause and with to the query using the DwdStation relation
 *
 * @method     \DwdStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDwdPrecipitation findOne(ConnectionInterface $con = null) Return the first ChildDwdPrecipitation matching the query
 * @method     ChildDwdPrecipitation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDwdPrecipitation matching the query, or a new ChildDwdPrecipitation object populated from the query conditions when no match is found
 *
 * @method     ChildDwdPrecipitation findOneById(int $id) Return the first ChildDwdPrecipitation filtered by the id column
 * @method     ChildDwdPrecipitation findOneByStationId(int $station_id) Return the first ChildDwdPrecipitation filtered by the station_id column
 * @method     ChildDwdPrecipitation findOneByTime(string $time) Return the first ChildDwdPrecipitation filtered by the time column
 * @method     ChildDwdPrecipitation findOneByQuality(int $quality) Return the first ChildDwdPrecipitation filtered by the quality column
 * @method     ChildDwdPrecipitation findOneByR1(double $r1) Return the first ChildDwdPrecipitation filtered by the r1 column
 * @method     ChildDwdPrecipitation findOneByRsInd(boolean $rs_ind) Return the first ChildDwdPrecipitation filtered by the rs_ind column
 * @method     ChildDwdPrecipitation findOneByWrtr(int $wrtr) Return the first ChildDwdPrecipitation filtered by the wrtr column *

 * @method     ChildDwdPrecipitation requirePk($key, ConnectionInterface $con = null) Return the ChildDwdPrecipitation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOne(ConnectionInterface $con = null) Return the first ChildDwdPrecipitation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdPrecipitation requireOneById(int $id) Return the first ChildDwdPrecipitation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByStationId(int $station_id) Return the first ChildDwdPrecipitation filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByTime(string $time) Return the first ChildDwdPrecipitation filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByQuality(int $quality) Return the first ChildDwdPrecipitation filtered by the quality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByR1(double $r1) Return the first ChildDwdPrecipitation filtered by the r1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByRsInd(boolean $rs_ind) Return the first ChildDwdPrecipitation filtered by the rs_ind column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdPrecipitation requireOneByWrtr(int $wrtr) Return the first ChildDwdPrecipitation filtered by the wrtr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdPrecipitation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDwdPrecipitation objects based on current ModelCriteria
 * @method     ChildDwdPrecipitation[]|ObjectCollection findById(int $id) Return ChildDwdPrecipitation objects filtered by the id column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByStationId(int $station_id) Return ChildDwdPrecipitation objects filtered by the station_id column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByTime(string $time) Return ChildDwdPrecipitation objects filtered by the time column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByQuality(int $quality) Return ChildDwdPrecipitation objects filtered by the quality column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByR1(double $r1) Return ChildDwdPrecipitation objects filtered by the r1 column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByRsInd(boolean $rs_ind) Return ChildDwdPrecipitation objects filtered by the rs_ind column
 * @method     ChildDwdPrecipitation[]|ObjectCollection findByWrtr(int $wrtr) Return ChildDwdPrecipitation objects filtered by the wrtr column
 * @method     ChildDwdPrecipitation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DwdPrecipitationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DwdPrecipitationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DwdPrecipitation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDwdPrecipitationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDwdPrecipitationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDwdPrecipitationQuery) {
            return $criteria;
        }
        $query = new ChildDwdPrecipitationQuery();
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
     * @return ChildDwdPrecipitation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DwdPrecipitationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DwdPrecipitationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDwdPrecipitation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, quality, r1, rs_ind, wrtr FROM dwd_precipitation WHERE id = :p0';
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
            /** @var ChildDwdPrecipitation $obj */
            $obj = new ChildDwdPrecipitation();
            $obj->hydrate($row);
            DwdPrecipitationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDwdPrecipitation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_STATION_ID, $stationId, $comparison);
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByQuality($quality = null, $comparison = null)
    {
        if (is_array($quality)) {
            $useMinMax = false;
            if (isset($quality['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_QUALITY, $quality['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quality['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_QUALITY, $quality['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_QUALITY, $quality, $comparison);
    }

    /**
     * Filter the query on the r1 column
     *
     * Example usage:
     * <code>
     * $query->filterByR1(1234); // WHERE r1 = 1234
     * $query->filterByR1(array(12, 34)); // WHERE r1 IN (12, 34)
     * $query->filterByR1(array('min' => 12)); // WHERE r1 > 12
     * </code>
     *
     * @param     mixed $r1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByR1($r1 = null, $comparison = null)
    {
        if (is_array($r1)) {
            $useMinMax = false;
            if (isset($r1['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_R1, $r1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($r1['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_R1, $r1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_R1, $r1, $comparison);
    }

    /**
     * Filter the query on the rs_ind column
     *
     * Example usage:
     * <code>
     * $query->filterByRsInd(true); // WHERE rs_ind = true
     * $query->filterByRsInd('yes'); // WHERE rs_ind = true
     * </code>
     *
     * @param     boolean|string $rsInd The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByRsInd($rsInd = null, $comparison = null)
    {
        if (is_string($rsInd)) {
            $rsInd = in_array(strtolower($rsInd), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_RS_IND, $rsInd, $comparison);
    }

    /**
     * Filter the query on the wrtr column
     *
     * Example usage:
     * <code>
     * $query->filterByWrtr(1234); // WHERE wrtr = 1234
     * $query->filterByWrtr(array(12, 34)); // WHERE wrtr IN (12, 34)
     * $query->filterByWrtr(array('min' => 12)); // WHERE wrtr > 12
     * </code>
     *
     * @param     mixed $wrtr The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByWrtr($wrtr = null, $comparison = null)
    {
        if (is_array($wrtr)) {
            $useMinMax = false;
            if (isset($wrtr['min'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_WRTR, $wrtr['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wrtr['max'])) {
                $this->addUsingAlias(DwdPrecipitationTableMap::COL_WRTR, $wrtr['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdPrecipitationTableMap::COL_WRTR, $wrtr, $comparison);
    }

    /**
     * Filter the query by a related \DwdStation object
     *
     * @param \DwdStation|ObjectCollection $dwdStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function filterByDwdStation($dwdStation, $comparison = null)
    {
        if ($dwdStation instanceof \DwdStation) {
            return $this
                ->addUsingAlias(DwdPrecipitationTableMap::COL_STATION_ID, $dwdStation->getId(), $comparison);
        } elseif ($dwdStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DwdPrecipitationTableMap::COL_STATION_ID, $dwdStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
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
     * @param   ChildDwdPrecipitation $dwdPrecipitation Object to remove from the list of results
     *
     * @return $this|ChildDwdPrecipitationQuery The current query, for fluid interface
     */
    public function prune($dwdPrecipitation = null)
    {
        if ($dwdPrecipitation) {
            $this->addUsingAlias(DwdPrecipitationTableMap::COL_ID, $dwdPrecipitation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dwd_precipitation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdPrecipitationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DwdPrecipitationTableMap::clearInstancePool();
            DwdPrecipitationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdPrecipitationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DwdPrecipitationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DwdPrecipitationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DwdPrecipitationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DwdPrecipitationQuery
