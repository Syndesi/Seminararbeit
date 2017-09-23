<?php

namespace Base;

use \UbaPM10 as ChildUbaPM10;
use \UbaPM10Query as ChildUbaPM10Query;
use \Exception;
use \PDO;
use Map\UbaPM10TableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'uba_pm10_smw' table.
 *
 *
 *
 * @method     ChildUbaPM10Query orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUbaPM10Query orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildUbaPM10Query orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildUbaPM10Query orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildUbaPM10Query groupById() Group by the id column
 * @method     ChildUbaPM10Query groupByStationId() Group by the station_id column
 * @method     ChildUbaPM10Query groupByTime() Group by the time column
 * @method     ChildUbaPM10Query groupByValue() Group by the value column
 *
 * @method     ChildUbaPM10Query leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUbaPM10Query rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUbaPM10Query innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUbaPM10Query leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUbaPM10Query rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUbaPM10Query innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUbaPM10Query leftJoinUbaStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaStation relation
 * @method     ChildUbaPM10Query rightJoinUbaStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaStation relation
 * @method     ChildUbaPM10Query innerJoinUbaStation($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaStation relation
 *
 * @method     ChildUbaPM10Query joinWithUbaStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaStation relation
 *
 * @method     ChildUbaPM10Query leftJoinWithUbaStation() Adds a LEFT JOIN clause and with to the query using the UbaStation relation
 * @method     ChildUbaPM10Query rightJoinWithUbaStation() Adds a RIGHT JOIN clause and with to the query using the UbaStation relation
 * @method     ChildUbaPM10Query innerJoinWithUbaStation() Adds a INNER JOIN clause and with to the query using the UbaStation relation
 *
 * @method     \UbaStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUbaPM10 findOne(ConnectionInterface $con = null) Return the first ChildUbaPM10 matching the query
 * @method     ChildUbaPM10 findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUbaPM10 matching the query, or a new ChildUbaPM10 object populated from the query conditions when no match is found
 *
 * @method     ChildUbaPM10 findOneById(int $id) Return the first ChildUbaPM10 filtered by the id column
 * @method     ChildUbaPM10 findOneByStationId(int $station_id) Return the first ChildUbaPM10 filtered by the station_id column
 * @method     ChildUbaPM10 findOneByTime(string $time) Return the first ChildUbaPM10 filtered by the time column
 * @method     ChildUbaPM10 findOneByValue(double $value) Return the first ChildUbaPM10 filtered by the value column *

 * @method     ChildUbaPM10 requirePk($key, ConnectionInterface $con = null) Return the ChildUbaPM10 by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaPM10 requireOne(ConnectionInterface $con = null) Return the first ChildUbaPM10 matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaPM10 requireOneById(int $id) Return the first ChildUbaPM10 filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaPM10 requireOneByStationId(int $station_id) Return the first ChildUbaPM10 filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaPM10 requireOneByTime(string $time) Return the first ChildUbaPM10 filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaPM10 requireOneByValue(double $value) Return the first ChildUbaPM10 filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaPM10[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUbaPM10 objects based on current ModelCriteria
 * @method     ChildUbaPM10[]|ObjectCollection findById(int $id) Return ChildUbaPM10 objects filtered by the id column
 * @method     ChildUbaPM10[]|ObjectCollection findByStationId(int $station_id) Return ChildUbaPM10 objects filtered by the station_id column
 * @method     ChildUbaPM10[]|ObjectCollection findByTime(string $time) Return ChildUbaPM10 objects filtered by the time column
 * @method     ChildUbaPM10[]|ObjectCollection findByValue(double $value) Return ChildUbaPM10 objects filtered by the value column
 * @method     ChildUbaPM10[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UbaPM10Query extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UbaPM10Query object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UbaPM10', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUbaPM10Query object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUbaPM10Query
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUbaPM10Query) {
            return $criteria;
        }
        $query = new ChildUbaPM10Query();
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
     * @return ChildUbaPM10|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UbaPM10TableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UbaPM10TableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUbaPM10 A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, value FROM uba_pm10_smw WHERE id = :p0';
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
            /** @var ChildUbaPM10 $obj */
            $obj = new ChildUbaPM10();
            $obj->hydrate($row);
            UbaPM10TableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUbaPM10|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UbaPM10TableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UbaPM10TableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaPM10TableMap::COL_ID, $id, $comparison);
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
     * @see       filterByUbaStation()
     *
     * @param     mixed $stationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaPM10TableMap::COL_STATION_ID, $stationId, $comparison);
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
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaPM10TableMap::COL_TIME, $time, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue(1234); // WHERE value = 1234
     * $query->filterByValue(array(12, 34)); // WHERE value IN (12, 34)
     * $query->filterByValue(array('min' => 12)); // WHERE value > 12
     * </code>
     *
     * @param     mixed $value The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UbaPM10TableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaPM10TableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \UbaStation object
     *
     * @param \UbaStation|ObjectCollection $ubaStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUbaPM10Query The current query, for fluid interface
     */
    public function filterByUbaStation($ubaStation, $comparison = null)
    {
        if ($ubaStation instanceof \UbaStation) {
            return $this
                ->addUsingAlias(UbaPM10TableMap::COL_STATION_ID, $ubaStation->getId(), $comparison);
        } elseif ($ubaStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UbaPM10TableMap::COL_STATION_ID, $ubaStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUbaStation() only accepts arguments of type \UbaStation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UbaStation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function joinUbaStation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UbaStation');

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
            $this->addJoinObject($join, 'UbaStation');
        }

        return $this;
    }

    /**
     * Use the UbaStation relation UbaStation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UbaStationQuery A secondary query class using the current class as primary query
     */
    public function useUbaStationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUbaStation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UbaStation', '\UbaStationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUbaPM10 $ubaPM10 Object to remove from the list of results
     *
     * @return $this|ChildUbaPM10Query The current query, for fluid interface
     */
    public function prune($ubaPM10 = null)
    {
        if ($ubaPM10) {
            $this->addUsingAlias(UbaPM10TableMap::COL_ID, $ubaPM10->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the uba_pm10_smw table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UbaPM10TableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UbaPM10TableMap::clearInstancePool();
            UbaPM10TableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UbaPM10TableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UbaPM10TableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UbaPM10TableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UbaPM10TableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UbaPM10Query