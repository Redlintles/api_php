<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Permission as ChildPermission;
use Buildings\PermissionQuery as ChildPermissionQuery;
use Buildings\Map\PermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `permission` table.
 *
 * @method     ChildPermissionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPermissionQuery orderByAdminId($order = Criteria::ASC) Order by the admin_id column
 * @method     ChildPermissionQuery orderByCreatePermission($order = Criteria::ASC) Order by the create_permission column
 * @method     ChildPermissionQuery orderByReadPermission($order = Criteria::ASC) Order by the read_permission column
 * @method     ChildPermissionQuery orderByUpdatePermission($order = Criteria::ASC) Order by the update_permission column
 * @method     ChildPermissionQuery orderByDeletePermission($order = Criteria::ASC) Order by the delete_permission column
 *
 * @method     ChildPermissionQuery groupById() Group by the id column
 * @method     ChildPermissionQuery groupByAdminId() Group by the admin_id column
 * @method     ChildPermissionQuery groupByCreatePermission() Group by the create_permission column
 * @method     ChildPermissionQuery groupByReadPermission() Group by the read_permission column
 * @method     ChildPermissionQuery groupByUpdatePermission() Group by the update_permission column
 * @method     ChildPermissionQuery groupByDeletePermission() Group by the delete_permission column
 *
 * @method     ChildPermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPermissionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPermissionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPermissionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPermissionQuery leftJoinPermissionAdminId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PermissionAdminId relation
 * @method     ChildPermissionQuery rightJoinPermissionAdminId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PermissionAdminId relation
 * @method     ChildPermissionQuery innerJoinPermissionAdminId($relationAlias = null) Adds a INNER JOIN clause to the query using the PermissionAdminId relation
 *
 * @method     ChildPermissionQuery joinWithPermissionAdminId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PermissionAdminId relation
 *
 * @method     ChildPermissionQuery leftJoinWithPermissionAdminId() Adds a LEFT JOIN clause and with to the query using the PermissionAdminId relation
 * @method     ChildPermissionQuery rightJoinWithPermissionAdminId() Adds a RIGHT JOIN clause and with to the query using the PermissionAdminId relation
 * @method     ChildPermissionQuery innerJoinWithPermissionAdminId() Adds a INNER JOIN clause and with to the query using the PermissionAdminId relation
 *
 * @method     \Buildings\AdminQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPermission|null findOne(?ConnectionInterface $con = null) Return the first ChildPermission matching the query
 * @method     ChildPermission findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildPermission matching the query, or a new ChildPermission object populated from the query conditions when no match is found
 *
 * @method     ChildPermission|null findOneById(int $id) Return the first ChildPermission filtered by the id column
 * @method     ChildPermission|null findOneByAdminId(int $admin_id) Return the first ChildPermission filtered by the admin_id column
 * @method     ChildPermission|null findOneByCreatePermission(int $create_permission) Return the first ChildPermission filtered by the create_permission column
 * @method     ChildPermission|null findOneByReadPermission(int $read_permission) Return the first ChildPermission filtered by the read_permission column
 * @method     ChildPermission|null findOneByUpdatePermission(int $update_permission) Return the first ChildPermission filtered by the update_permission column
 * @method     ChildPermission|null findOneByDeletePermission(int $delete_permission) Return the first ChildPermission filtered by the delete_permission column
 *
 * @method     ChildPermission requirePk($key, ?ConnectionInterface $con = null) Return the ChildPermission by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOne(?ConnectionInterface $con = null) Return the first ChildPermission matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPermission requireOneById(int $id) Return the first ChildPermission filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByAdminId(int $admin_id) Return the first ChildPermission filtered by the admin_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByCreatePermission(int $create_permission) Return the first ChildPermission filtered by the create_permission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByReadPermission(int $read_permission) Return the first ChildPermission filtered by the read_permission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByUpdatePermission(int $update_permission) Return the first ChildPermission filtered by the update_permission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPermission requireOneByDeletePermission(int $delete_permission) Return the first ChildPermission filtered by the delete_permission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPermission[]|Collection find(?ConnectionInterface $con = null) Return ChildPermission objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildPermission> find(?ConnectionInterface $con = null) Return ChildPermission objects based on current ModelCriteria
 *
 * @method     ChildPermission[]|Collection findById(int|array<int> $id) Return ChildPermission objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildPermission> findById(int|array<int> $id) Return ChildPermission objects filtered by the id column
 * @method     ChildPermission[]|Collection findByAdminId(int|array<int> $admin_id) Return ChildPermission objects filtered by the admin_id column
 * @psalm-method Collection&\Traversable<ChildPermission> findByAdminId(int|array<int> $admin_id) Return ChildPermission objects filtered by the admin_id column
 * @method     ChildPermission[]|Collection findByCreatePermission(int|array<int> $create_permission) Return ChildPermission objects filtered by the create_permission column
 * @psalm-method Collection&\Traversable<ChildPermission> findByCreatePermission(int|array<int> $create_permission) Return ChildPermission objects filtered by the create_permission column
 * @method     ChildPermission[]|Collection findByReadPermission(int|array<int> $read_permission) Return ChildPermission objects filtered by the read_permission column
 * @psalm-method Collection&\Traversable<ChildPermission> findByReadPermission(int|array<int> $read_permission) Return ChildPermission objects filtered by the read_permission column
 * @method     ChildPermission[]|Collection findByUpdatePermission(int|array<int> $update_permission) Return ChildPermission objects filtered by the update_permission column
 * @psalm-method Collection&\Traversable<ChildPermission> findByUpdatePermission(int|array<int> $update_permission) Return ChildPermission objects filtered by the update_permission column
 * @method     ChildPermission[]|Collection findByDeletePermission(int|array<int> $delete_permission) Return ChildPermission objects filtered by the delete_permission column
 * @psalm-method Collection&\Traversable<ChildPermission> findByDeletePermission(int|array<int> $delete_permission) Return ChildPermission objects filtered by the delete_permission column
 *
 * @method     ChildPermission[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildPermission> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class PermissionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\PermissionQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Permission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPermissionQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPermissionQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPermissionQuery) {
            return $criteria;
        }
        $query = new ChildPermissionQuery();
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PermissionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PermissionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, admin_id, create_permission, read_permission, update_permission, delete_permission FROM permission WHERE id = :p0';
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
            /** @var ChildPermission $obj */
            $obj = new ChildPermission();
            $obj->hydrate($row);
            PermissionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(PermissionTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(PermissionTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(PermissionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the admin_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdminId(1234); // WHERE admin_id = 1234
     * $query->filterByAdminId(array(12, 34)); // WHERE admin_id IN (12, 34)
     * $query->filterByAdminId(array('min' => 12)); // WHERE admin_id > 12
     * </code>
     *
     * @see       filterByPermissionAdminId()
     *
     * @param mixed $adminId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAdminId($adminId = null, ?string $comparison = null)
    {
        if (is_array($adminId)) {
            $useMinMax = false;
            if (isset($adminId['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_ADMIN_ID, $adminId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adminId['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_ADMIN_ID, $adminId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_ADMIN_ID, $adminId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the create_permission column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatePermission(1234); // WHERE create_permission = 1234
     * $query->filterByCreatePermission(array(12, 34)); // WHERE create_permission IN (12, 34)
     * $query->filterByCreatePermission(array('min' => 12)); // WHERE create_permission > 12
     * </code>
     *
     * @param mixed $createPermission The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatePermission($createPermission = null, ?string $comparison = null)
    {
        if (is_array($createPermission)) {
            $useMinMax = false;
            if (isset($createPermission['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_CREATE_PERMISSION, $createPermission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createPermission['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_CREATE_PERMISSION, $createPermission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_CREATE_PERMISSION, $createPermission, $comparison);

        return $this;
    }

    /**
     * Filter the query on the read_permission column
     *
     * Example usage:
     * <code>
     * $query->filterByReadPermission(1234); // WHERE read_permission = 1234
     * $query->filterByReadPermission(array(12, 34)); // WHERE read_permission IN (12, 34)
     * $query->filterByReadPermission(array('min' => 12)); // WHERE read_permission > 12
     * </code>
     *
     * @param mixed $readPermission The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByReadPermission($readPermission = null, ?string $comparison = null)
    {
        if (is_array($readPermission)) {
            $useMinMax = false;
            if (isset($readPermission['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_READ_PERMISSION, $readPermission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($readPermission['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_READ_PERMISSION, $readPermission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_READ_PERMISSION, $readPermission, $comparison);

        return $this;
    }

    /**
     * Filter the query on the update_permission column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatePermission(1234); // WHERE update_permission = 1234
     * $query->filterByUpdatePermission(array(12, 34)); // WHERE update_permission IN (12, 34)
     * $query->filterByUpdatePermission(array('min' => 12)); // WHERE update_permission > 12
     * </code>
     *
     * @param mixed $updatePermission The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUpdatePermission($updatePermission = null, ?string $comparison = null)
    {
        if (is_array($updatePermission)) {
            $useMinMax = false;
            if (isset($updatePermission['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_UPDATE_PERMISSION, $updatePermission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatePermission['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_UPDATE_PERMISSION, $updatePermission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_UPDATE_PERMISSION, $updatePermission, $comparison);

        return $this;
    }

    /**
     * Filter the query on the delete_permission column
     *
     * Example usage:
     * <code>
     * $query->filterByDeletePermission(1234); // WHERE delete_permission = 1234
     * $query->filterByDeletePermission(array(12, 34)); // WHERE delete_permission IN (12, 34)
     * $query->filterByDeletePermission(array('min' => 12)); // WHERE delete_permission > 12
     * </code>
     *
     * @param mixed $deletePermission The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDeletePermission($deletePermission = null, ?string $comparison = null)
    {
        if (is_array($deletePermission)) {
            $useMinMax = false;
            if (isset($deletePermission['min'])) {
                $this->addUsingAlias(PermissionTableMap::COL_DELETE_PERMISSION, $deletePermission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deletePermission['max'])) {
                $this->addUsingAlias(PermissionTableMap::COL_DELETE_PERMISSION, $deletePermission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PermissionTableMap::COL_DELETE_PERMISSION, $deletePermission, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Buildings\Admin object
     *
     * @param \Buildings\Admin|ObjectCollection $admin The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPermissionAdminId($admin, ?string $comparison = null)
    {
        if ($admin instanceof \Buildings\Admin) {
            return $this
                ->addUsingAlias(PermissionTableMap::COL_ADMIN_ID, $admin->getId(), $comparison);
        } elseif ($admin instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(PermissionTableMap::COL_ADMIN_ID, $admin->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPermissionAdminId() only accepts arguments of type \Buildings\Admin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PermissionAdminId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPermissionAdminId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PermissionAdminId');

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
            $this->addJoinObject($join, 'PermissionAdminId');
        }

        return $this;
    }

    /**
     * Use the PermissionAdminId relation Admin object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Buildings\AdminQuery A secondary query class using the current class as primary query
     */
    public function usePermissionAdminIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPermissionAdminId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PermissionAdminId', '\Buildings\AdminQuery');
    }

    /**
     * Use the PermissionAdminId relation Admin object
     *
     * @param callable(\Buildings\AdminQuery):\Buildings\AdminQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPermissionAdminIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePermissionAdminIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PermissionAdminId relation to the Admin table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Buildings\AdminQuery The inner query object of the EXISTS statement
     */
    public function usePermissionAdminIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Buildings\AdminQuery */
        $q = $this->useExistsQuery('PermissionAdminId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the PermissionAdminId relation to the Admin table for a NOT EXISTS query.
     *
     * @see usePermissionAdminIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AdminQuery The inner query object of the NOT EXISTS statement
     */
    public function usePermissionAdminIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AdminQuery */
        $q = $this->useExistsQuery('PermissionAdminId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the PermissionAdminId relation to the Admin table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Buildings\AdminQuery The inner query object of the IN statement
     */
    public function useInPermissionAdminIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Buildings\AdminQuery */
        $q = $this->useInQuery('PermissionAdminId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the PermissionAdminId relation to the Admin table for a NOT IN query.
     *
     * @see usePermissionAdminIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Buildings\AdminQuery The inner query object of the NOT IN statement
     */
    public function useNotInPermissionAdminIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Buildings\AdminQuery */
        $q = $this->useInQuery('PermissionAdminId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildPermission $permission Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($permission = null)
    {
        if ($permission) {
            $this->addUsingAlias(PermissionTableMap::COL_ID, $permission->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PermissionTableMap::clearInstancePool();
            PermissionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PermissionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
