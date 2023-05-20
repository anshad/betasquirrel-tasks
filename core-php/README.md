# Core PHP Task

A simple student management system using pure PHP and MySQL.

## PHP Installation on Windows

- Download XAMPP from and install it https://www.apachefriends.org/download.html
- Choose a drive other than "C" drive for installation to avoid permission issues.
- Add PHP to your environment variables
  - For windows 10/11, search environment variables on Windows search.
  - Click "Edit the system environment variables"
  - Click on "Environment Variables"
  - Select "Path" from "System variables" list on the bottom
  - Click on "New"
  - Then copy the path to your php installation folder inside XAMPP. (Ex: D:\xampp\php\)
  - Paste it and click "Ok"
  - Close all your terminal apps like GitBash/terminal/command prompt/power shell and open again

Note: On Windows, the root folder to place project is `xampp/htdocs`

## PHP Installation on Linux (Ubuntu)

- Run the below commands on terminal
- sudo apt update && sudo apt upgrade
- sudo apt install software-properties-common curl
- sudo apt-get install apache2
- sudo apt-get install mysql-server
- sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql php-cli php-all-dev php-cgi php-common php-curl php-gd php-gmp php-dev php-pear php-mbstring php-xml php-xmlrpc
- sudo a2enmod rewrite
- sudo systemctl restart apache2
- sudo chown -R www-data /var/www/html
- sudo chmod 777 -R /var/www/html

Note: On Linux, the root folder to place project is `/var/www/html`

## PHP Installation on Mac

- Install Homebrew by running this command on terminal `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`
- brew update
- brew install php mysql

## Running the code

- CD to the code folder where you have `index.php` file.
- Then run `php -S localhost:9001`
- Then open your browser and navigate to http://localhost:9001/
