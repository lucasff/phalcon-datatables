<?php
/**
 * @author Lucas Freitas <lucas@lucasfreitas.me>
 * @since 09.03.18 12:17
 */

namespace LukeShard\DataTables\Request;


abstract class AbstractParam implements ParamInterface
{

    /**
     * @var string $requestKey Query parameter key coming on the request.
     */
    protected $requestKey;

    /**
     * @var string $type Type of the request key (will be casted)
     */
    protected $type;

    /**
     * @var array|string
     */
    protected $params;

	public function getRequestKey() {
        return $this->requestKey;
    }

	public function getType() {
        return $this->type;
    }

    public function getContents()
    {
        return $this->params;
    }

    /**
     * Returns a single value inside the column array OR false if doesn't exists
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param $name
     * @return mixed
     */
    public function getValue($name)
    {
        if ($this->isColumn() && array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return null;
    }

    public function isSearchable() : bool
    {
        return $this->isColumn() && $this->hasSearchValue();
    }

    public function isSortable() : bool
    {
        return $this->isColumn() && $this->params['searchable'] == true;
    }

    public function hasSearchValue() : bool
    {
        return $this->isColumn() && $this->params['search'] != '';
    }

    public function isAlias()
    {
        return $this->isColumn() && $this->params['name'] != '';
    }

    public function isColumn()
    {
        return count(array_diff(['data', 'name', 'search', 'orderable', 'searchable'], $this->params)) == 0;
    }


}
