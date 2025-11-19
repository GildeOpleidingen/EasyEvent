# Requirements
Composer installeren in WSL.
PHP 8.4 versie is nodig.

sudo apt install mysql-server
sudo apt install apache2

sudo apt-get install php-mbstring	
sudo apt install php-xml
sudo apt-get install php-gd	

Sudo a2enmod rewrite

Maak een VHOST aan voor Easyevent
Voeg dit toe.
    Dit gaat ervanuit dat de repo  in /var/www/easyevents is geplaatst.
    Dit zorgt ervoor dat er voor het easyevent project naar .htaccess word gekeken.
    <Directory /var/www/easyevents>
        AllowOverride All
        Require all granted
    </Directory>


# Stappen folder aanmaken in nginx
```eerst genereer je een ssh key die je in gitlab gooit in het project.
ssh-keygen -t ed25519 -C "Naam.Achternaam@student.gildeopleidingen.nl"
druk overal op enter op alle vragen (of yes als er om gevraagd word)

hier vraag je de ssh key op en kopieer je ALLES wat je terug krijgt, verander naam voor de naam in de folder die .ssh heeft aangemaakt
cat /home/Naam/.ssh/id_ed25519.pub
dan kan je dit kopieren in gitlab in easyevents bij ssh key toevoegen.

eerst maak je de folder aan MITS JE DEZE FOLDER NOG NIET HEBT
sudo mkdir /var/www/easyevents

nu verander je de eigenaar zodat je dadelijk mag clonen als je dit niet doet krijg je een error
sudo chown -R $USER:$USER /var/www/easyevents
```

# Maak een clone vanuit Gitlab
```Let op dat je op gilde 1.09 zit anders mag je geen verbinding maken met git server op school!
git clone git@gitlab.gdcs.gildedevops.it:evenement/evenementen-app.git /var/www/easyevents/.
```

# Database fixes
```diff
- HIGH PRIORITY!
```



# Credentials
Database user
Naam: easyevent_user
Wachtwoord: jsKU]ptclOSJ5ziA

 
