This code sample was developed localy on a pc using wamp.

--------------- PROJECT ---------------
The project root directory is called angiestropp and should be placed in the
wamp www directory.

The project root path should look something like this:
C:\wamp64\www\angiestropp

The project root directory (angiestropp) should contain the following folders
and files:
classes					(folder)
  - DB.php				(file)
  - Functions.php		(file)
css						(folder)
  - style.css			(file)
ini						(folder)
  - config.ini			(file)
js						(folder)
  - ajax.js				(file)
  - jquery-3.3.1.min.js (file)
sql						(folder)
  - angiestropp.sql 	(file)
  - user.sql			(file)
hierarchy.php			(file)
index.php				(file)
README.txt				(file)
save-changes.php		(file)


--------------- DATABASE ---------------
Create a database called 'angiestropp'
Import the tables and data using import angiestropp.sql
Import the user for the database using import user.sql
Both files can be found in the angiestropp/sql/ folder

NOTE: if there are any database or user changes, the /ini/config.ini file will
need to be updated accordingly.

------------ RUN THE INTERFACE -----------
Once the database and database user have been created and populated & the
project root folder has been placed into the www directory, you are ready to go.

Make sure to start the wamp server and confirm that all services are running.
Now go to your browser and  enter the following url:
http://localhost/angiestropp/
to open the interface

Cheers