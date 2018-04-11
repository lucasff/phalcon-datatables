<?php

namespace LukeShard\DataTables;

use LukeShard\DataTables\Adapters\AdapterInterface;
use LukeShard\DataTables\Adapters\ArrayAdapter;
use LukeShard\DataTables\Adapters\QueryBuilder as QueryBuilderAdapter;
use LukeShard\DataTables\Adapters\ResultSet;
use LukeShard\DataTables\QueryBuilder\QueryBuilder;
use Phalcon\Http\RequestInterface;
use Phalcon\Http\Response;
use Phalcon\Mvc\User\Plugin;

final class DataTableQuery extends Plugin
{

    /** @var array */
    private $params;

    /** @var AdapterInterface $adapter */
    protected $adapter;

    private $mapColumnToDatabase = [
        'studio' => [
            'venue_address.name'
        ]
    ];

    private $columnDefs;

    /**
     * DataTable constructor.
     */
    public function __construct()
    {
        $this->params = new ParameterBag();
    }


    public function setColumnDefinitions($columnDefs) {
        $this->columnDefs = $columnDefs;
    }

    /**
     * @return array
     */
    public function getParams()
    {

    }

    /**
     * @return array
     */
    public function getResponse()
    {

    }

    /**
     *
     */
    public function sendResponse()
    {
        if ($this->di->has('view')) {
            $this->di->get('view')->disable();
        }

        $response = new Response();
        $response->setContentType('application/json', 'utf8');
        $response->setJsonContent($this->getResponse());
        $response->send();
    }

    /**
     * @param QueryBuilder $builder
     * @param RequestInterface $request
     * @param array $columns
     * @return $this
     */
    public function fromBuilder($builder, RequestInterface $request, $columnsDefs = [])
    {

        $adapter = new QueryBuilderAdapter();
        $adapter->setBuilder($builder);
        $adapter->setParams($this->params->fromRequest($request));

        if (empty($columns)) {
            $columns = $builder->getColumns();
            $columns = (is_array($columns)) ? $columns : array_map('trim', explode(',', $columns));
        }

        $adapter->setColumns($columns);
        $this->response = $adapter->getResponse();

        return $this;
    }

    /**
     * @param $resultSet
     * @param array $columns
     * @return $this
     */
    public function fromResultSet($resultSet, $columns = [])
    {
        if (empty($columns) && $resultSet->count() > 0) {
            $columns = array_keys($resultSet->getFirst()->toArray());
            $resultSet->rewind();
        }

        $adapter = new ResultSet($this->options['length']);
        $adapter->setResultSet($resultSet);
        $adapter->setParser($this->parser);
        $adapter->setColumns($columns);
        $this->response = $adapter->getResponse();

        return $this;
    }

    /**
     * @param $array
     * @param array $columns
     * @return $this
     */
    public function fromArray($array, $columns = [])
    {
        if (empty($columns) && count($array) > 0) {
            $columns = array_keys(current($array));
        }

        $adapter = new ArrayAdapter($this->options['length']);
        $adapter->setArray($array);
        $adapter->setParser($this->parser);
        $adapter->setColumns($columns);
        $this->response = $adapter->getResponse();

        return $this;
    }

}
