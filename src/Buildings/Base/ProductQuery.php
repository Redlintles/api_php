<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Product as ChildProduct;
use Buildings\ProductQuery as ChildProductQuery;
use Buildings\Map\ProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `product` table.
 *
 * @method     ChildProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildProductQuery orderByDesc($order = Criteria::ASC) Order by the desc column
 * @method     ChildProductQuery orderByUnityPrice($order = Criteria::ASC) Order by the unity_price column
 * @method     ChildProductQuery orderByInStock($order = Criteria::ASC) Order by the in_stock column
 *
 * @method     ChildProductQuery groupById() Group by the id column
 * @method     ChildProductQuery groupByTitle() Group by the title column
 * @method     ChildProductQuery groupByDesc() Group by the desc column
 * @method     ChildProductQuery groupByUnityPrice() Group by the unity_price column
 * @method     ChildProductQuery groupByInStock() Group by the in_stock column
 *
 * @method     ChildProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProductQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProductQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProductQuery leftJoinCartProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the CartProduct relation
 * @method     ChildProductQuery rightJoinCartProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CartProduct relation
 * @method     ChildProductQuery innerJoinCartProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the CartProduct relation
 *
 * @method     ChildProductQuery joinWithCartProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CartProduct relation
 *
 * @method     ChildProductQuery leftJoinWithCartProduct() Adds a LEFT JOIN clause and with to the query using the CartProduct relation
 * @method     ChildProductQuery rightJoinWithCartProduct() Adds a RIGHT JOIN clause and with to the query using the CartProduct relation
 * @method     ChildProductQuery innerJoinWithCartProduct() Adds a INNER JOIN clause and with to the query using the CartProduct relation
 *
 * @method     ChildProductQuery leftJoinSellerProductProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the SellerProductProduct relation
 * @method     ChildProductQuery rightJoinSellerProductProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SellerProductProduct relation
 * @method     ChildProductQuery innerJoinSellerProductProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the SellerProductProduct relation
 *
 * @method     ChildProductQuery joinWithSellerProductProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SellerProductProduct relation
 *
 * @method     ChildProductQuery leftJoinWithSellerProductProduct() Adds a LEFT JOIN clause and with to the query using the SellerProductProduct relation
 * @method     ChildProductQuery rightJoinWithSellerProductProduct() Adds a RIGHT JOIN clause and with to the query using the SellerProductProduct relation
 * @method     ChildProductQuery innerJoinWithSellerProductProduct() Adds a INNER JOIN clause and with to the query using the SellerProductProduct relation
 *
 * @method     ChildProductQuery leftJoinOrderProductProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProductProduct relation
 * @method     ChildProductQuery rightJoinOrderProductProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProductProduct relation
 * @method     ChildProductQuery innerJoinOrderProductProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProductProduct relation
 *
 * @method     ChildProductQuery joinWithOrderProductProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OrderProductProduct relation
 *
 * @method     ChildProductQuery leftJoinWithOrderProductProduct() Adds a LEFT JOIN clause and with to the query using the OrderProductProduct relation
 * @method     ChildProductQuery rightJoinWithOrderProductProduct() Adds a RIGHT JOIN clause and with to the query using the OrderProductProduct relation
 * @method     ChildProductQuery innerJoinWithOrderProductProduct() Adds a INNER JOIN clause and with to the query using the OrderProductProduct relation
 *
 * @method     ChildProductQuery leftJoinDiscountProductProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the DiscountProductProduct relation
 * @method     ChildProductQuery rightJoinDiscountProductProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DiscountProductProduct relation
 * @method     ChildProductQuery innerJoinDiscountProductProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the DiscountProductProduct relation
 *
 * @method     ChildProductQuery joinWithDiscountProductProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DiscountProductProduct relation
 *
 * @method     ChildProductQuery leftJoinWithDiscountProductProduct() Adds a LEFT JOIN clause and with to the query using the DiscountProductProduct relation
 * @method     ChildProductQuery rightJoinWithDiscountProductProduct() Adds a RIGHT JOIN clause and with to the query using the DiscountProductProduct relation
 * @method     ChildProductQuery innerJoinWithDiscountProductProduct() Adds a INNER JOIN clause and with to the query using the DiscountProductProduct relation
 *
 * @method     ChildProductQuery leftJoinProductCategoryProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductCategoryProduct relation
 * @method     ChildProductQuery rightJoinProductCategoryProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductCategoryProduct relation
 * @method     ChildProductQuery innerJoinProductCategoryProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductCategoryProduct relation
 *
 * @method     ChildProductQuery joinWithProductCategoryProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ProductCategoryProduct relation
 *
 * @method     ChildProductQuery leftJoinWithProductCategoryProduct() Adds a LEFT JOIN clause and with to the query using the ProductCategoryProduct relation
 * @method     ChildProductQuery rightJoinWithProductCategoryProduct() Adds a RIGHT JOIN clause and with to the query using the ProductCategoryProduct relation
 * @method     ChildProductQuery innerJoinWithProductCategoryProduct() Adds a INNER JOIN clause and with to the query using the ProductCategoryProduct relation
 *
 * @method     \Buildings\CartProductQuery|\Buildings\SellerProductQuery|\Buildings\OrderProductQuery|\Buildings\DiscountQuery|\Buildings\ProductCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProduct|null findOne(?ConnectionInterface $con = null) Return the first ChildProduct matching the query
 * @method     ChildProduct findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildProduct matching the query, or a new ChildProduct object populated from the query conditions when no match is found
 *
 * @method     ChildProduct|null findOneById(int $id) Return the first ChildProduct filtered by the id column
 * @method     ChildProduct|null findOneByTitle(string $title) Return the first ChildProduct filtered by the title column
 * @method     ChildProduct|null findOneByDesc(string $desc) Return the first ChildProduct filtered by the desc column
 * @method     ChildProduct|null findOneByUnityPrice(double $unity_price) Return the first ChildProduct filtered by the unity_price column
 * @method     ChildProduct|null findOneByInStock(int $in_stock) Return the first ChildProduct filtered by the in_stock column
 *
 * @method     ChildProduct requirePk($key, ?ConnectionInterface $con = null) Return the ChildProduct by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduct requireOne(?ConnectionInterface $con = null) Return the first ChildProduct matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduct requireOneById(int $id) Return the first ChildProduct filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduct requireOneByTitle(string $title) Return the first ChildProduct filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduct requireOneByDesc(string $desc) Return the first ChildProduct filtered by the desc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduct requireOneByUnityPrice(double $unity_price) Return the first ChildProduct filtered by the unity_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduct requireOneByInStock(int $in_stock) Return the first ChildProduct filtered by the in_stock column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduct[]|Collection find(?ConnectionInterface $con = null) Return ChildProduct objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildProduct> find(?ConnectionInterface $con = null) Return ChildProduct objects based on current ModelCriteria
 *
 * @method     ChildProduct[]|Collection findById(int|array<int> $id) Return ChildProduct objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildProduct> findById(int|array<int> $id) Return ChildProduct objects filtered by the id column
 * @method     ChildProduct[]|Collection findByTitle(string|array<string> $title) Return ChildProduct objects filtered by the title column
 * @psalm-method Collection&\Traversable<ChildProduct> findByTitle(string|array<string> $title) Return ChildProduct objects filtered by the title column
 * @method     ChildProduct[]|Collection findByDesc(string|array<string> $desc) Return ChildProduct objects filtered by the desc column
 * @psalm-method Collection&\Traversable<ChildProduct> findByDesc(string|array<string> $desc) Return ChildProduct objects filtered by the desc column
 * @method     ChildProduct[]|Collection findByUnityPrice(double|array<double> $unity_price) Return ChildProduct objects filtered by the unity_price column
 * @psalm-method Collection&\Traversable<ChildProduct> findByUnityPrice(double|array<double> $unity_price) Return ChildProduct objects filtered by the unity_price column
 * @method     ChildProduct[]|Collection findByInStock(int|array<int> $in_stock) Return ChildProduct objects filtered by the in_stock column
 * @psalm-method Collection&\Traversable<ChildProduct> findByInStock(int|array<int> $in_stock) Return ChildProduct objects filtered by the in_stock column
 *
 * @method     ChildProduct[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildProduct> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class ProductQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\ProductQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Product', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildProductQuery) {
            return $criteria;
        }
        $query = new ChildProductQuery();
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
     * @return ChildProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProductTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProduct A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, desc, unity_price, in_stock FROM product WHERE id = :p0';
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
            /** @var ChildProduct $obj */
            $obj = new ChildProduct();
            $obj->hydrate($row);
            ProductTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProduct|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(ProductTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(ProductTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(ProductTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE title IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductTableMap::COL_TITLE, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the desc column
     *
     * Example usage:
     * <code>
     * $query->filterByDesc('fooValue');   // WHERE desc = 'fooValue'
     * $query->filterByDesc('%fooValue%', Criteria::LIKE); // WHERE desc LIKE '%fooValue%'
     * $query->filterByDesc(['foo', 'bar']); // WHERE desc IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $desc The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDesc($desc = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($desc)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductTableMap::COL_DESC, $desc, $comparison);

        return $this;
    }

    /**
     * Filter the query on the unity_price column
     *
     * Example usage:
     * <code>
     * $query->filterByUnityPrice(1234); // WHERE unity_price = 1234
     * $query->filterByUnityPrice(array(12, 34)); // WHERE unity_price IN (12, 34)
     * $query->filterByUnityPrice(array('min' => 12)); // WHERE unity_price > 12
     * </code>
     *
     * @param mixed $unityPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUnityPrice($unityPrice = null, ?string $comparison = null)
    {
        if (is_array($unityPrice)) {
            $useMinMax = false;
            if (isset($unityPrice['min'])) {
                $this->addUsingAlias(ProductTableMap::COL_UNITY_PRICE, $unityPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unityPrice['max'])) {
                $this->addUsingAlias(ProductTableMap::COL_UNITY_PRICE, $unityPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductTableMap::COL_UNITY_PRICE, $unityPrice, $comparison);

        return $this;
    }

    /**
     * Filter the query on the in_stock column
     *
     * Example usage:
     * <code>
     * $query->filterByInStock(1234); // WHERE in_stock = 1234
     * $query->filterByInStock(array(12, 34)); // WHERE in_stock IN (12, 34)
     * $query->filterByInStock(array('min' => 12)); // WHERE in_stock > 12
     * </code>
     *
     * @param mixed $inStock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInStock($inStock = null, ?string $comparison = null)
    {
        if (is_array($inStock)) {
            $useMinMax = false;
            if (isset($inStock['min'])) {
                $this->addUsingAlias(ProductTableMap::COL_IN_STOCK, $inStock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inStock['max'])) {
                $this->addUsingAlias(ProductTableMap::COL_IN_STOCK, $inStock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductTableMap::COL_IN_STOCK, $inStock, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\CartProduct object
     *
     * @param \Buildings\CartProduct|ObjectCollection $cartProduct the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCartProduct($cartProduct, ?string $comparison = null)
    {
        if ($cartProduct instanceof \Buildings\CartProduct) {
            $this
                ->addUsingAlias(ProductTableMap::COL_ID, $cartProduct->getIdProduct(), $comparison);

            return $this;
        } elseif ($cartProduct instanceof ObjectCollection) {
            $this
                ->useCartProductQuery()
                ->filterByPrimaryKeys($cartProduct->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByCartProduct() only accepts arguments of type \Buildings\CartProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CartProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCartProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CartProduct');

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
            $this->addJoinObject($join, 'CartProduct');
        }

        return $this;
    }

    /**
     * Use the CartProduct relation CartProduct object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\CartProductQuery A secondary query class using the current class as primary query
     */
    public function useCartProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCartProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CartProduct', '\Buildings\CartProductQuery');
    }

    /**
     * Use the CartProduct relation CartProduct object
     *
     * @param callable(\Buildings\CartProductQuery):\Buildings\CartProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCartProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCartProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to CartProduct table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\CartProductQuery The inner query object of the EXISTS statement
     */
    public function useCartProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\CartProductQuery */
        $q = $this->useExistsQuery('CartProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to CartProduct table for a NOT EXISTS query.
     *
     * @see useCartProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useCartProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartProductQuery */
        $q = $this->useExistsQuery('CartProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to CartProduct table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\CartProductQuery The inner query object of the IN statement
     */
    public function useInCartProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\CartProductQuery */
        $q = $this->useInQuery('CartProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to CartProduct table for a NOT IN query.
     *
     * @see useCartProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInCartProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartProductQuery */
        $q = $this->useInQuery('CartProduct', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterBySellerProductProduct($sellerProduct, ?string $comparison = null)
    {
        if ($sellerProduct instanceof \Buildings\SellerProduct) {
            $this
                ->addUsingAlias(ProductTableMap::COL_ID, $sellerProduct->getIdProduct(), $comparison);

            return $this;
        } elseif ($sellerProduct instanceof ObjectCollection) {
            $this
                ->useSellerProductProductQuery()
                ->filterByPrimaryKeys($sellerProduct->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterBySellerProductProduct() only accepts arguments of type \Buildings\SellerProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SellerProductProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinSellerProductProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SellerProductProduct');

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
            $this->addJoinObject($join, 'SellerProductProduct');
        }

        return $this;
    }

    /**
     * Use the SellerProductProduct relation SellerProduct object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\SellerProductQuery A secondary query class using the current class as primary query
     */
    public function useSellerProductProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSellerProductProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SellerProductProduct', '\Buildings\SellerProductQuery');
    }

    /**
     * Use the SellerProductProduct relation SellerProduct object
     *
     * @param callable(\Buildings\SellerProductQuery):\Buildings\SellerProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSellerProductProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSellerProductProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the SellerProductProduct relation to the SellerProduct table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\SellerProductQuery The inner query object of the EXISTS statement
     */
    public function useSellerProductProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useExistsQuery('SellerProductProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the SellerProduct table for a NOT EXISTS query.
     *
     * @see useSellerProductProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useSellerProductProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useExistsQuery('SellerProductProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the SellerProduct table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\SellerProductQuery The inner query object of the IN statement
     */
    public function useInSellerProductProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useInQuery('SellerProductProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the SellerProduct table for a NOT IN query.
     *
     * @see useSellerProductProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInSellerProductProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerProductQuery */
        $q = $this->useInQuery('SellerProductProduct', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByOrderProductProduct($orderProduct, ?string $comparison = null)
    {
        if ($orderProduct instanceof \Buildings\OrderProduct) {
            $this
                ->addUsingAlias(ProductTableMap::COL_ID, $orderProduct->getIdProduct(), $comparison);

            return $this;
        } elseif ($orderProduct instanceof ObjectCollection) {
            $this
                ->useOrderProductProductQuery()
                ->filterByPrimaryKeys($orderProduct->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByOrderProductProduct() only accepts arguments of type \Buildings\OrderProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProductProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrderProductProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProductProduct');

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
            $this->addJoinObject($join, 'OrderProductProduct');
        }

        return $this;
    }

    /**
     * Use the OrderProductProduct relation OrderProduct object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\OrderProductQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderProductProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProductProduct', '\Buildings\OrderProductQuery');
    }

    /**
     * Use the OrderProductProduct relation OrderProduct object
     *
     * @param callable(\Buildings\OrderProductQuery):\Buildings\OrderProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderProductProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useOrderProductProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the OrderProductProduct relation to the OrderProduct table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\OrderProductQuery The inner query object of the EXISTS statement
     */
    public function useOrderProductProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useExistsQuery('OrderProductProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the OrderProductProduct relation to the OrderProduct table for a NOT EXISTS query.
     *
     * @see useOrderProductProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderProductProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useExistsQuery('OrderProductProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the OrderProductProduct relation to the OrderProduct table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\OrderProductQuery The inner query object of the IN statement
     */
    public function useInOrderProductProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useInQuery('OrderProductProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the OrderProductProduct relation to the OrderProduct table for a NOT IN query.
     *
     * @see useOrderProductProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\OrderProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderProductProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\OrderProductQuery */
        $q = $this->useInQuery('OrderProductProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\Discount object
     *
     * @param \Buildings\Discount|ObjectCollection $discount the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDiscountProductProduct($discount, ?string $comparison = null)
    {
        if ($discount instanceof \Buildings\Discount) {
            $this
                ->addUsingAlias(ProductTableMap::COL_ID, $discount->getIdProduct(), $comparison);

            return $this;
        } elseif ($discount instanceof ObjectCollection) {
            $this
                ->useDiscountProductProductQuery()
                ->filterByPrimaryKeys($discount->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByDiscountProductProduct() only accepts arguments of type \Buildings\Discount or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DiscountProductProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinDiscountProductProduct(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DiscountProductProduct');

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
            $this->addJoinObject($join, 'DiscountProductProduct');
        }

        return $this;
    }

    /**
     * Use the DiscountProductProduct relation Discount object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\DiscountQuery A secondary query class using the current class as primary query
     */
    public function useDiscountProductProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDiscountProductProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DiscountProductProduct', '\Buildings\DiscountQuery');
    }

    /**
     * Use the DiscountProductProduct relation Discount object
     *
     * @param callable(\Buildings\DiscountQuery):\Buildings\DiscountQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDiscountProductProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useDiscountProductProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the DiscountProductProduct relation to the Discount table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\DiscountQuery The inner query object of the EXISTS statement
     */
    public function useDiscountProductProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useExistsQuery('DiscountProductProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the DiscountProductProduct relation to the Discount table for a NOT EXISTS query.
     *
     * @see useDiscountProductProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\DiscountQuery The inner query object of the NOT EXISTS statement
     */
    public function useDiscountProductProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useExistsQuery('DiscountProductProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the DiscountProductProduct relation to the Discount table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\DiscountQuery The inner query object of the IN statement
     */
    public function useInDiscountProductProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useInQuery('DiscountProductProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the DiscountProductProduct relation to the Discount table for a NOT IN query.
     *
     * @see useDiscountProductProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\DiscountQuery The inner query object of the NOT IN statement
     */
    public function useNotInDiscountProductProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useInQuery('DiscountProductProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\ProductCategory object
     *
     * @param \Buildings\ProductCategory|ObjectCollection $productCategory the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProductCategoryProduct($productCategory, ?string $comparison = null)
    {
        if ($productCategory instanceof \Buildings\ProductCategory) {
            $this
                ->addUsingAlias(ProductTableMap::COL_ID, $productCategory->getIdProduct(), $comparison);

            return $this;
        } elseif ($productCategory instanceof ObjectCollection) {
            $this
                ->useProductCategoryProductQuery()
                ->filterByPrimaryKeys($productCategory->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByProductCategoryProduct() only accepts arguments of type \Buildings\ProductCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductCategoryProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProductCategoryProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductCategoryProduct');

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
            $this->addJoinObject($join, 'ProductCategoryProduct');
        }

        return $this;
    }

    /**
     * Use the ProductCategoryProduct relation ProductCategory object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductCategoryQuery A secondary query class using the current class as primary query
     */
    public function useProductCategoryProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductCategoryProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductCategoryProduct', '\Buildings\ProductCategoryQuery');
    }

    /**
     * Use the ProductCategoryProduct relation ProductCategory object
     *
     * @param callable(\Buildings\ProductCategoryQuery):\Buildings\ProductCategoryQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductCategoryProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductCategoryProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ProductCategoryProduct relation to the ProductCategory table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the EXISTS statement
     */
    public function useProductCategoryProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ProductCategoryProduct relation to the ProductCategory table for a NOT EXISTS query.
     *
     * @see useProductCategoryProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductCategoryProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ProductCategoryProduct relation to the ProductCategory table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the IN statement
     */
    public function useInProductCategoryProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useInQuery('ProductCategoryProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ProductCategoryProduct relation to the ProductCategory table for a NOT IN query.
     *
     * @see useProductCategoryProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductCategoryProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useInQuery('ProductCategoryProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildProduct $product Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($product = null)
    {
        if ($product) {
            $this->addUsingAlias(ProductTableMap::COL_ID, $product->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductTableMap::clearInstancePool();
            ProductTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProductTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
