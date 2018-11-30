# Asterisk RESTful Interface (ARI) WebHook Library

Using Asterisk in a microservice environment by .

`Implemented for Asterisk 16!`

## Installation
Use this library with composer and include it into your composer.json by using the terminal command
`composer require ng-voice/arilib` ??????

##### PHP extensions
You might run into troubles with missing php extensions. The following are required:
   
   - mbstring
    
   - json
  
We recommend to install them with terminal commands.

E.g. for Debian: `apt install php7.2-mbstring` (may differ depending on your underlying operating system. Don't forget 
to restart your apache server with `service apache2 restart`
##### Asterisk
You will have to start a running asterisk instance first and configure it to use it's light http server and the 
"Asterisk RESTful Interface" (ARI). The official Asterisk documentation shows you how to configure http.conf and 
ari.conf in order to use ARI.

Preferably use the provided Dockerfile in this library to compile your own asterisk container.

    docker build -t asterisk:16.0.1 .
    docker run -t -d --name some-asterisk -p 8088:8088 asterisk:16.0.1

##### Tests
Before you start developing your application around your asterisk, make shure everything is up and running nicely. 
Run the `execute_tests.sh` script from the /tests directory. If everything is green, you are ready to go!

## Features
#### ARI Clients
To build your own stasis applications, talk to your asterisk instance by using the given http clients.
That's about it!
We believe that today microservices can easily scale with your needs. And so should your asterisk instances.
So of couse it is possible to use the asterisk rest api directly. But why, if we communicate through amqp
in our microservice universe anyway?

#### ARI WebsocketClient
Basically connects to asterisk via `GET /events` and listens for either for one, many or all stasis application events.

## Example

Starts a WebSocketClient process and publishes events into an AMQP server.
```php
<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * The asterisk events will be received by a web socket client and then published to an ampq server (e.g RabbitMQ).
 * Implement your own consumers for the queues (name of the queue that holds events from your stasis app is
 * 'yourapplicationname') or (preferably) use your favorite framework like we do to handle amqp events :) e.g. Laravel
 */

use AriStasisApp\websocket_client\WebSocketClient;

require_once '/vendor/autoload.php';

$ariSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => 'asterisk',
    'password' => 'asterisk'
];

$myApiSettings = [
    'host' => 'localhost',
    'port' => 8000,
    'rootUri' => '/api',
    'user' => 'myUserName',
    'password' => 'myPassword',
    'apiKey' => 'myApiKey'
];

$ariWebSocket = new WebSocketClient('', $ariSettings, $myApiSettings);
$ariWebSocket->run();
```

Simple ARI request to send an event
```php
<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 * Example for usage in your application.
 */

use AriStasisApp\rest_clients\Asterisk;
use AriStasisApp\rest_clients\Events;

require_once '/vendor/autoload.php';


// E.g. get your asterisk settings (This will not trigger stasis app events!)
$asterisk = new Asterisk();
$asteriskInfo = $asterisk->getInfo();

/*
 * This ARI client can generate custom user events for specific applications. Nice and simple to test your setup :)
 * The events will be published to your AMQP server.
 */
$events = new Events();
$events->userEvent('customEventExample', 'ExampleStasisApp');
```
## FAQ
Q: Why didn't you also implement consumers?!

A: We are leaving out AMQP consumers on purpose because we believe that it is best practice to use this 
library within a light microframework like e.g. Laravel/Lumen.
They consume AMQP messages much better than we would implement it, while providing the possibility to use asterisk 
calls in ORM context.

##Contact
We are happy to help! Feel free to send us a message! :) 
We'd also love to hear about your application ideas and use cases.

- Lukas Stermann lukas@ng-voice.com

- Rick Barenthin rick@ng-voice.com

##Licence
MIT

## Contribute
We are happy to hear about your improvement ideas. Please use PSR-2 if you want to contribute.

Possible TODO's if you want to contribute but don't have an own idea:

[composer.json]

- Rename "autoload" namespace from "AriStasisApp" to something better 


[ARIClients]

- Go through every single client class and compare to Asterisk Documentation

- Test the clients!

[Asterisk]

- Restrict origin of ARI to localhost.
  
  - Add 'origin' header in WebSocketClient requests
  

[DEVELOPEMENT]

- Mockery

- Pact

- TESTING!!!!