Simple photoapp which let users upload their geotagged photos and place them on a map when showing. The app is just a basic app which could easily be extended for more functionality. For example, instead of uploading photos it could search instagram for photos instead.

Uses a heavy javascript frontend and light PHP + MySQL as backend. The backend is exposed as a REST web service.

If you use this project as a base I would really like to hear from you!

Demo
====
Check the wiki pages for some images from the application, unfortunately I can't host the demo online.

Install
=======

+ Put all files in a folder in your local web server, I'm using Apache.
+ Change the connection details for MySQL in class/DBAL.php, line 16.
+ Run the dump.sql query in MySQL to import all tables.
+ Login using example@example.com/abc123

Dependencies
============ 

Front-end (included)
jQuery
Underscore
Backbone
https://github.com/cmlenz/jquery-iframe-transport

Back-end (included):
Tonic REST Framework
https://github.com/peej/tonic

API
Google maps:
https://developers.google.com/maps/documentation/javascript/reference