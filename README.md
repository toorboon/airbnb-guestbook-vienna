## About airbnb Guestbook

The Guestbook is written with Laravel PHP and some Javascript so it doesn't look to ugly. 
I planned to get rid of the tedious paper based guestbook you are required to keep 
if you are hosting here in Vienna. The requirements from the city got implemented as stated here:

- [Requirements](https://www.wien.gv.at/amtshelfer/wirtschaft/gewerbe/meldepflicht/tourismus/gaeste/gaesteverzeichnis.html).

The general workflow looks like this:
- Booking at airbnb is confirmed (you are going to have a guest)
- You are asking the guest for an email address
- Got the email?
- **\[Yes]** Create a guest user in your app and invite the guest
    - The guest gets an email and will register guests and fellows for the stay (with signature)
- **\[No]** When the keys are handed over, tell the guest it is mandatory to register on your 
mobile phone (you are admin then)

## Anything to keep in mind while setting up?

If you want to host the software yourself you have to have a SMTP server ready for the outbound e-mails. 
Just configure your .env file accordingly 
(be sure your MAIL_FROM_NAME is the same as the email from your first admin user).

## If you are updating from v0.9-alpha to v1.0

You should keep in mind that the session driver was changed (switch this in your .env file). This also 
means you have to create a session table in your app, or it won't work properly 
(you can read about it [here](https://laravel.com/docs/7.x/session#driver-prerequisites)). 
Those who set up the app anew don't have that problem because a Laravel migration is included.

## License

The whole thing is open source and published under AGPL v3 (please check the licencse.txt for further information). 
If you need somebody to host the software just contact me, and I'm quite sure we can arrange something on my webhosting. 

## Support

Even though I cannot provide any support (this is just a hobby!), I would really like to know what you believe 
should be different in the app. If I have time, and I am in a good mood I might change this or that, feel free to ask. :) 
You can contact me via the issue ticker, or you can visit my profile page:

- [Profile page](https://www.marcohaefner.de).

## If you like the app

Please consider making a donation if you can really use this app or if it saves you some time. :) 

