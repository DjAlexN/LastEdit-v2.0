# LastEdit-v2.0
The module displays the last 100 articles that have been edited

# Instrukcja po Polsku
1. W folderze "templates" zmień nazwę folderu "{THEME}" na nazwę swojego szablonu jai używasz na stronie
2. Wgraj foldery: "engine" oraz "templates" na swój serwer.
3. W Panelu Administratora w sekcji Zarządzania Wtyczami wgraj plik lastedit.xml
4. W swoim szablonie w wybranym miejscu (np w pliku main.tpl) dodaj odnośnik do podstrony która wyświetla ostatnio edytowane artykuły.
Odnośnik: twoja-strona.pl/?do=lastedit
5. W głónym pliku .htaccess na serwerze znajdź linijkę: 
RewriteEngine On

Poniżej dodaj:
RewriteRule ^lastnews(/?)+$ index.php?do=lastedit [L]

6. Gotowe :) Teraz możesz cieszyć się modułem

# English manual
1. In the "templates" folder change the name of the "{THEME}" folder to the name of your template you use on the website
2. Upload the folders: "engine" and "templates" to your server.
3. In the Administrator Panel, in the Plugins Management section, upload the lastedit.xml file
4. In your template, in the selected place (eg in the main.tpl file) add a link to the subpage that displays recently edited articles.
Reference: your-site.com/?do=lastedit
5. In the main .htaccess file on the server, look for the line:
RewriteEngine On
Add below:
RewriteRule ^ lastnews (/?) + $ Index.php? Do = lastedit [L]

6. Done :) Now you can enjoy the module
