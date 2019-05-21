/*ADD the drop database tables and user code here*/

DROP DATABASE IF EXISTS microwave_info;

/*F.2 Create new intsace of the database*/
CREATE DATABASE microwave_info;

/*Set character set to UTF-8*/
ALTER DATABASE microwave_info CHARACTER SET utf8 COLLATE utf8_general_ci;

/*F.3 Delete user if exists*/
DROP USER IF EXISTS 'part1user'@'localhost';
/*F.4 create New user*/
CREATE USER 'part1user'@'localhost' IDENTIFIED BY 'Test123!';

/*F.5Grant all privileges on database*/
GRANT ALL PRIVILEGES ON microwave_info.* TO 'part1user'@'localhost';

use microwave_info;

create table file_info(
   fileID int NOT NULL AUTO_INCREMENT,
   file_name varchar(255) NOT NULL UNIQUE,
   PRIMARY KEY(fileID)
);

create table path_info(
   pathID int NOT NULL AUTO_INCREMENT,
   fileID int,
   path_name varchar(100) NOT NULL UNIQUE,
   path_length DECIMAL(4,1) NOT NULL,
   descrip varchar(255) NOT NULL,
   note text(65534), 
   PRIMARY KEY(pathID), 
   FOREIGN KEY (fileID) REFERENCES file_info(fileID)
);

create table begin_point_info(
   pointID int NOT NULL AUTO_INCREMENT,
   fileID int,
   point1 DECIMAL(4,2) NOT NULL,
   point2 DECIMAL(4,2) NOT NULL,
   point3 DECIMAL(4,2) NOT NULL,
   PRIMARY KEY(pointID), 
   FOREIGN KEY (fileID) REFERENCES file_info(fileID)
);

create table end_point_info(
   pointID int NOT NULL AUTO_INCREMENT,
   fileID int,
   point1 DECIMAL(4,2) NOT NULL,
   point2 DECIMAL(4,2) NOT NULL,
   point3 DECIMAL(4,2) NOT NULL,
   PRIMARY KEY(pointID), 
   FOREIGN KEY (fileID) REFERENCES file_info(fileID)
);

create table main_data_info(
   dataID int NOT NULL AUTO_INCREMENT,
   fileID int,
   distance DECIMAL(4,2) NOT NULL,
   ground_height DECIMAL(4,2) NOT NULL,
   terrain_type varchar(50) NOT NULL,
   obstruction_height DECIMAL(4,2) NOT NULL,
   obstruction_type varchar(50) NOT NULL,

   PRIMARY KEY(dataID), 
   FOREIGN KEY (fileID) REFERENCES file_info(fileID)
);

