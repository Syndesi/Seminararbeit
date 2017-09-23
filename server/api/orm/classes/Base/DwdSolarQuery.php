<?php

namespace Base;

use \DwdSolar as ChildDwdSolar;
use \DwdSolarQuery as ChildDwdSolarQuery;
use \Exception;
use \PDO;
use Map\DwdSolarTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dwd_solar' table.
 *
 *
 *
 * @method     ChildDwdSolarQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDwdSolarQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildDwdSolarQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildDwdSolarQuery orderByQuality($order = Criteria::ASC) Order by the quality column
 * @method     ChildDwdSolarQuery orderByAtmoLberg($order = Criteria::ASC) Order by the atmo_lberg column
 * @method     ChildDwdSolarQuery orderByFdLberg($order = Criteria::ASC) Order by the fd_lberg column
 * @method     ChildDwdSolarQuery orderByFgLberg($order = Criteria::ASC) Order by the fg_lberg column
 * @method     ChildDwdSolarQuery orderBySdLberg($order = Criteria::ASC) Order by the sd_lberg column
 * @method     ChildDwdSolarQuery orderByZenit($order = Criteria::ASC) Order by the zenit column
 *
 * @method     ChildDwdSolarQuery groupById() Group by the id column
 * @method     ChildDwdSolarQuery groupByStationId() Group by the station_id column
 * @method     ChildDwdSolarQuery groupByTime() Group by the time column
 * @method     ChildDwdSolarQuery groupByQuality() Group by the quality column
 * @method     ChildDwdSolarQuery groupByAtmoLberg() Group by the atmo_lberg column
 * @method     ChildDwdSolarQuery groupByFdLberg() Group by the fd_lberg column
 * @method     ChildDwdSolarQuery groupByFgLberg() Group by the fg_lberg column
 * @method     ChildDwdSolarQuery groupBySdLberg() Group by the sd_lberg column
 * @method     ChildDwdSolarQuery groupByZenit() Group by the zenit column
 *
 * @method     ChildDwdSolarQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDwdSolarQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDwdSolarQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDwdSolarQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDwdSolarQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDwdSolarQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDwdSolarQuery leftJoinDwdStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdSolarQuery rightJoinDwdStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdSolarQuery innerJoinDwdStation($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdStation relation
 *
 * @method     ChildDwdSolarQuery joinWithDwdStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdStation relation
 *
 * @method     ChildDwdSolarQuery leftJoinWithDwdStation() Adds a LEFT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdSolarQuery rightJoinWithDwdStation() Adds a RIGHT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdSolarQuery innerJoinWithDwdStation() Adds a INNER JOIN clause and with to the query using the DwdStation relation
 *
 * @method     \DwdStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDwdSolar findOne(ConnectionInterface $con = null) Return the first ChildDwdSolar matching the query
 * @method     ChildDwdSolar findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDwdSolar matching the query, or a new ChildDwdSolar object populated from the query conditions when no match is found
 *
 * @method     ChildDwdSolar findOneById(int $id) Return the first ChildDwdSolar filtered by the id column
 * @method     ChildDwdSolar findOneByStationId(int $station_id) Return the first ChildDwdSolar filtered by the station_id column
 * @method     ChildDwdSolar findOneByTime(string $time) Return the first ChildDwdSolar filtered by the time column
 * @method     ChildDwdSolar findOneByQuality(int $quality) Return the first ChildDwdSolar filtered by the quality column
 * @method     ChildDwdSolar findOneByAtmoLberg(double $atmo_lberg) Return the first ChildDwdSolar filtered by the atmo_lberg column
 * @method     ChildDwdSolar findOneByFdLberg(double $fd_lberg) Return the first ChildDwdSolar filtered by the fd_lberg column
 * @method     ChildDwdSolar findOneByFgLberg(double $fg_lberg) Return the first ChildDwdSolar filtered by the fg_lberg column
 * @method     ChildDwdSolar findOneBySdLberg(int $sd_lberg) Return the first ChildDwdSolar filtered by the sd_lberg column
 * @method     ChildDwdSolar findOneByZenit(double $zenit) Return the first ChildDwdSolar filtered by the zenit column *

 * @method     ChildDwdSolar requirePk($key, ConnectionInterface $con = null) Return the ChildDwdSolar by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOne(ConnectionInterface $con = null) Return the first ChildDwdSolar matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdSolar requireOneById(int $id) Return the first ChildDwdSolar filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByStationId(int $station_id) Return the first ChildDwdSolar filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByTime(string $time) Return the first ChildDwdSolar filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByQuality(int $quality) Return the first ChildDwdSolar filtered by the quality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByAtmoLberg(double $atmo_lberg) Return the first ChildDwdSolar filtered by the atmo_lberg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByFdLberg(double $fd_lberg) Return the first ChildDwdSolar filtered by the fd_lberg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByFgLberg(double $fg_lberg) Return the first ChildDwdSolar filtered by the fg_lberg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneBySdLberg(int $sd_lberg) Return the first ChildDwdSolar filtered by the sd_lberg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdSolar requireOneByZenit(double $zenit) Return the first ChildDwdSolar filtered by the zenit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdSolar[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDwdSolar objects based on current ModelCriteria
 * @method     ChildDwdSolar[]|ObjectCollection findById(int $id) Return ChildDwdSolar objects filtered by the id column
 * @method     ChildDwdSolar[]|ObjectCollection findByStationId(int $station_id) Return ChildDwdSolar objects filtered by the station_id column
 * @method     ChildDwdSolar[]|ObjectCollection findByTime(string $time) Return ChildDwdSolar objects filtered by the time column
 * @method     ChildDwdSolar[]|ObjectCollection findByQuality(int $quality) Return ChildDwdSolar objects filtered by the quality column
 * @method     ChildDwdSolar[]|ObjectCollection findByAtmoLberg(double $atmo_lberg) Return ChildDwdSolar objects filtered by the atmo_lberg column
 * @method     ChildDwdSolar[]|ObjectCollection findByFdLberg(double $fd_lberg) Return ChildDwdSolar objects filtered by the fd_lberg column
 * @method     ChildDwdSolar[]|ObjectCollection findByFgLberg(double $fg_lberg) Return ChildDwdSolar objects filtered by the fg_lberg column
 * @method     ChildDwdSolar[]|ObjectCollection findBySdLberg(int $sd_lberg) Return ChildDwdSolar objects filtered by the sd_lberg column
 * @method     ChildDwdSolar[]|ObjectCollection findByZenit(double $zenit) Return ChildDwdSolar objects filtered by the zenit column
 * @method     ChildDwdSolar[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DwdSolarQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DwdSolarQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DwdSolar', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDwdSolarQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDwdSolarQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDwdSolarQuery) {
            return $criteria;
        }
        $query = new ChildDwdSolarQuery();
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
     * @return ChildDwdSolar|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DwdSolarTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DwdSolarTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDwdSolar A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, quality, atmo_lberg, fd_lberg, fg_lberg, sd_lberg, zenit FROM dwd_solar WHERE id = :p0';
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
            /** @var ChildDwdSolar $obj */
            $obj = new ChildDwdSolar();
            $obj->hydrate($row);
            DwdSolarTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDwdSolar|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DwdSolarTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DwdSolarTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_STATION_ID, $stationId, $comparison);
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByQuality($quality = null, $comparison = null)
    {
        if (is_array($quality)) {
            $useMinMax = false;
            if (isset($quality['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_QUALITY, $quality['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quality['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_QUALITY, $quality['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_QUALITY, $quality, $comparison);
    }

    /**
     * Filter the query on the atmo_lberg column
     *
     * Example usage:
     * <code>
     * $query->filterByAtmoLberg(1234); // WHERE atmo_lberg = 1234
     * $query->filterByAtmoLberg(array(12, 34)); // WHERE atmo_lberg IN (12, 34)
     * $query->filterByAtmoLberg(array('min' => 12)); // WHERE atmo_lberg > 12
     * </code>
     *
     * @param     mixed $atmoLberg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByAtmoLberg($atmoLberg = null, $comparison = null)
    {
        if (is_array($atmoLberg)) {
            $useMinMax = false;
            if (isset($atmoLberg['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ATMO_LBERG, $atmoLberg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($atmoLberg['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ATMO_LBERG, $atmoLberg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_ATMO_LBERG, $atmoLberg, $comparison);
    }

    /**
     * Filter the query on the fd_lberg column
     *
     * Example usage:
     * <code>
     * $query->filterByFdLberg(1234); // WHERE fd_lberg = 1234
     * $query->filterByFdLberg(array(12, 34)); // WHERE fd_lberg IN (12, 34)
     * $query->filterByFdLberg(array('min' => 12)); // WHERE fd_lberg > 12
     * </code>
     *
     * @param     mixed $fdLberg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByFdLberg($fdLberg = null, $comparison = null)
    {
        if (is_array($fdLberg)) {
            $useMinMax = false;
            if (isset($fdLberg['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_FD_LBERG, $fdLberg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fdLberg['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_FD_LBERG, $fdLberg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_FD_LBERG, $fdLberg, $comparison);
    }

    /**
     * Filter the query on the fg_lberg column
     *
     * Example usage:
     * <code>
     * $query->filterByFgLberg(1234); // WHERE fg_lberg = 1234
     * $query->filterByFgLberg(array(12, 34)); // WHERE fg_lberg IN (12, 34)
     * $query->filterByFgLberg(array('min' => 12)); // WHERE fg_lberg > 12
     * </code>
     *
     * @param     mixed $fgLberg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByFgLberg($fgLberg = null, $comparison = null)
    {
        if (is_array($fgLberg)) {
            $useMinMax = false;
            if (isset($fgLberg['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_FG_LBERG, $fgLberg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fgLberg['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_FG_LBERG, $fgLberg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_FG_LBERG, $fgLberg, $comparison);
    }

    /**
     * Filter the query on the sd_lberg column
     *
     * Example usage:
     * <code>
     * $query->filterBySdLberg(1234); // WHERE sd_lberg = 1234
     * $query->filterBySdLberg(array(12, 34)); // WHERE sd_lberg IN (12, 34)
     * $query->filterBySdLberg(array('min' => 12)); // WHERE sd_lberg > 12
     * </code>
     *
     * @param     mixed $sdLberg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterBySdLberg($sdLberg = null, $comparison = null)
    {
        if (is_array($sdLberg)) {
            $useMinMax = false;
            if (isset($sdLberg['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_SD_LBERG, $sdLberg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sdLberg['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_SD_LBERG, $sdLberg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_SD_LBERG, $sdLberg, $comparison);
    }

    /**
     * Filter the query on the zenit column
     *
     * Example usage:
     * <code>
     * $query->filterByZenit(1234); // WHERE zenit = 1234
     * $query->filterByZenit(array(12, 34)); // WHERE zenit IN (12, 34)
     * $query->filterByZenit(array('min' => 12)); // WHERE zenit > 12
     * </code>
     *
     * @param     mixed $zenit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByZenit($zenit = null, $comparison = null)
    {
        if (is_array($zenit)) {
            $useMinMax = false;
            if (isset($zenit['min'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ZENIT, $zenit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($zenit['max'])) {
                $this->addUsingAlias(DwdSolarTableMap::COL_ZENIT, $zenit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdSolarTableMap::COL_ZENIT, $zenit, $comparison);
    }

    /**
     * Filter the query by a related \DwdStation object
     *
     * @param \DwdStation|ObjectCollection $dwdStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDwdSolarQuery The current query, for fluid interface
     */
    public function filterByDwdStation($dwdStation, $comparison = null)
    {
        if ($dwdStation instanceof \DwdStation) {
            return $this
                ->addUsingAlias(DwdSolarTableMap::COL_STATION_ID, $dwdStation->getId(), $comparison);
        } elseif ($dwdStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DwdSolarTableMap::COL_STATION_ID, $dwdStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
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
     * @param   ChildDwdSolar $dwdSolar Object to remove from the list of results
     *
     * @return $this|ChildDwdSolarQuery The current query, for fluid interface
     */
    public function prune($dwdSolar = null)
    {
        if ($dwdSolar) {
            $this->addUsingAlias(DwdSolarTableMap::COL_ID, $dwdSolar->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dwd_solar table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSolarTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DwdSolarTableMap::clearInstancePool();
            DwdSolarTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdSolarTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DwdSolarTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DwdSolarTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DwdSolarTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DwdSolarQuery
