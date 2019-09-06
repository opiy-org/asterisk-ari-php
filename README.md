# Asterisk REST Interface (ARI) Client :telephone:

The simple REST Client to communicate with the Asterisk REST Interface. 

The idea of this client library is to make ARI calls safe and easy. 
Therefore, we wanted to get rid of 
JSON parsing in our application code. Instead, we aim to make it as easy as possible 
for anyone to talk to ARI without 
worrying about an implementation of a client stub. We already did the work for you :)

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

## Prerequisites
Download and install composer from the following link

https://getcomposer.org/download/

## Installing

##### Composer
Please run following command to add the library in your project

`composer require ng-voice/asterisk-ari-client`

While installing, you might run into composer errors concerning missing php extensions.
There are several ways to install them, depending on your operating system (e.g. `apt install php7.3-http`).

##### Asterisk
You will have to start an Asterisk instance and configure it in order to use ARI.
The official Asterisk documentation shows you how to do so. 

https://wiki.asterisk.org/wiki/display/AST/Asterisk+Configuration+for+ARI

Alternatively use our Dockerfile to fire up Asterisk from Deployment section below.

## Examples

#### REST Clients
Talk to your asterisk instance by the given RestClients.
All requests and responses are mapped onto objects that are easy to understand.

Following example originates a call using the Channels resource of the
Asterisk REST Interface.

    /* Call the ng-voice office number */
    
    $ariChannelsRestClient = new Channels(
        new AriRestClientSettings('asterisk', 'asterisk')
    );
        
        try {
            $ariChannelsRestClient->originate('PJSIP/494052475930');
        } catch (AsteriskRestInterfaceException $e) {
            $this->logger->error($e->getMessage());
        }

#### Web socket client

Connects to Asterisk and subscribes to a 
Stasis application running on your Asterisk instance. Following example shows 
how to define a function and handle the certain event. 


In this case we are handling a `ChannelHangupRequest` event.
    
    /**
     * Write your own Stasis application class that must implement the
     * StasisApplicationInterface.
     */
    class MyExampleStasisApplication implements AsteriskStasisApplication {
        /*
         * Define a function named after the occuring Asterisk event you want to handle.
         *
         * This event is triggered for channels that have been hung up.
         *
         * @param ChannelHangupRequest $channelHangupRequest The Asterisk event
         */     
        public function channelHangupRequest(ChannelHangupRequest $channelHangupRequest): void
        {
            echo 'This is the default hangup handler triggered by channel '
                . "'{$channelHangupRequest->getChannel()->getId()}' :-)";
        } 
    }

    $ariUser = 'asterisk';
    $ariPass = 'asterisk';
        
    // Initialize your Stasis application
    $ariRestClientSettings = new AriRestClientSettings($ariUser, $ariPass);

    $myExampleStasisApplication = new MyExampleStasisApplication();
    
    // Inject dependencies into your web socket client object
    $ariWebSocket = new WebSocketClient(
        new WebSocketSettings($ariUser, $ariPass),
        $myExampleStasisApplication,
        new AriFilteredMessageHandler(
            $myExampleStasisApplication,
            new Applications($ariRestClientSettings)
        )
    );
    
    // Start the web socket client
    $ariWebSocket->start();


You can find a detailed example in the `examples` directory.


## Running the tests

Please run the following:

`composer test`

Don't worry about the mocked exception messages, which are logged as error messages :)

### Coding style tests

Please run this for code sniffing

`composer lint `

Please run this for static code analysis

`composer sca`

## Deployment

We added the Dockerfile in the `docker/asterisk/` directory where you can also find some 
example configuration files for your own Asterisk instance.

Preferably use the provided Dockerfile in this library to compile your own 
Asterisk container.
    
    cd docker/asterisk
    docker build -t --build-arg asterisk_version=16.2.1 asterisk:latest .
    docker run -d --name some-asterisk -p 8088:8088 -p 5060:5060 -p 5060:5060/udp asterisk:latest

    !!! PLEASE NOTE !!!
    Compiling Asterisk sometimes is bound to the hardware you are compiling it on.
    Right now we compile an own container for every machine we run Asterisk on,
    to make sure it will work.
    Alternatively you can set generic compiler flags at your own risk.

## Licence

##### MIT © ng-voice GmbH (2019)

![](images/ng-voice-logo.png)

## Contact
ng-voice is happy to help! Feel free to send us a message.
We'd also like to hear about your application ideas and use cases :)

Lukas Stermann (lukas@ng-voice.com)
Ahmad Hussain  (ahmad@ng-voice.com)