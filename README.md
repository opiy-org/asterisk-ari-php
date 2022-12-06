# Asterisk REST Interface (ARI) Application Client

forked from https://bitbucket.org/ngvoice/asterisk-ari-client/

A client implementation of the Asterisk REST Interface and simple Stasis
application development library.

The idea is to make ARI calls safe and easy. Therefore, we wanted to get rid of
JSON parsing in our application code. Instead, we aim to make it as easy as possible
for anyone to talk to ARI without worrying about the implementation of a client stub.

[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=security_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=coverage)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_index)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=ncloc)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)

![Diagram of the ARI communication](image/AriClientSketch.png)

## Prerequisites

Download and install composer from the following link:

https://getcomposer.org/download/

## Installing

##### Composer

Please run the following command to add the library to your project:

PHP 7.4
`composer require opiy-org/asterisk-ari-php` 

PHP 8.0|8.1
`composer require opiy-org/asterisk-ari-php:2` 

While installing, you might run into composer errors concerning missing PHP extensions.
There are several ways to install them, depending on your operating system.
In some very unlikely cases, you might need to install `php-dev` first and then install
and enable the extension via PECL. But that is generally not required.

##### Asterisk

You will have to start an Asterisk instance and configure it in order to use ARI.
The official Asterisk documentation shows you how to do so. 

https://wiki.asterisk.org/wiki/display/AST/Asterisk+Configuration+for+ARI

Alternatively, use our Dockerfile to fire up Asterisk ([See Deployment](#deployment)).

## Examples

#### REST Clients

Talk to the Asterisk REST Interface through the given REST clients.
All requests and responses are objects and easy to understand.

The following example originates a call using the Channels resource:

    <?php
    
    declare(strict_types=1);
    
    use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
    use OpiyOrg\AriClient\Client\Rest\Settings as AriRestClientSettings;
    use OpiyOrg\AriClient\Client\Rest\Resource\Channels as AriChannelsRestResourceClient;
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Of course inject your own REST client settings here.
    $ariChannelsRestResourceClient = new AriChannelsRestResourceClient(
        new AriRestClientSettings('asterisk', 'asterisk')
    );
    
    try {
        // Call the specified number
        $originatedChannel = $ariChannelsRestResourceClient->originate(
            'PJSIP/+4940123456789',
            [
                'app' => 'MyExampleStasisApp'
            ]
        );
    } catch (AsteriskRestInterfaceException $e) {
        printf("Error occurred: '%s'\n", $e->getMessage());
    }
    
    printf("The originated channel has the ID '%s'\n", $originatedChannel->getId());

#### Web socket client

Connects to Asterisk and subscribes to a Stasis application. The following example shows
how to define your Stasis application and how to handle specific incoming events, which
are emitted by a channel that is part of the application context.

In this example, we are handling a `StasisStart` event:
    
    <?php
    
    declare(strict_types=1);
    
    // TODO: Change to your own project namespace.
    namespace My\Own\Project\Namespace;
        
    use OpiyOrg\AriClient\StasisApplicationInterface;
    use OpiyOrg\AriClient\Model\Message\Event\StasisStart;
    
    /**
     * Write your own Stasis application class that must implement the
     * StasisApplicationInterface.
     *
     * This application will register automatically in Asterisk as soon
     * as you start a WebSocketClient (@see example/my_example_stasis_app_worker.php).
     */
    class MyExampleStasisApp implements StasisApplicationInterface
    {
        /**
         * To declare an ARI event handler function, name it after
         * the occurring Asterisk event you want to handle and add
         * the prefix 'onAriEvent'. The only parameter is the object
         * representation of the event, provided by this library.
         * The function MUST also be public and non-static.
         *
         * Of course you can define any other functions within this class
         * that do not handle incoming ARI events (leave out the prefix ;-)).
         * Think of your Stasis application class as container for your
         * application logic.
         *
         * The StasisStart event for example is triggered for
         * channels when they enter your application.
         *
         * @param StasisStart $stasisStart The Asterisk event,
         * telling you that a channel has entered your application.
         */
        public function onAriEventStasisStart(StasisStart $stasisStart): void
        {
            printf(
                'This is the channel's StasisStart event '
                . "handler triggered by channel '%s' :-)\n",
                $stasisStart->getChannel()->getId()
            );
        }
    }

Write a PHP script to start your WebSocketClient worker process.
This is a blocking process! For production, you should use a process manager to run it in
the background. We recommend [supervisor](http://supervisord.org/) for Linux.

    <?php

    declare(strict_types=1);

    use OpiyOrg\AriClient\Client\WebSocket\Factory as AriWebSocketClientFactory;    
    use OpiyOrg\AriClient\Client\WebSocket\Settings as AriWebSocketClientSettings;
    
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/MyExampleStasisApp.php';
    
    /*
     * Initialize an ARI web socket client to
     * listen for incoming Asterisk events.
     *
     * Of course inject your own web socket settings here.
     */
    $ariWebSocketClient = AriWebSocketClientFactory::create(
        new AriWebSocketClientSettings('asterisk', 'asterisk'),
        new MyExampleStasisApp()
    );
    
    $ariWebSocketClient->start();

You can find a detailed example with more options in the `example` directory.

## Debug logs

To debug your ARI communication, this client library ships with a simple debug log switch.
Simply en-/disable it as an option in the REST/web socket client settings object. Error
logs will write to STDERR. All other logs will write to STDOUT.

Alternatively, use your own Logger and pass it to the REST client and/or web socket
client constructor.

## Error handler

As described in `example/my_example_stasis_app_worker.php`, you can add a custom error
handler to your application. This is a layer between the logic in your
Stasis application (`e.g. example/MyExampleStasisApp`), and the PHP process error handler.
That means you can decide what to do with a Throwable which is not caught
within your application logic and would normally cause the application (and likely the
whole process) to crash. Why not report it to BugSnag for example?

## Running the tests

### Unit tests

`composer test`

### Coding style tests

For code sniffing

`composer lint `

For static code analysis

`composer sca`

## Deployment

We added a Dockerfile in the `docker/asterisk/` directory, where you can also find some
example configuration files for your own Asterisk instance.

Preferably use the provided Dockerfile in this library to compile your own Asterisk
container.
    
    cd docker/asterisk
    docker build -t --build-arg asterisk_version=WHATEVER_VERSION_YOU_LIKE asterisk:latest .
    docker run -d --name some-asterisk -p 8088:8088 -p 5060:5060 -p 5060:5060/udp asterisk:latest

    !!! PLEASE NOTE !!!
    Compiling Asterisk sometimes is bound to the hardware you are compiling it on.
    Currently, we compile a separate container for every machine we run Asterisk on,
    to make sure it will work.
    Alternatively, you can set generic compiler flags at your own risk.

## Licence

##### MIT © ng-voice GmbH (2020)

![ng-voice logo](image/ng-voice-logo.png)

ng-voice is happy to help! Feel free to send us a message.
We'd also like to hear about your application ideas and use cases. :)

## Contributors

Your pull requests are welcome. Please stick to the PSR-12 coding standards if
you want to contribute.

### Maintainer

* [Lukas Stermann](https://gitlab.com/Oktavlachs) (lukas@ng-voice.com)

### Others

* [Benedikt Vollmerhaus](https://gitlab.com/BVollmerhaus) (Project Review)
