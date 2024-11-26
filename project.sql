-CREATE DATABASE IF NOT EXISTS project;

USE project;

CREATE TABLE IF NOT EXISTS Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(255) NOT NULL,
    Email VARCHAR(191) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Events (
    eventID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    EventName VARCHAR(255) NOT NULL,
    Month INT NOT NULL,
    Day INT NOT NULL,
    Year INT NOT NULL,
    StartHour INT NOT NULL,
    StartMin INT NOT NULL,
    EndHour INT NOT NULL,
    EndMin INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    Location VARCHAR(255) NOT NULL,
    Price INT NOT NULL,
    guestIDs JSON,
    Tag VARCHAR(255),
    Image LONGBLOB,
    FOREIGN KEY (userID) REFERENCES Users(userID)
);