<?php

namespace JS\MysqlndBundle\Analytics;

/**
* Describe an analytics rule to be checked
*
* A rule consists of two formulas and a comparison operator as well as
* meta infomration describing the analytics event in case this rule matches.
*/
class Rule
{
    private $left;
    private $right;
    private $operator;

    private $name;
    private $severity;
    private $guidance;

    public function __construct($left, $right, $operator, $name, $severity, $guidance)
    {
        $this->left = $left;
        $this->right = $right;
        $this->operator = $operator;
	
        $this->name = $name;
        $this->severity = $severity;
        $this->guidance = $guidance;
    }

    /**
    * Get left term of the comparison
    */
    public function getLeft()
    {
        return $this->left;
    }

    /**
    * Get right term of the comparison
    */
    public function getRight()
    {
        return $this->right;
    }

    /**
    * Get the comparison operator
    */
    public function getOperator()
    {
        return $this->operator;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getGuidance()
    {
        return $this->guidance;
    }
}

