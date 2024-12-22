use 2022F_patpanka;
CREATE TABLE Students (

	sid int AUTO_INCREMENT NOT NULL,
	first_name VARCHAR(100) NOT NULL,
	last_name VARCHAR(100) NOT NULL,
	birthday DATE NOT NULL, 
	major VARCHAR(100) NOT NULL, 
	zipcode VARCHAR(100) NOT NULL,
	PRIMARY KEY (sid)

);

SELECT * FROM 2022F_patpanka.Students ;

CREATE TABLE Courses (
	cid VARCHAR(100) NOT NULL, 
	name VARCHAR(100) NOT NULL,
	credits int NOT NULL,
	PRIMARY KEY (cid)

);

SELECT * FROM 2022F_patpanka.Courses;