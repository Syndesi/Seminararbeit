<?php

namespace Base;

use \Account as ChildAccount;
use \AccountQuery as ChildAccountQuery;
use \Exception;
use \PDO;
use Map\AccountTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'account' table.
 *
 *
 *
 * @method     ChildAccountQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccountQuery orderByForename($order = Criteria::ASC) Order by the forename column
 * @method     ChildAccountQuery orderBySurname($order = Criteria::ASC) Order by the surname column
 * @method     ChildAccountQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAccountQuery orderByEmailVerified($order = Criteria::ASC) Order by the email_verified column
 * @method     ChildAccountQuery orderByHash($order = Criteria::ASC) Order by the hash column
 * @method     ChildAccountQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAccountQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAccountQuery groupById() Group by the id column
 * @method     ChildAccountQuery groupByForename() Group by the forename column
 * @method     ChildAccountQuery groupBySurname() Group by the surname column
 * @method     ChildAccountQuery groupByEmail() Group by the email column
 * @method     ChildAccountQuery groupByEmailVerified() Group by the email_verified column
 * @method     ChildAccountQuery groupByHash() Group by the hash column
 * @method     ChildAccountQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAccountQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAccountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccountQuery leftJoinAccountAuthorized($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountAuthorized relation
 * @method     ChildAccountQuery rightJoinAccountAuthorized($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountAuthorized relation
 * @method     ChildAccountQuery innerJoinAccountAuthorized($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountAuthorized relation
 *
 * @method     ChildAccountQuery joinWithAccountAuthorized($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountAuthorized relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountAuthorized() Adds a LEFT JOIN clause and with to the query using the AccountAuthorized relation
 * @method     ChildAccountQuery rightJoinWithAccountAuthorized() Adds a RIGHT JOIN clause and with to the query using the AccountAuthorized relation
 * @method     ChildAccountQuery innerJoinWithAccountAuthorized() Adds a INNER JOIN clause and with to the query using the AccountAuthorized relation
 *
 * @method     ChildAccountQuery leftJoinAccountVerification($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountVerification relation
 * @method     ChildAccountQuery rightJoinAccountVerification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountVerification relation
 * @method     ChildAccountQuery innerJoinAccountVerification($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountVerification relation
 *
 * @method     ChildAccountQuery joinWithAccountVerification($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountVerification relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountVerification() Adds a LEFT JOIN clause and with to the query using the AccountVerification relation
 * @method     ChildAccountQuery rightJoinWithAccountVerification() Adds a RIGHT JOIN clause and with to the query using the AccountVerification relation
 * @method     ChildAccountQuery innerJoinWithAccountVerification() Adds a INNER JOIN clause and with to the query using the AccountVerification relation
 *
 * @method     \AccountAuthorizedQuery|\AccountVerificationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccount findOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query
 * @method     ChildAccount findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccount matching the query, or a new ChildAccount object populated from the query conditions when no match is found
 *
 * @method     ChildAccount findOneById(int $id) Return the first ChildAccount filtered by the id column
 * @method     ChildAccount findOneByForename(string $forename) Return the first ChildAccount filtered by the forename column
 * @method     ChildAccount findOneBySurname(string $surname) Return the first ChildAccount filtered by the surname column
 * @method     ChildAccount findOneByEmail(string $email) Return the first ChildAccount filtered by the email column
 * @method     ChildAccount findOneByEmailVerified(boolean $email_verified) Return the first ChildAccount filtered by the email_verified column
 * @method     ChildAccount findOneByHash(string $hash) Return the first ChildAccount filtered by the hash column
 * @method     ChildAccount findOneByCreatedAt(string $created_at) Return the first ChildAccount filtered by the created_at column
 * @method     ChildAccount findOneByUpdatedAt(string $updated_at) Return the first ChildAccount filtered by the updated_at column *

 * @method     ChildAccount requirePk($key, ConnectionInterface $con = null) Return the ChildAccount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount requireOneById(int $id) Return the first ChildAccount filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByForename(string $forename) Return the first ChildAccount filtered by the forename column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneBySurname(string $surname) Return the first ChildAccount filtered by the surname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByEmail(string $email) Return the first ChildAccount filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByEmailVerified(boolean $email_verified) Return the first ChildAccount filtered by the email_verified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByHash(string $hash) Return the first ChildAccount filtered by the hash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByCreatedAt(string $created_at) Return the first ChildAccount filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByUpdatedAt(string $updated_at) Return the first ChildAccount filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccount objects based on current ModelCriteria
 * @method     ChildAccount[]|ObjectCollection findById(int $id) Return ChildAccount objects filtered by the id column
 * @method     ChildAccount[]|ObjectCollection findByForename(string $forename) Return ChildAccount objects filtered by the forename column
 * @method     ChildAccount[]|ObjectCollection findBySurname(string $surname) Return ChildAccount objects filtered by the surname column
 * @method     ChildAccount[]|ObjectCollection findByEmail(string $email) Return ChildAccount objects filtered by the email column
 * @method     ChildAccount[]|ObjectCollection findByEmailVerified(boolean $email_verified) Return ChildAccount objects filtered by the email_verified column
 * @method     ChildAccount[]|ObjectCollection findByHash(string $hash) Return ChildAccount objects filtered by the hash column
 * @method     ChildAccount[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAccount objects filtered by the created_at column
 * @method     ChildAccount[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAccount objects filtered by the updated_at column
 * @method     ChildAccount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccountQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AccountQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Account', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccountQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccountQuery) {
            return $criteria;
        }
        $query = new ChildAccountQuery();
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
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAccount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, forename, surname, email, email_verified, hash, created_at, updated_at FROM account WHERE id = :p0';
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
            /** @var ChildAccount $obj */
            $obj = new ChildAccount();
            $obj->hydrate($row);
            AccountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the forename column
     *
     * Example usage:
     * <code>
     * $query->filterByForename('fooValue');   // WHERE forename = 'fooValue'
     * $query->filterByForename('%fooValue%', Criteria::LIKE); // WHERE forename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $forename The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByForename($forename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($forename)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_FORENAME, $forename, $comparison);
    }

    /**
     * Filter the query on the surname column
     *
     * Example usage:
     * <code>
     * $query->filterBySurname('fooValue');   // WHERE surname = 'fooValue'
     * $query->filterBySurname('%fooValue%', Criteria::LIKE); // WHERE surname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $surname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterBySurname($surname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($surname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_SURNAME, $surname, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the email_verified column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailVerified(true); // WHERE email_verified = true
     * $query->filterByEmailVerified('yes'); // WHERE email_verified = true
     * </code>
     *
     * @param     boolean|string $emailVerified The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByEmailVerified($emailVerified = null, $comparison = null)
    {
        if (is_string($emailVerified)) {
            $emailVerified = in_array(strtolower($emailVerified), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccountTableMap::COL_EMAIL_VERIFIED, $emailVerified, $comparison);
    }

    /**
     * Filter the query on the hash column
     *
     * Example usage:
     * <code>
     * $query->filterByHash('fooValue');   // WHERE hash = 'fooValue'
     * $query->filterByHash('%fooValue%', Criteria::LIKE); // WHERE hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hash The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByHash($hash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hash)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_HASH, $hash, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \AccountAuthorized object
     *
     * @param \AccountAuthorized|ObjectCollection $accountAuthorized the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountAuthorized($accountAuthorized, $comparison = null)
    {
        if ($accountAuthorized instanceof \AccountAuthorized) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ID, $accountAuthorized->getAccountId(), $comparison);
        } elseif ($accountAuthorized instanceof ObjectCollection) {
            return $this
                ->useAccountAuthorizedQuery()
                ->filterByPrimaryKeys($accountAuthorized->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountAuthorized() only accepts arguments of type \AccountAuthorized or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountAuthorized relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountAuthorized($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountAuthorized');

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
            $this->addJoinObject($join, 'AccountAuthorized');
        }

        return $this;
    }

    /**
     * Use the AccountAuthorized relation AccountAuthorized object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AccountAuthorizedQuery A secondary query class using the current class as primary query
     */
    public function useAccountAuthorizedQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountAuthorized($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountAuthorized', '\AccountAuthorizedQuery');
    }

    /**
     * Filter the query by a related \AccountVerification object
     *
     * @param \AccountVerification|ObjectCollection $accountVerification the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountVerification($accountVerification, $comparison = null)
    {
        if ($accountVerification instanceof \AccountVerification) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ID, $accountVerification->getAccountId(), $comparison);
        } elseif ($accountVerification instanceof ObjectCollection) {
            return $this
                ->useAccountVerificationQuery()
                ->filterByPrimaryKeys($accountVerification->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountVerification() only accepts arguments of type \AccountVerification or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountVerification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountVerification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountVerification');

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
            $this->addJoinObject($join, 'AccountVerification');
        }

        return $this;
    }

    /**
     * Use the AccountVerification relation AccountVerification object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AccountVerificationQuery A secondary query class using the current class as primary query
     */
    public function useAccountVerificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountVerification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountVerification', '\AccountVerificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccount $account Object to remove from the list of results
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function prune($account = null)
    {
        if ($account) {
            $this->addUsingAlias(AccountTableMap::COL_ID, $account->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the account table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccountTableMap::clearInstancePool();
            AccountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AccountTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AccountTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AccountTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AccountTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AccountTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAccountQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AccountTableMap::COL_CREATED_AT);
    }

} // AccountQuery
