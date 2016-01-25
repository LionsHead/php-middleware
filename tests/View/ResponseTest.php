<?php

use \LionHead\View\Pagination;

/**
 * надеюсь это никто не увидит ч2
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider additionPages
     */
    public function testPaginationOffset($all, $current, $limit, $result)
    { 
        $this->assertEquals($result, ( new Pagination($all, $limit, $current) )->getOffset());
    }

    public function additionPages()
    {
        // $all, $current, $limit, $result
        return [
            [122, 13, 10, 120],
            [150, 1, 18, 0],
            [150, 18, 20, 140],
            [0, 1, 20, 0],
            [322, 8, 12, 84],
            [322, 1258, 12, 312],
        ];
    }

}
