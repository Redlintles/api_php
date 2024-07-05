<?php

namespace Buildings\Base;

use \Exception;
use Buildings\SellerProduct as ChildSellerProduct;
use Buildings\SellerProductQuery as ChildSellerProductQuery;
use Buildings\Map\SellerProductTableMap;
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
 * Base class that represents a query for the `seller_products` table.
 *
 * @method     ChildSellerProductQuery orderByIdSeller($order = Criteria::ASC) Order by the id_seller column
 * @method     ChildSellerProductQuery orderByIdProduct($order = Criteria::ASC) Order by the id_product column
 *
 * @method     ChildSellerProductQuery groupByIdSeller() Group by the id_seller column
 * @method     ChildSellerProductQuery groupByIdProduct() Group by the id_product column
 *
 * @method     ChildSellerProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSellerProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSellerProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSellerProductQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSellerProductQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSellerProductQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSellerProductQuery leftJoinSellerProductId($relationAlias = null) Adds a LEFT JOIN clause to the query using the SellerProductId relation
 * @method     ChildSellerProductQuery rightJoinSellerProductId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SellerProductId relation
 * @method     ChildSellerProductQuery innerJoinSellerProductId($relationAlias = null) Adds a INNER JOIN clause to the query using the SellerProductId relation
 *
 * @method     ChildSellerProductQuery joinWithSellerProductId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SellerProductId relation
 *
 * @method     ChildSellerProductQuery leftJoinWithSellerProductId() Adds a LEFT JOIN clause and with to the query using the SellerProductId relation
 * @method     ChildSellerProductQuery rightJoinWithSellerProductId() Adds a RIGHT JOIN clause and with to the query using the SellerProductId relation
 * @method     ChildSellerProductQuery innerJoinWithSellerProductId() Adds a INNER JOIN clause and with to the query using the SellerProductId relation
 *
 * @method     ChildSellerProductQuery leftJoinSellerProductProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the SellerProductProduct relation
 * @method     ChildSellerProductQuery rightJoinSellerProductProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SellerProductProduct relation
 * @method     ChildSellerProductQuery innerJoinSellerProductProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the SellerProductProduct relation
 *
 * @method     ChildSellerProductQuery joinWithSellerProductProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SellerProductProduct relation
 *
 * @method     ChildSellerProductQuery leftJoinWithSellerProductProduct() Adds a LEFT JOIN clause and with to the query using the SellerProductProduct relation
 * @method     ChildSellerProductQuery rightJoinWithSellerProductProduct() Adds a RIGHT JOIN clause and with to the query using the SellerProductProduct relation
 * @method     ChildSellerProductQuery innerJoinWithSellerProductProduct() Adds a INNER JOIN clause and with to the query using the SellerProductProduct relation
 *
 * @method     \Buildings\SellerQuery|\Buildings\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSellerProduct|null findOne(?ConnectionInterface $con = null) Return the first ChildSellerProduct matching the query
 * @method     ChildSellerProduct findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildSellerProduct matching the query, or a new ChildSellerProduct object populated from the query conditions when no match is found
 *
 * @method     ChildSellerProduct|null findOneByIdSeller(int $id_seller) Return the first ChildSellerProduct filtered by the id_seller column
 * @method     ChildSellerProduct|null findOneByIdProduct(int $id_product) Return the first ChildSellerProduct filtered by the id_product column
 *
 * @method     ChildSellerProduct requirePk($key, ?ConnectionInterface $con = null) Return the ChildSellerProduct by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSellerProduct requireOne(?ConnectionInterface $con = null) Return the first ChildSellerProduct matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSellerProduct requireOneByIdSeller(int $id_seller) Return the first ChildSellerProduct filtered by the id_seller column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSellerProduct requireOneByIdProduct(int $id_product) Return the first ChildSellerProduct filtered by the id_product column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSellerProduct[]|Collection find(?ConnectionInterface $con = null) Return ChildSellerProduct objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildSellerProduct> find(?ConnectionInterface $con = null) Return ChildSellerProduct objects based on current ModelCriteria
 *
 * @method     ChildSellerProduct[]|Collection findByIdSeller(int|array<int> $id_seller) Return ChildSellerProduct objects filtered by the id_seller column
 * @psalm-method Collection&\Traversable<ChildSellerProduct> findByIdSeller(int|array<int> $id_seller) Return ChildSellerProduct objects filtered by the id_seller column
 * @method     ChildSellerProduct[]|Collection findByIdProduct(int|array<int> $id_product) Return ChildSellerProduct objects filtered by the id_product column
 * @psalm-method Collection&\Traversable<ChildSellerProduct> findByIdProduct(int|array<int> $id_product) Return ChildSellerProduct objects filtered by the id_product column
 *
 * @method     ChildSellerProduct[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildSellerProduct> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class SellerProductQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\SellerProductQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\SellerProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSellerProductQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSellerProductQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildSellerProductQuery) {
            return $criteria;
        }
        $query = new ChildSellerProductQuery();
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
     * @return ChildSellerProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The SellerProduct object has no primary key');
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
        throw new LogicException('The SellerProduct object has no primary key');
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
        throw new LogicException('The SellerProduct object has no primary key');
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
        throw new LogicException('The SellerProduct object has no primary key');
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
     * @see       filterBySellerProductId()
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
                $this->addUsingAlias(SellerProductTableMap::COL_ID_SELLER, $idSeller['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSeller['max'])) {
                $this->addUsingAlias(SellerProductTableMap::COL_ID_SELLER, $idSeller['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerProductTableMap::COL_ID_SELLER, $idSeller, $comparison);

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
     * @see       filterBySellerProductProduct()
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
                $this->addUsingAlias(SellerProductTableMap::COL_ID_PRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(SellerProductTableMap::COL_ID_PRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(SellerProductTableMap::COL_ID_PRODUCT, $idProduct, $comparison);

        return $this;
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
    public function filterBySellerProductId($seller, ?string $comparison = null)
    {
        if ($seller instanceof \Buildings\Seller) {
            return $this
                ->addUsingAlias(SellerProductTableMap::COL_ID_SELLER, $seller->getId(), $comparison);
        } elseif ($seller instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(SellerProductTableMap::COL_ID_SELLER, $seller->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterBySellerProductId() only accepts arguments of type \Buildings\Seller or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SellerProductId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinSellerProductId(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SellerProductId');

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
            $this->addJoinObject($join, 'SellerProductId');
        }

        return $this;
    }

    /**
     * Use the SellerProductId relation Seller object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\SellerQuery A secondary query class using the current class as primary query
     */
    public function useSellerProductIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSellerProductId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SellerProductId', '\Buildings\SellerQuery');
    }

    /**
     * Use the SellerProductId relation Seller object
     *
     * @param callable(\Buildings\SellerQuery):\Buildings\SellerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSellerProductIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSellerProductIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the SellerProductId relation to the Seller table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\SellerQuery The inner query object of the EXISTS statement
     */
    public function useSellerProductIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('SellerProductId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the SellerProductId relation to the Seller table for a NOT EXISTS query.
     *
     * @see useSellerProductIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT EXISTS statement
     */
    public function useSellerProductIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('SellerProductId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the SellerProductId relation to the Seller table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\SellerQuery The inner query object of the IN statement
     */
    public function useInSellerProductIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('SellerProductId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the SellerProductId relation to the Seller table for a NOT IN query.
     *
     * @see useSellerProductIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT IN statement
     */
    public function useNotInSellerProductIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('SellerProductId', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterBySellerProductProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \Buildings\Product) {
            return $this
                ->addUsingAlias(SellerProductTableMap::COL_ID_PRODUCT, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(SellerProductTableMap::COL_ID_PRODUCT, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterBySellerProductProduct() only accepts arguments of type \Buildings\Product or Collection');
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
     * Use the SellerProductProduct relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductQuery A secondary query class using the current class as primary query
     */
    public function useSellerProductProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSellerProductProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SellerProductProduct', '\Buildings\ProductQuery');
    }

    /**
     * Use the SellerProductProduct relation Product object
     *
     * @param callable(\Buildings\ProductQuery):\Buildings\ProductQuery $callable A function working on the related query
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
     * Use the SellerProductProduct relation to the Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductQuery The inner query object of the EXISTS statement
     */
    public function useSellerProductProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('SellerProductProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the Product table for a NOT EXISTS query.
     *
     * @see useSellerProductProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useSellerProductProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('SellerProductProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductQuery The inner query object of the IN statement
     */
    public function useInSellerProductProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('SellerProductProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the SellerProductProduct relation to the Product table for a NOT IN query.
     *
     * @see useSellerProductProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInSellerProductProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('SellerProductProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildSellerProduct $sellerProduct Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($sellerProduct = null)
    {
        if ($sellerProduct) {
            throw new LogicException('SellerProduct object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the seller_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SellerProductTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SellerProductTableMap::clearInstancePool();
            SellerProductTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SellerProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SellerProductTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SellerProductTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SellerProductTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
