<?php

require_once('boostrap.php');

// Use Namespaced classes
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\NativeMailerHandler;

// create a log channel
$log = new Logger('app');

//Instantiate the handlers
$streamHandler = new StreamHandler(__DIR__ . '/logs/error.log', Logger::NOTICE, false);
$mailHandler = new NativeMailerHandler(
                        'sathees1kumar@gmail.com', 
                        'test',
                        'noreply@gmail.com',
                        Logger::ERROR,
                        true
                    );



//Instantiate Formatters
$jsonFormatter = new JsonFormatter();
$htmlFormatter = new HtmlFormatter();

//Set the formtter to handler
$streamHandler->setFormatter($jsonFormatter);
$mailHandler->setFormatter($htmlFormatter);

//Set the contentType of mailer data
$mailHandler->setContentType('text/html');


//Push a stack of handlers
$log->pushHandler($streamHandler);
$log->pushHandler($mailHandler);

// add records to the log
$log->addNotice('test messsage');
$log->addWarning('Foo');
$log->addError('Bar');
