CREATE DATABASE IF NOT EXISTS DocumentSubmissionSystem;
USE DocumentSubmissionSystem;

CREATE TABLE USERS(
UserId VARCHAR(10) NOT NULL
, Name VARCHAR(50) NOT NULL
, Email VARCHAR(100) NOT NULL
, Password VARCHAR(100) NOT NULL
, Role VARCHAR(100) NOT NULL
, PRIMARY KEY (UserId)
);

ALTER TABLE USERS
ADD CONSTRAINT ChkRoles CHECK (Role IN ('Student', 'Convenor','Admin'));

INSERT INTO USERS (UserId,Name,Email,Password,Role) 
VALUES 
('101231636','JunWee','101231636@student.swin.edu.au','swin','Student')
,('101225244','AdrianSim','101225244@student.swin.edu.au','swin','Student') 
,('103698851','XinZhe','103698851@student.swin.edu.au','swin','Student')
,('103340644','RichardLy','103340644@student.swin.edu.au','swin','Student')
,('102426323','YovinmaKonara','102426323@student.swin.edu.au','swin','Student') 
,('102849357','SandaliJayasinghe','102849357@student.swin.edu.au','swin','Student')
,('C101','John','john@convenor.swin.edu.au','swin','Convenor')
,('A101','Admin','admin101@admin.swin.edu.au','swin','Admin');