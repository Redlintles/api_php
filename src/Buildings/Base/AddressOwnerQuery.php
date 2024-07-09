<?php

namespace Buildings\Base;

use \Exception;
use Buildings\AddressOwner as ChildAddressOwner;
use Buildings\AddressOwnerQuery as ChildAddressOwnerQuery;
use Buildings\Map\AddressOwnerTableMap;
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
 * Base class that represents a query for the `address_owner` table.
 *
 * @method     ChildAddressOwnerQuery orderByIdAddress($order = Criteria::ASC) Order by the id_address column
 * @method     ChildAddressOwnerQuery orderByIdClient($order = Criteria::ASC) Order by the id_client column
 * @method     ChildAddressOwnerQuery orderByIdSeller($order = Criteria::ASC) Order by the id_seller column
 * @method     ChildAddressOwnerQuery orderByType($order = Criteria::ASC) Order by the type column
 *
 * @method     ChildAddressOwnerQuery groupByIdAddress() Group by the id_address column
 * @method     ChildAddressOwnerQuery groupByIdClient() Group by the id_client column
 * @method     ChildAddressOwnerQuery groupByIdSeller() Group by the id_seller column
 * @method     ChildAddressOwnerQuery groupByType() Group by the type column
 *
 * @method     ChildAddressOwnerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAddressOwnerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAddressOwnerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAddressOwnerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAddressOwnerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAddressOwnerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAddressOwnerQuery leftJoinAddressOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerId relation
 * @method     ChildAddressOwnerQuery rightJoinAddressOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerId relation
 * @method     ChildAddressOwnerQuery innerJoinAddressOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerId relation
 *
 * @method     ChildAddressOwnerQuery joinWithAddressOwnerId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerId relation
 *
 * @method     ChildAddressOwnerQuery leftJoinWithAddressOwnerId() Adds a LEFT JOIN clause and with to the query using the AddressOwnerId relation
 * @method     ChildAddressOwnerQuery rightJoinWithAddressOwnerId() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerId relation
 * @method     ChildAddressOwnerQuery innerJoinWithAddressOwnerId() Adds a INNER JOIN clause and with to the query using the AddressOwnerId relation
 *
 * @method     ChildAddressOwnerQuery leftJoinAddressOwnerIdClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerIdClient relation
 * @method     ChildAddressOwnerQuery rightJoinAddressOwnerIdClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerIdClient relation
 * @method     ChildAddressOwnerQuery innerJoinAddressOwnerIdClient($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerIdClient relation
 *
 * @method     ChildAddressOwnerQuery joinWithAddressOwnerIdClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerIdClient relation
 *
 * @method     ChildAddressOwnerQuery leftJoinWithAddressOwnerIdClient() Adds a LEFT JOIN clause and with to the query using the AddressOwnerIdClient relation
 * @method     ChildAddressOwnerQuery rightJoinWithAddressOwnerIdClient() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerIdClient relation
 * @method     ChildAddressOwnerQuery innerJoinWithAddressOwnerIdClient() Adds a INNER JOIN clause and with to the query using the AddressOwnerIdClient relation
 *
 * @method     ChildAddressOwnerQuery leftJoinAddressOwnerIdSeller($relationAlias = null) Adds a LEFT JOIN clause to the query using the AddressOwnerIdSeller relation
 * @method     ChildAddressOwnerQuery rightJoinAddressOwnerIdSeller($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AddressOwnerIdSeller relation
 * @method     ChildAddressOwnerQuery innerJoinAddressOwnerIdSeller($relationAlias = null) Adds a INNER JOIN clause to the query using the AddressOwnerIdSeller relation
 *
 * @method     ChildAddressOwnerQuery joinWithAddressOwnerIdSeller($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AddressOwnerIdSeller relation
 *
 * @method     ChildAddressOwnerQuery leftJoinWithAddressOwnerIdSeller() Adds a LEFT JOIN clause and with to the query using the AddressOwnerIdSeller relation
 * @method     ChildAddressOwnerQuery rightJoinWithAddressOwnerIdSeller() Adds a RIGHT JOIN clause and with to the query using the AddressOwnerIdSeller relation
 * @method     ChildAddressOwnerQuery innerJoinWithAddressOwnerIdSeller() Adds a INNER JOIN clause and with to the query using the AddressOwnerIdSeller relation
 *
 * @method     \Buildings\AddressQuery|\Buildings\ClientQuery|\Buildings\SellerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAddressOwner|null findOne(?ConnectionInterface $con = null) Return the first ChildAddressOwner matching the query
 * @method     ChildAddressOwner findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAddressOwner matching the query, or a new ChildAddressOwner object populated from the query conditions when no match is found
 *
 * @method     ChildAddressOwner|null findOneByIdAddress(int $id_address) Return the first ChildAddressOwner filtered by the id_address column
 * @method     ChildAddressOwner|null findOneByIdClient(int $id_client) Return the first ChildAddressOwner filtered by the id_client column
 * @method     ChildAddressOwner|null findOneByIdSeller(int $id_seller) Return the first ChildAddressOwner filtered by the id_seller column
 * @method     ChildAddressOwner|null findOneByType(string $type) Return the first ChildAddressOwner filtered by the type column
 *
 * @method     ChildAddressOwner requirePk($key, ?ConnectionInterface $con = null) Return the ChildAddressOwner by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddressOwner requireOne(?ConnectionInterface $con = null) Return the first ChildAddressOwner matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddressOwner requireOneByIdAddress(int $id_address) Return the first ChildAddressOwner filtered by the id_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddressOwner requireOneByIdClient(int $id_client) Return the first ChildAddressOwner filtered by the id_client column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddressOwner requireOneByIdSeller(int $id_seller) Return the first ChildAddressOwner filtered by the id_seller column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddressOwner requireOneByType(string $type) Return the first ChildAddressOwner filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddressOwner[]|Collection find(?ConnectionInterface $con = null) Return ChildAddressOwner objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAddressOwner> find(?ConnectionInterface $con = null) Return ChildAddressOwner objects based on current ModelCriteria
 *
 * @method     ChildAddressOwner[]|Collection findByIdAddress(int|array<int> $id_address) Return ChildAddressOwner objects filtered by the id_address column
 * @psalm-method Collection&\Traversable<ChildAddressOwner> findByIdAddress(int|array<int> $id_address) Return ChildAddressOwner objects filtered by the id_address column
 * @method     ChildAddressOwner[]|Collection findByIdClient(int|array<int> $id_client) Return ChildAddressOwner objects filtered by the id_client column
 * @psalm-method Collection&\Traversable<ChildAddressOwner> findByIdClient(int|array<int> $id_client) Return ChildAddressOwner objects filtered by the id_client column
 * @method     ChildAddressOwner[]|Collection findByIdSeller(int|array<int> $id_seller) Return ChildAddressOwner objects filtered by the id_seller column
 * @psalm-method Collection&\Traversable<ChildAddressOwner> findByIdSeller(int|array<int> $id_seller) Return ChildAddressOwner objects filtered by the id_seller column
 * @method     ChildAddressOwner[]|Collection findByType(string|array<string> $type) Return ChildAddressOwner objects filtered by the type column
 * @psalm-method Collection&\Traversable<ChildAddressOwner> findByType(string|array<string> $type) Return ChildAddressOwner objects filtered by the type column
 *
 * @method     ChildAddressOwner[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAddressOwner> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class AddressOwnerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\AddressOwnerQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\AddressOwner', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAddressOwnerQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAddressOwnerQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAddressOwnerQuery) {
            return $criteria;
        }
        $query = new ChildAddressOwnerQuery();
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
     * @return ChildAddressOwner|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The AddressOwner object has no primary key');
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
        throw new LogicException('The AddressOwner object has no primary key');
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
        throw new LogicException('The AddressOwner object has no primary key');
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
        throw new LogicException('The AddressOwner object has no primary key');
    }

    /**
     * Filter the query on the id_address column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAddress(1234); // WHERE id_address = 1234
     * $query->filterByIdAddress(array(12, 34)); // WHERE id_address IN (12, 34)
     * $query->filterByIdAddress(array('min' => 12)); // WHERE id_address > 12
     * </code>
     *
     * @see       filterByAddressOwnerId()
     *
     * @param mixed $idAddress The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIdAddress($idAddress = null, ?string $comparison = null)
    {
        if (is_array($idAddress)) {
            $useMinMax = false;
            if (isset($idAddress['min'])) {
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_ADDRESS, $idAddress['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAddress['max'])) {
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_ADDRESS, $idAddress['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressOwnerTableMap::COL_ID_ADDRESS, $idAddress, $comparison);

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
     * @see       filterByAddressOwnerIdClient()
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
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_CLIENT, $idClient['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idClient['max'])) {
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_CLIENT, $idClient['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressOwnerTableMap::COL_ID_CLIENT, $idClient, $comparison);

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
     * @see       filterByAddressOwnerIdSeller()
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
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_SELLER, $idSeller['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSeller['max'])) {
                $this->addUsingAlias(AddressOwnerTableMap::COL_ID_SELLER, $idSeller['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AddressOwnerTableMap::COL_ID_SELLER, $idSeller, $comparison);

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

        $this->addUsingAlias(AddressOwnerTableMap::COL_TYPE, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Address object
     *
     * @param \Buildings\Address|ObjectCollection $address The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAddressOwnerId($address, ?string $comparison = null)
    {
        if ($address instanceof \Buildings\Address) {
            return $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_ADDRESS, $address->getId(), $comparison);
        } elseif ($address instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_ADDRESS, $address->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerId() only accepts arguments of type \Buildings\Address or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerId(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerId');

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
            $this->addJoinObject($join, 'AddressOwnerId');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerId relation Address object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\AddressQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAddressOwnerId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerId', '\Buildings\AddressQuery');
    }

    /**
     * Use the AddressOwnerId relation Address object
     *
     * @param callable(\Buildings\AddressQuery):\Buildings\AddressQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerId relation to the Address table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\AddressQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\AddressQuery */
        $q = $this->useExistsQuery('AddressOwnerId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerId relation to the Address table for a NOT EXISTS query.
     *
     * @see useAddressOwnerIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressQuery */
        $q = $this->useExistsQuery('AddressOwnerId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerId relation to the Address table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\AddressQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\AddressQuery */
        $q = $this->useInQuery('AddressOwnerId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerId relation to the Address table for a NOT IN query.
     *
     * @see useAddressOwnerIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AddressQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AddressQuery */
        $q = $this->useInQuery('AddressOwnerId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
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
    public function filterByAddressOwnerIdClient($client, ?string $comparison = null)
    {
        if ($client instanceof \Buildings\Client) {
            return $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_CLIENT, $client->getId(), $comparison);
        } elseif ($client instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_CLIENT, $client->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerIdClient() only accepts arguments of type \Buildings\Client or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerIdClient relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerIdClient(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerIdClient');

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
            $this->addJoinObject($join, 'AddressOwnerIdClient');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerIdClient relation Client object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\ClientQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerIdClientQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAddressOwnerIdClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerIdClient', '\Buildings\ClientQuery');
    }

    /**
     * Use the AddressOwnerIdClient relation Client object
     *
     * @param callable(\Buildings\ClientQuery):\Buildings\ClientQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerIdClientQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerIdClientQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerIdClient relation to the Client table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\ClientQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerIdClientExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useExistsQuery('AddressOwnerIdClient', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerIdClient relation to the Client table for a NOT EXISTS query.
     *
     * @see useAddressOwnerIdClientExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ClientQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerIdClientNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useExistsQuery('AddressOwnerIdClient', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerIdClient relation to the Client table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\ClientQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerIdClientQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useInQuery('AddressOwnerIdClient', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerIdClient relation to the Client table for a NOT IN query.
     *
     * @see useAddressOwnerIdClientInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\ClientQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerIdClientQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\ClientQuery */
        $q = $this->useInQuery('AddressOwnerIdClient', $modelAlias, $queryClass, 'NOT IN');
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
    public function filterByAddressOwnerIdSeller($seller, ?string $comparison = null)
    {
        if ($seller instanceof \Buildings\Seller) {
            return $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_SELLER, $seller->getId(), $comparison);
        } elseif ($seller instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(AddressOwnerTableMap::COL_ID_SELLER, $seller->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByAddressOwnerIdSeller() only accepts arguments of type \Buildings\Seller or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AddressOwnerIdSeller relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAddressOwnerIdSeller(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AddressOwnerIdSeller');

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
            $this->addJoinObject($join, 'AddressOwnerIdSeller');
        }

        return $this;
    }

    /**
     * Use the AddressOwnerIdSeller relation Seller object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\SellerQuery A secondary query class using the current class as primary query
     */
    public function useAddressOwnerIdSellerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAddressOwnerIdSeller($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AddressOwnerIdSeller', '\Buildings\SellerQuery');
    }

    /**
     * Use the AddressOwnerIdSeller relation Seller object
     *
     * @param callable(\Buildings\SellerQuery):\Buildings\SellerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAddressOwnerIdSellerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useAddressOwnerIdSellerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the AddressOwnerIdSeller relation to the Seller table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\SellerQuery The inner query object of the EXISTS statement
     */
    public function useAddressOwnerIdSellerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('AddressOwnerIdSeller', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the AddressOwnerIdSeller relation to the Seller table for a NOT EXISTS query.
     *
     * @see useAddressOwnerIdSellerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT EXISTS statement
     */
    public function useAddressOwnerIdSellerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useExistsQuery('AddressOwnerIdSeller', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the AddressOwnerIdSeller relation to the Seller table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\SellerQuery The inner query object of the IN statement
     */
    public function useInAddressOwnerIdSellerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('AddressOwnerIdSeller', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the AddressOwnerIdSeller relation to the Seller table for a NOT IN query.
     *
     * @see useAddressOwnerIdSellerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\SellerQuery The inner query object of the NOT IN statement
     */
    public function useNotInAddressOwnerIdSellerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\SellerQuery */
        $q = $this->useInQuery('AddressOwnerIdSeller', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAddressOwner $addressOwner Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($addressOwner = null)
    {
        if ($addressOwner) {
            throw new LogicException('AddressOwner object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the address_owner table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressOwnerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AddressOwnerTableMap::clearInstancePool();
            AddressOwnerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AddressOwnerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AddressOwnerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AddressOwnerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AddressOwnerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
