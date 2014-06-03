<?php

require_once('boostrap.php');

// Use Namespaced classes
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;

// create a log channel
$log = new Logger('app');



//Instantiate the handlers
$streamHandler = new StreamHandler(__DIR__ . '/logs/error.log', Logger::NOTICE, false);

//Instantiate Formatters
$jsonFormatter = new JsonFormatter();

//Set the formtter to handler
$streamHandler->setFormatter($jsonFormatter);


//Push a stack of handlers
$log->pushHandler($streamHandler);


// add records to the log
$log->addNotice('test messsage');
$log->addWarning('Foo');
$log->addError('Bar');
