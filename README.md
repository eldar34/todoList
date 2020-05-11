# INSTALLATION WITH DOCKER
Run docker-compose command
<pre>
docker-compose up --build
</pre>
Open web aplication at http://your_host:8080<br>
Open adminer for db at http://your_host:6080

# INSTALLATION
Run composer command
<pre>
composer install
</pre>

# DB Settings
Set connection with database in file .env
<pre>
DB_HOST="" //localhost
DB_NAME="" //database name
DB_USER_NAME="eldar"  //user name
DB_PASSWORD="" //password
</pre>

# DB Migrations
This command create tables in your database
<pre>
vendor/bin/phinx migrate -e production
</pre>

# DB Seeds
This command populate your database with dummy data
<pre>
vendor/bin/phinx seed:run -e production
</pre>

