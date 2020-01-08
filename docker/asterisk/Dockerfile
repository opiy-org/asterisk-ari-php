FROM debian:latest
ARG asterisk_version=16.7.0

LABEL maintainer="Lukas Stermann <lukas@ng-voice.com>"
LABEL Description="This is an Asterisk 16 image, configured to work with ARI"
LABEL Vendor="ng-voice"
LABEL Version="${asterisk_version}"

# Make debian frontend noninteractive, so we don't get errors while building
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
WORKDIR /tmp

RUN apt-get update
RUN apt-get install -y apt-utils
RUN apt-get update
RUN echo 'Y' | apt-get upgrade
RUN apt-get install -y wget

RUN wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-${asterisk_version}.tar.gz
RUN tar -zxvf asterisk-${asterisk_version}.tar.gz && rm asterisk-${asterisk_version}.tar.gz

WORKDIR /tmp/asterisk-${asterisk_version}/contrib/scripts
RUN echo 'Y' | ./install_prereq test
RUN echo 'Y' | ./install_prereq install
#RUN echo 'Y' | ./install_prereq install-unpackaged
# Should be run for self signed certificate (e.g. more secure WebRTC for browsers)
# https://wiki.asterisk.org/wiki/display/AST/Configuring+Asterisk+for+WebRTC+Clients
#RUN echo 'Y' | ./ast_tls_cert

# Asterisk modifications to use WebRTC
WORKDIR /tmp/asterisk-${asterisk_version}
RUN ./configure --with-jansson-bundled
# TODO: Hand over some compiling flags, because right now this container has to be built locally
#  and depends on the hardware on which Asterisk is compiled.
RUN make
RUN make install
# Install sample asterisk conf files
RUN make samples
# Installs an initscript that starts asterisk when starting the server and monitors it.
# This script starts Asterisk when your server starts, will monitor the Asterisk process
# in case anything bad happens to it, and can be used to stop or restart Asterisk as well
RUN make config
# Smarter and compiled logs in asterisk
RUN make install-logrotate

# Default configurations are copied into the container
COPY ari.conf /etc/asterisk/
COPY http.conf /etc/asterisk/
COPY sorcery.conf /etc/asterisk/
# TODO: This operation is not working at the moment!
#COPY modules.conf /etc/asterisk/
COPY docker-entrypoint.sh /tmp
WORKDIR /tmp
RUN rm -rf ./asterisk-${asterisk_version}
RUN chmod +x docker-entrypoint.sh

# Exposing the default ARI HTTP Port
EXPOSE 8088
EXPOSE 5060

# TODO: Healthcheck doesn't work. Has to be edited.
HEALTHCHECK CMD pidof asterisk || exit 1

WORKDIR /etc/asterisk
ENTRYPOINT /tmp/docker-entrypoint.sh
