# Manejo-De-Incidentes

Moving files to be executed {
sudo mv * /var/www/html/

cd /var/www/html/

sudo chown www-data:www-data *

sudo chmod 755 *    // for permissions

ls -la
}

cat /var/log/apache2/error.log      // to see error logs

when a user tries to log into the same account incorrectly multiple times, the delay to try to log in again has to be longer.
The bruteforce protection has to control both ip and account name, because the ip of the user logging in can be changed, but the name can't.


To-Do List:
    server:
        migrate servers (apache and mariadb) from XAMPP to a permanent server