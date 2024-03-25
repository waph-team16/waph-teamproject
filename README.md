# README.md Template

*NOTE*: _This is just a tentative template for your team to start working on sprint 0. It is a minimum requirement for your project's final report and can be updated later.
Your team can revise/add more sections; however, it is highly recommended that you seek approval from the instructor for a pull request._

# WAPH-Web Application Programming and Hacking

## Instructor: Dr. Phu Phung

# Project Topic/Title : Mini Facebook

# Team members

1. Sohan Chidvilas Bodapati, bodapass@mail.uc.edu
2. Maheedhar Atmakuru, atmakuma@mail.uc.edu
3. Bhanu Suraj Kurella, kurellbj@mail.uc.edu

# Project Management Information

Source code repository (private access): <https://github.com/waph-team16/waph-teamproject>

Project homepage (public): <https://waph-team16.github.io>

## Revision History

| Date       |   Version     |  Description |
|------------|:-------------:|-------------:|
| 24/03/2024 |  0.0          | Init draft   |


# Overview

The project entails the development of a mini Facebook application from the ground up, employing a three-tier architecture for robustness and scalability. The frontend interface is constructed using HTML, CSS, and JavaScript to provide an engaging user experience. Meanwhile, PHP serves as the backend language, handling core functionalities such as user authentication, account management, and post operations. The MySQL database underpins the application, storing user data, posts, and chat messages.

Functionality-wise, the application encompasses essential features expected from a social networking platform. Users can register new accounts and securely log in, while superusers possess the authority to disable and enable accounts as needed. Account management extends to post operations, allowing regular users to delete their own posts but not those made by others. Moreover, robust security measures are implemented, including CSRF attack prevention to safeguard against unauthorized post deletions. Access control mechanisms ensure that user privileges are appropriately enforced, with superuser-exclusive functionalities inaccessible to regular users. Additionally, real-time chat functionality fosters seamless communication among logged-in users, enhancing the overall social experience.

In summary, the mini Facebook application is a comprehensive solution designed to provide users with a familiar social networking environment while prioritizing security, usability, and functionality. By leveraging a three-tier architecture and employing a stack comprising HTML, CSS, JavaScript, PHP, and MySQL, the application aims to deliver a seamless and enjoyable social networking experience

# System Analysis

### Problem Definition:
The primary problem the mini Facebook application aims to address is providing users with a platform to connect and interact socially. This involves facilitating user registration and login processes, enabling users to manage their accounts effectively, allowing users to create and delete posts, implementing real-time chat features, and ensuring secure access control to different functionalities based on user roles.

### System Modeling:
Various modeling techniques are employed to represent the system's structure, behavior, and interactions. Use case diagrams depict the various user interactions and system functionalities. Entity-relationship diagrams illustrate the relationships between different entities such as users, posts, and messages. Data flow diagrams visualize the flow of data within the system, highlighting key processes and data transformations.

### Security implementation:
In the mini Facebook project, a comprehensive security strategy is implemented to counter common threats like SQL injection and cross-site scripting (XSS) attacks. This strategy includes rigorous input validation to ensure user inputs adhere to expected formats and ranges, effectively thwarting SQL injection attempts. Parameterized queries are employed to separate data from instructions within SQL queries, bolstering defense against SQL injection. User-generated content undergoes thorough output encoding to neutralize malicious scripts, mitigating XSS vulnerabilities. Secure session management techniques are employed to prevent session hijacking and maintain session integrity. Additionally, user passwords are securely hashed using strong cryptographic algorithms like bcrypt before storage, enhancing overall system security and preventing unauthorized access. These measures collectively form a robust defense mechanism, safeguarding the mini Facebook application and its users from potential security risks.

## High-level Requirements

1. User registration functionality allowing individuals to create new accounts.
2. User login functionality for registered users to access their accounts securely.
3. Account management system enabling superusers to disable and enable user accounts as needed.
4. Post management features allowing users to delete their own posts while preventing deletion of others' posts.
5. Implementation of real-time chat functionality facilitating instant communication between logged-in users.
6. Robust security measures including prevention of SQL injection and cross-site scripting (XSS) attacks.
7. Detection and prevention of CSRF attacks to safeguard against unauthorized actions initiated by malicious third parties.
8. Access control mechanisms ensuring that regular users cannot access functionalities reserved for superusers.

## Use-Case Realization

In this Sprint-0 we a focusing on groundwork for out team project by configuring HTTPS , database and github repositories. As part of Login system migration from lab3 and lab4 to Mini project. We deployed our login application related files like form.php , index.php , logout.php into our new setup  and tested it


## Database 

As a part of database design for our Mini facebook project we utilized the entity diagram given in lecture-18 and created two sql scripts namely database-acount.sql and database-data.sql.

Database-accoutn.sql file is responsible for Database and user creation in MYSQL. Database-data.sql file is used to create tables like Users, Messages with its entities and relationships. We also created two relationships between users and messages they are Sends and receives.

Entity diagram :

![Database entity diagram](images/dbentity.jpg)

Source code : database-account.sql

```
create database waph_team;
 CREATE USER 'waph_team16'@'localhost' IDENTIFIED BY  'Pa$$w0rd';
 GRANT ALL ON waph.* TO 'waph_team16'@'localhost';
 ```

source code : database-data.sql

```
-- Create the users table
create table users(
 username varchar(50) PRIMARY KEY,
 password varchar(100) NOT NULL);
 INSERT INTO users(username,password) VALUES ('admin',md5('MyPa$$w0rd'));

-- Create the messages table
CREATE TABLE messages (
    message_ID INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT,
    type VARCHAR(20),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sender_username VARCHAR(50),
    FOREIGN KEY (sender_username) REFERENCES users(username)
);

-- Create the sends relationship table
CREATE TABLE sends (
    message_ID INT,
    sender_username VARCHAR(50),
    PRIMARY KEY (message_ID),
    FOREIGN KEY (message_ID) REFERENCES messages(message_ID),
    FOREIGN KEY (sender_username) REFERENCES users(username)
);

-- Create the receives relationship table
CREATE TABLE receives (
    message_ID INT,
    receiver_username VARCHAR(50),
    PRIMARY KEY (message_ID, receiver_username),
    FOREIGN KEY (message_ID) REFERENCES messages(message_ID),
    FOREIGN KEY (receiver_username) REFERENCES users(username)
);

GRANT ALL ON messages TO 'waph_team16'@'localhost';
GRANT ALL ON sends TO 'waph_team16'@'localhost';
GRANT ALL ON receives TO 'waph_team16'@'localhost';
```

## User Interface

Each member of the team successfully configured the setup in their local machine and tested it successfully. Also provided the testing screenshots below

![SSL certificate created for the team project](images/sslcert.jpg)

![Maheedhar HTTPS configuration test](images/atmakumatest.jpg)

![Sohan Bodapati HTTPS configuration test](images/sohantest.jpg)

![Bhanu Suraj HTTPS configuration test](images/sohantest.jpg)

# Security analysis

_Include a brief explanation of your implementation and the security aspects based on the following questions:_

*  How did you apply the security programming principles in your project?
*  What database security principles have you used in your project?
*  Is your code robust and defensive? How?
*  How did you defend your code against known attacks such as XSS, SQL Injection, CSRF, Session Hijacking
*   How do you separate the roles of super users and regular users?

# Demo (screenshots)

In this Sprint-0 we successfully tested the login page of our mini facebook application 

![User Login Page](images/loginform.jpg)

![Admin User Sucessfull login](images/loginsuccess.jpg)

![Invalid user Login Failed](images/invaliduserattempt.jpg)

# Software Process Management

1. Agile software development approach, primarily utilizing the Scrum framework for project management.
2. Sprint 0 focused on collaboration and task division among team members.
3. Member-1 created repositories in GitHub to ensure structured version control and collaboration.
4. Member-2 generated SSL keys and updated the repository, prioritizing security measures.
5. Member-3 contributed by writing SQL scripts for database design and uploading them to the GitHub repository.
6. Individual setup tasks included configuring local machines with HTTPS and integrating SSL keys for secure communication.

Result: Establishment of essential project foundations and streamlined development processes for subsequent sprints.

## Scrum process

### Sprint 0

Duration: DD/MM/YYYY-DD/MM/YYYY

#### Completed Tasks: 

1. Github Repositories Setup
2. SSL key generation and HTTPS Setup
3. Team database Setup and Script management
4. Login System Code migration and testing

#### Contributions: 

1. Member 1, x commits, y hours, contributed in xxx
2. Member 2, x commits, y hours, contributed in xxx
3. Member 3, x commits, y hours, contributed in xxx

#### Sprint Retrospection:

_(Introduction to Sprint Retrospection:

_Working through the sprints is a continuous improvement process. Discussing the completed sprint can improve the next sprint walk through a much more efficient one. Sprint retrospection is done once a sprint is finished and the team is ready to start another sprint planning meeting. This discussion can take up to 1 hour depending on the ideal team size of 4 members. 
Discussing good things that happened during the sprint can improve the team's morale, good team collaboration, appreciating someone who did a fantastic job solving a blocker issue, work well-organized, and helping someone in need. This will improve the team's confidence and keep them motivated.
As a team, we can discuss what has gone wrong during the sprint and come up with improvement points for the next sprints. Few points can be like, need to manage time well, need to prioritize the tasks properly and finish a task in time, incorrect design lead to multiple reviews and that wasted time during the sprint, team meetings were too long which consumed most of the effective work hours. We can mention every problem is in the sprint which is hindering the progress.
Finally, this meeting should improve your next sprint drastically and understand the team dynamics well. Mention the bullet points and discuss how to solve it.)_

| Good     |   Could have been better    |  How to improve?  |
|----------|:---------------------------:|------------------:|
|          |                             |                   |

# Appendix

Include the content (in text, not as images) of the SQL files and all source code of your PHP files (with the file name). 