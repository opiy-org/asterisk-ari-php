Inspired by the phpari library. Mainly refactored it using non-deprecated libraries.

`Tested and implemented for Asterisk 16!` 

## Asterisk Setup

You have to set up http.conf and ari.conf on your asterisk instance first.

[http.conf]
* You have to enable the http server here.
* Copy bindaddr and bindport to the asterisk.ini in this library

[ari.conf]
* Enable the ARI here -> "enable=yes"
* Please make sure you enable the pretty human readable format for the ARI events -> "pretty=yes"
* Configure a user, password
* Copy \[user] and bindport to the asterisk.ini in this library

# Features
To build your own stasis applications, simply build your own class and inherit from BasicStasisApp.
That's about it!
For further information on functions etc. read the Documentation phpDoc (link)

### AMQP Publisher
And ontop of that, thanks to the awesome people from php-amqplib, you can use whatever implements the AMQP. 
You are not depending on RabbitMQ (although it is tested with that)!

We didn't implement a consumer on purpose. Most likely you will use a framework (e.g. we use Laravel)
for your asterisk application that lets you work with consumers waaaaay more easy.
Great for microservices!

### Examples

## Todos
Possible TODO's if you want to contribute but don't have an own idea:

[GENERAL]

- We need a LICENCE! Also see if the used libraries are free to integrate.

- Error logs should really be exceptions so the person using the library has to handle them.
  
  - But really also the guzzle exceptions? They make code in the class that uses the AriManager really messy.
 
[Writing a wrapping Asterisk application with Laravel]

- Think of a simple turn key setup (which also includes to start and supervise the RabbitMQ workers)
  
  - How can we automatically install stuff? Dockerfile?

- PDO transactional for concurrent conference database calls (avoids two database users read/write because 
of optimistic database usage).

- Integrate Swagger for php

- Integrate Laravel Nova :)
 
[DEVELOPEMENT]

- Mockery

- Pact
 
[composer.json]

- Rename "autoload" namespace from "AriStasisApp" to something better

- Move test frameworks to require-dev
 
[Asterisk]

- Restrict origin of ARI to localhost.
  
  - Add this to 'origin' header in AriWebSocketClient
 
[RabbitMQ]

- What if someone is already in a call and has to be pushed into a conference that exists elsewhere?
  
  - Have a deeper thought about bridging via ARI to another asterisk (in a cluster)

## Contributing
Feel free to send us a message! :) We'd love to hear from you and get to know your applications and use cases.

lukas@ng-voice.com or rick@ng-voice.com