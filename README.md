# Manejo-De-Incidentes
sudo mv * /var/www/html/

cd /var/www/html/

sudo chown www-data:www-data *

sudo chmod 755 *    // for permissions

ls -la

cat /var/log/apache2/error.log      // to see error logs

should there be a status besides in process and concluded that is something like paused or postponed

When an account is made, should an email have to be set, should it be optional or should it not be an option at all? Conclusion: If you have an account, you can create an account. Redirect to register.php from index.php or integrated into index.php.

To-Do List:
    index.php:


    registeration:
    stop page reloading from redirecting to login.php
    minimum character requirement for username and pwd
    visual components

    login:
    blocking brute-force attacks

    search bar:
        back function for search (in consideration/ask adrian)
        search stays when page is data is sent to the db (postponed or cancelled)
        currently selected incident stays when data is sent to the db (postponed or cancelled)
