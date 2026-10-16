Requirements
Composer installeren in WSL.
PHP 8.4 versie is nodig.

sudo apt install mysql-server
sudo apt install apache2
sudo apt-get install php-mbstring    
sudo apt install php-xml
sudo apt-get install php-gd    
sudo a2enmod rewrite



Maak een clone van Github
Eerst naar de www map in WSL navigeren.

cd /var/www/
en daarna moet je de clone commando runnen: 
git clone git@github.com:GildeOpleidingen/EasyEvent.git


Config file aanmaken/aanpassen
Ten eerste moeten we een config file kopie maken:
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/easyevent.conf


Daarna moeten we de config file aanpassen:
sudo nano /etc/apache2/sites-available/easyevent.conf


Je zou dit moeten zien in het config bestand:

<VirtualHost *:80>
  ...
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
   ...
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>


En dat moet je veranderen naar:

<VirtualHost *:80>
  ...
    ServerAdmin admin@easyevent
    ServerName easyevent
    ServerAlias easyevent
    DocumentRoot /var/www/easyevent
    ...
</VirtualHost>


Activeer de config file:
sudo a2ensite easyevent.conf


Test of alles goed werkt:
sudo apache2ctl configtest


Als alles goed is, zou je dit terug moeten krijgen:
. . .
Syntax OK


Herstart apache2 om de wijzigingen in werking te stellen:
sudo systemctl restart apache2


Voeg de host toe in system32:

Ga naar system32/drivers/etc en open het bestand hosts, voeg dit toe en sla op:

127.0.0.1 easyevent
::1 easyevent


Tot slot installeer je composer in de map waar easyevent zich bevindt:
cd /var/www/EasyEvent
composer install


Geniet ervan!

Credentials
Database gebruiker
Naam: easyevent_user
Wachtwoord: jsKU]ptclOSJ5ziA