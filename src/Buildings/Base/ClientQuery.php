<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Client as ChildClient;
use Buildings\ClientQuery as ChildClientQuery;
use Buildings\Map\ClientTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `client` table.
 *
 * @method     ChildClientQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildClientQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildClientQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildClientQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildClientQuery orderByPhoneNumber($order = Criteria::ASC) Order by the phone_number column
 *
 * @method     ChildClientQuery groupById() Group by the id column
 * @method     ChildClientQuery groupByUsername() Group by the username column
 * @method     ChildClientQuery groupByPassword() Group by the password column
 * @method     ChildClientQuery groupByEmail() Group by the email column
 * @method     ChildClientQuery groupByPhoneNumber() Group by the phone_number column
 *
 * @method     ChildClientQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildClientQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildClientQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildClientQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildClientQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildClientQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildClientQuery leftJoinOrderClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderClient relation
 * @method     ChildClientQuery rightJoinOrderClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderClient relation
 * @method     ChildClientQuery innerJoinOrderClient($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderClient relation
 *
 * @method     ChildClientQuery joinWithOrderClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderClient relation
 *
 * @method     ChildClientQuery leftJoinWithOrderClient() Adds a LEFT JOIN clause and with to the query using the OrderClient relation
 * @method     ChildClientQuery rightJoinWithOrderClient() Adds a RIGHT JOIN clause and with to the query using the OrderClient relation
 * @method     ChildClientQuery innerJoinWithOrderClient() Adds a INNER JOIN clause and with to the query using the OrderClient relation
 *
 * @method     ChildClientQuery leftJoinCartClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the CartClient relation
 * @method     ChildClientQuery rightJoinCartClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CartClient relation
 * @method     ChildClientQuery innerJoinCartClient($relationAlias = null) Adds a INNER JOIN clause to the query using the CartClient relation
 *
 * @method     ChildClientQuery joinWithCartClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CartClient relation
 *
 * @method     ChildClientQuery leftJoinWithCartClient() Adds a LEFT JOIN clause and with to the query using the CartClient relation
 * @method     ChildClientQuery rightJoinWithCartClient() Adds a RIGHT JOIN clause and with to the query using the CartClient relation
 * @method     ChildClientQuery innerJoinWithCartClient() Adds a INNER JOIN clause and with to the query using the CartClient relation
 *
 * @method     ChildClientQuery leftJoinAddressOwnerClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerClient relation
 * @method     ChildClientQuery rightJoinAddressOwnerClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerClient relation
 * @method     ChildClientQuery innerJoinAddressOwnerClient($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerClient relation
 *
 * @method     ChildClientQuery joinWithAddressOwnerClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerClient relation
 *
 * @method     ChildClientQuery leftJoinWithAddressOwnerClient() Adds a LEFT JOIN clause and with to the query using the AddressOwnerClient relation
 * @method     ChildClientQuery rightJoinWithAddressOwnerClient() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerClient relation
 * @method     ChildClientQuery innerJoinWithAddressOwnerClient() Adds a INNER JOIN clause and with to the query using the AddressOwnerClient relation
 *
 * @method     \Buildings\OrderQuery|\Buildings\CartQuery|\Buildings\AddressOwnerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildClient|null findOne(?ConnectionInterface $con = null) Return the first ChildClient matching the query
 * @method     ChildClient findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildClient matching the query, or a new ChildClient object populated from the query conditions when no match is found
 *
 * @method     ChildClient|null findOneById(int $id) Return the first ChildClient filtered by the id column
 * @method     ChildClient|null findOneByUsername(string $username) Return the first ChildClient filtered by the username column
 * @method     ChildClient|null findOneByPassword(string $password) Return the first ChildClient filtered by the password column
 * @method     ChildClient|null findOneByEmail(string $email) Return the first ChildClient filtered by the email column
 * @method     ChildClient|null findOneByPhoneNumber(string $phone_number) Return the first ChildClient filtered by the phone_number column
 *
 * @method     ChildClient requirePk($key, ?ConnectionInterface $con = null) Return the ChildClient by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClient requireOne(?ConnectionInterface $con = null) Return the first ChildClient matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildClient requireOneById(int $id) Return the first ChildClient filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClient requireOneByUsername(string $username) Return the first ChildClient filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClient requireOneByPassword(string $password) Return the first ChildClient filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClient requireOneByEmail(string $email) Return the first ChildClient filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClient requireOneByPhoneNumber(string $phone_number) Return the first ChildClient filtered by the phone_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildClient[]|Collection find(?ConnectionInterface $con = null) Return ChildClient objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildClient> find(?ConnectionInterface $con = null) Return ChildClient objects based on current ModelCriteria
 *
 * @method     ChildClient[]|Collection findById(int|array<int> $id) Return ChildClient objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildClient> findById(int|array<int> $id) Return ChildClient objects filtered by the id column
 * @method     ChildClient[]|Collection findByUsername(string|array<string> $username) Return ChildClient objects filtered by the username column
 * @psalm-method Collection&\Traversable<ChildClient> findByUsername(string|array<string> $username) Return ChildClient objects filtered by the username column
 * @method     ChildClient[]|Collection findByPassword(string|array<string> $password) Return ChildClient objects filtered by the password column
 * @psalm-method Collection&\Traversable<ChildClient> findByPassword(string|array<string> $password) Return ChildClient objects filtered by the password column
 * @method     ChildClient[]|Collection findByEmail(string|array<string> $email) Return ChildClient objects filtered by the email column
 * @psalm-method Collection&\Traversable<ChildClient> findByEmail(string|array<string> $email) Return ChildClient objects filtered by the email column
 * @method     ChildClient[]|Collection findByPhoneNumber(string|array<string> $phone_number) Return ChildClient objects filtered by the phone_number column
 * @psalm-method Collection&\Traversable<ChildClient> findByPhoneNumber(string|array<string> $phone_number) Return ChildClient objects filtered by the phone_number column
 *
 * @method     ChildClient[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildClient> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class ClientQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\ClientQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Client', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildClientQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildClientQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildClientQuery) {
            return $criteria;
        }
        $query = new ChildClientQuery();
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
     * @return ChildClient|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ClientTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ClientTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildClient A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, username, password, email, phone_number FROM client WHERE id = :p0';
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
            /** @var ChildClient $obj */
            $obj = new ChildClient();
            $obj->hydrate($row);
            ClientTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildClient|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(ClientTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(ClientTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(ClientTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ClientTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ClientTableMap::COL_ID, $id, $comparison);

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

        $this->addUsingAlias(ClientTableMap::COL_USERNAME, $username, $comparison);

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

        $this->addUsingAlias(ClientTableMap::COL_PASSWORD, $password, $comparison);

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

        $this->addUsingAlias(ClientTableMap::COL_EMAIL, $email, $comparison);

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

        $this->addUsingAlias(ClientTableMap::COL_PHONE_NUMBER, $phoneNumber, $comparison);

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
    public function filterByOrderClient($order, ?string $comparison = null)
    {
        if ($order instanceof \Buildings\Order) {
            $this
                ->addUsingAlias(ClientTableMap::COL_ID, $order->getIdClient(), $comparison);

            return $this;
        } elseif ($order instanceof ObjectCollection) {
            $this
                ->useOrderClientQuery()
                ->filterByPrimaryKeys($order->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByOrderClient() only accepts arguments of type \Buildings\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderClient relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderClient(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderClient');

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
            $this->addJoinObject($join, 'OrderClient');
        }

        return $this;
    }

    /**
     * Use the OrderClient relation Order object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderClientQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderClient', '\Buildings\OrderQuery');
    }

    /**
     * Use the OrderClient relation Order object
     *
     * @param callable(\Buildings\OrderQuery):\Buildings\OrderQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderClientQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useOrderClientQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderClient relation to the Order table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\OrderQuery The inner query object of the EXISTS statement
     */
    public function useOrderClientExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderClient', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderClient relation to the Order table for a NOT EXISTS query.
     *
     * @see useOrderClientExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderClientNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderClient', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderClient relation to the Order table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\OrderQuery The inner query object of the IN statement
     */
    public function useInOrderClientQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderClient', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderClient relation to the Order table for a NOT IN query.
     *
     * @see useOrderClientInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderClientQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderClient', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\Cart object
     *
     * @param \Buildings\Cart|ObjectCollection $cart the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCartClient($cart, ?string $comparison = null)
    {
        if ($cart instanceof \Buildings\Cart) {
            $this
                ->addUsingAlias(ClientTableMap::COL_ID, $cart->getIdClient(), $comparison);

            return $this;
        } elseif ($cart instanceof ObjectCollection) {
            $this
                ->useCartClientQuery()
                ->filterByPrimaryKeys($cart->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByCartClient() only accepts arguments of type \Buildings\Cart or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CartClient relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCartClient(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CartClient');

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
            $this->addJoinObject($join, 'CartClient');
        }

        return $this;
    }

    /**
     * Use the CartClient relation Cart object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\CartQuery A secondary query class using the current class as primary query
     */
    public function useCartClientQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCartClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CartClient', '\Buildings\CartQuery');
    }

    /**
     * Use the CartClient relation Cart object
     *
     * @param callable(\Buildings\CartQuery):\Buildings\CartQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCartClientQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCartClientQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the CartClient relation to the Cart table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\CartQuery The inner query object of the EXISTS statement
     */
    public function useCartClientExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useExistsQuery('CartClient', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the CartClient relation to the Cart table for a NOT EXISTS query.
     *
     * @see useCartClientExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartQuery The inner query object of the NOT EXISTS statement
     */
    public function useCartClientNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useExistsQuery('CartClient', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the CartClient relation to the Cart table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\CartQuery The inner query object of the IN statement
     */
    public function useInCartClientQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useInQuery('CartClient', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the CartClient relation to the Cart table for a NOT IN query.
     *
     * @see useCartClientInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartQuery The inner query object of the NOT IN statement
     */
    public function useNotInCartClientQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useInQuery('CartClient', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByAddressOwnerClient($addressOwner, ?string $comparison = null)
    {
        if ($addressOwner instanceof \Buildings\AddressOwner) {
            $this
                ->addUsingAlias(ClientTableMap::COL_ID, $addressOwner->getIdClient(), $comparison);

            return $this;
        } elseif ($addressOwner instanceof ObjectCollection) {
            $this
                ->useAddressOwnerClientQuery()
                ->filterByPrimaryKeys($addressOwner->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerClient() only accepts arguments of type \Buildings\AddressOwner or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerClient relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerClient(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerClient');

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
            $this->addJoinObject($join, 'AddressOwnerClient');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerClient relation AddressOwner object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\AddressOwnerQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerClientQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAddressOwnerClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerClient', '\Buildings\AddressOwnerQuery');
    }

    /**
     * Use the AddressOwnerClient relation AddressOwner object
     *
     * @param callable(\Buildings\AddressOwnerQuery):\Buildings\AddressOwnerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerClientQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerClientQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerClient relation to the AddressOwner table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerClientExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerClient', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerClient relation to the AddressOwner table for a NOT EXISTS query.
     *
     * @see useAddressOwnerClientExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerClientNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerClient', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerClient relation to the AddressOwner table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerClientQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerClient', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerClient relation to the AddressOwner table for a NOT IN query.
     *
     * @see useAddressOwnerClientInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerClientQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerClient', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildClient $client Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($client = null)
    {
        if ($client) {
            $this->addUsingAlias(ClientTableMap::COL_ID, $client->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the client table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ClientTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ClientTableMap::clearInstancePool();
            ClientTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ClientTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ClientTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ClientTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ClientTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
