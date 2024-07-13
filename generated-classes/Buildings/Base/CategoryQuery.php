<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Category as ChildCategory;
use Buildings\CategoryQuery as ChildCategoryQuery;
use Buildings\Map\CategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `category` table.
 *
 * @method     ChildCategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCategoryQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildCategoryQuery groupById() Group by the id column
 * @method     ChildCategoryQuery groupByName() Group by the name column
 *
 * @method     ChildCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCategoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCategoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCategoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCategoryQuery leftJoinDiscountCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the DiscountCategory relation
 * @method     ChildCategoryQuery rightJoinDiscountCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DiscountCategory relation
 * @method     ChildCategoryQuery innerJoinDiscountCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the DiscountCategory relation
 *
 * @method     ChildCategoryQuery joinWithDiscountCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DiscountCategory relation
 *
 * @method     ChildCategoryQuery leftJoinWithDiscountCategory() Adds a LEFT JOIN clause and with to the query using the DiscountCategory relation
 * @method     ChildCategoryQuery rightJoinWithDiscountCategory() Adds a RIGHT JOIN clause and with to the query using the DiscountCategory relation
 * @method     ChildCategoryQuery innerJoinWithDiscountCategory() Adds a INNER JOIN clause and with to the query using the DiscountCategory relation
 *
 * @method     ChildCategoryQuery leftJoinProductCategoryCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductCategoryCategory relation
 * @method     ChildCategoryQuery rightJoinProductCategoryCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductCategoryCategory relation
 * @method     ChildCategoryQuery innerJoinProductCategoryCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductCategoryCategory relation
 *
 * @method     ChildCategoryQuery joinWithProductCategoryCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ProductCategoryCategory relation
 *
 * @method     ChildCategoryQuery leftJoinWithProductCategoryCategory() Adds a LEFT JOIN clause and with to the query using the ProductCategoryCategory relation
 * @method     ChildCategoryQuery rightJoinWithProductCategoryCategory() Adds a RIGHT JOIN clause and with to the query using the ProductCategoryCategory relation
 * @method     ChildCategoryQuery innerJoinWithProductCategoryCategory() Adds a INNER JOIN clause and with to the query using the ProductCategoryCategory relation
 *
 * @method     \Buildings\DiscountQuery|\Buildings\ProductCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCategory|null findOne(?ConnectionInterface $con = null) Return the first ChildCategory matching the query
 * @method     ChildCategory findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildCategory matching the query, or a new ChildCategory object populated from the query conditions when no match is found
 *
 * @method     ChildCategory|null findOneById(int $id) Return the first ChildCategory filtered by the id column
 * @method     ChildCategory|null findOneByName(string $name) Return the first ChildCategory filtered by the name column
 *
 * @method     ChildCategory requirePk($key, ?ConnectionInterface $con = null) Return the ChildCategory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategory requireOne(?ConnectionInterface $con = null) Return the first ChildCategory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategory requireOneById(int $id) Return the first ChildCategory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategory requireOneByName(string $name) Return the first ChildCategory filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategory[]|Collection find(?ConnectionInterface $con = null) Return ChildCategory objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildCategory> find(?ConnectionInterface $con = null) Return ChildCategory objects based on current ModelCriteria
 *
 * @method     ChildCategory[]|Collection findById(int|array<int> $id) Return ChildCategory objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildCategory> findById(int|array<int> $id) Return ChildCategory objects filtered by the id column
 * @method     ChildCategory[]|Collection findByName(string|array<string> $name) Return ChildCategory objects filtered by the name column
 * @psalm-method Collection&\Traversable<ChildCategory> findByName(string|array<string> $name) Return ChildCategory objects filtered by the name column
 *
 * @method     ChildCategory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildCategory> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class CategoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\CategoryQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Category', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCategoryQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCategoryQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCategoryQuery) {
            return $criteria;
        }
        $query = new ChildCategoryQuery();
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
     * @return ChildCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CategoryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CategoryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCategory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name FROM category WHERE id = :p0';
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
            /** @var ChildCategory $obj */
            $obj = new ChildCategory();
            $obj->hydrate($row);
            CategoryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCategory|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(CategoryTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(CategoryTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(CategoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CategoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CategoryTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CategoryTableMap::COL_NAME, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Discount object
     *
     * @param \Buildings\Discount|ObjectCollection $discount the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDiscountCategory($discount, ?string $comparison = null)
    {
        if ($discount instanceof \Buildings\Discount) {
            $this
                ->addUsingAlias(CategoryTableMap::COL_ID, $discount->getIdCategory(), $comparison);

            return $this;
        } elseif ($discount instanceof ObjectCollection) {
            $this
                ->useDiscountCategoryQuery()
                ->filterByPrimaryKeys($discount->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByDiscountCategory() only accepts arguments of type \Buildings\Discount or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DiscountCategory relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinDiscountCategory(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DiscountCategory');

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
            $this->addJoinObject($join, 'DiscountCategory');
        }

        return $this;
    }

    /**
     * Use the DiscountCategory relation Discount object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\DiscountQuery A secondary query class using the current class as primary query
     */
    public function useDiscountCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDiscountCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DiscountCategory', '\Buildings\DiscountQuery');
    }

    /**
     * Use the DiscountCategory relation Discount object
     *
     * @param callable(\Buildings\DiscountQuery):\Buildings\DiscountQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDiscountCategoryQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useDiscountCategoryQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the DiscountCategory relation to the Discount table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\DiscountQuery The inner query object of the EXISTS statement
     */
    public function useDiscountCategoryExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useExistsQuery('DiscountCategory', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Discount table for a NOT EXISTS query.
     *
     * @see useDiscountCategoryExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\DiscountQuery The inner query object of the NOT EXISTS statement
     */
    public function useDiscountCategoryNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useExistsQuery('DiscountCategory', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Discount table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\DiscountQuery The inner query object of the IN statement
     */
    public function useInDiscountCategoryQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useInQuery('DiscountCategory', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Discount table for a NOT IN query.
     *
     * @see useDiscountCategoryInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\DiscountQuery The inner query object of the NOT IN statement
     */
    public function useNotInDiscountCategoryQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\DiscountQuery */
        $q = $this->useInQuery('DiscountCategory', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByProductCategoryCategory($productCategory, ?string $comparison = null)
    {
        if ($productCategory instanceof \Buildings\ProductCategory) {
            $this
                ->addUsingAlias(CategoryTableMap::COL_ID, $productCategory->getIdCategory(), $comparison);

            return $this;
        } elseif ($productCategory instanceof ObjectCollection) {
            $this
                ->useProductCategoryCategoryQuery()
                ->filterByPrimaryKeys($productCategory->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByProductCategoryCategory() only accepts arguments of type \Buildings\ProductCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductCategoryCategory relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProductCategoryCategory(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductCategoryCategory');

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
            $this->addJoinObject($join, 'ProductCategoryCategory');
        }

        return $this;
    }

    /**
     * Use the ProductCategoryCategory relation ProductCategory object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductCategoryQuery A secondary query class using the current class as primary query
     */
    public function useProductCategoryCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductCategoryCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductCategoryCategory', '\Buildings\ProductCategoryQuery');
    }

    /**
     * Use the ProductCategoryCategory relation ProductCategory object
     *
     * @param callable(\Buildings\ProductCategoryQuery):\Buildings\ProductCategoryQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductCategoryCategoryQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductCategoryCategoryQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ProductCategoryCategory relation to the ProductCategory table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the EXISTS statement
     */
    public function useProductCategoryCategoryExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryCategory', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ProductCategoryCategory relation to the ProductCategory table for a NOT EXISTS query.
     *
     * @see useProductCategoryCategoryExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductCategoryCategoryNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useExistsQuery('ProductCategoryCategory', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ProductCategoryCategory relation to the ProductCategory table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the IN statement
     */
    public function useInProductCategoryCategoryQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useInQuery('ProductCategoryCategory', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ProductCategoryCategory relation to the ProductCategory table for a NOT IN query.
     *
     * @see useProductCategoryCategoryInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductCategoryQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductCategoryCategoryQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductCategoryQuery */
        $q = $this->useInQuery('ProductCategoryCategory', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildCategory $category Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($category = null)
    {
        if ($category) {
            $this->addUsingAlias(CategoryTableMap::COL_ID, $category->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CategoryTableMap::clearInstancePool();
            CategoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CategoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CategoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CategoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
