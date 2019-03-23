# Asterisk REST Interface (ARI) Client :telephone:
> Grab yourself some coffee and save plenty of time with this object oriented ARI client library. 
Keeping your code nice and clean. Taking care of easy REST calls to Asterisk. Handling incoming messages for you
while you focus on developing your Stasis apps.

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=alert_status)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=security_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=sqale_index)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=ncloc)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ngvoice_asterisk-ari-client&metric=coverage)](https://sonarcloud.io/dashboard?id=ngvoice_asterisk-ari-client)

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)

![](images/AriClientSketch.png)

## Installation
Install composer and include this library into your project

`composer require ng-voice/asterisk-ari-client`

While installing, you might run into composer errors concerning missing php extensions.
There are several ways to install them, depending on your operating system (e.g. `apt install php7.3-http`).

Don't forget to restart your apache server after installing the extensions.

##### Asterisk
You will have to start an Asterisk instance and configure it in order to use ARI.
The official Asterisk documentation shows you how to do so. 
Alternatively use the provided Dockerfile in the docker directory as described below.

## Features
#### ARI abstraction layer
The idea of this client library is to make ARI calls safe and easy. Therefore I wanted to get rid of 
JSON parsing in my application code. Instead I aim to make it as easy as possible for anyone to talk to ARI without 
worrying about an implementation of a client stub. I already did the work for you :)

#### REST Clients
Talk to your asterisk instance by the given well documented HTTP clients.
All requests and responses are mapped onto objects that are easy to understand.

#### Web socket client
Connects to Asterisk via `GET /events` and subscribes either to one, many or all stasis applications running on your 
Asterisk instance.

#### Asynchronous stasis application principle
Simply extend the BasicStasisApp and implement your own stasis app logic (have a look at the **examples** directory).
Say goodbye to boilerplate code!

#### Asterisk Docker container
Preferably use the provided Dockerfile in this library to compile your own asterisk container.
    
    cd docker/asterisk
    docker build -t --build-arg asterisk_version=16.2.1 asterisk:latest .
    docker run -d --name some-asterisk -p 8088:8088 -p 5060:5060 -p 5060:5060/udp asterisk:latest

    !!! PLEASE NOTE !!!
    Compiling Asterisk sometimes is bound to the hardware you are compiling it on.
    Right now we compile an own container for every machine we run Asterisk on,
    to make sure it will work.
    Alternatively you can set generic compiler flags at your own risk.

## How to use
Two examples can be found in the example directory.

Basically there are two possibilities to handle incoming events from Asterisk, depending on what you would like to do 
with them:

* Write a class for local event handling (like in ExampleLocalApp)
* Pass events to a remote app, e.g. if you are wrapping Asterisk with an own REST Interface
(like with example_worker_remote_app)

Now, how should we handle events, that are sent to our WebSocketClient workers?

Out of the box you can use the `LocalAppMessageHandler` (handling event objects in a local App) 
or the `RemoteAppMessageHandler` (sending events to another API) but of course you can write your own.

## Tests
`./vendor/bin/phpunit`

##Licence
MIT © ng-voice GmbH (2019)

##Contact
ng-voice is happy to help! Feel free to send me a message.
I'd also like to hear about your application ideas and use cases :)

Lukas Stermann (lukas@ng-voice.com)