<?php

namespace LukeShard\DataTables\Adapters;

use LukeShard\DataTables\ParameterBag;
use LukeShard\DataTables\QueryBuilder\QueryBuilderInterface;

/**
 * Class QueryBuilder
 * @package LukeShard\DataTables\Adapters
 */
class QueryBuilder extends AdapterInterface
{
    /** @var QueryBuilderInterface $builder */
    protected $builder;

    /** @var ParameterBag $paramBag */
    protected $params;

    /**
     * @return QueryBuilderInterface
     */
    public function getBuilder(): QueryBuilderInterface
    {
        return $this->builder;
    }

    /**
     * @param QueryBuilderInterface $builder
     */
    public function setBuilder(QueryBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return ParameterBag
     */
    public function getParams(): ParameterBag
    {
        return $this->params;
    }

    /**
     * @param ParameterBag $params
     */
    public function setParams(ParameterBag $params)
    {
        $this->params = $params;
    }

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     */
    public function handleOrder() {
        list($column, $dir) = $this->paramBag->getOrder();
        $this->builder->orderBy($column, $dir);
    }

}
