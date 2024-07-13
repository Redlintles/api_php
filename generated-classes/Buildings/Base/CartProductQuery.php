<?php

namespace Buildings\Base;

use \Exception;
use Buildings\CartProduct as ChildCartProduct;
use Buildings\CartProductQuery as ChildCartProductQuery;
use Buildings\Map\CartProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `cart_products` table.
 *
 * @method     ChildCartProductQuery orderByIdCart($order = Criteria::ASC) Order by the id_cart column
 * @method     ChildCartProductQuery orderByIdProduct($order = Criteria::ASC) Order by the id_product column
 * @method     ChildCartProductQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildCartProductQuery groupByIdCart() Group by the id_cart column
 * @method     ChildCartProductQuery groupByIdProduct() Group by the id_product column
 * @method     ChildCartProductQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildCartProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCartProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCartProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCartProductQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCartProductQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCartProductQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCartProductQuery leftJoinCartProductIdCart($relationAlias = null) Adds a LEFT JOIN clause to the query using the CartProductIdCart relation
 * @method     ChildCartProductQuery rightJoinCartProductIdCart($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CartProductIdCart relation
 * @method     ChildCartProductQuery innerJoinCartProductIdCart($relationAlias = null) Adds a INNER JOIN clause to the query using the CartProductIdCart relation
 *
 * @method     ChildCartProductQuery joinWithCartProductIdCart($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CartProductIdCart relation
 *
 * @method     ChildCartProductQuery leftJoinWithCartProductIdCart() Adds a LEFT JOIN clause and with to the query using the CartProductIdCart relation
 * @method     ChildCartProductQuery rightJoinWithCartProductIdCart() Adds a RIGHT JOIN clause and with to the query using the CartProductIdCart relation
 * @method     ChildCartProductQuery innerJoinWithCartProductIdCart() Adds a INNER JOIN clause and with to the query using the CartProductIdCart relation
 *
 * @method     ChildCartProductQuery leftJoinCartProductIdProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the CartProductIdProduct relation
 * @method     ChildCartProductQuery rightJoinCartProductIdProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CartProductIdProduct relation
 * @method     ChildCartProductQuery innerJoinCartProductIdProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the CartProductIdProduct relation
 *
 * @method     ChildCartProductQuery joinWithCartProductIdProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CartProductIdProduct relation
 *
 * @method     ChildCartProductQuery leftJoinWithCartProductIdProduct() Adds a LEFT JOIN clause and with to the query using the CartProductIdProduct relation
 * @method     ChildCartProductQuery rightJoinWithCartProductIdProduct() Adds a RIGHT JOIN clause and with to the query using the CartProductIdProduct relation
 * @method     ChildCartProductQuery innerJoinWithCartProductIdProduct() Adds a INNER JOIN clause and with to the query using the CartProductIdProduct relation
 *
 * @method     \Buildings\CartQuery|\Buildings\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCartProduct|null findOne(?ConnectionInterface $con = null) Return the first ChildCartProduct matching the query
 * @method     ChildCartProduct findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildCartProduct matching the query, or a new ChildCartProduct object populated from the query conditions when no match is found
 *
 * @method     ChildCartProduct|null findOneByIdCart(int $id_cart) Return the first ChildCartProduct filtered by the id_cart column
 * @method     ChildCartProduct|null findOneByIdProduct(int $id_product) Return the first ChildCartProduct filtered by the id_product column
 * @method     ChildCartProduct|null findOneByQuantity(int $quantity) Return the first ChildCartProduct filtered by the quantity column
 *
 * @method     ChildCartProduct requirePk($key, ?ConnectionInterface $con = null) Return the ChildCartProduct by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCartProduct requireOne(?ConnectionInterface $con = null) Return the first ChildCartProduct matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCartProduct requireOneByIdCart(int $id_cart) Return the first ChildCartProduct filtered by the id_cart column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCartProduct requireOneByIdProduct(int $id_product) Return the first ChildCartProduct filtered by the id_product column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCartProduct requireOneByQuantity(int $quantity) Return the first ChildCartProduct filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCartProduct[]|Collection find(?ConnectionInterface $con = null) Return ChildCartProduct objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildCartProduct> find(?ConnectionInterface $con = null) Return ChildCartProduct objects based on current ModelCriteria
 *
 * @method     ChildCartProduct[]|Collection findByIdCart(int|array<int> $id_cart) Return ChildCartProduct objects filtered by the id_cart column
 * @psalm-method Collection&\Traversable<ChildCartProduct> findByIdCart(int|array<int> $id_cart) Return ChildCartProduct objects filtered by the id_cart column
 * @method     ChildCartProduct[]|Collection findByIdProduct(int|array<int> $id_product) Return ChildCartProduct objects filtered by the id_product column
 * @psalm-method Collection&\Traversable<ChildCartProduct> findByIdProduct(int|array<int> $id_product) Return ChildCartProduct objects filtered by the id_product column
 * @method     ChildCartProduct[]|Collection findByQuantity(int|array<int> $quantity) Return ChildCartProduct objects filtered by the quantity column
 * @psalm-method Collection&\Traversable<ChildCartProduct> findByQuantity(int|array<int> $quantity) Return ChildCartProduct objects filtered by the quantity column
 *
 * @method     ChildCartProduct[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildCartProduct> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class CartProductQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\CartProductQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\CartProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCartProductQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCartProductQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCartProductQuery) {
            return $criteria;
        }
        $query = new ChildCartProductQuery();
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
     * @return ChildCartProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The CartProduct object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The CartProduct object has no primary key');
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
        throw new LogicException('The CartProduct object has no primary key');
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
        throw new LogicException('The CartProduct object has no primary key');
    }

    /**
     * Filter the query on the id_cart column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCart(1234); // WHERE id_cart = 1234
     * $query->filterByIdCart(array(12, 34)); // WHERE id_cart IN (12, 34)
     * $query->filterByIdCart(array('min' => 12)); // WHERE id_cart > 12
     * </code>
     *
     * @see       filterByCartProductIdCart()
     *
     * @param mixed $idCart The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdCart($idCart = null, ?string $comparison = null)
    {
        if (is_array($idCart)) {
            $useMinMax = false;
            if (isset($idCart['min'])) {
                $this->addUsingAlias(CartProductTableMap::COL_ID_CART, $idCart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCart['max'])) {
                $this->addUsingAlias(CartProductTableMap::COL_ID_CART, $idCart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CartProductTableMap::COL_ID_CART, $idCart, $comparison);

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
     * @see       filterByCartProductIdProduct()
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
                $this->addUsingAlias(CartProductTableMap::COL_ID_PRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(CartProductTableMap::COL_ID_PRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CartProductTableMap::COL_ID_PRODUCT, $idProduct, $comparison);

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
                $this->addUsingAlias(CartProductTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(CartProductTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CartProductTableMap::COL_QUANTITY, $quantity, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Cart object
     *
     * @param \Buildings\Cart|ObjectCollection $cart The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCartProductIdCart($cart, ?string $comparison = null)
    {
        if ($cart instanceof \Buildings\Cart) {
            return $this
                ->addUsingAlias(CartProductTableMap::COL_ID_CART, $cart->getId(), $comparison);
        } elseif ($cart instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(CartProductTableMap::COL_ID_CART, $cart->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCartProductIdCart() only accepts arguments of type \Buildings\Cart or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CartProductIdCart relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCartProductIdCart(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CartProductIdCart');

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
            $this->addJoinObject($join, 'CartProductIdCart');
        }

        return $this;
    }

    /**
     * Use the CartProductIdCart relation Cart object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\CartQuery A secondary query class using the current class as primary query
     */
    public function useCartProductIdCartQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCartProductIdCart($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CartProductIdCart', '\Buildings\CartQuery');
    }

    /**
     * Use the CartProductIdCart relation Cart object
     *
     * @param callable(\Buildings\CartQuery):\Buildings\CartQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCartProductIdCartQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCartProductIdCartQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the CartProductIdCart relation to the Cart table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\CartQuery The inner query object of the EXISTS statement
     */
    public function useCartProductIdCartExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useExistsQuery('CartProductIdCart', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the CartProductIdCart relation to the Cart table for a NOT EXISTS query.
     *
     * @see useCartProductIdCartExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartQuery The inner query object of the NOT EXISTS statement
     */
    public function useCartProductIdCartNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useExistsQuery('CartProductIdCart', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the CartProductIdCart relation to the Cart table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\CartQuery The inner query object of the IN statement
     */
    public function useInCartProductIdCartQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useInQuery('CartProductIdCart', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the CartProductIdCart relation to the Cart table for a NOT IN query.
     *
     * @see useCartProductIdCartInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CartQuery The inner query object of the NOT IN statement
     */
    public function useNotInCartProductIdCartQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CartQuery */
        $q = $this->useInQuery('CartProductIdCart', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByCartProductIdProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \Buildings\Product) {
            return $this
                ->addUsingAlias(CartProductTableMap::COL_ID_PRODUCT, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(CartProductTableMap::COL_ID_PRODUCT, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCartProductIdProduct() only accepts arguments of type \Buildings\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CartProductIdProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCartProductIdProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CartProductIdProduct');

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
            $this->addJoinObject($join, 'CartProductIdProduct');
        }

        return $this;
    }

    /**
     * Use the CartProductIdProduct relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductQuery A secondary query class using the current class as primary query
     */
    public function useCartProductIdProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCartProductIdProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CartProductIdProduct', '\Buildings\ProductQuery');
    }

    /**
     * Use the CartProductIdProduct relation Product object
     *
     * @param callable(\Buildings\ProductQuery):\Buildings\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCartProductIdProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCartProductIdProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the CartProductIdProduct relation to the Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductQuery The inner query object of the EXISTS statement
     */
    public function useCartProductIdProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('CartProductIdProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the CartProductIdProduct relation to the Product table for a NOT EXISTS query.
     *
     * @see useCartProductIdProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useCartProductIdProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('CartProductIdProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the CartProductIdProduct relation to the Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductQuery The inner query object of the IN statement
     */
    public function useInCartProductIdProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('CartProductIdProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the CartProductIdProduct relation to the Product table for a NOT IN query.
     *
     * @see useCartProductIdProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInCartProductIdProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('CartProductIdProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildCartProduct $cartProduct Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($cartProduct = null)
    {
        if ($cartProduct) {
            throw new LogicException('CartProduct object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the cart_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CartProductTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CartProductTableMap::clearInstancePool();
            CartProductTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CartProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CartProductTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CartProductTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CartProductTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
