-- Create database
CREATE DATABASE IF NOT EXISTS goevent_db;

USE goevent_db;

-- Create tables

CREATE TABLE venues (
  venue_id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255),
  name VARCHAR(100),
  capacity VARCHAR(50),
  facilities VARCHAR(255),
  location VARCHAR(100)
);

CREATE TABLE events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255),
  name VARCHAR(100),
  category VARCHAR(50),
  date VARCHAR(20),
  time VARCHAR(30),
  venue VARCHAR(100),
  link VARCHAR(255)
);

CREATE TABLE bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  event VARCHAR(50),
  ticket_type VARCHAR(20),
  quantity INT,
  name VARCHAR(100),
  email VARCHAR(120)
);
