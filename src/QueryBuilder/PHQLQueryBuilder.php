<?php

namespace LukeShard\DataTables\QueryBuilder;

use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\QueryBuilder as PQueryBuilder;

class PHQLQueryBuilder extends QueryBuilder
{

	/** @var \Phalcon\Mvc\Model\Query\Builder */
	private $queryBuilder;

	private $parameters = [];

    /**
     * @inheritdoc
     */
	public function setQueryBuilder($queryBuilder)
    {
        if ($queryBuilder instanceof Query ||
            $queryBuilder instanceof Query\Builder
        ) {
            $builder = new PQueryBuilder([
                'builder' => $queryBuilder,
                'limit' => 1,
                'page' => 1,
            ]);
            $this->queryBuilder = $builder;
        } else {
            throw new \Exception('Unsupported QueryBuilder');
        }
    }

    /**
     * @inheritdoc
     */
    public function getColumns()
	{
		return $this->queryBuilder->getColumns();
	}

	/**
	 * @inheritdoc
	 */
	public function andWhere($where): QueryBuilderInterface
	{
		// TODO PARAMS
		$this->queryBuilder->andWhere($where);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function orWhere($where): QueryBuilderInterface
	{
		// TODO PARAMS
		$this->queryBuilder->orWhere($where);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function count(): int
	{
		return $this->queryBuilder->columns('count(*)')->getQuery()->execute();
	}

	/**
	 * @inheritdoc
	 */
	public function setParameter($name, $value): QueryBuilderInterface
	{
		$this->parameters[$name] = $value;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setParameters($params): QueryBuilderInterface
	{
		$this->parameters = array_merge($this->parameters, $params);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function orderBy($column, $dir): QueryBuilderInterface
	{
		$this->queryBuilder->orderBy($column . ' ' . $dir);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function groupBy($column): QueryBuilderInterface
	{
		$this->queryBuilder->groupBy($column);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function toSQL(): string
	{
		$phql = $this->queryBuilder->getPhql();
		$query = new Query($phql);
		return implode('', $query->getSql());
	}

	/**
	 * @inheritdoc
	 */
	public function limit(int $limit): QueryBuilderInterface
	{
		$this->queryBuilder->limit($limit);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function offset(int $offset): QueryBuilderInterface
	{
		$this->queryBuilder->offset($offset);
		return $this;
	}


}
