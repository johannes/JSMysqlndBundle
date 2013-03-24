<?php

namespace JS\MysqlndBundle\Analytics;

/**
* Outside representation of a result
*
* This class provides access to all elements for a report to
* an user. This the joint content of the Rule and the inidvidual Result.
*
* A consumer should check getMatched() to see whether the rule matched
* (the user should be advised to improve his application) or not.
*/
class Analytic
{
    private $rule;
    private $result;

    public function __construct(Rule $rule, Result $result)
    {
        $this->rule = $rule;
	$this->result = $result;
    }

    public function getMatched()
    {
        return $this->result->getResult();
    }

    public function getName()
    {
        return $this->rule->getName();
    }

    public function getSeverity()
    {
        return $this->rule->getSeverity();
    }

    public function getGuidance()
    {
        return $this->rule->getGuidance();
    }

    public function getLeftFormula()
    {
        return $this->rule->getLeft();
    }

    public function getLeftValue()
    {
        return $this->result->getLeft();
    }

    public function getRightFormula()
    {   
        return $this->rule->getRight();
    }

    public function getRightValue()
    {
        return $this->result->getRight();
    }

    public function getOperator()
    {   
        return $this->rule->getOperator();
    }  
}

