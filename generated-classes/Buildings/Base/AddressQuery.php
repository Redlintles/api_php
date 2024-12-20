<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Address as ChildAddress;
use Buildings\AddressQuery as ChildAddressQuery;
use Buildings\Map\AddressTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `address` table.
 *
 * @method     ChildAddressQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAddressQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildAddressQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildAddressQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildAddressQuery orderByNeighborhood($order = Criteria::ASC) Order by the neighborhood column
 * @method     ChildAddressQuery orderByStreet($order = Criteria::ASC) Order by the street column
 * @method     ChildAddressQuery orderByNumber($order = Criteria::ASC) Order by the number column
 *
 * @method     ChildAddressQuery groupById() Group by the id column
 * @method     ChildAddressQuery groupByCountry() Group by the country column
 * @method     ChildAddressQuery groupByState() Group by the state column
 * @method     ChildAddressQuery groupByCity() Group by the city column
 * @method     ChildAddressQuery groupByNeighborhood() Group by the neighborhood column
 * @method     ChildAddressQuery groupByStreet() Group by the street column
 * @method     ChildAddressQuery groupByNumber() Group by the number column
 *
 * @method     ChildAddressQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAddressQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAddressQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAddressQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAddressQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAddressQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAddressQuery leftJoinAddressOwnerAddress($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerAddress relation
 * @method     ChildAddressQuery rightJoinAddressOwnerAddress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerAddress relation
 * @method     ChildAddressQuery innerJoinAddressOwnerAddress($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerAddress relation
 *
 * @method     ChildAddressQuery joinWithAddressOwnerAddress($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerAddress relation
 *
 * @method     ChildAddressQuery leftJoinWithAddressOwnerAddress() Adds a LEFT JOIN clause and with to the query using the AddressOwnerAddress relation
 * @method     ChildAddressQuery rightJoinWithAddressOwnerAddress() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerAddress relation
 * @method     ChildAddressQuery innerJoinWithAddressOwnerAddress() Adds a INNER JOIN clause and with to the query using the AddressOwnerAddress relation
 *
 * @method     \Buildings\AddressOwnerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAddress|null findOne(?ConnectionInterface $con = null) Return the first ChildAddress matching the query
 * @method     ChildAddress findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAddress matching the query, or a new ChildAddress object populated from the query conditions when no match is found
 *
 * @method     ChildAddress|null findOneById(int $id) Return the first ChildAddress filtered by the id column
 * @method     ChildAddress|null findOneByCountry(string $country) Return the first ChildAddress filtered by the country column
 * @method     ChildAddress|null findOneByState(string $state) Return the first ChildAddress filtered by the state column
 * @method     ChildAddress|null findOneByCity(string $city) Return the first ChildAddress filtered by the city column
 * @method     ChildAddress|null findOneByNeighborhood(string $neighborhood) Return the first ChildAddress filtered by the neighborhood column
 * @method     ChildAddress|null findOneByStreet(string $street) Return the first ChildAddress filtered by the street column
 * @method     ChildAddress|null findOneByNumber(int $number) Return the first ChildAddress filtered by the number column
 *
 * @method     ChildAddress requirePk($key, ?ConnectionInterface $con = null) Return the ChildAddress by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOne(?ConnectionInterface $con = null) Return the first ChildAddress matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddress requireOneById(int $id) Return the first ChildAddress filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByCountry(string $country) Return the first ChildAddress filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByState(string $state) Return the first ChildAddress filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByCity(string $city) Return the first ChildAddress filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByNeighborhood(string $neighborhood) Return the first ChildAddress filtered by the neighborhood column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByStreet(string $street) Return the first ChildAddress filtered by the street column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByNumber(int $number) Return the first ChildAddress filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddress[]|Collection find(?ConnectionInterface $con = null) Return ChildAddress objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAddress> find(?ConnectionInterface $con = null) Return ChildAddress objects based on current ModelCriteria
 *
 * @method     ChildAddress[]|Collection findById(int|array<int> $id) Return ChildAddress objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildAddress> findById(int|array<int> $id) Return ChildAddress objects filtered by the id column
 * @method     ChildAddress[]|Collection findByCountry(string|array<string> $country) Return ChildAddress objects filtered by the country column
 * @psalm-method Collection&\Traversable<ChildAddress> findByCountry(string|array<string> $country) Return ChildAddress objects filtered by the country column
 * @method     ChildAddress[]|Collection findByState(string|array<string> $state) Return ChildAddress objects filtered by the state column
 * @psalm-method Collection&\Traversable<ChildAddress> findByState(string|array<string> $state) Return ChildAddress objects filtered by the state column
 * @method     ChildAddress[]|Collection findByCity(string|array<string> $city) Return ChildAddress objects filtered by the city column
 * @psalm-method Collection&\Traversable<ChildAddress> findByCity(string|array<string> $city) Return ChildAddress objects filtered by the city column
 * @method     ChildAddress[]|Collection findByNeighborhood(string|array<string> $neighborhood) Return ChildAddress objects filtered by the neighborhood column
 * @psalm-method Collection&\Traversable<ChildAddress> findByNeighborhood(string|array<string> $neighborhood) Return ChildAddress objects filtered by the neighborhood column
 * @method     ChildAddress[]|Collection findByStreet(string|array<string> $street) Return ChildAddress objects filtered by the street column
 * @psalm-method Collection&\Traversable<ChildAddress> findByStreet(string|array<string> $street) Return ChildAddress objects filtered by the street column
 * @method     ChildAddress[]|Collection findByNumber(int|array<int> $number) Return ChildAddress objects filtered by the number column
 * @psalm-method Collection&\Traversable<ChildAddress> findByNumber(int|array<int> $number) Return ChildAddress objects filtered by the number column
 *
 * @method     ChildAddress[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAddress> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class AddressQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\AddressQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Address', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAddressQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAddressQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAddressQuery) {
            return $criteria;
        }
        $query = new ChildAddressQuery();
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
     * @return ChildAddress|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AddressTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AddressTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAddress A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, country, state, city, neighborhood, street, number FROM address WHERE id = :p0';
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
            /** @var ChildAddress $obj */
            $obj = new ChildAddress();
            $obj->hydrate($row);
            AddressTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAddress|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(AddressTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(AddressTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(AddressTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%', Criteria::LIKE); // WHERE country LIKE '%fooValue%'
     * $query->filterByCountry(['foo', 'bar']); // WHERE country IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $country The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCountry($country = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_COUNTRY, $country, $comparison);

        return $this;
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE state LIKE '%fooValue%'
     * $query->filterByState(['foo', 'bar']); // WHERE state IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $state The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByState($state = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_STATE, $state, $comparison);

        return $this;
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE city LIKE '%fooValue%'
     * $query->filterByCity(['foo', 'bar']); // WHERE city IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $city The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCity($city = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_CITY, $city, $comparison);

        return $this;
    }

    /**
     * Filter the query on the neighborhood column
     *
     * Example usage:
     * <code>
     * $query->filterByNeighborhood('fooValue');   // WHERE neighborhood = 'fooValue'
     * $query->filterByNeighborhood('%fooValue%', Criteria::LIKE); // WHERE neighborhood LIKE '%fooValue%'
     * $query->filterByNeighborhood(['foo', 'bar']); // WHERE neighborhood IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $neighborhood The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByNeighborhood($neighborhood = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($neighborhood)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_NEIGHBORHOOD, $neighborhood, $comparison);

        return $this;
    }

    /**
     * Filter the query on the street column
     *
     * Example usage:
     * <code>
     * $query->filterByStreet('fooValue');   // WHERE street = 'fooValue'
     * $query->filterByStreet('%fooValue%', Criteria::LIKE); // WHERE street LIKE '%fooValue%'
     * $query->filterByStreet(['foo', 'bar']); // WHERE street IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $street The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStreet($street = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($street)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_STREET, $street, $comparison);

        return $this;
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber(1234); // WHERE number = 1234
     * $query->filterByNumber(array(12, 34)); // WHERE number IN (12, 34)
     * $query->filterByNumber(array('min' => 12)); // WHERE number > 12
     * </code>
     *
     * @param mixed $number The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByNumber($number = null, ?string $comparison = null)
    {
        if (is_array($number)) {
            $useMinMax = false;
            if (isset($number['min'])) {
                $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($number['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\AddressOwner object
     *
     * @param \Buildings\AddressOwner|ObjectCollection $addressOwner the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAddressOwnerAddress($addressOwner, ?string $comparison = null)
    {
        if ($addressOwner instanceof \Buildings\AddressOwner) {
            $this
                ->addUsingAlias(AddressTableMap::COL_ID, $addressOwner->getIdAddress(), $comparison);

            return $this;
        } elseif ($addressOwner instanceof ObjectCollection) {
            $this
                ->useAddressOwnerAddressQuery()
                ->filterByPrimaryKeys($addressOwner->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerAddress() only accepts arguments of type \Buildings\AddressOwner or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerAddress relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerAddress(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerAddress');

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
            $this->addJoinObject($join, 'AddressOwnerAddress');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerAddress relation AddressOwner object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\AddressOwnerQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerAddressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAddressOwnerAddress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerAddress', '\Buildings\AddressOwnerQuery');
    }

    /**
     * Use the AddressOwnerAddress relation AddressOwner object
     *
     * @param callable(\Buildings\AddressOwnerQuery):\Buildings\AddressOwnerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerAddressQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerAddressQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerAddress relation to the AddressOwner table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerAddressExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerAddress', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerAddress relation to the AddressOwner table for a NOT EXISTS query.
     *
     * @see useAddressOwnerAddressExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerAddressNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useExistsQuery('AddressOwnerAddress', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerAddress relation to the AddressOwner table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerAddressQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerAddress', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerAddress relation to the AddressOwner table for a NOT IN query.
     *
     * @see useAddressOwnerAddressInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressOwnerQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerAddressQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressOwnerQuery */
        $q = $this->useInQuery('AddressOwnerAddress', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAddress $address Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($address = null)
    {
        if ($address) {
            $this->addUsingAlias(AddressTableMap::COL_ID, $address->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AddressTableMap::clearInstancePool();
            AddressTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AddressTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AddressTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AddressTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
