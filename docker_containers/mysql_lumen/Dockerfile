FROM mysql:latest
MAINTAINER Lukas Stermann <lukas@ng-voice.com>

RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
WORKDIR /tmp

RUN apt-get update