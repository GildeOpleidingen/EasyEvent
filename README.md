# Requirements
Composer installeren in WSL.
PHP 8.4 versie is nodig.

hier vraag je de ssh key op en kopieer je ALLES wat je terug krijgt, verander naam voor de naam in de folder die .ssh heeft aangemaakt
cat /home/Naam/.ssh/id_ed25519.pub
dan kan je dit kopieren in gitlab in easyevents bij ssh key toevoegen.

eerst maak je de folder aan MITS JE DEZE FOLDER NOG NIET HEBT
sudo mkdir /var/www/easyevents

nu verander je de eigenaar zodat je dadelijk mag clonen als je dit niet doet krijg je een error
sudo chown -R $USER:$USER /var/www/easyevents
```

# apache
In dit project staat een .htaccess file.
Hierdoor moet je aan de configuratie van de website de volgende configuratie toevoegen.

    <Directory /var/www/EasyEvent>
        AllowOverride All
        Require all granted
    </Directory>

Het pad moet je aanpassen naar het pad waar de .htaccess file staat. Hiermee zeg je tegen apache dat die specifieke website regels moet opvolgen van de .htaccess

# Maak een clone vanuit Gitlab
```Let op dat je op gilde 1.09 zit anders mag je geen verbinding maken met git server op school!
git clone git@gitlab.gdcs.gildedevops.it:evenement/evenementen-app.git /var/www/easyevents/.
```

# Database fixes
```diff
- HIGH PRIORITY!
```bash
sudo apt install mysql-server
sudo apt install apache2
sudo apt-get install php-mbstring	
sudo apt install php-xml
sudo apt-get install php-gd	
sudo a2enmod rewrite
```


# Maak een clone van Github
Eerst naar de www map in WSL navigeren.

```bash
cd /var/www/
en daarna moet je de clone commando runnen: 
git clone git@github.com:GildeOpleidingen/EasyEvent.git
```

# Config file aanmaken/aanpassen

1. Ten eerste moeten we een config file kopie maken:
```bash
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/easyevent.conf
```

2. Daarna moeten we de config file aanpassen:
```bash
sudo nano /etc/apache2/sites-available/easyevent.conf
```

Je zou dit moeten zien in het config bestand:

```xml
<VirtualHost *:80>
  ...
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
   ...
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

En dat moet je veranderen naar:

```xml
<VirtualHost *:80>
  ...
    ServerAdmin admin@easyevent
    ServerName easyevent
    ServerAlias easyevent
    DocumentRoot /var/www/easyevent
    ...
</VirtualHost>
```

3. Activeer de config file:
```bash
sudo a2ensite easyevent.conf
```

4. Test of alles goed werkt:
```bash
sudo apache2ctl configtest
```

Als alles goed is, zou je dit terug moeten krijgen:
```
. . .
Syntax OK
```

5. Herstart apache2 om de wijzigingen in werking te stellen:
```bash
sudo systemctl restart apache2
```

6. Voeg de host toe in system32:

Ga naar `system32/drivers/etc` en open het bestand `hosts`, voeg dit toe en sla op:

```
127.0.0.1 easyevent
::1 easyevent
```

7. Tot slot installeer je composer in de map waar easyevent zich bevindt:
```bash
cd /var/www/EasyEvent
composer install
```

8. Geniet ervan!

# Credentials
**Database gebruiker**
- Naam: easyevent_user
- Wachtwoord: jsKU]ptclOSJ5ziA
