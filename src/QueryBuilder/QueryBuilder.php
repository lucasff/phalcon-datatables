<?php

namespace LukeShard\DataTables\QueryBuilder;

use Phalcon\Mvc\Model\Query;

/**
 * Class QueryBuilder
 * @package LukeShard\DataTables\QueryBuilder
 */
abstract class QueryBuilder implements QueryBuilderInterface
{

    /**
     * @var \Doctrine\DBAL\Query\QueryBuilder|\Phalcon\Mvc\Model\Query\Builder
     */
    protected $queryBuilder;

	/**
     * Returns the concrete QueryBuilder implementation provided by the user
	 * @return \Doctrine\DBAL\Query\QueryBuilder|\Phalcon\Mvc\Model\Query\Builder
	 */
	public function getQueryBuilder()
	{
		return $this->queryBuilder;
	}

	/**
     * Sets the concrete QueryBuilder implementation provided by the user.
     * @throws \Exception Checks if the incoming QueryBuilder is supported.
	 * @param \Doctrine\DBAL\Query\QueryBuilder|\Phalcon\Mvc\Model\Query\Builder $queryBuilder
	 */
	public function setQueryBuilder($queryBuilder)
	{
        if ($queryBuilder instanceof \Doctrine\DBAL\Query\QueryBuilder ||
            $queryBuilder instanceof Query ||
            $queryBuilder instanceof Query\Builder
        ) {
            $this->queryBuilder = $queryBuilder;
        } else {
            throw new \Exception('Unsupported QueryBuilder');
        }
	}


}
