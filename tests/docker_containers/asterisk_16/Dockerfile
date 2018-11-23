FROM debian:9.6
RUN cd /etc && mkdir asterisk
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
COPY ./asterisk_config.sh /etc/asterisk
RUN cd /etc/asterisk && bash ./asterisk_config.sh
CMD asterisk