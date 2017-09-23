<?php

namespace Base;

use \UbaNO2 as ChildUbaNO2;
use \UbaNO2Query as ChildUbaNO2Query;
use \Exception;
use \PDO;
use Map\UbaNO2TableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'uba_no2_smw' table.
 *
 *
 *
 * @method     ChildUbaNO2Query orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUbaNO2Query orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildUbaNO2Query orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildUbaNO2Query orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildUbaNO2Query groupById() Group by the id column
 * @method     ChildUbaNO2Query groupByStationId() Group by the station_id column
 * @method     ChildUbaNO2Query groupByTime() Group by the time column
 * @method     ChildUbaNO2Query groupByValue() Group by the value column
 *
 * @method     ChildUbaNO2Query leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUbaNO2Query rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUbaNO2Query innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUbaNO2Query leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUbaNO2Query rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUbaNO2Query innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUbaNO2Query leftJoinUbaStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the UbaStation relation
 * @method     ChildUbaNO2Query rightJoinUbaStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UbaStation relation
 * @method     ChildUbaNO2Query innerJoinUbaStation($relationAlias = null) Adds a INNER JOIN clause to the query using the UbaStation relation
 *
 * @method     ChildUbaNO2Query joinWithUbaStation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UbaStation relation
 *
 * @method     ChildUbaNO2Query leftJoinWithUbaStation() Adds a LEFT JOIN clause and with to the query using the UbaStation relation
 * @method     ChildUbaNO2Query rightJoinWithUbaStation() Adds a RIGHT JOIN clause and with to the query using the UbaStation relation
 * @method     ChildUbaNO2Query innerJoinWithUbaStation() Adds a INNER JOIN clause and with to the query using the UbaStation relation
 *
 * @method     \UbaStationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUbaNO2 findOne(ConnectionInterface $con = null) Return the first ChildUbaNO2 matching the query
 * @method     ChildUbaNO2 findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUbaNO2 matching the query, or a new ChildUbaNO2 object populated from the query conditions when no match is found
 *
 * @method     ChildUbaNO2 findOneById(int $id) Return the first ChildUbaNO2 filtered by the id column
 * @method     ChildUbaNO2 findOneByStationId(int $station_id) Return the first ChildUbaNO2 filtered by the station_id column
 * @method     ChildUbaNO2 findOneByTime(string $time) Return the first ChildUbaNO2 filtered by the time column
 * @method     ChildUbaNO2 findOneByValue(double $value) Return the first ChildUbaNO2 filtered by the value column *

 * @method     ChildUbaNO2 requirePk($key, ConnectionInterface $con = null) Return the ChildUbaNO2 by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaNO2 requireOne(ConnectionInterface $con = null) Return the first ChildUbaNO2 matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaNO2 requireOneById(int $id) Return the first ChildUbaNO2 filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaNO2 requireOneByStationId(int $station_id) Return the first ChildUbaNO2 filtered by the station_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaNO2 requireOneByTime(string $time) Return the first ChildUbaNO2 filtered by the time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUbaNO2 requireOneByValue(double $value) Return the first ChildUbaNO2 filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUbaNO2[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUbaNO2 objects based on current ModelCriteria
 * @method     ChildUbaNO2[]|ObjectCollection findById(int $id) Return ChildUbaNO2 objects filtered by the id column
 * @method     ChildUbaNO2[]|ObjectCollection findByStationId(int $station_id) Return ChildUbaNO2 objects filtered by the station_id column
 * @method     ChildUbaNO2[]|ObjectCollection findByTime(string $time) Return ChildUbaNO2 objects filtered by the time column
 * @method     ChildUbaNO2[]|ObjectCollection findByValue(double $value) Return ChildUbaNO2 objects filtered by the value column
 * @method     ChildUbaNO2[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UbaNO2Query extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UbaNO2Query object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\UbaNO2', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUbaNO2Query object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUbaNO2Query
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUbaNO2Query) {
            return $criteria;
        }
        $query = new ChildUbaNO2Query();
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
     * @return ChildUbaNO2|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UbaNO2TableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UbaNO2TableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUbaNO2 A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, station_id, time, value FROM uba_no2_smw WHERE id = :p0';
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
            /** @var ChildUbaNO2 $obj */
            $obj = new ChildUbaNO2();
            $obj->hydrate($row);
            UbaNO2TableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUbaNO2|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UbaNO2TableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UbaNO2TableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaNO2TableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaNO2TableMap::COL_STATION_ID, $stationId, $comparison);
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaNO2TableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(UbaNO2TableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UbaNO2TableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \UbaStation object
     *
     * @param \UbaStation|ObjectCollection $ubaStation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUbaNO2Query The current query, for fluid interface
     */
    public function filterByUbaStation($ubaStation, $comparison = null)
    {
        if ($ubaStation instanceof \UbaStation) {
            return $this
                ->addUsingAlias(UbaNO2TableMap::COL_STATION_ID, $ubaStation->getId(), $comparison);
        } elseif ($ubaStation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UbaNO2TableMap::COL_STATION_ID, $ubaStation->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
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
     * @param   ChildUbaNO2 $ubaNO2 Object to remove from the list of results
     *
     * @return $this|ChildUbaNO2Query The current query, for fluid interface
     */
    public function prune($ubaNO2 = null)
    {
        if ($ubaNO2) {
            $this->addUsingAlias(UbaNO2TableMap::COL_ID, $ubaNO2->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the uba_no2_smw table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UbaNO2TableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UbaNO2TableMap::clearInstancePool();
            UbaNO2TableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UbaNO2TableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UbaNO2TableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UbaNO2TableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UbaNO2TableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UbaNO2Query
