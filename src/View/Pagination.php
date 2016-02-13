<?php

namespace LionHead\View;

/**
 * usage:
 *
 * $limit = 10;
 * $all = 100500;
 * $pg = new Pagination($all, $limit, $_GET['page']);
 * $offset = $pg->getOffset();
 *
 * $result = query('SELECT * FROM `table` LIMIT '. $limit .' OFFSET '. $offset .' ;');
 */
class Pagination
{
    private $count = 10; //  count all element
    private $current_page = 1;
    private $last_page = 1;
    private $limit = 10;
    private $offset = 0;

    private $name = 'page';

    /**
     * [__construct description]
     * @method __construct
     * @param  integer     $count   count all element
     * @param  integer     $limit   elements on the page
     * @param  [type]      $current the current page number
     */
    function __construct($count = 10, $limit = 10, $current = null)
    {
        $get_page = isset($_GET[$this->name]) ? intval($_GET[$this->name]) : 1;
        $this->current_page = abs( is_null($current) ? $get_page : $current );

        $this->count = $count;
        $this->limit = $limit;

        $this->setPagination();

        return $this;
    }

    public function setName($name = 'page')
    {
        $this->name = $name;

        return $this;
    }

    /**
     * [setLimit description]
     * @method setLimit
     * @param  integer  $limit [description]
     */
    public function setLimit($limit = 10)
    {
        $this->limit = $limit;
         // reload
        $this->setPagination();
        return $this;
    }

    /**
     * [setPagination description]
     * @method setPagination
     */
    private function setPagination() {
        $this->last_page = ceil($this->count / $this->limit);
        $this->offset = $this->setOffset();
        if ($this->offset > ($this->count - $this->limit)){
            $this->current_page = $this->last_page;
            $this->offset = $this->setOffset();
        }
        return $this;
    }

    /**
     * [setOffset description]
     * @method setOffset
     */
    private function setOffset()
    {
        $this->offset = ($this->last_page > 1) ? ( ($this->current_page - 1) * $this->limit ) : 0;
        return intval($this->offset);
    }

    /**
     * Получение универсальной конструкции
     *  LIMIT x (сколько) OFFSET y (откуда начинать) для sql запроса
     *  работает с mysql, postgresql, sqlite
     *
     *  example code:
     *  'SQL... LIMIT 10 OFFSET '. ( new Pagination($all, 10, $_GET['page']) )->getOffset() .' ;'
     *
     * @return string
     */
    public function getOffset($limit = null) {
        if (!is_null($limit) && $limit > 0) {
            $this->limit = $limit;
            $this->setPagination($all);
        }

        return $this->offset;
    }

    /**
     * [getLimit description]
     * @method getLimit
     * @return [type]   [description]
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * [getLastPage description]
     * @method getLastPage
     * @return integer      [description]
     */
    public function getLastPage()
    {
        return $this->last_page;
    }

    /**
     * [getCurrentPage description]
     * @method getCurrentPage
     * @return integer         [description]
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }
}
