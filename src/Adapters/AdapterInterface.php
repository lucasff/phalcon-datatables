<?php

namespace LukeShard\DataTables\Adapters;

use LukeShard\DataTables\ParameterBag;

abstract class AdapterInterface
{

    protected $columns;

    /** @var ParameterBag */
    protected $params;

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function columnExists($column)
    {
        return in_array($column, $this->columns);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function formResponse($options)
    {
        $defaults = [
            'total' => 0,
            'filtered' => 0,
            'data' => []
        ];
        $options += $defaults;

        $response = [];
        $response['draw'] = (int) $this->params->getDraw();
        $response['recordsTotal'] = $options['total'];
        $response['recordsFiltered'] = $options['filtered'];

        if (count($options['data'])) {
            foreach ($options['data'] as $item) {
                if (isset($item['id'])) {
                    $item['DT_RowId'] = $item['id'];
                }

                $response['data'][] = $item;
            }
        } else {
            $response['data'] = [];
        }

        return $response;
    }

    /**
     * @deprecated
     * @param $case
     * @param $closure
     * @throws \Exception
     */
    public function bind($case, $closure)
    {
        switch ($case) {
            case "global_search":
                $search = $this->parser->getSearchValue();
                if (!mb_strlen($search)) return;

                foreach ($this->parser->getSearchableColumns() as $column) {
                    if (!$this->columnExists($column)) continue;
                    $closure($column, $this->sanitize($search));
                }
                break;
            case "column_search":
                $columnSearch = $this->parser->getColumnsSearch();
                if (!$columnSearch) return;

                foreach ($columnSearch as $key => $column) {
                    if (!$this->columnExists($column['data'])) continue;
                    $closure($column['data'], $this->sanitize($column['search']['value']));
                }
                break;
            case "order":
                $order = $this->parser->getOrder();
                if (!$order) return;

                $orderArray = [];

                foreach ($order as $orderBy) {
                    if (!isset($orderBy['dir']) || !isset($orderBy['column'])) continue;
                    $orderDir = $orderBy['dir'];

                    $column = $this->parser->getColumnById($orderBy['column']);
                    if (is_null($column) || !$this->columnExists($column)) continue;

                    $orderArray[] = "{$column} {$orderDir}";
                }

                $closure($orderArray);
                break;
            default:
                throw new \Exception('Unknown bind type');
        }

    }

}
