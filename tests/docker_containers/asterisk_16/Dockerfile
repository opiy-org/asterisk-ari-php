FROM debian:9.6
MAINTAINER Lukas Stermann <lukas@ng-voice.com>

RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
WORKDIR /tmp

RUN apt-get update
RUN apt-get install apt-utils -y
RUN apt-get update
RUN apt-get upgrade
RUN apt-get install wget -y
# Get Asterisk package. Reconfigure this for newer versions!
RUN wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-16.0.1.tar.gz
RUN tar -zxvf asterisk-16.0.1.tar.gz && rm asterisk-16.0.1.tar.gz

WORKDIR /tmp/asterisk-16.0.1/contrib/scripts
RUN echo 'Y' | ./install_prereq test
RUN echo 'Y' | ./install_prereq install
RUN echo 'Y' | ./install_prereq install-unpackaged

WORKDIR /tmp/asterisk-16.0.1
RUN ./configure --with-jansson-bundled
RUN make
RUN make install
# Install sample asterisk conf files
RUN make samples
# Installs an initscript that starts asterisk when starting the server and monitors it.
# This script starts Asterisk when your server starts, will monitor the Asterisk process in case anything bad happens
# to it, and can be used to stop or restart Asterisk as well
RUN make config
#Smarter and compiled logs in asterisk
RUN make install-logrotate

# Default configurations are copied into the container
COPY ari.conf /etc/asterisk/
COPY http.conf /etc/asterisk/
COPY docker-entrypoint.sh /tmp
WORKDIR /tmp
RUN chmod +x docker-entrypoint.sh
# Exposing the default ARI HTTP Port
EXPOSE 8088

WORKDIR /etc/asterisk
ENTRYPOINT /tmp/docker-entrypoint.sh