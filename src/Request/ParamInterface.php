<?php
/**
 * @author Lucas Freitas <lucas@lucasfreitas.me>
 * @since 09.03.18 13:05
 */

namespace LukeShard\DataTables\Request;


/**
 * Interface ParamInterface
 * @package LukeShard\DataTables\Request
 */
interface ParamInterface
{

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function getRequestKey();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function getType();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function getContents();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function isSearchable();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function isSortable();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function isAlias();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function isColumn();

    /**
     * @author Lucas Freitas <lucas@lucasfreitas.me>
     * @return mixed
     */
    public function hasSearchValue();

}
