<?php

namespace JS\MysqlndBundle\Analytics;

/**
* The result of an calculation
*
* Unlike the Rule, which includes formulas, this contains the actual
* values for the calculation after replacing place holders and
* executing required calculations.
*/
class Result
{
    private $left;
    private $right;
    private $result;

    public function __construct($left, $right, $result)
    {
        $this->left =  $left;
        $this->right = $right;
        $this->result = $result;
    }

    public function getLeft()
    {
        return $this->left;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function getResult()
    {
        return $this->result;
    }
}
