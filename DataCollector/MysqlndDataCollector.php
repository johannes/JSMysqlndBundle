<?php

namespace JS\MysqlndBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

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
            $this->data = $this->initialData;
            array_walk($this->data, function (&$value, $key, $current_values) {
                $value = $current_values[$key] - $value;
            }, mysqli_get_client_stats());
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
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Dump information about mysqli.
     * 
     * This is used by the view in case no statistics were collected to
     * ease the debugging
     * 
     * @return string
     */
    function getMysqlInfo()
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
}
