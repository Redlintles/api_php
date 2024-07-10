<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Audit as ChildAudit;
use Buildings\AuditQuery as ChildAuditQuery;
use Buildings\Map\AuditTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `audit` table.
 *
 * @method     ChildAuditQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAuditQuery orderByOperationExecutor($order = Criteria::ASC) Order by the operation_executor column
 * @method     ChildAuditQuery orderByOperationType($order = Criteria::ASC) Order by the operation_type column
 * @method     ChildAuditQuery orderByOperationRoute($order = Criteria::ASC) Order by the operation_route column
 * @method     ChildAuditQuery orderByOperationDataString($order = Criteria::ASC) Order by the operation_data_string column
 * @method     ChildAuditQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAuditQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAuditQuery groupById() Group by the id column
 * @method     ChildAuditQuery groupByOperationExecutor() Group by the operation_executor column
 * @method     ChildAuditQuery groupByOperationType() Group by the operation_type column
 * @method     ChildAuditQuery groupByOperationRoute() Group by the operation_route column
 * @method     ChildAuditQuery groupByOperationDataString() Group by the operation_data_string column
 * @method     ChildAuditQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAuditQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAuditQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuditQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuditQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuditQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuditQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuditQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAudit|null findOne(?ConnectionInterface $con = null) Return the first ChildAudit matching the query
 * @method     ChildAudit findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAudit matching the query, or a new ChildAudit object populated from the query conditions when no match is found
 *
 * @method     ChildAudit|null findOneById(int $id) Return the first ChildAudit filtered by the id column
 * @method     ChildAudit|null findOneByOperationExecutor(string $operation_executor) Return the first ChildAudit filtered by the operation_executor column
 * @method     ChildAudit|null findOneByOperationType(string $operation_type) Return the first ChildAudit filtered by the operation_type column
 * @method     ChildAudit|null findOneByOperationRoute(string $operation_route) Return the first ChildAudit filtered by the operation_route column
 * @method     ChildAudit|null findOneByOperationDataString(string $operation_data_string) Return the first ChildAudit filtered by the operation_data_string column
 * @method     ChildAudit|null findOneByCreatedAt(string $created_at) Return the first ChildAudit filtered by the created_at column
 * @method     ChildAudit|null findOneByUpdatedAt(string $updated_at) Return the first ChildAudit filtered by the updated_at column
 *
 * @method     ChildAudit requirePk($key, ?ConnectionInterface $con = null) Return the ChildAudit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOne(?ConnectionInterface $con = null) Return the first ChildAudit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAudit requireOneById(int $id) Return the first ChildAudit filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByOperationExecutor(string $operation_executor) Return the first ChildAudit filtered by the operation_executor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByOperationType(string $operation_type) Return the first ChildAudit filtered by the operation_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByOperationRoute(string $operation_route) Return the first ChildAudit filtered by the operation_route column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByOperationDataString(string $operation_data_string) Return the first ChildAudit filtered by the operation_data_string column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByCreatedAt(string $created_at) Return the first ChildAudit filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAudit requireOneByUpdatedAt(string $updated_at) Return the first ChildAudit filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAudit[]|Collection find(?ConnectionInterface $con = null) Return ChildAudit objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAudit> find(?ConnectionInterface $con = null) Return ChildAudit objects based on current ModelCriteria
 *
 * @method     ChildAudit[]|Collection findById(int|array<int> $id) Return ChildAudit objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildAudit> findById(int|array<int> $id) Return ChildAudit objects filtered by the id column
 * @method     ChildAudit[]|Collection findByOperationExecutor(string|array<string> $operation_executor) Return ChildAudit objects filtered by the operation_executor column
 * @psalm-method Collection&\Traversable<ChildAudit> findByOperationExecutor(string|array<string> $operation_executor) Return ChildAudit objects filtered by the operation_executor column
 * @method     ChildAudit[]|Collection findByOperationType(string|array<string> $operation_type) Return ChildAudit objects filtered by the operation_type column
 * @psalm-method Collection&\Traversable<ChildAudit> findByOperationType(string|array<string> $operation_type) Return ChildAudit objects filtered by the operation_type column
 * @method     ChildAudit[]|Collection findByOperationRoute(string|array<string> $operation_route) Return ChildAudit objects filtered by the operation_route column
 * @psalm-method Collection&\Traversable<ChildAudit> findByOperationRoute(string|array<string> $operation_route) Return ChildAudit objects filtered by the operation_route column
 * @method     ChildAudit[]|Collection findByOperationDataString(string|array<string> $operation_data_string) Return ChildAudit objects filtered by the operation_data_string column
 * @psalm-method Collection&\Traversable<ChildAudit> findByOperationDataString(string|array<string> $operation_data_string) Return ChildAudit objects filtered by the operation_data_string column
 * @method     ChildAudit[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildAudit objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildAudit> findByCreatedAt(string|array<string> $created_at) Return ChildAudit objects filtered by the created_at column
 * @method     ChildAudit[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildAudit objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildAudit> findByUpdatedAt(string|array<string> $updated_at) Return ChildAudit objects filtered by the updated_at column
 *
 * @method     ChildAudit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAudit> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class AuditQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\AuditQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Audit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuditQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuditQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAuditQuery) {
            return $criteria;
        }
        $query = new ChildAuditQuery();
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
     * @return ChildAudit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuditTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuditTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAudit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, operation_executor, operation_type, operation_route, operation_data_string, created_at, updated_at FROM audit WHERE id = :p0';
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
            /** @var ChildAudit $obj */
            $obj = new ChildAudit();
            $obj->hydrate($row);
            AuditTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAudit|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(AuditTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(AuditTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(AuditTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AuditTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the operation_executor column
     *
     * Example usage:
     * <code>
     * $query->filterByOperationExecutor('fooValue');   // WHERE operation_executor = 'fooValue'
     * $query->filterByOperationExecutor('%fooValue%', Criteria::LIKE); // WHERE operation_executor LIKE '%fooValue%'
     * $query->filterByOperationExecutor(['foo', 'bar']); // WHERE operation_executor IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $operationExecutor The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOperationExecutor($operationExecutor = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($operationExecutor)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_OPERATION_EXECUTOR, $operationExecutor, $comparison);

        return $this;
    }

    /**
     * Filter the query on the operation_type column
     *
     * Example usage:
     * <code>
     * $query->filterByOperationType('fooValue');   // WHERE operation_type = 'fooValue'
     * $query->filterByOperationType('%fooValue%', Criteria::LIKE); // WHERE operation_type LIKE '%fooValue%'
     * $query->filterByOperationType(['foo', 'bar']); // WHERE operation_type IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $operationType The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOperationType($operationType = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($operationType)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_OPERATION_TYPE, $operationType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the operation_route column
     *
     * Example usage:
     * <code>
     * $query->filterByOperationRoute('fooValue');   // WHERE operation_route = 'fooValue'
     * $query->filterByOperationRoute('%fooValue%', Criteria::LIKE); // WHERE operation_route LIKE '%fooValue%'
     * $query->filterByOperationRoute(['foo', 'bar']); // WHERE operation_route IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $operationRoute The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOperationRoute($operationRoute = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($operationRoute)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_OPERATION_ROUTE, $operationRoute, $comparison);

        return $this;
    }

    /**
     * Filter the query on the operation_data_string column
     *
     * Example usage:
     * <code>
     * $query->filterByOperationDataString('fooValue');   // WHERE operation_data_string = 'fooValue'
     * $query->filterByOperationDataString('%fooValue%', Criteria::LIKE); // WHERE operation_data_string LIKE '%fooValue%'
     * $query->filterByOperationDataString(['foo', 'bar']); // WHERE operation_data_string IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $operationDataString The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOperationDataString($operationDataString = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($operationDataString)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_OPERATION_DATA_STRING, $operationDataString, $comparison);

        return $this;
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, ?string $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AuditTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AuditTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_CREATED_AT, $createdAt, $comparison);

        return $this;
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, ?string $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AuditTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AuditTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuditTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAudit $audit Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($audit = null)
    {
        if ($audit) {
            $this->addUsingAlias(AuditTableMap::COL_ID, $audit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the audit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuditTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuditTableMap::clearInstancePool();
            AuditTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuditTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuditTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuditTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuditTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        $this->addUsingAlias(AuditTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(AuditTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(AuditTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(AuditTableMap::COL_CREATED_AT);

        return $this;
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        $this->addUsingAlias(AuditTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(AuditTableMap::COL_CREATED_AT);

        return $this;
    }

}
