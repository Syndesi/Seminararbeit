<?php

namespace Base;

use \DwdStation as ChildDwdStation;
use \DwdStationQuery as ChildDwdStationQuery;
use \Exception;
use \PDO;
use Map\DwdStationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dwd_station' table.
 *
 *
 *
 * @method     ChildDwdStationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDwdStationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildDwdStationQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildDwdStationQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildDwdStationQuery orderByAlt($order = Criteria::ASC) Order by the alt column
 *
 * @method     ChildDwdStationQuery groupById() Group by the id column
 * @method     ChildDwdStationQuery groupByName() Group by the name column
 * @method     ChildDwdStationQuery groupByLat() Group by the lat column
 * @method     ChildDwdStationQuery groupByLng() Group by the lng column
 * @method     ChildDwdStationQuery groupByAlt() Group by the alt column
 *
 * @method     ChildDwdStationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDwdStationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDwdStationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDwdStationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDwdStationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDwdStationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDwdStationQuery leftJoinDwdAirTemperature($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdAirTemperature relation
 * @method     ChildDwdStationQuery rightJoinDwdAirTemperature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdAirTemperature relation
 * @method     ChildDwdStationQuery innerJoinDwdAirTemperature($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdAirTemperature relation
 *
 * @method     ChildDwdStationQuery joinWithDwdAirTemperature($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdAirTemperature relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdAirTemperature() Adds a LEFT JOIN clause and with to the query using the DwdAirTemperature relation
 * @method     ChildDwdStationQuery rightJoinWithDwdAirTemperature() Adds a RIGHT JOIN clause and with to the query using the DwdAirTemperature relation
 * @method     ChildDwdStationQuery innerJoinWithDwdAirTemperature() Adds a INNER JOIN clause and with to the query using the DwdAirTemperature relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdCloudines($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdCloudines relation
 * @method     ChildDwdStationQuery rightJoinDwdCloudines($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdCloudines relation
 * @method     ChildDwdStationQuery innerJoinDwdCloudines($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdCloudines relation
 *
 * @method     ChildDwdStationQuery joinWithDwdCloudines($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdCloudines relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdCloudines() Adds a LEFT JOIN clause and with to the query using the DwdCloudines relation
 * @method     ChildDwdStationQuery rightJoinWithDwdCloudines() Adds a RIGHT JOIN clause and with to the query using the DwdCloudines relation
 * @method     ChildDwdStationQuery innerJoinWithDwdCloudines() Adds a INNER JOIN clause and with to the query using the DwdCloudines relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdPrecipitation($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdPrecipitation relation
 * @method     ChildDwdStationQuery rightJoinDwdPrecipitation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdPrecipitation relation
 * @method     ChildDwdStationQuery innerJoinDwdPrecipitation($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdPrecipitation relation
 *
 * @method     ChildDwdStationQuery joinWithDwdPrecipitation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdPrecipitation relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdPrecipitation() Adds a LEFT JOIN clause and with to the query using the DwdPrecipitation relation
 * @method     ChildDwdStationQuery rightJoinWithDwdPrecipitation() Adds a RIGHT JOIN clause and with to the query using the DwdPrecipitation relation
 * @method     ChildDwdStationQuery innerJoinWithDwdPrecipitation() Adds a INNER JOIN clause and with to the query using the DwdPrecipitation relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdPressure($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdPressure relation
 * @method     ChildDwdStationQuery rightJoinDwdPressure($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdPressure relation
 * @method     ChildDwdStationQuery innerJoinDwdPressure($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdPressure relation
 *
 * @method     ChildDwdStationQuery joinWithDwdPressure($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdPressure relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdPressure() Adds a LEFT JOIN clause and with to the query using the DwdPressure relation
 * @method     ChildDwdStationQuery rightJoinWithDwdPressure() Adds a RIGHT JOIN clause and with to the query using the DwdPressure relation
 * @method     ChildDwdStationQuery innerJoinWithDwdPressure() Adds a INNER JOIN clause and with to the query using the DwdPressure relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdSoilTemperature($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdSoilTemperature relation
 * @method     ChildDwdStationQuery rightJoinDwdSoilTemperature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdSoilTemperature relation
 * @method     ChildDwdStationQuery innerJoinDwdSoilTemperature($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdSoilTemperature relation
 *
 * @method     ChildDwdStationQuery joinWithDwdSoilTemperature($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdSoilTemperature relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdSoilTemperature() Adds a LEFT JOIN clause and with to the query using the DwdSoilTemperature relation
 * @method     ChildDwdStationQuery rightJoinWithDwdSoilTemperature() Adds a RIGHT JOIN clause and with to the query using the DwdSoilTemperature relation
 * @method     ChildDwdStationQuery innerJoinWithDwdSoilTemperature() Adds a INNER JOIN clause and with to the query using the DwdSoilTemperature relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdSolar($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdSolar relation
 * @method     ChildDwdStationQuery rightJoinDwdSolar($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdSolar relation
 * @method     ChildDwdStationQuery innerJoinDwdSolar($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdSolar relation
 *
 * @method     ChildDwdStationQuery joinWithDwdSolar($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdSolar relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdSolar() Adds a LEFT JOIN clause and with to the query using the DwdSolar relation
 * @method     ChildDwdStationQuery rightJoinWithDwdSolar() Adds a RIGHT JOIN clause and with to the query using the DwdSolar relation
 * @method     ChildDwdStationQuery innerJoinWithDwdSolar() Adds a INNER JOIN clause and with to the query using the DwdSolar relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdSun($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdSun relation
 * @method     ChildDwdStationQuery rightJoinDwdSun($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdSun relation
 * @method     ChildDwdStationQuery innerJoinDwdSun($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdSun relation
 *
 * @method     ChildDwdStationQuery joinWithDwdSun($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdSun relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdSun() Adds a LEFT JOIN clause and with to the query using the DwdSun relation
 * @method     ChildDwdStationQuery rightJoinWithDwdSun() Adds a RIGHT JOIN clause and with to the query using the DwdSun relation
 * @method     ChildDwdStationQuery innerJoinWithDwdSun() Adds a INNER JOIN clause and with to the query using the DwdSun relation
 *
 * @method     ChildDwdStationQuery leftJoinDwdWind($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdWind relation
 * @method     ChildDwdStationQuery rightJoinDwdWind($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdWind relation
 * @method     ChildDwdStationQuery innerJoinDwdWind($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdWind relation
 *
 * @method     ChildDwdStationQuery joinWithDwdWind($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdWind relation
 *
 * @method     ChildDwdStationQuery leftJoinWithDwdWind() Adds a LEFT JOIN clause and with to the query using the DwdWind relation
 * @method     ChildDwdStationQuery rightJoinWithDwdWind() Adds a RIGHT JOIN clause and with to the query using the DwdWind relation
 * @method     ChildDwdStationQuery innerJoinWithDwdWind() Adds a INNER JOIN clause and with to the query using the DwdWind relation
 *
 * @method     \DwdAirTemperatureQuery|\DwdCloudinesQuery|\DwdPrecipitationQuery|\DwdPressureQuery|\DwdSoilTemperatureQuery|\DwdSolarQuery|\DwdSunQuery|\DwdWindQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDwdStation findOne(ConnectionInterface $con = null) Return the first ChildDwdStation matching the query
 * @method     ChildDwdStation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDwdStation matching the query, or a new ChildDwdStation object populated from the query conditions when no match is found
 *
 * @method     ChildDwdStation findOneById(int $id) Return the first ChildDwdStation filtered by the id column
 * @method     ChildDwdStation findOneByName(string $name) Return the first ChildDwdStation filtered by the name column
 * @method     ChildDwdStation findOneByLat(double $lat) Return the first ChildDwdStation filtered by the lat column
 * @method     ChildDwdStation findOneByLng(double $lng) Return the first ChildDwdStation filtered by the lng column
 * @method     ChildDwdStation findOneByAlt(double $alt) Return the first ChildDwdStation filtered by the alt column *

 * @method     ChildDwdStation requirePk($key, ConnectionInterface $con = null) Return the ChildDwdStation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdStation requireOne(ConnectionInterface $con = null) Return the first ChildDwdStation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdStation requireOneById(int $id) Return the first ChildDwdStation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdStation requireOneByName(string $name) Return the first ChildDwdStation filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdStation requireOneByLat(double $lat) Return the first ChildDwdStation filtered by the lat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdStation requireOneByLng(double $lng) Return the first ChildDwdStation filtered by the lng column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdStation requireOneByAlt(double $alt) Return the first ChildDwdStation filtered by the alt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdStation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDwdStation objects based on current ModelCriteria
 * @method     ChildDwdStation[]|ObjectCollection findById(int $id) Return ChildDwdStation objects filtered by the id column
 * @method     ChildDwdStation[]|ObjectCollection findByName(string $name) Return ChildDwdStation objects filtered by the name column
 * @method     ChildDwdStation[]|ObjectCollection findByLat(double $lat) Return ChildDwdStation objects filtered by the lat column
 * @method     ChildDwdStation[]|ObjectCollection findByLng(double $lng) Return ChildDwdStation objects filtered by the lng column
 * @method     ChildDwdStation[]|ObjectCollection findByAlt(double $alt) Return ChildDwdStation objects filtered by the alt column
 * @method     ChildDwdStation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DwdStationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DwdStationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DwdStation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDwdStationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDwdStationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDwdStationQuery) {
            return $criteria;
        }
        $query = new ChildDwdStationQuery();
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
     * @return ChildDwdStation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DwdStationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DwdStationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDwdStation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, lat, lng, alt FROM dwd_station WHERE id = :p0';
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
            /** @var ChildDwdStation $obj */
            $obj = new ChildDwdStation();
            $obj->hydrate($row);
            DwdStationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDwdStation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DwdStationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DwdStationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdStationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdStationTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the lat column
     *
     * Example usage:
     * <code>
     * $query->filterByLat(1234); // WHERE lat = 1234
     * $query->filterByLat(array(12, 34)); // WHERE lat IN (12, 34)
     * $query->filterByLat(array('min' => 12)); // WHERE lat > 12
     * </code>
     *
     * @param     mixed $lat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByLat($lat = null, $comparison = null)
    {
        if (is_array($lat)) {
            $useMinMax = false;
            if (isset($lat['min'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_LAT, $lat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lat['max'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_LAT, $lat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdStationTableMap::COL_LAT, $lat, $comparison);
    }

    /**
     * Filter the query on the lng column
     *
     * Example usage:
     * <code>
     * $query->filterByLng(1234); // WHERE lng = 1234
     * $query->filterByLng(array(12, 34)); // WHERE lng IN (12, 34)
     * $query->filterByLng(array('min' => 12)); // WHERE lng > 12
     * </code>
     *
     * @param     mixed $lng The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByLng($lng = null, $comparison = null)
    {
        if (is_array($lng)) {
            $useMinMax = false;
            if (isset($lng['min'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_LNG, $lng['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lng['max'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_LNG, $lng['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdStationTableMap::COL_LNG, $lng, $comparison);
    }

    /**
     * Filter the query on the alt column
     *
     * Example usage:
     * <code>
     * $query->filterByAlt(1234); // WHERE alt = 1234
     * $query->filterByAlt(array(12, 34)); // WHERE alt IN (12, 34)
     * $query->filterByAlt(array('min' => 12)); // WHERE alt > 12
     * </code>
     *
     * @param     mixed $alt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByAlt($alt = null, $comparison = null)
    {
        if (is_array($alt)) {
            $useMinMax = false;
            if (isset($alt['min'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_ALT, $alt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alt['max'])) {
                $this->addUsingAlias(DwdStationTableMap::COL_ALT, $alt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdStationTableMap::COL_ALT, $alt, $comparison);
    }

    /**
     * Filter the query by a related \DwdAirTemperature object
     *
     * @param \DwdAirTemperature|ObjectCollection $dwdAirTemperature the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdAirTemperature($dwdAirTemperature, $comparison = null)
    {
        if ($dwdAirTemperature instanceof \DwdAirTemperature) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdAirTemperature->getStationId(), $comparison);
        } elseif ($dwdAirTemperature instanceof ObjectCollection) {
            return $this
                ->useDwdAirTemperatureQuery()
                ->filterByPrimaryKeys($dwdAirTemperature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdAirTemperature() only accepts arguments of type \DwdAirTemperature or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdAirTemperature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdAirTemperature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdAirTemperature');

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
            $this->addJoinObject($join, 'DwdAirTemperature');
        }

        return $this;
    }

    /**
     * Use the DwdAirTemperature relation DwdAirTemperature object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdAirTemperatureQuery A secondary query class using the current class as primary query
     */
    public function useDwdAirTemperatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdAirTemperature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdAirTemperature', '\DwdAirTemperatureQuery');
    }

    /**
     * Filter the query by a related \DwdCloudines object
     *
     * @param \DwdCloudines|ObjectCollection $dwdCloudines the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdCloudines($dwdCloudines, $comparison = null)
    {
        if ($dwdCloudines instanceof \DwdCloudines) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdCloudines->getStationId(), $comparison);
        } elseif ($dwdCloudines instanceof ObjectCollection) {
            return $this
                ->useDwdCloudinesQuery()
                ->filterByPrimaryKeys($dwdCloudines->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdCloudines() only accepts arguments of type \DwdCloudines or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdCloudines relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdCloudines($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdCloudines');

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
            $this->addJoinObject($join, 'DwdCloudines');
        }

        return $this;
    }

    /**
     * Use the DwdCloudines relation DwdCloudines object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdCloudinesQuery A secondary query class using the current class as primary query
     */
    public function useDwdCloudinesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdCloudines($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdCloudines', '\DwdCloudinesQuery');
    }

    /**
     * Filter the query by a related \DwdPrecipitation object
     *
     * @param \DwdPrecipitation|ObjectCollection $dwdPrecipitation the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdPrecipitation($dwdPrecipitation, $comparison = null)
    {
        if ($dwdPrecipitation instanceof \DwdPrecipitation) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdPrecipitation->getStationId(), $comparison);
        } elseif ($dwdPrecipitation instanceof ObjectCollection) {
            return $this
                ->useDwdPrecipitationQuery()
                ->filterByPrimaryKeys($dwdPrecipitation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdPrecipitation() only accepts arguments of type \DwdPrecipitation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdPrecipitation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdPrecipitation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdPrecipitation');

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
            $this->addJoinObject($join, 'DwdPrecipitation');
        }

        return $this;
    }

    /**
     * Use the DwdPrecipitation relation DwdPrecipitation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdPrecipitationQuery A secondary query class using the current class as primary query
     */
    public function useDwdPrecipitationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdPrecipitation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdPrecipitation', '\DwdPrecipitationQuery');
    }

    /**
     * Filter the query by a related \DwdPressure object
     *
     * @param \DwdPressure|ObjectCollection $dwdPressure the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdPressure($dwdPressure, $comparison = null)
    {
        if ($dwdPressure instanceof \DwdPressure) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdPressure->getStationId(), $comparison);
        } elseif ($dwdPressure instanceof ObjectCollection) {
            return $this
                ->useDwdPressureQuery()
                ->filterByPrimaryKeys($dwdPressure->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdPressure() only accepts arguments of type \DwdPressure or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdPressure relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdPressure($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdPressure');

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
            $this->addJoinObject($join, 'DwdPressure');
        }

        return $this;
    }

    /**
     * Use the DwdPressure relation DwdPressure object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdPressureQuery A secondary query class using the current class as primary query
     */
    public function useDwdPressureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdPressure($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdPressure', '\DwdPressureQuery');
    }

    /**
     * Filter the query by a related \DwdSoilTemperature object
     *
     * @param \DwdSoilTemperature|ObjectCollection $dwdSoilTemperature the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdSoilTemperature($dwdSoilTemperature, $comparison = null)
    {
        if ($dwdSoilTemperature instanceof \DwdSoilTemperature) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdSoilTemperature->getStationId(), $comparison);
        } elseif ($dwdSoilTemperature instanceof ObjectCollection) {
            return $this
                ->useDwdSoilTemperatureQuery()
                ->filterByPrimaryKeys($dwdSoilTemperature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdSoilTemperature() only accepts arguments of type \DwdSoilTemperature or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdSoilTemperature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdSoilTemperature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdSoilTemperature');

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
            $this->addJoinObject($join, 'DwdSoilTemperature');
        }

        return $this;
    }

    /**
     * Use the DwdSoilTemperature relation DwdSoilTemperature object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdSoilTemperatureQuery A secondary query class using the current class as primary query
     */
    public function useDwdSoilTemperatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdSoilTemperature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdSoilTemperature', '\DwdSoilTemperatureQuery');
    }

    /**
     * Filter the query by a related \DwdSolar object
     *
     * @param \DwdSolar|ObjectCollection $dwdSolar the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdSolar($dwdSolar, $comparison = null)
    {
        if ($dwdSolar instanceof \DwdSolar) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdSolar->getStationId(), $comparison);
        } elseif ($dwdSolar instanceof ObjectCollection) {
            return $this
                ->useDwdSolarQuery()
                ->filterByPrimaryKeys($dwdSolar->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdSolar() only accepts arguments of type \DwdSolar or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdSolar relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdSolar($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdSolar');

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
            $this->addJoinObject($join, 'DwdSolar');
        }

        return $this;
    }

    /**
     * Use the DwdSolar relation DwdSolar object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdSolarQuery A secondary query class using the current class as primary query
     */
    public function useDwdSolarQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdSolar($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdSolar', '\DwdSolarQuery');
    }

    /**
     * Filter the query by a related \DwdSun object
     *
     * @param \DwdSun|ObjectCollection $dwdSun the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdSun($dwdSun, $comparison = null)
    {
        if ($dwdSun instanceof \DwdSun) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdSun->getStationId(), $comparison);
        } elseif ($dwdSun instanceof ObjectCollection) {
            return $this
                ->useDwdSunQuery()
                ->filterByPrimaryKeys($dwdSun->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdSun() only accepts arguments of type \DwdSun or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdSun relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdSun($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdSun');

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
            $this->addJoinObject($join, 'DwdSun');
        }

        return $this;
    }

    /**
     * Use the DwdSun relation DwdSun object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdSunQuery A secondary query class using the current class as primary query
     */
    public function useDwdSunQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdSun($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdSun', '\DwdSunQuery');
    }

    /**
     * Filter the query by a related \DwdWind object
     *
     * @param \DwdWind|ObjectCollection $dwdWind the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDwdStationQuery The current query, for fluid interface
     */
    public function filterByDwdWind($dwdWind, $comparison = null)
    {
        if ($dwdWind instanceof \DwdWind) {
            return $this
                ->addUsingAlias(DwdStationTableMap::COL_ID, $dwdWind->getStationId(), $comparison);
        } elseif ($dwdWind instanceof ObjectCollection) {
            return $this
                ->useDwdWindQuery()
                ->filterByPrimaryKeys($dwdWind->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDwdWind() only accepts arguments of type \DwdWind or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DwdWind relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function joinDwdWind($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DwdWind');

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
            $this->addJoinObject($join, 'DwdWind');
        }

        return $this;
    }

    /**
     * Use the DwdWind relation DwdWind object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DwdWindQuery A secondary query class using the current class as primary query
     */
    public function useDwdWindQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDwdWind($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DwdWind', '\DwdWindQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDwdStation $dwdStation Object to remove from the list of results
     *
     * @return $this|ChildDwdStationQuery The current query, for fluid interface
     */
    public function prune($dwdStation = null)
    {
        if ($dwdStation) {
            $this->addUsingAlias(DwdStationTableMap::COL_ID, $dwdStation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dwd_station table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdStationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DwdStationTableMap::clearInstancePool();
            DwdStationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdStationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DwdStationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DwdStationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DwdStationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DwdStationQuery
