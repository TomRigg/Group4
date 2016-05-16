
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Paychecks;
DROP TABLE IF EXISTS Hours;
DROP TABLE IF EXISTS Jobs;
DROP TABLE IF EXISTS EmployeeJobs;
DROP TABLE IF EXISTS Employees;
DROP TABLE IF EXISTS Employers;
DROP TABLE IF EXISTS Users; 
DROP TABLE IF EXISTS Roles;
SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE Roles (
 roleID INT AUTO_INCREMENT,
 rolename VARCHAR(20),
 PRIMARY KEY (roleID)
 );
 
CREATE TABLE Users (
  userID INT NOT NULL AUTO_INCREMENT,
  hashedPass VARCHAR(255) NOT NULL,
  firstname VARCHAR(45) NOT NULL,
  lastname VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  role INT NOT NULL,    
  PRIMARY KEY (userID),
  FOREIGN KEY(role) REFERENCES Roles(roleID)
); 

CREATE TABLE Employees (
  employeeID INT AUTO_INCREMENT,
  name VARCHAR(40) NOT NULL,
  phoneNumber VARCHAR(15) DEFAULT NULL,
  employeeAddress VARCHAR(80) NOT NULL,
  userID INT,
  PRIMARY KEY (employeeID),
  FOREIGN KEY(userID) REFERENCES Users(userID) ON DELETE CASCADE
);

CREATE TABLE Jobs (
  jobID INT AUTO_INCREMENT,
  workAddress VARCHAR(80),
  workname VARCHAR(80),  
  PRIMARY KEY(JobID)
);

CREATE TABLE EmployeeJobs (
  ID INT AUTO_INCREMENT,
  hourlyWage DECIMAL(6,2),
  employeeID INT,
  jobID INT,
  PRIMARY KEY(ID), 
  FOREIGN KEY(employeeID) REFERENCES Employees(employeeID),
  FOREIGN KEY(jobID) REFERENCES Jobs(jobID)
);

CREATE TABLE Employers (
  employerID INT AUTO_INCREMENT,
  jobID INT,
  userID INT,
  employerAddress VARCHAR(40),
  PRIMARY KEY(EmployerID),
  FOREIGN KEY(jobID) REFERENCES Jobs(jobID),
  FOREIGN KEY(userID) REFERENCES Users(userID)
);

CREATE TABLE Paychecks (
  paycheckID int AUTO_INCREMENT,
  employeeID INT,
  jobID INT,
  checkStartDate DATE NOT NULL,
  checkEndDate DATE NOT NULL,
  hoursWorked INT(3),
  wagesEarned decimal(6,2),
  PRIMARY KEY (paycheckID),
  FOREIGN KEY (employeeID) REFERENCES Employees(employeeID)
); 

CREATE TABLE Hours (
  hoursID INT AUTO_INCREMENT,
  jobID INT,
  employeeID INT,
  paycheckID INT,
  date DATE,
  workAddress VARCHAR(80), 
  hoursWorked INT(3),
  wagesEarned decimal(6,2),
  PRIMARY KEY (HoursID),
  FOREIGN KEY (paycheckID) REFERENCES Paychecks(paycheckID),
  FOREIGN KEY (jobID) REFERENCES Jobs(jobID),
  FOREIGN KEY (employeeID) REFERENCES Employees(employeeID)
);

CREATE TABLE JobRequests (
  jobRequestID INT AUTO_INCREMENT,
  workAddress VARCHAR(80),
  workname VARCHAR(80),
  notes VARCHAR(1000),
  employeeID INT,
  PRIMARY KEY (jobRequestID),
  FOREIGN KEY (employeeID) REFERENCES Employees(employeeID)
) ;

INSERT INTO Roles (roleID, rolename) VAlUES (1, 'admin');
INSERT INTO Roles (roleID, rolename) VAlUES (2, 'user');
INSERT INTO Roles (roleID, rolename) VAlUES (3, 'nonprofit');
INSERT INTO Users (hashedPass, firstname, lastname, email, role) VALUES ('$2a$12$T1DiH775K8XZEQ6iu6iAaelTkPnYOdu20z0vK40puAz5beHzcLIOq', 'abc', 'def', 'abc@hotmail.com', 1 );
INSERT INTO Employees (userID, name, phoneNumber, employeeAddress) VALUES ('1', 'John Doe', '8675309', '123 Church St.' );

INSERT INTO Jobs (workAddress, workname) VALUES ( 'Riverside Dr.', 'Wal-Mart');
INSERT INTO Jobs (workAddress, workname) VALUES ( 'Purple Road', 'Target');
INSERT INTO Jobs (workAddress, workname) VALUES ( '123 street', 'Hyvee');

INSERT INTO Paychecks(paycheckID, employeeID, jobID, checkStartDate, checkEndDate, hoursWorked, wagesEarned) VALUES('1', '1', '1', '2013.11.22','2013.11.29', '8', '500.00');