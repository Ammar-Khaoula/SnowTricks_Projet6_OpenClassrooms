# SnowTricks_Projet6_OpenClassrooms

1. Web server:
    XAMPP
      	->control panel:3.33.0
      	->Apache: 2.4.5
      	->Mysql: 5.2.1
      	->PHP: 8.1.5
          
2. Css Framework + Icon toolkit
    	bootstrap : 5.1.3
    	font-awesome 4

3. Installation:
      1.	Download zip files or clone the Project repository with GitHub
      2.	Edit .env.local file

  # SQL
   DATABASE_URL="mysql://username:password@host:port/dbname"

  # Mailer ->mailtrap
  MAILER_DSN=smtp://url@sandbox.smtp.mailtrap.io:2525

4. Install packages needed
        Run your terminal at root Project
        Composer install
     
5. Create database and tables
      php bin/console doctrine:database:create
      php bin/console doctrine:migrations:migrate
