CREATE DATABASE IF NOT EXISTS airport;
USE airport;

CREATE TABLE flights (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flight_number VARCHAR(20) NOT NULL,
  destination VARCHAR(100) NOT NULL,
  gate VARCHAR(20) NOT NULL,
  departure_time TIME NOT NULL,
  status VARCHAR(30) NOT NULL
);

CREATE TABLE passengers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  booking_reference VARCHAR(20) NOT NULL UNIQUE,
  flight_id INT NOT NULL,
  seat VARCHAR(10) NOT NULL,
  FOREIGN KEY (flight_id) REFERENCES flights(id)
);

INSERT INTO flights (flight_number,destination,gate,departure_time,status) VALUES
('GA-102','Jakarta','A12','09:30:00','Boarding'),
('QZ-701','Bali','B03','10:15:00','On Time'),
('ID-650','Surabaya','A08','11:00:00','Delayed'),
('GA-215','Makassar','C02','12:20:00','On Time'),
('IU-432','Medan','B11','13:10:00','Scheduled');

INSERT INTO passengers (name,booking_reference,flight_id,seat) VALUES
('Ahmad','ABC123',1,'12A'),
('Siti','DEF456',2,'18C'),
('Budi','GHI789',3,'07B'),
('Rina','JKL012',4,'21A');
