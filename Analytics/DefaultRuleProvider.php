<?php

namespace JS\MysqlndBundle\Analytics;

/**
 * Default set of rules.
 *
 * By default rules are loaded from an XML file called analytics.xml which
 * has to be located next to this file.
 *
 * @todo Don't hard-code the location
 */
class DefaultRuleProvider implements \IteratorAggregate, RuleProvider 
{
    public function getIterator()
    {
        $dom = new \DOMDocument();
	$dom->load(__DIR__.'/analytics.xml');
        return new DefaultRuleIterator($dom->getElementsByTagName('rule'));
    }
}

/**
 * Internal helper class for DefaultRuleProvider
 */
class DefaultRuleIterator extends \IteratorIterator
{
    public function __construct(\DOMNodeList $nodes)
    {
        // parent::__construct($nodes);
	// Work-around due to Bug #60762 (IteratorIterator doesn't iterate over DomNodeList)
        parent::__construct(new \ArrayIterator(iterator_to_array($nodes)));
    }

    public function current()
    {
        $node = parent::current();
	return new Rule(
            $node->getElementsByTagname('left')->item(0)->textContent,
            $node->getElementsByTagname('right')->item(0)->textContent,
            $node->getElementsByTagname('operator')->item(0)->textContent,
            $node->getAttribute('name'),
	    $node->getAttribute('severity'), 
            $node->getElementsByTagname('guidance')->item(0)->textContent
        );
    }
}

