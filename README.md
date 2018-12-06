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

## How to use this library

Starts a WebSocketClient process and handles incoming events within your own local app.
```php
<?php

use AriStasisApp\websocket_client\WebSocketClient;

require_once __DIR__ . '/vendor/autoload.php';

$webSocketSettings = [
    'wssEnabled' => false,
    'host' => 'localhost',
    'port' => 8088,
    'rootUri' => '/ari',
    'user' => 'myUser',
    'password' => 'myPass'
];

$ariWebSocket = new WebSocketClient($webSocketSettings, 'ExampleLocalApp');
$ariWebSocket->runWithLocalApp(new ExampleLocalApp('myUser', 'myPass'));
```

Simple ARI request to send an event
```php

```
## FAQ

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

- Responsetypes Check in every Client!

[Asterisk]

- Restrict origin of ARI to localhost.
  
  - Add 'origin' header in WebSocketClient requests
  

[DEVELOPEMENT]

- Mockery

- Pact

- TESTING!!!!

- JSON Validation with justinrainbow/json-schema

- Get rid of JSON Mapper exceptions for Client. Not his fault!

- Rename GuzzleExceptions to something from the own library.

- Subtypes Getter/setter public and class that was extended from no getter/setter and protected attributes!?

- Add a MissingParams model to /messages? This is only required when the WebSocketClient fails during Startup so wayne?!

- Take care of Lists in models!!!! Not yet implemented