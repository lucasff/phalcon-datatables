<?php

namespace LukeShard\DataTables\QueryBuilder;

/**
 * Class DoctrineDBALQueryBuilder
 * @package LukeShard\DataTables\QueryBuilder
 */
class DoctrineDBALQueryBuilder extends QueryBuilder
{
    /** @var \Doctrine\DBAL\Query\QueryBuilder $queryBuilder */
    protected $queryBuilder;

    /**
     * @inheritdoc
     */
    public function andWhere($where): QueryBuilderInterface
    {
        $this->queryBuilder->andWhere($where);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function orWhere($where): QueryBuilderInterface
    {
        $this->queryBuilder->orWhere($where);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->queryBuilder->select('count(*)')->execute()->fetchColumn();
    }

    /**
     * @inheritdoc
     */
    public function setParameter($name, $value): QueryBuilderInterface
    {
        $this->queryBuilder->setParameter($name, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setParameters($params): QueryBuilderInterface
    {
        $this->queryBuilder->setParameters($params);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function orderBy($column, $dir): QueryBuilderInterface
    {
        $this->queryBuilder->addOrderBy($column, $dir);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function groupBy($column): QueryBuilderInterface
    {
        $this->queryBuilder->addGroupBy($column);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toSQL(): string
    {
        return $this->queryBuilder->getSQL();
    }

    /**
     * @inheritdoc
     */
    public function limit(int $limit): QueryBuilderInterface
    {
        $this->queryBuilder->setMaxResults($limit);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function offset(int $offset): QueryBuilderInterface
    {
        $this->queryBuilder->setFirstResult($offset);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setColumns($columns)
    {
        $this->queryBuilder->select($columns);
    }
}
