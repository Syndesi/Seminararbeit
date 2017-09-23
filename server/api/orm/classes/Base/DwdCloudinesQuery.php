<?php

namespace Base;

use \DwdCloudines as ChildDwdCloudines;
use \DwdCloudinesQuery as ChildDwdCloudinesQuery;
use \Exception;
use \PDO;
use Map\DwdCloudinesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dwd_cloudines' table.
 *
 *
 *
 * @method     ChildDwdCloudinesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDwdCloudinesQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildDwdCloudinesQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildDwdCloudinesQuery orderByQuality($order = Criteria::ASC) Order by the quality column
 * @method     ChildDwdCloudinesQuery orderByVNI($order = Criteria::ASC) Order by the v_n_i column
 * @method     ChildDwdCloudinesQuery orderByVN($order = Criteria::ASC) Order by the v_n column
 *
 * @method     ChildDwdCloudinesQuery groupById() Group by the id column
 * @method     ChildDwdCloudinesQuery groupByStationId() Group by the station_id column
 * @method     ChildDwdCloudinesQuery groupByTime() Group by the time column
 * @method     ChildDwdCloudinesQuery groupByQuality() Group by the quality column
 * @method     ChildDwdCloudinesQuery groupByVNI() Group by the v_n_i column
 * @method     ChildDwdCloudinesQuery groupByVN() Group by the v_n column
 *
 * @method     ChildDwdCloudinesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDwdCloudinesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDwdCloudinesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDwdCloudinesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDwdCloudinesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDwdCloudinesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDwdCloudinesQuery leftJoinDwdStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdCloudinesQuery rightJoinDwdStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DwdStation relation
 * @method     ChildDwdCloudinesQuery innerJoinDwdStation($relationAlias = null) Adds a INNER JOIN clause to the query using the DwdStation relation
 *
 * @method     ChildDwdCloudinesQuery joinWithDwdStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DwdStation relation
 *
 * @method     ChildDwdCloudinesQuery leftJoinWithDwdStation() Adds a LEFT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdCloudinesQuery rightJoinWithDwdStation() Adds a RIGHT JOIN clause and with to the query using the DwdStation relation
 * @method     ChildDwdCloudinesQuery innerJoinWithDwdStation() Adds a INNER JOIN clause and with to the query using the DwdStation relation
 *
 * @method     \DwdStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDwdCloudines findOne(ConnectionInterface $con = null) Return the first ChildDwdCloudines matching the query
 * @method     ChildDwdCloudines findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDwdCloudines matching the query, or a new ChildDwdCloudines object populated from the query conditions when no match is found
 *
 * @method     ChildDwdCloudines findOneById(int $id) Return the first ChildDwdCloudines filtered by the id column
 * @method     ChildDwdCloudines findOneByStationId(int $station_id) Return the first ChildDwdCloudines filtered by the station_id column
 * @method     ChildDwdCloudines findOneByTime(string $time) Return the first ChildDwdCloudines filtered by the time column
 * @method     ChildDwdCloudines findOneByQuality(int $quality) Return the first ChildDwdCloudines filtered by the quality column
 * @method     ChildDwdCloudines findOneByVNI(string $v_n_i) Return the first ChildDwdCloudines filtered by the v_n_i column
 * @method     ChildDwdCloudines findOneByVN(int $v_n) Return the first ChildDwdCloudines filtered by the v_n column *

 * @method     ChildDwdCloudines requirePk($key, ConnectionInterface $con = null) Return the ChildDwdCloudines by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOne(ConnectionInterface $con = null) Return the first ChildDwdCloudines matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdCloudines requireOneById(int $id) Return the first ChildDwdCloudines filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOneByStationId(int $station_id) Return the first ChildDwdCloudines filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOneByTime(string $time) Return the first ChildDwdCloudines filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOneByQuality(int $quality) Return the first ChildDwdCloudines filtered by the quality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOneByVNI(string $v_n_i) Return the first ChildDwdCloudines filtered by the v_n_i column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDwdCloudines requireOneByVN(int $v_n) Return the first ChildDwdCloudines filtered by the v_n column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDwdCloudines[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDwdCloudines objects based on current ModelCriteria
 * @method     ChildDwdCloudines[]|ObjectCollection findById(int $id) Return ChildDwdCloudines objects filtered by the id column
 * @method     ChildDwdCloudines[]|ObjectCollection findByStationId(int $station_id) Return ChildDwdCloudines objects filtered by the station_id column
 * @method     ChildDwdCloudines[]|ObjectCollection findByTime(string $time) Return ChildDwdCloudines objects filtered by the time column
 * @method     ChildDwdCloudines[]|ObjectCollection findByQuality(int $quality) Return ChildDwdCloudines objects filtered by the quality column
 * @method     ChildDwdCloudines[]|ObjectCollection findByVNI(string $v_n_i) Return ChildDwdCloudines objects filtered by the v_n_i column
 * @method     ChildDwdCloudines[]|ObjectCollection findByVN(int $v_n) Return ChildDwdCloudines objects filtered by the v_n column
 * @method     ChildDwdCloudines[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DwdCloudinesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DwdCloudinesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DwdCloudines', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDwdCloudinesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDwdCloudinesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDwdCloudinesQuery) {
            return $criteria;
        }
        $query = new ChildDwdCloudinesQuery();
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
     * @return ChildDwdCloudines|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DwdCloudinesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DwdCloudinesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDwdCloudines A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, quality, v_n_i, v_n FROM dwd_cloudines WHERE id = :p0';
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
            /** @var ChildDwdCloudines $obj */
            $obj = new ChildDwdCloudines();
            $obj->hydrate($row);
            DwdCloudinesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDwdCloudines|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_STATION_ID, $stationId, $comparison);
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByQuality($quality = null, $comparison = null)
    {
        if (is_array($quality)) {
            $useMinMax = false;
            if (isset($quality['min'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_QUALITY, $quality['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quality['max'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_QUALITY, $quality['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_QUALITY, $quality, $comparison);
    }

    /**
     * Filter the query on the v_n_i column
     *
     * Example usage:
     * <code>
     * $query->filterByVNI('fooValue');   // WHERE v_n_i = 'fooValue'
     * $query->filterByVNI('%fooValue%', Criteria::LIKE); // WHERE v_n_i LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vNI The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByVNI($vNI = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vNI)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_V_N_I, $vNI, $comparison);
    }

    /**
     * Filter the query on the v_n column
     *
     * Example usage:
     * <code>
     * $query->filterByVN(1234); // WHERE v_n = 1234
     * $query->filterByVN(array(12, 34)); // WHERE v_n IN (12, 34)
     * $query->filterByVN(array('min' => 12)); // WHERE v_n > 12
     * </code>
     *
     * @param     mixed $vN The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByVN($vN = null, $comparison = null)
    {
        if (is_array($vN)) {
            $useMinMax = false;
            if (isset($vN['min'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_V_N, $vN['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vN['max'])) {
                $this->addUsingAlias(DwdCloudinesTableMap::COL_V_N, $vN['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DwdCloudinesTableMap::COL_V_N, $vN, $comparison);
    }

    /**
     * Filter the query by a related \DwdStation object
     *
     * @param \DwdStation|ObjectCollection $dwdStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function filterByDwdStation($dwdStation, $comparison = null)
    {
        if ($dwdStation instanceof \DwdStation) {
            return $this
                ->addUsingAlias(DwdCloudinesTableMap::COL_STATION_ID, $dwdStation->getId(), $comparison);
        } elseif ($dwdStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DwdCloudinesTableMap::COL_STATION_ID, $dwdStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
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
     * @param   ChildDwdCloudines $dwdCloudines Object to remove from the list of results
     *
     * @return $this|ChildDwdCloudinesQuery The current query, for fluid interface
     */
    public function prune($dwdCloudines = null)
    {
        if ($dwdCloudines) {
            $this->addUsingAlias(DwdCloudinesTableMap::COL_ID, $dwdCloudines->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dwd_cloudines table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DwdCloudinesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DwdCloudinesTableMap::clearInstancePool();
            DwdCloudinesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DwdCloudinesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DwdCloudinesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DwdCloudinesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DwdCloudinesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DwdCloudinesQuery
