<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Seller as ChildSeller;
use Buildings\SellerQuery as ChildSellerQuery;
use Buildings\Map\SellerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `seller` table.
 *
 * @method     ChildSellerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSellerQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildSellerQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildSellerQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildSellerQuery orderByPhoneNumber($order = Criteria::ASC) Order by the phone_number column
 *
 * @method     ChildSellerQuery groupById() Group by the id column
 * @method     ChildSellerQuery groupByUsername() Group by the username column
 * @method     ChildSellerQuery groupByPassword() Group by the password column
 * @method     ChildSellerQuery groupByEmail() Group by the email column
 * @method     ChildSellerQuery groupByPhoneNumber() Group by the phone_number column
 *
 * @method     ChildSellerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSellerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSellerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSellerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSellerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSellerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSellerQuery leftJoinOrderSeller($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderSeller relation
 * @method     ChildSellerQuery rightJoinOrderSeller($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderSeller relation
 * @method     ChildSellerQuery innerJoinOrderSeller($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderSeller relation
 *
 * @method     ChildSellerQuery joinWithOrderSeller($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderSeller relation
 *
 * @method     ChildSellerQuery leftJoinWithOrderSeller() Adds a LEFT JOIN clause and with to the query using the OrderSeller relation
 * @method     ChildSellerQuery rightJoinWithOrderSeller() Adds a RIGHT JOIN clause and with to the query using the OrderSeller relation
 * @method     ChildSellerQuery innerJoinWithOrderSeller() Adds a INNER JOIN clause and with to the query using the OrderSeller relation
 *
 * @method     ChildSellerQuery leftJoinSellerProductSeller($relationAlias = null) Adds a LEFT JOIN clause to the query using the SellerProductSeller relation
 * @method     ChildSellerQuery rightJoinSellerProductSeller($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SellerProductSeller relation
 * @method     ChildSellerQuery innerJoinSellerProductSeller($relationAlias = null) Adds a INNER JOIN clause to the query using the SellerProductSeller relation
 *
 * @method     ChildSellerQuery joinWithSellerProductSeller($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SellerProductSeller relation
 *
 * @method     ChildSellerQuery leftJoinWithSellerProductSeller() Adds a LEFT JOIN clause and with to the query using the SellerProductSeller relation
 * @method     ChildSellerQuery rightJoinWithSellerProductSeller() Adds a RIGHT JOIN clause and with to the query using the SellerProductSeller relation
 * @method     ChildSellerQuery innerJoinWithSellerProductSeller() Adds a INNER JOIN clause and with to the query using the SellerProductSeller relation
 *
 * @method     ChildSellerQuery leftJoinAddressOwnerSeller($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerSeller relation
 * @method     ChildSellerQuery rightJoinAddressOwnerSeller($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerSeller relation
 * @method     ChildSellerQuery innerJoinAddressOwnerSeller($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerSeller relation
 *
 * @method     ChildSellerQuery joinWithAddressOwnerSeller($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerSeller relation
 *
 * @method     ChildSellerQuery leftJoinWithAddressOwnerSeller() Adds a LEFT JOIN clause and with to the query using the AddressOwnerSeller relation
 * @method     ChildSellerQuery rightJoinWithAddressOwnerSeller() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerSeller relation
 * @method     ChildSellerQuery innerJoinWithAddressOwnerSeller() Adds a INNER JOIN clause and with to the query using the AddressOwnerSeller relation
 *
 * @method     \Buildings\OrderQuery|\Buildings\SellerProductQuery|\Buildings\AddressOwnerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSeller|null findOne(?ConnectionInterface $con = null) Return the first ChildSeller matching the query
 * @method     ChildSeller findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildSeller matching the query, or a new ChildSeller object populated from the query conditions when no match is found
 *
 * @method     ChildSeller|null findOneById(int $id) Return the first ChildSeller filtered by the id column
 * @method     ChildSeller|null findOneByUsername(string $username) Return the first ChildSeller filtered by the username column
 * @method     ChildSeller|null findOneByPassword(string $password) Return the first ChildSeller filtered by the password column
 * @method     ChildSeller|null findOneByEmail(string $email) Return the first ChildSeller filtered by the email column
 * @method     ChildSeller|null findOneByPhoneNumber(string $phone_number) Return the first ChildSeller filtered by the phone_number column
 *
 * @method     ChildSeller requirePk($key, ?ConnectionInterface $con = null) Return the ChildSeller by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSeller requireOne(?ConnectionInterface $con = null) Return the first ChildSeller matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSeller requireOneById(int $id) Return the first ChildSeller filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSeller requireOneByUsername(string $username) Return the first ChildSeller filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSeller requireOneByPassword(string $password) Return the first ChildSeller filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSeller requireOneByEmail(string $email) Return the first ChildSeller filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSeller requireOneByPhoneNumber(string $phone_number) Return the first ChildSeller filtered by the phone_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSeller[]|Collection find(?ConnectionInterface $con = null) Return ChildSeller objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildSeller> find(?ConnectionInterface $con = null) Return ChildSeller objects based on current ModelCriteria
 *
 * @method     ChildSeller[]|Collection findById(int|array<int> $id) Return ChildSeller objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildSeller> findById(int|array<int> $id) Return ChildSeller objects filtered by the id column
 * @method     ChildSeller[]|Collection findByUsername(string|array<string> $username) Return ChildSeller objects filtered by the username column
 * @psalm-method Collection&\Traversable<ChildSeller> findByUsername(string|array<string> $username) Return ChildSeller objects filtered by the username column
 * @method     ChildSeller[]|Collection findByPassword(string|array<string> $password) Return ChildSeller objects filtered by the password column
 * @psalm-method Collection&\Traversable<ChildSeller> findByPassword(string|array<string> $password) Return ChildSeller objects filtered by the password column
 * @method     ChildSeller[]|Collection findByEmail(string|array<string> $email) Return ChildSeller objects filtered by the email column
 * @psalm-method Collection&\Traversable<ChildSeller> findByEmail(string|array<string> $email) Return ChildSeller objects filtered by the email column
 * @method     ChildSeller[]|Collection findByPhoneNumber(string|array<string> $phone_number) Return ChildSeller objects filtered by the phone_number column
 * @psalm-method Collection&\Traversable<ChildSeller> findByPhoneNumber(string|array<string> $phone_number) Return ChildSeller objects filtered by the phone_number column
 *
 * @method     ChildSeller[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildSeller> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class SellerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\SellerQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Seller', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSellerQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSellerQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildSellerQuery) {
            return $criteria;
        }
        $query = new ChildSellerQuery();
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
     * @return ChildSeller|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SellerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SellerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSeller A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, username, password, email, phone_number FROM seller WHERE id = :p0';
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
            /** @var ChildSeller $obj */
            $obj = new ChildSeller();
            $obj->hydrate($row);
            SellerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildSeller|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(SellerTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(SellerTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
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
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SellerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SellerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * $query->filterByUsername(['foo', 'bar']); // WHERE username IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $username The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUsername($username = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerTableMap::COL_USERNAME, $username, $comparison);

        return $this;
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * $query->filterByPassword(['foo', 'bar']); // WHERE password IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $password The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPassword($password = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerTableMap::COL_PASSWORD, $password, $comparison);

        return $this;
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * $query->filterByEmail(['foo', 'bar']); // WHERE email IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $email The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmail($email = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerTableMap::COL_EMAIL, $email, $comparison);

        return $this;
    }

    /**
     * Filter the query on the phone_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoneNumber('fooValue');   // WHERE phone_number = 'fooValue'
     * $query->filterByPhoneNumber('%fooValue%', Criteria::LIKE); // WHERE phone_number LIKE '%fooValue%'
     * $query->filterByPhoneNumber(['foo', 'bar']); // WHERE phone_number IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $phoneNumber The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPhoneNumber($phoneNumber = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phoneNumber)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerTableMap::COL_PHONE_NUMBER, $phoneNumber, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Order object
     *
     * @param \Buildings\Order|ObjectCollection $order the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderSeller($order, ?string $comparison = null)
    {
        if ($order instanceof \Buildings\Order) {
            $this
                ->addUsingAlias(SellerTableMap::COL_ID, $order->getIdSeller(), $comparison);

            return $this;
        } elseif ($order instanceof ObjectCollection) {
            $this
                ->useOrderSellerQuery()
                ->filterByPrimaryKeys($order->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByOrderSeller() only accepts arguments of type \Buildings\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderSeller relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderSeller(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderSeller');

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
            $this->addJoinObject($join, 'OrderSeller');
        }

        return $this;
    }

    /**
     * Use the OrderSeller relation Order object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderSellerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderSeller($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderSeller', '\Buildings\OrderQuery');
    }

    /**
     * Use the OrderSeller relation Order object
     *
     * @param callable(\Buildings\OrderQuery):\Buildings\OrderQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderSellerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useOrderSellerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderSeller relation to the Order table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\OrderQuery The inner query object of the EXISTS statement
     */
    public function useOrderSellerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderSeller', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderSeller relation to the Order table for a NOT EXISTS query.
     *
     * @see useOrderSellerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderSellerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderSeller', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderSeller relation to the Order table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\OrderQuery The inner query object of the IN statement
     */
    public function useInOrderSellerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderSeller', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderSeller relation to the Order table for a NOT IN query.
     *
     * @see useOrderSellerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderSellerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderSeller', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\SellerProduct object
     *
     * @param \Buildings\SellerProduct|ObjectCollection $sellerProduct the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySellerProductSeller($sellerProduct, ?string $comparison = null)
    {
        if ($sellerProduct instanceof \Buildings\SellerProduct) {
            $this
                ->addUsingAlias(SellerTableMap::COL_ID, $sellerProduct->getIdSeller(), $comparison);

            return $this;
        } elseif ($sellerProduct instanceof ObjectCollection) {
            $this
                ->useSellerProductSellerQuery()
                ->filterByPrimaryKeys($sellerProduct->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterBySellerProductSeller() only accepts arguments of type \Buildings\SellerProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SellerProductSeller relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinSellerProductSeller(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SellerProductSeller');

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
            $this->addJoinObject($join, 'SellerProductSeller');
        }

        return $this;
    }

    /**
     * Use the SellerProductSeller relation SellerProduct object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\SellerProductQuery A secondary query class using the current class as primary query
     */
    public function useSellerProductSellerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSellerProductSeller($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SellerProductSeller', '\Buildings\SellerProductQuery');
    }

    /**
     * Use the SellerProductSeller relation SellerProduct object
     *
     * @param callable(\Buildings\SellerProductQuery):\Buildings\SellerProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSellerProductSellerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSellerProductSellerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the SellerProductSeller relation to the SellerProduct table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\SellerProductQuery The inner query object of the EXISTS statement
     */
    public function useSellerProductSellerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useExistsQuery('SellerProductSeller', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the SellerProductSeller relation to the SellerProduct table for a NOT EXISTS query.
     *
     * @see useSellerProductSellerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useSellerProductSellerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useExistsQuery('SellerProductSeller', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the SellerProductSeller relation to the SellerProduct table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\SellerProductQuery The inner query object of the IN statement
     */
    public function useInSellerProductSellerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useInQuery('SellerProductSeller', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the SellerProductSeller relation to the SellerProduct table for a NOT IN query.
     *
     * @see useSellerProductSellerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInSellerProductSellerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useInQuery('SellerProductSeller', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\AddressOwner object
     *
     * @param \Buildings\AddressOwner|ObjectCollection $addressOwner the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAddressOwnerSeller($addressOwner, ?string $comparison = null)
    {
        if ($addressOwner instanceof \Buildings\AddressOwner) {
            $this
                ->addUsingAlias(SellerTableMap::COL_ID, $addressOwner->getIdSeller(), $comparison);

            return $this;
        } elseif ($addressOwner instanceof ObjectCollection) {
            $this
                ->useAddressOwnerSellerQuery()
                ->filterByPrimaryKeys($addressOwner->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerSeller() only accepts arguments of type \Buildings\AddressOwner or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerSeller relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerSeller(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerSeller');

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
            $this->addJoinObject($join, 'AddressOwnerSeller');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerSeller relation AddressOwner object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\AddressOwnerQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerSellerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAddressOwnerSeller($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerSeller', '\Buildings\AddressOwnerQuery');
    }

    /**
     * Use the AddressOwnerSeller relation AddressOwner object
     *
     * @param callable(\Buildings\AddressOwnerQuery):\Buildings\AddressOwnerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerSellerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerSellerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerSeller relation to the AddressOwner table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerSellerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerSeller', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerSeller relation to the AddressOwner table for a NOT EXISTS query.
     *
     * @see useAddressOwnerSellerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerSellerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerSeller', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerSeller relation to the AddressOwner table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerSellerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerSeller', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerSeller relation to the AddressOwner table for a NOT IN query.
     *
     * @see useAddressOwnerSellerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerSellerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerSeller', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildSeller $seller Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($seller = null)
    {
        if ($seller) {
            $this->addUsingAlias(SellerTableMap::COL_ID, $seller->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the seller table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SellerTableMap::clearInstancePool();
            SellerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SellerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SellerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SellerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
