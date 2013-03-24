<?php

namespace JS\MysqlndBundle\Analytics;

use Rezzza\Formulate\Formula;

/**
* Evaluation of rules
*
* This class process a Rule for each call of calculate() for the
* given set of collected statistics.
*/
class Calculator
{
    private $statistics;

    public function __construct(array $statistics)
    {
        $this->statistics = $statistics;
    }

    private function calculateFormula($form)
    {
        $formula = new Formula($form);
        foreach ($this->statistics as $key => $value) {
            $formula->setParameter($key, $value);
	}

	$formula->setIsCalculable(true);

	return $formula->render();
    }

    public function calculate(Rule $rule)
    {
        $left  = $this->calculateFormula($rule->getLeft());
        $right = $this->calculateFormula($rule->getRight());

        switch ($rule->getOperator()) {
        case 'less-than':     return new Result($left, $right, $left <  $right);
	case 'less-equal':    return new Result($left, $right, $left <= $right);
        case 'equal':         return new Result($left, $right, $left == $right);
	case 'greater-equal': return new Result($left, $right, $left >= $right);
	case 'greater-than':  return new Result($left, $right, $left >  $right);
	default: throw new \UnexpectedValueException("Unknown operator {$rule->getOperator()} while calculating {$rule->getName()}.");
        }
    }
}

