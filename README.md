# Login and News System

## Overview

This project provides a simple login and news system. To use the system, some configuration is required.

## Installation and Configuration

1. **Database Configuration**

   To use the system, you need to adjust the database settings in the `db.php` file located in the `includes` folder. This file contains the necessary information to connect to your database.

2. **Create Database Tables**

   Create the following tables in your database to make the system fully functional:

   - **Table `news`**

     ```sql
     CREATE TABLE news (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       content TEXT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

   - **Table `user`**

     ```sql
     CREATE TABLE user (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(255) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL
     );
     ```

## Usage

After configuring the database and creating the tables, you can use the login and news system as intended.

## Additional Information

For more details on usage or to develop new features, refer to the relevant files and documentation in the project folder.
The password has to be encrypted in the database. For more information, get in contact with me.

## Support

If you have any questions or issues, you can contact us through the usual communication channels.
