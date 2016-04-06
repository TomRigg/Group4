
DROP TABLE IF EXISTS Employee CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS Employer CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS Jobs CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS Hours CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS Paycheck CASCADE CONSTRAINTS;


CREATE TABLE Employee (
  employeeID INT AUTO_INCREMENT,
  jobID INT,
  name VARCHAR(40) NOT NULL,
  phoneNumber VARCHAR(15) DEFAULT NULL,
  employeeAddress VARCHAR(80) NOT NULL,
  employeeType INT(1) NOT NULL,
  PRIMARY KEY(EmployeeID)
)

CREATE TABLE Employer (
  employerID INT AUTO_INCREMENT,
  employerAddress VARCHAR(40), 
  PRIMARY KEY(EmployerID)
)

CREATE TABLE Jobs (
  jobID INT AUTO_INCREMENT,
  employerID INT,
  employeeID INT,
  hourlyWage DECIMAL(6,2),
  workAddress VARCHAR(80),
  PRIMARY KEY(JobID),
  FOREIGN KEY(employerID) REFERENCES Employer(employerID),
  FOREIGN KEY(employeeID) REFERENCES Employee(employeeID) 
)


CREATE TABLE Hours (
  hoursID INT unsigned NOT NULL,
  jobID INT,
  date VARCHAR(40),
  workAddress VARCHAR(80), 
  hoursWorked INT(3),
  wagesEarned INT(6),
  PRIMARY KEY (HoursID),
  FOREIGN KEY (JobID) REFERENCES Jobs(JobID)
) 

CREATE TABLE Paycheck (
  paycheckID int unsigned NOT NULL,
  jobID INT,
  checkDate VARCHAR(20),
  hoursWorked INT(3),
  wagesEarned INT(6),
  PRIMARY KEY (paycheckID),
  FOREIGN KEY (JobID) REFERENCES Jobs(JobID)
) 
  
  
ALTER TABLE Employee ADD CONSTRAINT FOREIGN KEY (jobID) REFERENCES Jobs(JobID);

