<?php

namespace Base;

use \UbaStation as ChildUbaStation;
use \UbaStationQuery as ChildUbaStationQuery;
use \Exception;
use \PDO;
use Map\UbaStationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'uba_station' table.
 *
 *
 *
 * @method     ChildUbaStationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUbaStationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUbaStationQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildUbaStationQuery orderByNetwork($order = Criteria::ASC) Order by the network column
 * @method     ChildUbaStationQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildUbaStationQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildUbaStationQuery orderByAlt($order = Criteria::ASC) Order by the alt column
 *
 * @method     ChildUbaStationQuery groupById() Group by the id column
 * @method     ChildUbaStationQuery groupByName() Group by the name column
 * @method     ChildUbaStationQuery groupByCode() Group by the code column
 * @method     ChildUbaStationQuery groupByNetwork() Group by the network column
 * @method     ChildUbaStationQuery groupByLat() Group by the lat column
 * @method     ChildUbaStationQuery groupByLng() Group by the lng column
 * @method     ChildUbaStationQuery groupByAlt() Group by the alt column
 *
 * @method     ChildUbaStationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUbaStationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUbaStationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUbaStationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUbaStationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUbaStationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUbaStationQuery leftJoinUbaO3($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaO3 relation
 * @method     ChildUbaStationQuery rightJoinUbaO3($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaO3 relation
 * @method     ChildUbaStationQuery innerJoinUbaO3($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaO3 relation
 *
 * @method     ChildUbaStationQuery joinWithUbaO3($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaO3 relation
 *
 * @method     ChildUbaStationQuery leftJoinWithUbaO3() Adds a LEFT JOIN clause and with to the query using the UbaO3 relation
 * @method     ChildUbaStationQuery rightJoinWithUbaO3() Adds a RIGHT JOIN clause and with to the query using the UbaO3 relation
 * @method     ChildUbaStationQuery innerJoinWithUbaO3() Adds a INNER JOIN clause and with to the query using the UbaO3 relation
 *
 * @method     ChildUbaStationQuery leftJoinUbaSO2($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaSO2 relation
 * @method     ChildUbaStationQuery rightJoinUbaSO2($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaSO2 relation
 * @method     ChildUbaStationQuery innerJoinUbaSO2($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaSO2 relation
 *
 * @method     ChildUbaStationQuery joinWithUbaSO2($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaSO2 relation
 *
 * @method     ChildUbaStationQuery leftJoinWithUbaSO2() Adds a LEFT JOIN clause and with to the query using the UbaSO2 relation
 * @method     ChildUbaStationQuery rightJoinWithUbaSO2() Adds a RIGHT JOIN clause and with to the query using the UbaSO2 relation
 * @method     ChildUbaStationQuery innerJoinWithUbaSO2() Adds a INNER JOIN clause and with to the query using the UbaSO2 relation
 *
 * @method     ChildUbaStationQuery leftJoinUbaPM10($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaPM10 relation
 * @method     ChildUbaStationQuery rightJoinUbaPM10($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaPM10 relation
 * @method     ChildUbaStationQuery innerJoinUbaPM10($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaPM10 relation
 *
 * @method     ChildUbaStationQuery joinWithUbaPM10($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaPM10 relation
 *
 * @method     ChildUbaStationQuery leftJoinWithUbaPM10() Adds a LEFT JOIN clause and with to the query using the UbaPM10 relation
 * @method     ChildUbaStationQuery rightJoinWithUbaPM10() Adds a RIGHT JOIN clause and with to the query using the UbaPM10 relation
 * @method     ChildUbaStationQuery innerJoinWithUbaPM10() Adds a INNER JOIN clause and with to the query using the UbaPM10 relation
 *
 * @method     ChildUbaStationQuery leftJoinUbaNO2($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaNO2 relation
 * @method     ChildUbaStationQuery rightJoinUbaNO2($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaNO2 relation
 * @method     ChildUbaStationQuery innerJoinUbaNO2($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaNO2 relation
 *
 * @method     ChildUbaStationQuery joinWithUbaNO2($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaNO2 relation
 *
 * @method     ChildUbaStationQuery leftJoinWithUbaNO2() Adds a LEFT JOIN clause and with to the query using the UbaNO2 relation
 * @method     ChildUbaStationQuery rightJoinWithUbaNO2() Adds a RIGHT JOIN clause and with to the query using the UbaNO2 relation
 * @method     ChildUbaStationQuery innerJoinWithUbaNO2() Adds a INNER JOIN clause and with to the query using the UbaNO2 relation
 *
 * @method     ChildUbaStationQuery leftJoinUbaCO($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaCO relation
 * @method     ChildUbaStationQuery rightJoinUbaCO($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaCO relation
 * @method     ChildUbaStationQuery innerJoinUbaCO($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaCO relation
 *
 * @method     ChildUbaStationQuery joinWithUbaCO($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaCO relation
 *
 * @method     ChildUbaStationQuery leftJoinWithUbaCO() Adds a LEFT JOIN clause and with to the query using the UbaCO relation
 * @method     ChildUbaStationQuery rightJoinWithUbaCO() Adds a RIGHT JOIN clause and with to the query using the UbaCO relation
 * @method     ChildUbaStationQuery innerJoinWithUbaCO() Adds a INNER JOIN clause and with to the query using the UbaCO relation
 *
 * @method     \UbaO3Query|\UbaSO2Query|\UbaPM10Query|\UbaNO2Query|\UbaCOQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUbaStation findOne(ConnectionInterface $con = null) Return the first ChildUbaStation matching the query
 * @method     ChildUbaStation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUbaStation matching the query, or a new ChildUbaStation object populated from the query conditions when no match is found
 *
 * @method     ChildUbaStation findOneById(int $id) Return the first ChildUbaStation filtered by the id column
 * @method     ChildUbaStation findOneByName(string $name) Return the first ChildUbaStation filtered by the name column
 * @method     ChildUbaStation findOneByCode(string $code) Return the first ChildUbaStation filtered by the code column
 * @method     ChildUbaStation findOneByNetwork(string $network) Return the first ChildUbaStation filtered by the network column
 * @method     ChildUbaStation findOneByLat(double $lat) Return the first ChildUbaStation filtered by the lat column
 * @method     ChildUbaStation findOneByLng(double $lng) Return the first ChildUbaStation filtered by the lng column
 * @method     ChildUbaStation findOneByAlt(double $alt) Return the first ChildUbaStation filtered by the alt column *

 * @method     ChildUbaStation requirePk($key, ConnectionInterface $con = null) Return the ChildUbaStation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOne(ConnectionInterface $con = null) Return the first ChildUbaStation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaStation requireOneById(int $id) Return the first ChildUbaStation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByName(string $name) Return the first ChildUbaStation filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByCode(string $code) Return the first ChildUbaStation filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByNetwork(string $network) Return the first ChildUbaStation filtered by the network column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByLat(double $lat) Return the first ChildUbaStation filtered by the lat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByLng(double $lng) Return the first ChildUbaStation filtered by the lng column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaStation requireOneByAlt(double $alt) Return the first ChildUbaStation filtered by the alt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaStation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUbaStation objects based on current ModelCriteria
 * @method     ChildUbaStation[]|ObjectCollection findById(int $id) Return ChildUbaStation objects filtered by the id column
 * @method     ChildUbaStation[]|ObjectCollection findByName(string $name) Return ChildUbaStation objects filtered by the name column
 * @method     ChildUbaStation[]|ObjectCollection findByCode(string $code) Return ChildUbaStation objects filtered by the code column
 * @method     ChildUbaStation[]|ObjectCollection findByNetwork(string $network) Return ChildUbaStation objects filtered by the network column
 * @method     ChildUbaStation[]|ObjectCollection findByLat(double $lat) Return ChildUbaStation objects filtered by the lat column
 * @method     ChildUbaStation[]|ObjectCollection findByLng(double $lng) Return ChildUbaStation objects filtered by the lng column
 * @method     ChildUbaStation[]|ObjectCollection findByAlt(double $alt) Return ChildUbaStation objects filtered by the alt column
 * @method     ChildUbaStation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UbaStationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UbaStationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UbaStation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUbaStationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUbaStationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUbaStationQuery) {
            return $criteria;
        }
        $query = new ChildUbaStationQuery();
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
     * @return ChildUbaStation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UbaStationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UbaStationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUbaStation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, code, network, lat, lng, alt FROM uba_station WHERE id = :p0';
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
            /** @var ChildUbaStation $obj */
            $obj = new ChildUbaStation();
            $obj->hydrate($row);
            UbaStationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUbaStation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UbaStationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UbaStationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the network column
     *
     * Example usage:
     * <code>
     * $query->filterByNetwork('fooValue');   // WHERE network = 'fooValue'
     * $query->filterByNetwork('%fooValue%', Criteria::LIKE); // WHERE network LIKE '%fooValue%'
     * </code>
     *
     * @param     string $network The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByNetwork($network = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($network)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_NETWORK, $network, $comparison);
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByLat($lat = null, $comparison = null)
    {
        if (is_array($lat)) {
            $useMinMax = false;
            if (isset($lat['min'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_LAT, $lat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lat['max'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_LAT, $lat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_LAT, $lat, $comparison);
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByLng($lng = null, $comparison = null)
    {
        if (is_array($lng)) {
            $useMinMax = false;
            if (isset($lng['min'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_LNG, $lng['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lng['max'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_LNG, $lng['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_LNG, $lng, $comparison);
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
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByAlt($alt = null, $comparison = null)
    {
        if (is_array($alt)) {
            $useMinMax = false;
            if (isset($alt['min'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_ALT, $alt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alt['max'])) {
                $this->addUsingAlias(UbaStationTableMap::COL_ALT, $alt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaStationTableMap::COL_ALT, $alt, $comparison);
    }

    /**
     * Filter the query by a related \UbaO3 object
     *
     * @param \UbaO3|ObjectCollection $ubaO3 the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByUbaO3($ubaO3, $comparison = null)
    {
        if ($ubaO3 instanceof \UbaO3) {
            return $this
                ->addUsingAlias(UbaStationTableMap::COL_ID, $ubaO3->getStationId(), $comparison);
        } elseif ($ubaO3 instanceof ObjectCollection) {
            return $this
                ->useUbaO3Query()
                ->filterByPrimaryKeys($ubaO3->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUbaO3() only accepts arguments of type \UbaO3 or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaO3 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function joinUbaO3($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaO3');

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
            $this->addJoinObject($join, 'UbaO3');
        }

        return $this;
    }

    /**
     * Use the UbaO3 relation UbaO3 object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaO3Query A secondary query class using the current class as primary query
     */
    public function useUbaO3Query($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaO3($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaO3', '\UbaO3Query');
    }

    /**
     * Filter the query by a related \UbaSO2 object
     *
     * @param \UbaSO2|ObjectCollection $ubaSO2 the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByUbaSO2($ubaSO2, $comparison = null)
    {
        if ($ubaSO2 instanceof \UbaSO2) {
            return $this
                ->addUsingAlias(UbaStationTableMap::COL_ID, $ubaSO2->getStationId(), $comparison);
        } elseif ($ubaSO2 instanceof ObjectCollection) {
            return $this
                ->useUbaSO2Query()
                ->filterByPrimaryKeys($ubaSO2->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUbaSO2() only accepts arguments of type \UbaSO2 or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaSO2 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function joinUbaSO2($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaSO2');

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
            $this->addJoinObject($join, 'UbaSO2');
        }

        return $this;
    }

    /**
     * Use the UbaSO2 relation UbaSO2 object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaSO2Query A secondary query class using the current class as primary query
     */
    public function useUbaSO2Query($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaSO2($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaSO2', '\UbaSO2Query');
    }

    /**
     * Filter the query by a related \UbaPM10 object
     *
     * @param \UbaPM10|ObjectCollection $ubaPM10 the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByUbaPM10($ubaPM10, $comparison = null)
    {
        if ($ubaPM10 instanceof \UbaPM10) {
            return $this
                ->addUsingAlias(UbaStationTableMap::COL_ID, $ubaPM10->getStationId(), $comparison);
        } elseif ($ubaPM10 instanceof ObjectCollection) {
            return $this
                ->useUbaPM10Query()
                ->filterByPrimaryKeys($ubaPM10->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUbaPM10() only accepts arguments of type \UbaPM10 or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaPM10 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function joinUbaPM10($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaPM10');

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
            $this->addJoinObject($join, 'UbaPM10');
        }

        return $this;
    }

    /**
     * Use the UbaPM10 relation UbaPM10 object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaPM10Query A secondary query class using the current class as primary query
     */
    public function useUbaPM10Query($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaPM10($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaPM10', '\UbaPM10Query');
    }

    /**
     * Filter the query by a related \UbaNO2 object
     *
     * @param \UbaNO2|ObjectCollection $ubaNO2 the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByUbaNO2($ubaNO2, $comparison = null)
    {
        if ($ubaNO2 instanceof \UbaNO2) {
            return $this
                ->addUsingAlias(UbaStationTableMap::COL_ID, $ubaNO2->getStationId(), $comparison);
        } elseif ($ubaNO2 instanceof ObjectCollection) {
            return $this
                ->useUbaNO2Query()
                ->filterByPrimaryKeys($ubaNO2->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUbaNO2() only accepts arguments of type \UbaNO2 or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaNO2 relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function joinUbaNO2($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaNO2');

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
            $this->addJoinObject($join, 'UbaNO2');
        }

        return $this;
    }

    /**
     * Use the UbaNO2 relation UbaNO2 object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaNO2Query A secondary query class using the current class as primary query
     */
    public function useUbaNO2Query($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaNO2($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaNO2', '\UbaNO2Query');
    }

    /**
     * Filter the query by a related \UbaCO object
     *
     * @param \UbaCO|ObjectCollection $ubaCO the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUbaStationQuery The current query, for fluid interface
     */
    public function filterByUbaCO($ubaCO, $comparison = null)
    {
        if ($ubaCO instanceof \UbaCO) {
            return $this
                ->addUsingAlias(UbaStationTableMap::COL_ID, $ubaCO->getStationId(), $comparison);
        } elseif ($ubaCO instanceof ObjectCollection) {
            return $this
                ->useUbaCOQuery()
                ->filterByPrimaryKeys($ubaCO->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUbaCO() only accepts arguments of type \UbaCO or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaCO relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function joinUbaCO($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaCO');

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
            $this->addJoinObject($join, 'UbaCO');
        }

        return $this;
    }

    /**
     * Use the UbaCO relation UbaCO object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaCOQuery A secondary query class using the current class as primary query
     */
    public function useUbaCOQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaCO($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaCO', '\UbaCOQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUbaStation $ubaStation Object to remove from the list of results
     *
     * @return $this|ChildUbaStationQuery The current query, for fluid interface
     */
    public function prune($ubaStation = null)
    {
        if ($ubaStation) {
            $this->addUsingAlias(UbaStationTableMap::COL_ID, $ubaStation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the uba_station table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UbaStationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UbaStationTableMap::clearInstancePool();
            UbaStationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UbaStationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UbaStationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UbaStationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UbaStationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UbaStationQuery
