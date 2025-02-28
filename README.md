# Manejo-De-Incidentes
sudo mv * /var/www/html/

cd /var/www/html/

sudo chown www-data:www-data *

sudo chmod 755 *    // for permissions

ls -la

cat /var/log/apache2/error.log      // to see error logs

should there be an incident conclusion time

should there be a status besides in process and concluded that is something like paused or postponed

When searching for an incident by hostname or user, should it show all the related incidents or should it display the most relevant one

ask adrian about belgian exchange students

To-Do List:
    login
    search bar
    incident_status
    visual changes based on incident_status


add login: users table in db
           allow use of program if(loggedIn = true)