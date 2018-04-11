<?php
/**
 * @author Lucas Freitas <lucas@lucasfreitas.me>
 * @since 12.03.18 17:21
 */

namespace LukeShard\DataTables\Request;


class Column extends AbstractParam
{

	public function __construct(array $params)
	{
		$this->params = $params;
	}

}
