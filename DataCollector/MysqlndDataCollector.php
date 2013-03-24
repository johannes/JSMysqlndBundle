<?php

namespace JS\MysqlndBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use JS\MysqlndBundle\Analytics\Engine;
use JS\MysqlndBundle\Analytics\DefaultRuleProvider;
use JS\MysqlndBundle\Analytics\Calculator;

/**
 * Data collector collecting mysqlnd statistics.
 *
 * @author johannes
 */
class MysqlndDataCollector  extends DataCollector
{
    private $initialData = false;
    
    public function __construct()
    {
        if (function_exists('mysqli_get_client_stats')) {
            $this->initialData = mysqli_get_client_stats();
        }
    }
    
    public function onEarlyKernelRequest(GetResponseEvent $event)
    {
        if (!$this->initialData && function_exists('mysqli_get_client_stats')) {
            $this->initialData = mysqli_get_client_stats();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (function_exists('mysqli_get_client_stats')) {
            $this->data['stats'] = $this->initialData;
            array_walk($this->data['stats'], function (&$value, $key, $current_values) {
                $value = $current_values[$key] - $value;
            }, mysqli_get_client_stats());
        } else {
            $this->data['stats'] = false;
        }
        
        if (function_exists('mysqlnd_qc_get_query_trace_log') && ini_get('mysqlnd_qc.collect_query_trace')) {
            $this->data['mysqlnd_qc_trace'] = mysqlnd_qc_get_query_trace_log();
        } else {
            $this->data['mysqlnd_qc_trace'] = false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mysqlnd';
    }
    
    /**
     * Returns the collected data to be used by the view.
     * 
     * @return array 
     */
    public function getStatistics()
    {
        return $this->data['stats'];
    }
    
    public function getMysqlndQCTrace()
    {
        return $this->data['mysqlnd_qc_trace'];
    }
    
    /**
     * Dump information about mysqli.
     * 
     * This is used by the view in case no statistics were collected to
     * ease the debugging
     * 
     * @return string
     */
    public function getMysqlInfo()
    {
        if (!extension_loaded("mysqli")) {
            return "The mysqli extension is not available at all.";
        }
        
        ob_start();
        $re = new \ReflectionExtension("mysqli");
        $re->info();
        $info = ob_get_contents();
        ob_end_clean();
        
        return str_replace('<h2><a name="module_mysqli">mysqli</a></h2>', '', $info);
    }

    public function getAnalytics()
    {
        class_Exists(Engine::class);
        return new Engine(new DefaultRuleProvider(), new Calculator($this->getStatistics()));
    }
}
