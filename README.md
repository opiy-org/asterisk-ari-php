# Asterisk Ari AMQP Library

Inspired by the phpari library. Mainly refactored it using non-deprecated libraries.

`Tested and implemented for Asterisk 16!` 

## Setup
You should follow these installation steps: 
#### 1. Asterisk
You have to set up http.conf and ari.conf on your asterisk instance first.

[http.conf]

- You have to enable the http server here.

- Copy bindaddr and bindport to the asterisk.ini in this library

[ari.conf]

- Enable the ARI here -> "enable=yes"

- Please make sure you enable the pretty human readable format for the ARI events -> "pretty=yes"

- Configure a user, password

- Copy \[user] and bindport to the asterisk.ini in this library

#### 2. Other dependencies

- php7.2

We use docker containers for the following but you of course don't have to do that.

- RabbitMQ (recommended with the RabbitMQ management interface for better monitoring)

    - docker run -d -p 15672:15672 -p 5672:5672 --hostname my-rabbit --name some-rabbit rabbitmq:3-management
    
- Asterisk (either your own container or one from the official repository)

#### 3. Composer
Make sure you run `composer install` in this directory before you use the library. You might run into troubles with 
missing php extensions. Simply install them with e.g. `apt install php7.2-mbstring` (may differ depending on your 
underlying operating system.

#### 4. Tests
Before you start developing your application around your asterisk, make shure everything is up and running nicely. 
`Run the 'execute_tests.sh' script from the /tests directory`. If you have no errors, you are ready to go!

## Features
#### ARI HTTP Wrapper
To build your own stasis applications, talk to your asterisk instance by using the given http clients.
That's about it!
We believe that today microservices can easily scale with your needs. And so should your asterisk instances.
So of couse it is possible to use the asterisk rest api directly. But why, if we communicate through amqp
in our microservice universe anyway?

#### WebsocketClient
Basically connects to asterisk via `GET /events` and listens for either for one, many or all stasis application events.

### AMQP Publisher and Consumer
And ontop of that, thanks to the awesome people from php-amqplib, you can use whatever implements the AMQP. 
You are not depending on RabbitMQ (although it is recommended).
We only implemented one consumer. Most likely you will use a framework (e.g. we use Laravel)
for your wrapping asterisk application that lets you work with consumers waaaaay more easy.
Great for microservices!

#### Examples
An example of how to use the library is found in the examples directory.

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

- Have a deeper look at the RabbitMQ conventions and design of queues (names, topic, spreading messsages etc.)

- Erlang Cookie should be providable! Start a container with the cookie and make it configurable in the library

- What if someone is already in a call and has to be pushed into a conference that exists elsewhere?
  
  - Have a deeper thought about bridging via ARI to another asterisk (in a cluster)

## Contributing
Feel free to send us a message! :) We'd love to hear from you and get to know your applications and use cases.

lukas@ng-voice.com or rick@ng-voice.com

[ARIClients]

- Go through every single client class and compare to Documentation