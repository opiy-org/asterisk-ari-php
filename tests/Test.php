<?php
/**
 * Created by PhpStorm.
 * User: lukasstermann
 * Date: 09.11.18
 * Time: 14:48
 */

require_once __DIR__ . '/../vendor/autoload.php';
interface TestInterface
{
    function bla();
}


class BasicStApp
{
    function __construct()
    {
        print_r("This is " . get_class($this) . "\n");
        $this->bla();
    }

    function bla(){
        print_r("This is bla from TEST\n");
    }
}
class ExampleStApp extends BasicStApp implements TestInterface
{
    function bla(){
        print_r("This is bla from TEST1\n");
    }
}

class AriCl
{
    function __construct()
    {
        print_r("This is ".get_class($this)."\n");
        $this->bla();
    }

    function bla(){
        print_r("This is bla from TEST\n");
    }
}
class ChannelCl extends AriCl
{
    function bla(){
        print_r("This is bla from TEST1\n");
    }
}

$consumer = new \AriStasisApp\amqp\AriAMQPConsumer();