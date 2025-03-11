# Manejo-De-Incidentes

Moving files to be executed {
sudo mv * /var/www/html/

cd /var/www/html/

sudo chown www-data:www-data *

sudo chmod 755 *    // for permissions

ls -la
}

cat /var/log/apache2/error.log      // to see error logs

should there be a status besides in process and concluded that is something like paused or postponed

When an account is made, should an email have to be set, should it be optional or should it not be an option at all? Conclusion: If you have an account, you can create an account. Redirect to register.php from index.php or integrated into index.php.

when a user tries to log into the same account incorrectly multiple times, the delay to try to log in again has to be longer.
The bruteforce protection has to control both ip and account name, because the ip of the user logging in can be changed, but the name can't.

when creating a user, should register.php redirect to login.php or stay in register.php

To-Do List:
    index.php:
    visual components (after functionality of everything index.php connects to)

    registeration:
    visual components (after functionality is finished)

    login:
    blocking brute-force attacks
    login input values erased when logging in

    search bar:
        back function for search (in consideration/ask adrian)
        search stays when page is data is sent to the db (postponed or cancelled)
        currently selected incident stays when data is sent to the db (postponed or cancelled)
