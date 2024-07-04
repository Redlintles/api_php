<?php

namespace Buildings\Base;

use \Exception;
use \PDO;
use Buildings\Message as ChildMessage;
use Buildings\MessageQuery as ChildMessageQuery;
use Buildings\Map\MessageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `message` table.
 *
 * @method     ChildMessageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMessageQuery orderByMsg($order = Criteria::ASC) Order by the msg column
 *
 * @method     ChildMessageQuery groupById() Group by the id column
 * @method     ChildMessageQuery groupByMsg() Group by the msg column
 *
 * @method     ChildMessageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMessageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMessageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMessageQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMessageQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMessageQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMessage|null findOne(?ConnectionInterface $con = null) Return the first ChildMessage matching the query
 * @method     ChildMessage findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildMessage matching the query, or a new ChildMessage object populated from the query conditions when no match is found
 *
 * @method     ChildMessage|null findOneById(int $id) Return the first ChildMessage filtered by the id column
 * @method     ChildMessage|null findOneByMsg(string $msg) Return the first ChildMessage filtered by the msg column
 *
 * @method     ChildMessage requirePk($key, ?ConnectionInterface $con = null) Return the ChildMessage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOne(?ConnectionInterface $con = null) Return the first ChildMessage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessage requireOneById(int $id) Return the first ChildMessage filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByMsg(string $msg) Return the first ChildMessage filtered by the msg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessage[]|Collection find(?ConnectionInterface $con = null) Return ChildMessage objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildMessage> find(?ConnectionInterface $con = null) Return ChildMessage objects based on current ModelCriteria
 *
 * @method     ChildMessage[]|Collection findById(int|array<int> $id) Return ChildMessage objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildMessage> findById(int|array<int> $id) Return ChildMessage objects filtered by the id column
 * @method     ChildMessage[]|Collection findByMsg(string|array<string> $msg) Return ChildMessage objects filtered by the msg column
 * @psalm-method Collection&\Traversable<ChildMessage> findByMsg(string|array<string> $msg) Return ChildMessage objects filtered by the msg column
 *
 * @method     ChildMessage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildMessage> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class MessageQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Buildings\Base\MessageQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Buildings\\Message', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMessageQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMessageQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildMessageQuery) {
            return $criteria;
        }
        $query = new ChildMessageQuery();
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
     * @return ChildMessage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MessageTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MessageTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMessage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, msg FROM message WHERE id = :p0';
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
            /** @var ChildMessage $obj */
            $obj = new ChildMessage();
            $obj->hydrate($row);
            MessageTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMessage|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(MessageTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(MessageTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(MessageTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MessageTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MessageTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the msg column
     *
     * Example usage:
     * <code>
     * $query->filterByMsg('fooValue');   // WHERE msg = 'fooValue'
     * $query->filterByMsg('%fooValue%', Criteria::LIKE); // WHERE msg LIKE '%fooValue%'
     * $query->filterByMsg(['foo', 'bar']); // WHERE msg IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $msg The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMsg($msg = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($msg)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MessageTableMap::COL_MSG, $msg, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildMessage $message Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($message = null)
    {
        if ($message) {
            $this->addUsingAlias(MessageTableMap::COL_ID, $message->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the message table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MessageTableMap::clearInstancePool();
            MessageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MessageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MessageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MessageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
