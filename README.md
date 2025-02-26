# Stappen folder aanmaken in nginx
eerst genereer je een ssh key die je in gitlab gooit in het project.
ssh-keygen -t ed25519 -C "Naam.Achternaam@student.gildeopleidingen.nl"
druk overal op enter op alle vragen (of yes als er om gevraagd word)

hier vraag je de ssh key op en kopieer je ALLES wat je terug krijgt, verander naam voor de naam in de folder die .ssh heeft aangemaakt
cat /home/Naam/.ssh/id_ed25519.pub
dan kan je dit kopieren in gitlab in easyevents bij ssh key toevoegen.

eerst maak je de folder aan MITS JE DEZE FOLDER NOG NIET HEBT
sudo mkdir /var/www/easyevents

nu verander je de eigenaar zodat je dadelijk mag clonen als je dit niet doet krijg je een error
sudo chown -R $USER:$USER /var/www/easyevents

# Maak een clone vanuit Gitlab
Let op dat je op gilde 1.09 zit anders mag je geen verbinding maken met git server op school!
git clone git@gitlab.gdcs.gildedevops.it:evenement/evenementen-app.git /var/www/easyevents/.

# Database fixes
```diff
- HIGH PRIORITY!
```



# Credentials

```

 
