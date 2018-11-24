FROM mysql
LABEL maintainer="Lukas Stermann <lukas@ng-voice.com>"
LABEL Description="This is an Asterisk 16 image, configured to work with ARI"
LABEL Vendor="ng-voice"

# Add a database
ENV MYSQL_DATABASE asterisk
ENV MYSQL_ROOT_PASSWORD lumen

# Add the content of the sql-scripts/ directory to your image
# All scripts in docker-entrypoint-initdb.d/ are automatically
# executed during container startup
COPY ./sql-scripts/ /docker-entrypoint-initdb.d/