<?php

namespace LukeShard\DataTables\QueryBuilder;

/**
 * Interface QueryBuilderInterface
 * @package DataTables\QueryBuilder
 */
interface QueryBuilderInterface
{

	public function setColumns($columns);

	/**
	 * Adds an AND condition to the top-level WHERE condition.
	 *
	 * @param $where
	 * @return QueryBuilderInterface
	 */
	public function andWhere($where): QueryBuilderInterface;

	/**
	 * Adds an OR condition to the top-level WHERE condition.
	 *
	 * @param $where
	 * @return QueryBuilderInterface
	 */
	public function orWhere($where): QueryBuilderInterface;

	/**
	 * Count the returned rows. Useful for getting the value for `resultsFiltered`
	 * @return int
	 */
	public function count(): int;

	/**
	 * Sets a value to a named parameter on the prepared statement.
	 *
	 * @param $name
	 * @param $value
	 * @return QueryBuilderInterface
	 */
	public function setParameter($name, $value): QueryBuilderInterface;

	/**
	 * Sets multiple parameter values on the prepared statement.
	 *
	 * @param $params
	 * @return QueryBuilderInterface
	 */
	public function setParameters($params): QueryBuilderInterface;

	/**
	 * Sets the ordering column and direction
	 *
	 * @param $column
	 * @param $dir string 'ASC'|'DESC'
	 * @return QueryBuilderInterface
	 */
	public function orderBy($column, $dir): QueryBuilderInterface;

	/**
	 * @param $column
	 * @return QueryBuilderInterface
	 */
	public function groupBy($column) : QueryBuilderInterface;

	/**
	 * @return string
	 */
	public function toSQL(): string;

	/**
	 * @param int $limit
	 * @return QueryBuilderInterface
	 */
	public function limit(int $limit): QueryBuilderInterface;

	/**
	 * @param int $offset
	 * @return QueryBuilderInterface
	 */
	public function offset(int $offset): QueryBuilderInterface;


}
