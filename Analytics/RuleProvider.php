<?php
namespace JS\MysqlndBundle\Analytics;

/**
 * An Iterator providing rules to the Engine
 *
 * The current(/) method of the iterator provided by RuleProvider
 * should return instances of Rule.
 */
interface RuleProvider extends \Traversable { }
