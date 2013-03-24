<?php

namespace JS\MysqlndBundle\Analytics;

class Engine extends \IteratorIterator
{
    private $calculator;

    public function __construct(RuleProvider $provider, Calculator $calculator)
    {
        parent::__construct($provider);
	$this->calculator = $calculator;
    }

    public function current()
    {
        $current = parent::current();
	$result = $this->calculator->calculate($current);
	return new Analytic($current, $result);
    }
}

