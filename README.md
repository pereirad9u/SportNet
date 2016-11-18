
###Projet SportNet

Platform to manage sport event.


# Table of content

- [Requirements](#requirements)
- [Install](#install)
- [Features](#features)
- [Login user test](#login-user-test)
- [Creators](#creators)
- [Licence](#licence)


  
###Requirements:
- PHP 5.5 or newer
- PDO PHP Extension
- MYSQl	


###Install
You can manually install by cloning this repo

`$ git clone git@github.com:pereirad9u/SportNet.git`

Configuration file located in folder `config`, edit the database.php file.

Create a new Database named sportnet ,

Import sportnet.sql in `BDD`, in your Database

Run Server  `php -S localhost:8000 -t public` in the root of the project

and go enjoy on SportNet

###Features

- Sign in / Log in as user and organiser
- Create event and trial as organiser
- Sign to an trial as user
- Search event with filters
- Profil as user and organiser
- See profil to other organiser and user to see him score
- Create group of user to sign in all together at a trial
- Choose to payed now or add in basket to payed later
- Upload result of all trial from our event as organiser
- Download participants' list from our event as organiser
- See result of all trial
- Update our event as organiser
- Close trial's sign in of our event as organiser
- Suggest trials in user profil in relation to him preferred disciplines

###Login user test

To test all features quickly we have include a user with pics already post, comments and likes and follows.

for User :
Username : postel@email.user
Pass : Postel5u

for Organiser :
Username : postel@email.org
Pass : Postel5u

###Creators

- LAUNAY Guillaume https://github.com/launay12u
- PEREIRA Alexendre https://github.com/NickMyName
- PIERRE Alexandre https://github.com/pierre121u
- POSTEL Romain https://github.com/postel5u

### Licence

This project is under gnu / gpl license for more information see <http://www.gnu.org/licenses/>






