<?php

namespace Buildings\Base;

use \Exception;
use Buildings\ProductCategory as ChildProductCategory;
use Buildings\ProductCategoryQuery as ChildProductCategoryQuery;
use Buildings\Map\ProductCategoryTableMap;
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
 * Base class that represents a query for the `product_category` table.
 *
 * @method     ChildProductCategoryQuery orderByIdProduct($order = Criteria::ASC) Order by the id_product column
 * @method     ChildProductCategoryQuery orderByIdCategory($order = Criteria::ASC) Order by the id_category column
 *
 * @method     ChildProductCategoryQuery groupByIdProduct() Group by the id_product column
 * @method     ChildProductCategoryQuery groupByIdCategory() Group by the id_category column
 *
 * @method     ChildProductCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductCategoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProductCategoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProductCategoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProductCategoryQuery leftJoinProductCategoryIdProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductCategoryIdProduct relation
 * @method     ChildProductCategoryQuery rightJoinProductCategoryIdProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductCategoryIdProduct relation
 * @method     ChildProductCategoryQuery innerJoinProductCategoryIdProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductCategoryIdProduct relation
 *
 * @method     ChildProductCategoryQuery joinWithProductCategoryIdProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ProductCategoryIdProduct relation
 *
 * @method     ChildProductCategoryQuery leftJoinWithProductCategoryIdProduct() Adds a LEFT JOIN clause and with to the query using the ProductCategoryIdProduct relation
 * @method     ChildProductCategoryQuery rightJoinWithProductCategoryIdProduct() Adds a RIGHT JOIN clause and with to the query using the ProductCategoryIdProduct relation
 * @method     ChildProductCategoryQuery innerJoinWithProductCategoryIdProduct() Adds a INNER JOIN clause and with to the query using the ProductCategoryIdProduct relation
 *
 * @method     ChildProductCategoryQuery leftJoinProductCategoryIdCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductCategoryIdCategory relation
 * @method     ChildProductCategoryQuery rightJoinProductCategoryIdCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductCategoryIdCategory relation
 * @method     ChildProductCategoryQuery innerJoinProductCategoryIdCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductCategoryIdCategory relation
 *
 * @method     ChildProductCategoryQuery joinWithProductCategoryIdCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ProductCategoryIdCategory relation
 *
 * @method     ChildProductCategoryQuery leftJoinWithProductCategoryIdCategory() Adds a LEFT JOIN clause and with to the query using the ProductCategoryIdCategory relation
 * @method     ChildProductCategoryQuery rightJoinWithProductCategoryIdCategory() Adds a RIGHT JOIN clause and with to the query using the ProductCategoryIdCategory relation
 * @method     ChildProductCategoryQuery innerJoinWithProductCategoryIdCategory() Adds a INNER JOIN clause and with to the query using the ProductCategoryIdCategory relation
 *
 * @method     \Buildings\ProductQuery|\Buildings\CategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProductCategory|null findOne(?ConnectionInterface $con = null) Return the first ChildProductCategory matching the query
 * @method     ChildProductCategory findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildProductCategory matching the query, or a new ChildProductCategory object populated from the query conditions when no match is found
 *
 * @method     ChildProductCategory|null findOneByIdProduct(int $id_product) Return the first ChildProductCategory filtered by the id_product column
 * @method     ChildProductCategory|null findOneByIdCategory(int $id_category) Return the first ChildProductCategory filtered by the id_category column
 *
 * @method     ChildProductCategory requirePk($key, ?ConnectionInterface $con = null) Return the ChildProductCategory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProductCategory requireOne(?ConnectionInterface $con = null) Return the first ChildProductCategory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProductCategory requireOneByIdProduct(int $id_product) Return the first ChildProductCategory filtered by the id_product column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProductCategory requireOneByIdCategory(int $id_category) Return the first ChildProductCategory filtered by the id_category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProductCategory[]|Collection find(?ConnectionInterface $con = null) Return ChildProductCategory objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildProductCategory> find(?ConnectionInterface $con = null) Return ChildProductCategory objects based on current ModelCriteria
 *
 * @method     ChildProductCategory[]|Collection findByIdProduct(int|array<int> $id_product) Return ChildProductCategory objects filtered by the id_product column
 * @psalm-method Collection&\Traversable<ChildProductCategory> findByIdProduct(int|array<int> $id_product) Return ChildProductCategory objects filtered by the id_product column
 * @method     ChildProductCategory[]|Collection findByIdCategory(int|array<int> $id_category) Return ChildProductCategory objects filtered by the id_category column
 * @psalm-method Collection&\Traversable<ChildProductCategory> findByIdCategory(int|array<int> $id_category) Return ChildProductCategory objects filtered by the id_category column
 *
 * @method     ChildProductCategory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildProductCategory> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class ProductCategoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\ProductCategoryQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\ProductCategory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductCategoryQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductCategoryQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildProductCategoryQuery) {
            return $criteria;
        }
        $query = new ChildProductCategoryQuery();
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
     * @return ChildProductCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The ProductCategory object has no primary key');
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
        throw new LogicException('The ProductCategory object has no primary key');
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
        throw new LogicException('The ProductCategory object has no primary key');
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
        throw new LogicException('The ProductCategory object has no primary key');
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
     * @see       filterByProductCategoryIdProduct()
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
                $this->addUsingAlias(ProductCategoryTableMap::COL_ID_PRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(ProductCategoryTableMap::COL_ID_PRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductCategoryTableMap::COL_ID_PRODUCT, $idProduct, $comparison);

        return $this;
    }

    /**
     * Filter the query on the id_category column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCategory(1234); // WHERE id_category = 1234
     * $query->filterByIdCategory(array(12, 34)); // WHERE id_category IN (12, 34)
     * $query->filterByIdCategory(array('min' => 12)); // WHERE id_category > 12
     * </code>
     *
     * @see       filterByProductCategoryIdCategory()
     *
     * @param mixed $idCategory The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdCategory($idCategory = null, ?string $comparison = null)
    {
        if (is_array($idCategory)) {
            $useMinMax = false;
            if (isset($idCategory['min'])) {
                $this->addUsingAlias(ProductCategoryTableMap::COL_ID_CATEGORY, $idCategory['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCategory['max'])) {
                $this->addUsingAlias(ProductCategoryTableMap::COL_ID_CATEGORY, $idCategory['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductCategoryTableMap::COL_ID_CATEGORY, $idCategory, $comparison);

        return $this;
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
    public function filterByProductCategoryIdProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \Buildings\Product) {
            return $this
                ->addUsingAlias(ProductCategoryTableMap::COL_ID_PRODUCT, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(ProductCategoryTableMap::COL_ID_PRODUCT, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProductCategoryIdProduct() only accepts arguments of type \Buildings\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductCategoryIdProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProductCategoryIdProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductCategoryIdProduct');

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
            $this->addJoinObject($join, 'ProductCategoryIdProduct');
        }

        return $this;
    }

    /**
     * Use the ProductCategoryIdProduct relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductCategoryIdProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductCategoryIdProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductCategoryIdProduct', '\Buildings\ProductQuery');
    }

    /**
     * Use the ProductCategoryIdProduct relation Product object
     *
     * @param callable(\Buildings\ProductQuery):\Buildings\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductCategoryIdProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductCategoryIdProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ProductCategoryIdProduct relation to the Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductQuery The inner query object of the EXISTS statement
     */
    public function useProductCategoryIdProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('ProductCategoryIdProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ProductCategoryIdProduct relation to the Product table for a NOT EXISTS query.
     *
     * @see useProductCategoryIdProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductCategoryIdProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('ProductCategoryIdProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ProductCategoryIdProduct relation to the Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductQuery The inner query object of the IN statement
     */
    public function useInProductCategoryIdProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('ProductCategoryIdProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ProductCategoryIdProduct relation to the Product table for a NOT IN query.
     *
     * @see useProductCategoryIdProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductCategoryIdProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('ProductCategoryIdProduct', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Buildings\Category object
     *
     * @param \Buildings\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProductCategoryIdCategory($category, ?string $comparison = null)
    {
        if ($category instanceof \Buildings\Category) {
            return $this
                ->addUsingAlias(ProductCategoryTableMap::COL_ID_CATEGORY, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(ProductCategoryTableMap::COL_ID_CATEGORY, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProductCategoryIdCategory() only accepts arguments of type \Buildings\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductCategoryIdCategory relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProductCategoryIdCategory(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductCategoryIdCategory');

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
            $this->addJoinObject($join, 'ProductCategoryIdCategory');
        }

        return $this;
    }

    /**
     * Use the ProductCategoryIdCategory relation Category object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useProductCategoryIdCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductCategoryIdCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductCategoryIdCategory', '\Buildings\CategoryQuery');
    }

    /**
     * Use the ProductCategoryIdCategory relation Category object
     *
     * @param callable(\Buildings\CategoryQuery):\Buildings\CategoryQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductCategoryIdCategoryQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductCategoryIdCategoryQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ProductCategoryIdCategory relation to the Category table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\CategoryQuery The inner query object of the EXISTS statement
     */
    public function useProductCategoryIdCategoryExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryIdCategory', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ProductCategoryIdCategory relation to the Category table for a NOT EXISTS query.
     *
     * @see useProductCategoryIdCategoryExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CategoryQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductCategoryIdCategoryNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryIdCategory', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ProductCategoryIdCategory relation to the Category table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\CategoryQuery The inner query object of the IN statement
     */
    public function useInProductCategoryIdCategoryQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useInQuery('ProductCategoryIdCategory', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ProductCategoryIdCategory relation to the Category table for a NOT IN query.
     *
     * @see useProductCategoryIdCategoryInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CategoryQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductCategoryIdCategoryQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useInQuery('ProductCategoryIdCategory', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildProductCategory $productCategory Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($productCategory = null)
    {
        if ($productCategory) {
            throw new LogicException('ProductCategory object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the product_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductCategoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductCategoryTableMap::clearInstancePool();
            ProductCategoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductCategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductCategoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProductCategoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductCategoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
