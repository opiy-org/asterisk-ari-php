Inspired by the phpari library. Mainly refactored it using non-deprecated libraries.

`Tested and implemented for Asterisk 16!` 

# Asterisk Setup

You have to set up http.conf and ari.conf on your asterisk instance first.

http.conf
- You have to enable the http server here.
- Copy bindaddr and bindport to the asterisk.ini in this library

ari.conf
- Enable the ARI here -> "enable=yes"
- Please make sure you enable the pretty human readable format for the ARI events -> "pretty=yes"
- Configure a user, password
- Copy \[user] and bindport to the asterisk.ini in this library

 !!! NEVER, we repeat, NEVER commit these settings to your (git) repository. 
 It makes your repository and live servers insecure!!!

To build your own stasis applications, simply build your own class and inherit from BasicStasisApp.
That's about it!
For further information on functions etc. read the Documentation phpDoc (link)

And ontop of that, thanks to the awesome people from php-amqplib, you can use whatever implements the AMQP. 
You are not depending on RabbitMQ (although it is tested with that)!

Feel free to send us a message! :) We'd love to hear from you and get to know your applications and use cases.

lukas@ng-voice.com or rick@ng-voice.com

# Examples

# Todos
Possible TODO's if you want to contribute but don't have an own idea:
- Add https / wss support, using what asterisk is already providing. Write down how to use it in this README 
for noobies :)