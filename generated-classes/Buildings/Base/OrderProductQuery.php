<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\OrderProduct as ChildOrderProduct;
use Buildings\OrderProductQuery as ChildOrderProductQuery;
use Buildings\Map\OrderProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `order_products` table.
 *
 * @method     ChildOrderProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderProductQuery orderByIdOrder($order = Criteria::ASC) Order by the id_order column
 * @method     ChildOrderProductQuery orderByIdProduct($order = Criteria::ASC) Order by the id_product column
 * @method     ChildOrderProductQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildOrderProductQuery groupById() Group by the id column
 * @method     ChildOrderProductQuery groupByIdOrder() Group by the id_order column
 * @method     ChildOrderProductQuery groupByIdProduct() Group by the id_product column
 * @method     ChildOrderProductQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildOrderProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderProductQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrderProductQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrderProductQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrderProductQuery leftJoinOrderProductIdOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProductIdOrder relation
 * @method     ChildOrderProductQuery rightJoinOrderProductIdOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProductIdOrder relation
 * @method     ChildOrderProductQuery innerJoinOrderProductIdOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProductIdOrder relation
 *
 * @method     ChildOrderProductQuery joinWithOrderProductIdOrder($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderProductIdOrder relation
 *
 * @method     ChildOrderProductQuery leftJoinWithOrderProductIdOrder() Adds a LEFT JOIN clause and with to the query using the OrderProductIdOrder relation
 * @method     ChildOrderProductQuery rightJoinWithOrderProductIdOrder() Adds a RIGHT JOIN clause and with to the query using the OrderProductIdOrder relation
 * @method     ChildOrderProductQuery innerJoinWithOrderProductIdOrder() Adds a INNER JOIN clause and with to the query using the OrderProductIdOrder relation
 *
 * @method     ChildOrderProductQuery leftJoinOrderProductIdProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProductIdProduct relation
 * @method     ChildOrderProductQuery rightJoinOrderProductIdProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProductIdProduct relation
 * @method     ChildOrderProductQuery innerJoinOrderProductIdProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProductIdProduct relation
 *
 * @method     ChildOrderProductQuery joinWithOrderProductIdProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderProductIdProduct relation
 *
 * @method     ChildOrderProductQuery leftJoinWithOrderProductIdProduct() Adds a LEFT JOIN clause and with to the query using the OrderProductIdProduct relation
 * @method     ChildOrderProductQuery rightJoinWithOrderProductIdProduct() Adds a RIGHT JOIN clause and with to the query using the OrderProductIdProduct relation
 * @method     ChildOrderProductQuery innerJoinWithOrderProductIdProduct() Adds a INNER JOIN clause and with to the query using the OrderProductIdProduct relation
 *
 * @method     \Buildings\OrderQuery|\Buildings\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrderProduct|null findOne(?ConnectionInterface $con = null) Return the first ChildOrderProduct matching the query
 * @method     ChildOrderProduct findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildOrderProduct matching the query, or a new ChildOrderProduct object populated from the query conditions when no match is found
 *
 * @method     ChildOrderProduct|null findOneById(int $id) Return the first ChildOrderProduct filtered by the id column
 * @method     ChildOrderProduct|null findOneByIdOrder(int $id_order) Return the first ChildOrderProduct filtered by the id_order column
 * @method     ChildOrderProduct|null findOneByIdProduct(int $id_product) Return the first ChildOrderProduct filtered by the id_product column
 * @method     ChildOrderProduct|null findOneByQuantity(int $quantity) Return the first ChildOrderProduct filtered by the quantity column
 *
 * @method     ChildOrderProduct requirePk($key, ?ConnectionInterface $con = null) Return the ChildOrderProduct by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderProduct requireOne(?ConnectionInterface $con = null) Return the first ChildOrderProduct matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrderProduct requireOneById(int $id) Return the first ChildOrderProduct filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderProduct requireOneByIdOrder(int $id_order) Return the first ChildOrderProduct filtered by the id_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderProduct requireOneByIdProduct(int $id_product) Return the first ChildOrderProduct filtered by the id_product column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderProduct requireOneByQuantity(int $quantity) Return the first ChildOrderProduct filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrderProduct[]|Collection find(?ConnectionInterface $con = null) Return ChildOrderProduct objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildOrderProduct> find(?ConnectionInterface $con = null) Return ChildOrderProduct objects based on current ModelCriteria
 *
 * @method     ChildOrderProduct[]|Collection findById(int|array<int> $id) Return ChildOrderProduct objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildOrderProduct> findById(int|array<int> $id) Return ChildOrderProduct objects filtered by the id column
 * @method     ChildOrderProduct[]|Collection findByIdOrder(int|array<int> $id_order) Return ChildOrderProduct objects filtered by the id_order column
 * @psalm-method Collection&\Traversable<ChildOrderProduct> findByIdOrder(int|array<int> $id_order) Return ChildOrderProduct objects filtered by the id_order column
 * @method     ChildOrderProduct[]|Collection findByIdProduct(int|array<int> $id_product) Return ChildOrderProduct objects filtered by the id_product column
 * @psalm-method Collection&\Traversable<ChildOrderProduct> findByIdProduct(int|array<int> $id_product) Return ChildOrderProduct objects filtered by the id_product column
 * @method     ChildOrderProduct[]|Collection findByQuantity(int|array<int> $quantity) Return ChildOrderProduct objects filtered by the quantity column
 * @psalm-method Collection&\Traversable<ChildOrderProduct> findByQuantity(int|array<int> $quantity) Return ChildOrderProduct objects filtered by the quantity column
 *
 * @method     ChildOrderProduct[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildOrderProduct> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class OrderProductQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\OrderProductQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\OrderProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderProductQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderProductQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildOrderProductQuery) {
            return $criteria;
        }
        $query = new ChildOrderProductQuery();
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
     * @return ChildOrderProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderProductTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrderProductTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOrderProduct A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, id_order, id_product, quantity FROM order_products WHERE id = :p0';
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
            /** @var ChildOrderProduct $obj */
            $obj = new ChildOrderProduct();
            $obj->hydrate($row);
            OrderProductTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOrderProduct|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(OrderProductTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(OrderProductTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(OrderProductTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderProductTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the id_order column
     *
     * Example usage:
     * <code>
     * $query->filterByIdOrder(1234); // WHERE id_order = 1234
     * $query->filterByIdOrder(array(12, 34)); // WHERE id_order IN (12, 34)
     * $query->filterByIdOrder(array('min' => 12)); // WHERE id_order > 12
     * </code>
     *
     * @see       filterByOrderProductIdOrder()
     *
     * @param mixed $idOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdOrder($idOrder = null, ?string $comparison = null)
    {
        if (is_array($idOrder)) {
            $useMinMax = false;
            if (isset($idOrder['min'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_ID_ORDER, $idOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idOrder['max'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_ID_ORDER, $idOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderProductTableMap::COL_ID_ORDER, $idOrder, $comparison);

        return $this;
    }

    /**
     * Filter the query on the id_product column
     *
     * Example usage:
     * <code>
     * $query->filterByIdProduct(1234); // WHERE id_product = 1234
     * $query->filterByIdProduct(array(12, 34)); // WHERE id_product IN (12, 34)
     * $query->filterByIdProduct(array('min' => 12)); // WHERE id_product > 12
     * </code>
     *
     * @see       filterByOrderProductIdProduct()
     *
     * @param mixed $idProduct The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdProduct($idProduct = null, ?string $comparison = null)
    {
        if (is_array($idProduct)) {
            $useMinMax = false;
            if (isset($idProduct['min'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_ID_PRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_ID_PRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderProductTableMap::COL_ID_PRODUCT, $idProduct, $comparison);

        return $this;
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, ?string $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(OrderProductTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderProductTableMap::COL_QUANTITY, $quantity, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Order object
     *
     * @param \Buildings\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderProductIdOrder($order, ?string $comparison = null)
    {
        if ($order instanceof \Buildings\Order) {
            return $this
                ->addUsingAlias(OrderProductTableMap::COL_ID_ORDER, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderProductTableMap::COL_ID_ORDER, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByOrderProductIdOrder() only accepts arguments of type \Buildings\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProductIdOrder relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderProductIdOrder(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProductIdOrder');

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
            $this->addJoinObject($join, 'OrderProductIdOrder');
        }

        return $this;
    }

    /**
     * Use the OrderProductIdOrder relation Order object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductIdOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderProductIdOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProductIdOrder', '\Buildings\OrderQuery');
    }

    /**
     * Use the OrderProductIdOrder relation Order object
     *
     * @param callable(\Buildings\OrderQuery):\Buildings\OrderQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderProductIdOrderQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useOrderProductIdOrderQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderProductIdOrder relation to the Order table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\OrderQuery The inner query object of the EXISTS statement
     */
    public function useOrderProductIdOrderExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderProductIdOrder', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderProductIdOrder relation to the Order table for a NOT EXISTS query.
     *
     * @see useOrderProductIdOrderExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderProductIdOrderNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useExistsQuery('OrderProductIdOrder', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderProductIdOrder relation to the Order table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\OrderQuery The inner query object of the IN statement
     */
    public function useInOrderProductIdOrderQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderProductIdOrder', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderProductIdOrder relation to the Order table for a NOT IN query.
     *
     * @see useOrderProductIdOrderInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderProductIdOrderQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderQuery */
        $q = $this->useInQuery('OrderProductIdOrder', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\Product object
     *
     * @param \Buildings\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderProductIdProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \Buildings\Product) {
            return $this
                ->addUsingAlias(OrderProductTableMap::COL_ID_PRODUCT, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderProductTableMap::COL_ID_PRODUCT, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByOrderProductIdProduct() only accepts arguments of type \Buildings\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProductIdProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderProductIdProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProductIdProduct');

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
            $this->addJoinObject($join, 'OrderProductIdProduct');
        }

        return $this;
    }

    /**
     * Use the OrderProductIdProduct relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductIdProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderProductIdProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProductIdProduct', '\Buildings\ProductQuery');
    }

    /**
     * Use the OrderProductIdProduct relation Product object
     *
     * @param callable(\Buildings\ProductQuery):\Buildings\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderProductIdProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useOrderProductIdProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderProductIdProduct relation to the Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductQuery The inner query object of the EXISTS statement
     */
    public function useOrderProductIdProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('OrderProductIdProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderProductIdProduct relation to the Product table for a NOT EXISTS query.
     *
     * @see useOrderProductIdProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderProductIdProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('OrderProductIdProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderProductIdProduct relation to the Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductQuery The inner query object of the IN statement
     */
    public function useInOrderProductIdProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('OrderProductIdProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderProductIdProduct relation to the Product table for a NOT IN query.
     *
     * @see useOrderProductIdProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderProductIdProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('OrderProductIdProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildOrderProduct $orderProduct Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($orderProduct = null)
    {
        if ($orderProduct) {
            $this->addUsingAlias(OrderProductTableMap::COL_ID, $orderProduct->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderProductTableMap::clearInstancePool();
            OrderProductTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderProductTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrderProductTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderProductTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
