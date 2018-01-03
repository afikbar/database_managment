CREATE TABLE Passenger (
  username VARCHAR(25) PRIMARY KEY,
  birthday DATE,
);

CREATE TABLE Hobby (
  name VARCHAR(50) PRIMARY KEY,
);

CREATE TABLE Company (
  name    VARCHAR(50) PRIMARY KEY,
  address VARCHAR(50),
);

CREATE TABLE City (
  name VARCHAR(25) PRIMARY KEY,
);

CREATE TABLE CarType (
  CarType VARCHAR(10) PRIMARY KEY,
);

INSERT INTO CarType (CarType) VALUES ('Urban'), ('Intercity');

CREATE TABLE Car (
  ID          VARCHAR(8) PRIMARY KEY CHECK (len(ID) > 6),
  carType     VARCHAR(10) NOT NULL,
  size        INT,
  maxCapacity INT,
  company     VARCHAR(50),
  UNIQUE (ID, carType),
  FOREIGN KEY (company) REFERENCES Company (name),
  FOREIGN KEY (carType) REFERENCES CarType (CarType),
);

CREATE TABLE UrbanCar (
  ID      VARCHAR(8) PRIMARY KEY,
  carType VARCHAR(10) NOT NULL DEFAULT ('Urban') CHECK (carType = 'Urban'),
  FOREIGN KEY (ID, carType) REFERENCES Car (ID, carType)
    ON DELETE CASCADE,
);

CREATE TABLE IntercityCar (
  ID      VARCHAR(8) PRIMARY KEY,
  carType VARCHAR(10) NOT NULL DEFAULT ('Intercity') CHECK (carType = 'Intercity'),
  FOREIGN KEY (ID, carType) REFERENCES Car (ID, carType)
    ON DELETE CASCADE,
);

CREATE TABLE CarCities (
  cID  VARCHAR(8),
  city VARCHAR(25),
  PRIMARY KEY (cID, city),
  FOREIGN KEY (cID) REFERENCES IntercityCar (ID)
    ON DELETE CASCADE,
  FOREIGN KEY (city) REFERENCES City (name)
    ON DELETE CASCADE,
);

CREATE TABLE Driver (
  ID       VARCHAR(9) PRIMARY KEY CHECK (len(ID) = 9),
  dCarID   VARCHAR(8)  NOT NULL, --Drives IN
  mainHoby VARCHAR(50) NOT NULL, --Main Hobby
  name     VARCHAR(25),
  birthday DATE,
  address  VARCHAR(50),
  comments VARCHAR(50),
  FOREIGN KEY (mainHoby) REFERENCES Hobby (name),
  FOREIGN KEY (dCarID) REFERENCES Car (ID),
);

CREATE TABLE PassengerHobbies (-- "Hobby list is"
  username VARCHAR(25),
  hobby    VARCHAR(50),
  PRIMARY KEY (username, hobby),
  FOREIGN KEY (username) REFERENCES Passenger (username),
  FOREIGN KEY (hobby) REFERENCES Hobby (name),
);

CREATE TABLE Drive (-- "Driven By"
  passenger VARCHAR(25),
  driverID  VARCHAR(9),
  PRIMARY KEY (passenger, driverID),
  FOREIGN KEY (passenger) REFERENCES Passenger (username),
  FOREIGN KEY (driverID) REFERENCES Driver (ID),
);
CREATE TABLE DriveDetails (
  timestamp  TIMESTAMP,
  latitude   DECIMAL(8, 6) -- x value of coordinate
    CHECK (latitude BETWEEN -90.0 AND 90.0), --between -90 to 90 degrees
  longtitude DECIMAL(9, 6) -- y value of coordinate
    CHECK (longtitude BETWEEN -180.0 AND 180.0), --between -180 to 180 degrees
  passenger  VARCHAR(25), -- Weak entity
  driverID   VARCHAR(9),
  PRIMARY KEY (timestamp, passenger, driverID),
  FOREIGN KEY (passenger, driverID) REFERENCES Drive (passenger, driverID),
);

