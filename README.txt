Installation of HHIMS
Quick guide

1. Install LAMP on the PC under LINUX * 
2. Copy the directory /www/ from the CD with all its files to /var/ (producing a directory /var/www/)
3. Give this directory read privileges: sudo chmod 755 /var/www -R
4. The CD comes with a demonstration license. If you want the name of your hospital/practice to appear on the reports, apply for a license from hhims.org. This license is free. Copy the license file that you obtain from hhims.org into this directory (/www/).
5. You have to enter your information into the file: /var/www/hhims/application/config/database.php  At the top of this file there are four define commands that you will need to correct (e-mail is only used for sending out notifications - not essential). These are:

DATABASE CONNECTION INFORMATIONS
$db['default']['hostname'] = 'localhost:3306';
$db['default']['dbdriver'] = 'mysql';
ENTER THE USER NAME AND PASSWOR DETAILS HERE FOR MYSQL
$db['default']['username'] = 'mdsfqtxu_mdsfoss';
$db['default']['password'] = '20mdsFoss12';
$db['default']['database'] = 'mdsfqtxu_hhimsv2';

6. Open MySQL with the LINUX command: mysql -p
7. Create a blank database Eg: hhims.
8. Give the MySQL command: source /var/www/install/new/install.sql
9. Give the MySQL command: source /var/www/install/data/data.sql
10. Start hhims from your net browser (we recommend Google's Chrome browser) by entering the URL: 127.0.0.1
11. To log on to HHIMS as a Programmer (with all privileges) username: demo  password: 123
12. If you want to run in a local area network, give a fixed IP number to the machine with the system on it and simply type that number into the browser on the other machines.

* We recommend the operating system Ubuntu version 11.04. Installations are also available for Microsoft Windows and Apple Mac PCs - contact info@hhims.org

Note: The basic distribution does not contain the SNOMED-CT terminology. You may qualify for a copy of the SNOMED-CT terminology for use within Sri Lanka. Make a request to info@hhims.org with a brief statement on how you intend to use it.

For further information, look at our web-site: www.hhims.org