#!/usr/bin/env bash

apt-get update
apt-get install apt-utils -y
apt-get update
apt-get upgrade
apt-get install wget -y
wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-16.0.1.tar.gz
tar -zxvf asterisk-16.0.1.tar.gz
cd ./asterisk-16.0.1
cd ./contrib/scripts
apt-get install libsvn-dev -y
apt-get install subversion
apt-get install build-essential -y
./install_prereq test
./install_prereq install
./install_prereq install-unpackaged
apt-get install libedit-dev -y
apt-get install uuid-dev -y
apt-get install libxml2-dev -y
apt-get install libsqlite3-dev -y
cd ../..
./configure --with-jansson-bundled
make
make install
cd ..
rm asterisk-16.0.1.tar.gz