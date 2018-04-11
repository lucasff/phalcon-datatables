<?php
/**
 * @author Lucas Freitas <lucas@lucasfreitas.me>
 * @since 12.03.18 12:18
 */

namespace LukeShard\DataTables\Request;

use Adbar\Dot;

class Columns implements \Countable, \ArrayAccess
{

	protected $requestKey = 'columns';
	protected $type = 'array';

	protected $params;

	public function __construct(array $params)
	{


		foreach ($params as $column) {
			$this->params[] = new Column($column);
		}

		$dot = new Dot($params);
		$this->params = $dot;
	}

	public function count() {
		$this->params->count();
	}

	/**
	 * @author Lucas Freitas <lucas@lucasfreitas.me>
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return $this->params->has($offset);
	}

	/**
	 * @author Lucas Freitas <lucas@lucasfreitas.me>
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->params->get($offset);
	}

	/**
	 * @author Lucas Freitas <lucas@lucasfreitas.me>
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		return $this->params->set($offset, $value);
	}

	/**
	 * @author Lucas Freitas <lucas@lucasfreitas.me>
	 * @param mixed $offset
	 */
	public function offsetUnset($offset)
	{
		$this->params->pull($offset);
	}


}
