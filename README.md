# Manejo-De-Incidentes
sudo mv * /var/www/html/

cd /var/www/html/

sudo chown www-data:www-data *

sudo chmod 755 *    // for permissions

ls -la

cat /var/log/apache2/error.log      // to see error logs

should there be a status besides in process and concluded that is something like paused or postponed

select * from logs where hostname like "dyna-automocion-5"

To-Do List:
    login:
        login page
        allow use of program if(loggedIn = true)

    search bar:
        back function for search
        last search 
        search stays when page is reloaded/data is sent to the db
        currently selected incident stays when page is reloaded/data is sent to the db
