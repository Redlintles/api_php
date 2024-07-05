<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Discount as ChildDiscount;
use Buildings\DiscountQuery as ChildDiscountQuery;
use Buildings\Map\DiscountTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `discount` table.
 *
 * @method     ChildDiscountQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDiscountQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildDiscountQuery orderByIdProduct($order = Criteria::ASC) Order by the id_product column
 * @method     ChildDiscountQuery orderByIdCategory($order = Criteria::ASC) Order by the id_category column
 * @method     ChildDiscountQuery orderByPercent($order = Criteria::ASC) Order by the percent column
 * @method     ChildDiscountQuery orderByStartAt($order = Criteria::ASC) Order by the start_at column
 * @method     ChildDiscountQuery orderByExpiresAt($order = Criteria::ASC) Order by the expires_at column
 *
 * @method     ChildDiscountQuery groupById() Group by the id column
 * @method     ChildDiscountQuery groupByType() Group by the type column
 * @method     ChildDiscountQuery groupByIdProduct() Group by the id_product column
 * @method     ChildDiscountQuery groupByIdCategory() Group by the id_category column
 * @method     ChildDiscountQuery groupByPercent() Group by the percent column
 * @method     ChildDiscountQuery groupByStartAt() Group by the start_at column
 * @method     ChildDiscountQuery groupByExpiresAt() Group by the expires_at column
 *
 * @method     ChildDiscountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDiscountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDiscountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDiscountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDiscountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDiscountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDiscountQuery leftJoinDiscountProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the DiscountProduct relation
 * @method     ChildDiscountQuery rightJoinDiscountProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DiscountProduct relation
 * @method     ChildDiscountQuery innerJoinDiscountProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the DiscountProduct relation
 *
 * @method     ChildDiscountQuery joinWithDiscountProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DiscountProduct relation
 *
 * @method     ChildDiscountQuery leftJoinWithDiscountProduct() Adds a LEFT JOIN clause and with to the query using the DiscountProduct relation
 * @method     ChildDiscountQuery rightJoinWithDiscountProduct() Adds a RIGHT JOIN clause and with to the query using the DiscountProduct relation
 * @method     ChildDiscountQuery innerJoinWithDiscountProduct() Adds a INNER JOIN clause and with to the query using the DiscountProduct relation
 *
 * @method     ChildDiscountQuery leftJoinDiscountCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the DiscountCategory relation
 * @method     ChildDiscountQuery rightJoinDiscountCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DiscountCategory relation
 * @method     ChildDiscountQuery innerJoinDiscountCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the DiscountCategory relation
 *
 * @method     ChildDiscountQuery joinWithDiscountCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DiscountCategory relation
 *
 * @method     ChildDiscountQuery leftJoinWithDiscountCategory() Adds a LEFT JOIN clause and with to the query using the DiscountCategory relation
 * @method     ChildDiscountQuery rightJoinWithDiscountCategory() Adds a RIGHT JOIN clause and with to the query using the DiscountCategory relation
 * @method     ChildDiscountQuery innerJoinWithDiscountCategory() Adds a INNER JOIN clause and with to the query using the DiscountCategory relation
 *
 * @method     \Buildings\ProductQuery|\Buildings\CategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDiscount|null findOne(?ConnectionInterface $con = null) Return the first ChildDiscount matching the query
 * @method     ChildDiscount findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildDiscount matching the query, or a new ChildDiscount object populated from the query conditions when no match is found
 *
 * @method     ChildDiscount|null findOneById(int $id) Return the first ChildDiscount filtered by the id column
 * @method     ChildDiscount|null findOneByType(string $type) Return the first ChildDiscount filtered by the type column
 * @method     ChildDiscount|null findOneByIdProduct(int $id_product) Return the first ChildDiscount filtered by the id_product column
 * @method     ChildDiscount|null findOneByIdCategory(int $id_category) Return the first ChildDiscount filtered by the id_category column
 * @method     ChildDiscount|null findOneByPercent(int $percent) Return the first ChildDiscount filtered by the percent column
 * @method     ChildDiscount|null findOneByStartAt(string $start_at) Return the first ChildDiscount filtered by the start_at column
 * @method     ChildDiscount|null findOneByExpiresAt(string $expires_at) Return the first ChildDiscount filtered by the expires_at column
 *
 * @method     ChildDiscount requirePk($key, ?ConnectionInterface $con = null) Return the ChildDiscount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOne(?ConnectionInterface $con = null) Return the first ChildDiscount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDiscount requireOneById(int $id) Return the first ChildDiscount filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByType(string $type) Return the first ChildDiscount filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByIdProduct(int $id_product) Return the first ChildDiscount filtered by the id_product column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByIdCategory(int $id_category) Return the first ChildDiscount filtered by the id_category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByPercent(int $percent) Return the first ChildDiscount filtered by the percent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByStartAt(string $start_at) Return the first ChildDiscount filtered by the start_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDiscount requireOneByExpiresAt(string $expires_at) Return the first ChildDiscount filtered by the expires_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDiscount[]|Collection find(?ConnectionInterface $con = null) Return ChildDiscount objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildDiscount> find(?ConnectionInterface $con = null) Return ChildDiscount objects based on current ModelCriteria
 *
 * @method     ChildDiscount[]|Collection findById(int|array<int> $id) Return ChildDiscount objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildDiscount> findById(int|array<int> $id) Return ChildDiscount objects filtered by the id column
 * @method     ChildDiscount[]|Collection findByType(string|array<string> $type) Return ChildDiscount objects filtered by the type column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByType(string|array<string> $type) Return ChildDiscount objects filtered by the type column
 * @method     ChildDiscount[]|Collection findByIdProduct(int|array<int> $id_product) Return ChildDiscount objects filtered by the id_product column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByIdProduct(int|array<int> $id_product) Return ChildDiscount objects filtered by the id_product column
 * @method     ChildDiscount[]|Collection findByIdCategory(int|array<int> $id_category) Return ChildDiscount objects filtered by the id_category column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByIdCategory(int|array<int> $id_category) Return ChildDiscount objects filtered by the id_category column
 * @method     ChildDiscount[]|Collection findByPercent(int|array<int> $percent) Return ChildDiscount objects filtered by the percent column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByPercent(int|array<int> $percent) Return ChildDiscount objects filtered by the percent column
 * @method     ChildDiscount[]|Collection findByStartAt(string|array<string> $start_at) Return ChildDiscount objects filtered by the start_at column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByStartAt(string|array<string> $start_at) Return ChildDiscount objects filtered by the start_at column
 * @method     ChildDiscount[]|Collection findByExpiresAt(string|array<string> $expires_at) Return ChildDiscount objects filtered by the expires_at column
 * @psalm-method Collection&\Traversable<ChildDiscount> findByExpiresAt(string|array<string> $expires_at) Return ChildDiscount objects filtered by the expires_at column
 *
 * @method     ChildDiscount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildDiscount> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class DiscountQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\DiscountQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Discount', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDiscountQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDiscountQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDiscountQuery) {
            return $criteria;
        }
        $query = new ChildDiscountQuery();
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
     * @return ChildDiscount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DiscountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DiscountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDiscount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, type, id_product, id_category, percent, start_at, expires_at FROM discount WHERE id = :p0';
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
            /** @var ChildDiscount $obj */
            $obj = new ChildDiscount();
            $obj->hydrate($row);
            DiscountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDiscount|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(DiscountTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(DiscountTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(DiscountTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_ID, $id, $comparison);

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

        $this->addUsingAlias(DiscountTableMap::COL_TYPE, $type, $comparison);

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
     * @see       filterByDiscountProduct()
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
                $this->addUsingAlias(DiscountTableMap::COL_ID_PRODUCT, $idProduct['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProduct['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_ID_PRODUCT, $idProduct['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_ID_PRODUCT, $idProduct, $comparison);

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
     * @see       filterByDiscountCategory()
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
                $this->addUsingAlias(DiscountTableMap::COL_ID_CATEGORY, $idCategory['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCategory['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_ID_CATEGORY, $idCategory['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_ID_CATEGORY, $idCategory, $comparison);

        return $this;
    }

    /**
     * Filter the query on the percent column
     *
     * Example usage:
     * <code>
     * $query->filterByPercent(1234); // WHERE percent = 1234
     * $query->filterByPercent(array(12, 34)); // WHERE percent IN (12, 34)
     * $query->filterByPercent(array('min' => 12)); // WHERE percent > 12
     * </code>
     *
     * @param mixed $percent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPercent($percent = null, ?string $comparison = null)
    {
        if (is_array($percent)) {
            $useMinMax = false;
            if (isset($percent['min'])) {
                $this->addUsingAlias(DiscountTableMap::COL_PERCENT, $percent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($percent['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_PERCENT, $percent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_PERCENT, $percent, $comparison);

        return $this;
    }

    /**
     * Filter the query on the start_at column
     *
     * Example usage:
     * <code>
     * $query->filterByStartAt('2011-03-14'); // WHERE start_at = '2011-03-14'
     * $query->filterByStartAt('now'); // WHERE start_at = '2011-03-14'
     * $query->filterByStartAt(array('max' => 'yesterday')); // WHERE start_at > '2011-03-13'
     * </code>
     *
     * @param mixed $startAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStartAt($startAt = null, ?string $comparison = null)
    {
        if (is_array($startAt)) {
            $useMinMax = false;
            if (isset($startAt['min'])) {
                $this->addUsingAlias(DiscountTableMap::COL_START_AT, $startAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startAt['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_START_AT, $startAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_START_AT, $startAt, $comparison);

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
                $this->addUsingAlias(DiscountTableMap::COL_EXPIRES_AT, $expiresAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiresAt['max'])) {
                $this->addUsingAlias(DiscountTableMap::COL_EXPIRES_AT, $expiresAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DiscountTableMap::COL_EXPIRES_AT, $expiresAt, $comparison);

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
    public function filterByDiscountProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \Buildings\Product) {
            return $this
                ->addUsingAlias(DiscountTableMap::COL_ID_PRODUCT, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DiscountTableMap::COL_ID_PRODUCT, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByDiscountProduct() only accepts arguments of type \Buildings\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DiscountProduct relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinDiscountProduct(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DiscountProduct');

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
            $this->addJoinObject($join, 'DiscountProduct');
        }

        return $this;
    }

    /**
     * Use the DiscountProduct relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ProductQuery A secondary query class using the current class as primary query
     */
    public function useDiscountProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDiscountProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DiscountProduct', '\Buildings\ProductQuery');
    }

    /**
     * Use the DiscountProduct relation Product object
     *
     * @param callable(\Buildings\ProductQuery):\Buildings\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDiscountProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useDiscountProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the DiscountProduct relation to the Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ProductQuery The inner query object of the EXISTS statement
     */
    public function useDiscountProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('DiscountProduct', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the DiscountProduct relation to the Product table for a NOT EXISTS query.
     *
     * @see useDiscountProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useDiscountProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useExistsQuery('DiscountProduct', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the DiscountProduct relation to the Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ProductQuery The inner query object of the IN statement
     */
    public function useInDiscountProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('DiscountProduct', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the DiscountProduct relation to the Product table for a NOT IN query.
     *
     * @see useDiscountProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInDiscountProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ProductQuery */
        $q = $this->useInQuery('DiscountProduct', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByDiscountCategory($category, ?string $comparison = null)
    {
        if ($category instanceof \Buildings\Category) {
            return $this
                ->addUsingAlias(DiscountTableMap::COL_ID_CATEGORY, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(DiscountTableMap::COL_ID_CATEGORY, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByDiscountCategory() only accepts arguments of type \Buildings\Category or Collection');
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
     * Use the DiscountCategory relation Category object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useDiscountCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDiscountCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DiscountCategory', '\Buildings\CategoryQuery');
    }

    /**
     * Use the DiscountCategory relation Category object
     *
     * @param callable(\Buildings\CategoryQuery):\Buildings\CategoryQuery $callable A function working on the related query
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
     * Use the DiscountCategory relation to the Category table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\CategoryQuery The inner query object of the EXISTS statement
     */
    public function useDiscountCategoryExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useExistsQuery('DiscountCategory', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Category table for a NOT EXISTS query.
     *
     * @see useDiscountCategoryExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CategoryQuery The inner query object of the NOT EXISTS statement
     */
    public function useDiscountCategoryNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useExistsQuery('DiscountCategory', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Category table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\CategoryQuery The inner query object of the IN statement
     */
    public function useInDiscountCategoryQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useInQuery('DiscountCategory', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the DiscountCategory relation to the Category table for a NOT IN query.
     *
     * @see useDiscountCategoryInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\CategoryQuery The inner query object of the NOT IN statement
     */
    public function useNotInDiscountCategoryQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\CategoryQuery */
        $q = $this->useInQuery('DiscountCategory', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildDiscount $discount Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($discount = null)
    {
        if ($discount) {
            $this->addUsingAlias(DiscountTableMap::COL_ID, $discount->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the discount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DiscountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DiscountTableMap::clearInstancePool();
            DiscountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DiscountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DiscountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DiscountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DiscountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
