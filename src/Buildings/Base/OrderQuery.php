<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Order as ChildOrder;
use Buildings\OrderQuery as ChildOrderQuery;
use Buildings\Map\OrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `order` table.
 *
 * @method     ChildOrderQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderQuery orderByIdClient($order = Criteria::ASC) Order by the id_client column
 * @method     ChildOrderQuery orderByIdSeller($order = Criteria::ASC) Order by the id_seller column
 * @method     ChildOrderQuery orderByExpiresAt($order = Criteria::ASC) Order by the expires_at column
 * @method     ChildOrderQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildOrderQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildOrderQuery groupById() Group by the id column
 * @method     ChildOrderQuery groupByIdClient() Group by the id_client column
 * @method     ChildOrderQuery groupByIdSeller() Group by the id_seller column
 * @method     ChildOrderQuery groupByExpiresAt() Group by the expires_at column
 * @method     ChildOrderQuery groupByType() Group by the type column
 * @method     ChildOrderQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildOrderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrderQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrderQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrderQuery leftJoinOrderIdClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderIdClient relation
 * @method     ChildOrderQuery rightJoinOrderIdClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderIdClient relation
 * @method     ChildOrderQuery innerJoinOrderIdClient($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderIdClient relation
 *
 * @method     ChildOrderQuery joinWithOrderIdClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderIdClient relation
 *
 * @method     ChildOrderQuery leftJoinWithOrderIdClient() Adds a LEFT JOIN clause and with to the query using the OrderIdClient relation
 * @method     ChildOrderQuery rightJoinWithOrderIdClient() Adds a RIGHT JOIN clause and with to the query using the OrderIdClient relation
 * @method     ChildOrderQuery innerJoinWithOrderIdClient() Adds a INNER JOIN clause and with to the query using the OrderIdClient relation
 *
 * @method     ChildOrderQuery leftJoinOrderIdSeller($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderIdSeller relation
 * @method     ChildOrderQuery rightJoinOrderIdSeller($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderIdSeller relation
 * @method     ChildOrderQuery innerJoinOrderIdSeller($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderIdSeller relation
 *
 * @method     ChildOrderQuery joinWithOrderIdSeller($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderIdSeller relation
 *
 * @method     ChildOrderQuery leftJoinWithOrderIdSeller() Adds a LEFT JOIN clause and with to the query using the OrderIdSeller relation
 * @method     ChildOrderQuery rightJoinWithOrderIdSeller() Adds a RIGHT JOIN clause and with to the query using the OrderIdSeller relation
 * @method     ChildOrderQuery innerJoinWithOrderIdSeller() Adds a INNER JOIN clause and with to the query using the OrderIdSeller relation
 *
 * @method     ChildOrderQuery leftJoinOrderProductOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProductOrder relation
 * @method     ChildOrderQuery rightJoinOrderProductOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProductOrder relation
 * @method     ChildOrderQuery innerJoinOrderProductOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProductOrder relation
 *
 * @method     ChildOrderQuery joinWithOrderProductOrder($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderProductOrder relation
 *
 * @method     ChildOrderQuery leftJoinWithOrderProductOrder() Adds a LEFT JOIN clause and with to the query using the OrderProductOrder relation
 * @method     ChildOrderQuery rightJoinWithOrderProductOrder() Adds a RIGHT JOIN clause and with to the query using the OrderProductOrder relation
 * @method     ChildOrderQuery innerJoinWithOrderProductOrder() Adds a INNER JOIN clause and with to the query using the OrderProductOrder relation
 *
 * @method     \Buildings\ClientQuery|\Buildings\SellerQuery|\Buildings\OrderProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrder|null findOne(?ConnectionInterface $con = null) Return the first ChildOrder matching the query
 * @method     ChildOrder findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildOrder matching the query, or a new ChildOrder object populated from the query conditions when no match is found
 *
 * @method     ChildOrder|null findOneById(int $id) Return the first ChildOrder filtered by the id column
 * @method     ChildOrder|null findOneByIdClient(int $id_client) Return the first ChildOrder filtered by the id_client column
 * @method     ChildOrder|null findOneByIdSeller(int $id_seller) Return the first ChildOrder filtered by the id_seller column
 * @method     ChildOrder|null findOneByExpiresAt(string $expires_at) Return the first ChildOrder filtered by the expires_at column
 * @method     ChildOrder|null findOneByType(string $type) Return the first ChildOrder filtered by the type column
 * @method     ChildOrder|null findOneByUpdatedAt(string $updated_at) Return the first ChildOrder filtered by the updated_at column
 *
 * @method     ChildOrder requirePk($key, ?ConnectionInterface $con = null) Return the ChildOrder by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOne(?ConnectionInterface $con = null) Return the first ChildOrder matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrder requireOneById(int $id) Return the first ChildOrder filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByIdClient(int $id_client) Return the first ChildOrder filtered by the id_client column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByIdSeller(int $id_seller) Return the first ChildOrder filtered by the id_seller column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByExpiresAt(string $expires_at) Return the first ChildOrder filtered by the expires_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByType(string $type) Return the first ChildOrder filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByUpdatedAt(string $updated_at) Return the first ChildOrder filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrder[]|Collection find(?ConnectionInterface $con = null) Return ChildOrder objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildOrder> find(?ConnectionInterface $con = null) Return ChildOrder objects based on current ModelCriteria
 *
 * @method     ChildOrder[]|Collection findById(int|array<int> $id) Return ChildOrder objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildOrder> findById(int|array<int> $id) Return ChildOrder objects filtered by the id column
 * @method     ChildOrder[]|Collection findByIdClient(int|array<int> $id_client) Return ChildOrder objects filtered by the id_client column
 * @psalm-method Collection&\Traversable<ChildOrder> findByIdClient(int|array<int> $id_client) Return ChildOrder objects filtered by the id_client column
 * @method     ChildOrder[]|Collection findByIdSeller(int|array<int> $id_seller) Return ChildOrder objects filtered by the id_seller column
 * @psalm-method Collection&\Traversable<ChildOrder> findByIdSeller(int|array<int> $id_seller) Return ChildOrder objects filtered by the id_seller column
 * @method     ChildOrder[]|Collection findByExpiresAt(string|array<string> $expires_at) Return ChildOrder objects filtered by the expires_at column
 * @psalm-method Collection&\Traversable<ChildOrder> findByExpiresAt(string|array<string> $expires_at) Return ChildOrder objects filtered by the expires_at column
 * @method     ChildOrder[]|Collection findByType(string|array<string> $type) Return ChildOrder objects filtered by the type column
 * @psalm-method Collection&\Traversable<ChildOrder> findByType(string|array<string> $type) Return ChildOrder objects filtered by the type column
 * @method     ChildOrder[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildOrder objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildOrder> findByUpdatedAt(string|array<string> $updated_at) Return ChildOrder objects filtered by the updated_at column
 *
 * @method     ChildOrder[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildOrder> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class OrderQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\OrderQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Order', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildOrderQuery) {
            return $criteria;
        }
        $query = new ChildOrderQuery();
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
     * @return ChildOrder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrderTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOrder A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, id_client, id_seller, expires_at, type, updated_at FROM order WHERE id = :p0';
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
            /** @var ChildOrder $obj */
            $obj = new ChildOrder();
            $obj->hydrate($row);
            OrderTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOrder|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(OrderTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(OrderTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(OrderTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the id_client column
     *
     * Example usage:
     * <code>
     * $query->filterByIdClient(1234); // WHERE id_client = 1234
     * $query->filterByIdClient(array(12, 34)); // WHERE id_client IN (12, 34)
     * $query->filterByIdClient(array('min' => 12)); // WHERE id_client > 12
     * </code>
     *
     * @see       filterByOrderIdClient()
     *
     * @param mixed $idClient The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdClient($idClient = null, ?string $comparison = null)
    {
        if (is_array($idClient)) {
            $useMinMax = false;
            if (isset($idClient['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_ID_CLIENT, $idClient['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idClient['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_ID_CLIENT, $idClient['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_ID_CLIENT, $idClient, $comparison);

        return $this;
    }

    /**
     * Filter the query on the id_seller column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSeller(1234); // WHERE id_seller = 1234
     * $query->filterByIdSeller(array(12, 34)); // WHERE id_seller IN (12, 34)
     * $query->filterByIdSeller(array('min' => 12)); // WHERE id_seller > 12
     * </code>
     *
     * @see       filterByOrderIdSeller()
     *
     * @param mixed $idSeller The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdSeller($idSeller = null, ?string $comparison = null)
    {
        if (is_array($idSeller)) {
            $useMinMax = false;
            if (isset($idSeller['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_ID_SELLER, $idSeller['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSeller['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_ID_SELLER, $idSeller['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_ID_SELLER, $idSeller, $comparison);

        return $this;
    }

    /**
     * Filter the query on the expires_at column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiresAt('2011-03-14'); // WHERE expires_at = '2011-03-14'
     * $query->filterByExpiresAt('now'); // WHERE expires_at = '2011-03-14'
     * $query->filterByExpiresAt(array('max' => 'yesterday')); // WHERE expires_at > '2011-03-13'
     * </code>
     *
     * @param mixed $expiresAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByExpiresAt($expiresAt = null, ?string $comparison = null)
    {
        if (is_array($expiresAt)) {
            $useMinMax = false;
            if (isset($expiresAt['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_EXPIRES_AT, $expiresAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiresAt['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_EXPIRES_AT, $expiresAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_EXPIRES_AT, $expiresAt, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE type IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $type The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_TYPE, $type, $comparison);

        return $this;
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
     * @param mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, ?string $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Client object
     *
     * @param \Buildings\Client|ObjectCollection $client The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderIdClient($client, ?string $comparison = null)
    {
        if ($client instanceof \Buildings\Client) {
            return $this
                ->addUsingAlias(OrderTableMap::COL_ID_CLIENT, $client->getId(), $comparison);
        } elseif ($client instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderTableMap::COL_ID_CLIENT, $client->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByOrderIdClient() only accepts arguments of type \Buildings\Client or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderIdClient relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderIdClient(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderIdClient');

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
            $this->addJoinObject($join, 'OrderIdClient');
        }

        return $this;
    }

    /**
     * Use the OrderIdClient relation Client object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ClientQuery A secondary query class using the current class as primary query
     */
    public function useOrderIdClientQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderIdClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderIdClient', '\Buildings\ClientQuery');
    }

    /**
     * Use the OrderIdClient relation Client object
     *
     * @param callable(\Buildings\ClientQuery):\Buildings\ClientQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderIdClientQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useOrderIdClientQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderIdClient relation to the Client table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ClientQuery The inner query object of the EXISTS statement
     */
    public function useOrderIdClientExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useExistsQuery('OrderIdClient', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderIdClient relation to the Client table for a NOT EXISTS query.
     *
     * @see useOrderIdClientExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ClientQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderIdClientNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useExistsQuery('OrderIdClient', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderIdClient relation to the Client table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ClientQuery The inner query object of the IN statement
     */
    public function useInOrderIdClientQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useInQuery('OrderIdClient', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderIdClient relation to the Client table for a NOT IN query.
     *
     * @see useOrderIdClientInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ClientQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderIdClientQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useInQuery('OrderIdClient', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\Seller object
     *
     * @param \Buildings\Seller|ObjectCollection $seller The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderIdSeller($seller, ?string $comparison = null)
    {
        if ($seller instanceof \Buildings\Seller) {
            return $this
                ->addUsingAlias(OrderTableMap::COL_ID_SELLER, $seller->getId(), $comparison);
        } elseif ($seller instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderTableMap::COL_ID_SELLER, $seller->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByOrderIdSeller() only accepts arguments of type \Buildings\Seller or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderIdSeller relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderIdSeller(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderIdSeller');

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
            $this->addJoinObject($join, 'OrderIdSeller');
        }

        return $this;
    }

    /**
     * Use the OrderIdSeller relation Seller object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\SellerQuery A secondary query class using the current class as primary query
     */
    public function useOrderIdSellerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderIdSeller($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderIdSeller', '\Buildings\SellerQuery');
    }

    /**
     * Use the OrderIdSeller relation Seller object
     *
     * @param callable(\Buildings\SellerQuery):\Buildings\SellerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderIdSellerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useOrderIdSellerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderIdSeller relation to the Seller table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\SellerQuery The inner query object of the EXISTS statement
     */
    public function useOrderIdSellerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('OrderIdSeller', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderIdSeller relation to the Seller table for a NOT EXISTS query.
     *
     * @see useOrderIdSellerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderIdSellerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('OrderIdSeller', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderIdSeller relation to the Seller table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\SellerQuery The inner query object of the IN statement
     */
    public function useInOrderIdSellerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('OrderIdSeller', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderIdSeller relation to the Seller table for a NOT IN query.
     *
     * @see useOrderIdSellerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderIdSellerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('OrderIdSeller', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\OrderProduct object
     *
     * @param \Buildings\OrderProduct|ObjectCollection $orderProduct the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderProductOrder($orderProduct, ?string $comparison = null)
    {
        if ($orderProduct instanceof \Buildings\OrderProduct) {
            $this
                ->addUsingAlias(OrderTableMap::COL_ID, $orderProduct->getIdOrder(), $comparison);

            return $this;
        } elseif ($orderProduct instanceof ObjectCollection) {
            $this
                ->useOrderProductOrderQuery()
                ->filterByPrimaryKeys($orderProduct->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByOrderProductOrder() only accepts arguments of type \Buildings\OrderProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProductOrder relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderProductOrder(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProductOrder');

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
            $this->addJoinObject($join, 'OrderProductOrder');
        }

        return $this;
    }

    /**
     * Use the OrderProductOrder relation OrderProduct object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\OrderProductQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderProductOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProductOrder', '\Buildings\OrderProductQuery');
    }

    /**
     * Use the OrderProductOrder relation OrderProduct object
     *
     * @param callable(\Buildings\OrderProductQuery):\Buildings\OrderProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderProductOrderQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useOrderProductOrderQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderProductOrder relation to the OrderProduct table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\OrderProductQuery The inner query object of the EXISTS statement
     */
    public function useOrderProductOrderExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useExistsQuery('OrderProductOrder', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderProductOrder relation to the OrderProduct table for a NOT EXISTS query.
     *
     * @see useOrderProductOrderExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderProductOrderNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useExistsQuery('OrderProductOrder', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderProductOrder relation to the OrderProduct table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\OrderProductQuery The inner query object of the IN statement
     */
    public function useInOrderProductOrderQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useInQuery('OrderProductOrder', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderProductOrder relation to the OrderProduct table for a NOT IN query.
     *
     * @see useOrderProductOrderInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderProductOrderQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useInQuery('OrderProductOrder', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildOrder $order Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($order = null)
    {
        if ($order) {
            $this->addUsingAlias(OrderTableMap::COL_ID, $order->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderTableMap::clearInstancePool();
            OrderTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrderTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        $this->addUsingAlias(OrderTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(OrderTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(OrderTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(OrderTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        $this->addUsingAlias(OrderTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(OrderTableMap::COL_UPDATED_AT);

        return $this;
    }

}
