Fetch Glass Timeline Items
=============================
This code shows how to fetch shared timeline cards from your user's Glass

It is intended as a complement to my tutorial:
http://20missionglass.tumblr.com/post/70635819823/fetch-glass-timeline-items

Configuration
--------------
Set up an OAuth2 Client App in the Google Code Console:
https://code.google.com/apis/console/

Once you register an app, create  you will get a client id and client secret. 
You will also need to create a Browser API Key for the Google Maps API.  

Edit your settings.php to reflect your oauth2 client app's settings.

$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';



Now you should be good to go.


