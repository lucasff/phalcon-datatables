<?php

namespace LukeShard\DataTables;

use LukeShard\DataTables\Request\AbstractParam;
use LukeShard\DataTables\Request\Columns;
use LukeShard\DataTables\Request\Draw;
use LukeShard\DataTables\Request\GlobalSearch;
use LukeShard\DataTables\Request\Length;
use LukeShard\DataTables\Request\Offset;
use LukeShard\DataTables\Request\Order;
use LukeShard\DataTables\Request\ParamInterface;
use Phalcon\Http\RequestInterface;
use Phalcon\Mvc\User\Component;

class ParameterBag extends Component
{

    /**
     * @var array $params Bag container
     */
    protected $params = [];
    protected $page = 1;

    const
        DRAW = 'draw',
        ORDER = 'order',
        GLOBAL_SEARCH = 'search',
        OFFSET = 'start',
        LIMIT = 'length',
        COLUMNS = 'columns';

    const PARAMS = [
        'Draw' => self::DRAW,
        'GlobalSearch' => self::GLOBAL_SEARCH,
        'Start' => self::OFFSET,
        'Length' => self::LIMIT,
        'Columns' => self::COLUMNS
    ];


    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param RequestInterface $request
     * @return ParameterBag
     */
    public function fromRequest(RequestInterface $request)
    {

        foreach (self::PARAMS as $className => $requestKey) {

            $param = static::makeParameter($className);

            if (class_exists($param)) {
                /** @var AbstractParam $singleParam */
                $singleParam = new $param;
                $singleParam->process($request);
                $singleParam->getParams() ? $this->add($singleParam) : null;
            }

        }

        return $this;

    }

    /**
     * Adds a new param to the Bag.
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param ParamInterface $param
     * @return $this Chainable
     */
    public function add(ParamInterface $param)
    {
        $this->params[$param->getRequestKey()] = $param;
        return $this;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     */
    public function setPage()
    {
        $this->page = (int)(floor($this->params['start'] / $this->params['length']) + 1);
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @throws \Exception
     */
    public function toRequest() {
        throw new \Exception('Method toRequest not implemented');
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return array
     */
    public function getColumnsSearch()
    {
        return array_filter(array_map(function ($item) {
            return (isset($item['search']['value']) && strlen($item['search']['value'])) ? $item : null;
        }, $this->params['columns']));
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return array
     */
    public function getSearchableColumns()
    {
        return array_filter(array_map(function ($item) {
            return (isset($item['searchable']) && $item['searchable'] === "true") ? $item['data'] : null;
        }, $this->params['columns']));
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return Draw
     */
    public function getDraw()
    {
        return $this->params[self::DRAW];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return Length
     */
    public function getLimit()
    {
        return $this->params[self::LIMIT];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return Offset
     */
    public function getOffset()
    {
        return $this->params[self::OFFSET];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return Columns
     */
    public function getColumns()
    {
        return $this->params[self::COLUMNS];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param $id
     * @return null
     */
    public function getColumnByIndex($id)
    {
        return isset($this->params[self::COLUMNS][$id]['data']) ? $this->params[self::COLUMNS][$id]['data'] : null;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return GlobalSearch
     */
    public function getSearch()
    {
        return $this->params[self::GLOBAL_SEARCH];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return string
     */
    public function getSearchValue()
    {
        return isset($this->params[self::GLOBAL_SEARCH]['value']) ? $this->params[self::GLOBAL_SEARCH]['value'] : '';
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return Order
     */
    public function getOrder()
    {
        return $this->params[self::ORDER];
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param $name
     * @param $arguments
     * @return mixed|null
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'get')) {
            $columnName = substr($name, 2);
            if (array_key_exists($columnName, $this->params)) {
                return $this->params[$columnName];
            }
        }
        return null;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @param string $name
     * @throws \Exception
     */
    public function __get($name)
    {
        throw new \Exception('__get not implemented');
    }

    /**
     * @param $name
     *
     * @return string
     */
    private static function makeParameter($name)
    {
        return __NAMESPACE__ . '\\' . str_replace(' ', '', str_replace('_', ' ', $name));
    }
}
