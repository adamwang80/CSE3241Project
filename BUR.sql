CREATE TABLE IF NOT EXISTS BATCHES (
	Batch_id varchar(15) primary key not null,
	Quantity_Of_Doses int not null,
	Manufacturer varchar(15) not null,
	Expire_Date date not null,
	Quantity_Of_Available int not null,
	Quantity_Of_Dosed int not null,
	Quantity_Of_Expired int not null,
	CHECK (Quantity_Of_Dose > 0 AND Quantity_Of_Available > 0 AND Quantity_Of_Dosed + Quantity_Of_Expired + Quantity_of_Available = Quantity_Of_Doses)) engine=innodb;

CREATE TABLE IF NOT EXISTS DOSES (
	Tracking_Number varchar(15) primary key not null,
	Status ENUM('Unused', 'Used', 'Expired') DEFAULT 'Unused',
	Batch_id varchar(15) not null,
	FOREIGN KEY (Batch_id) REFERENCES BATCHES (Batch_id)) engine=innodb;

CREATE TABLE IF NOT EXISTS PATIENTS(
	Patient_Id int primary key not null auto_increment,
	First_Name varchar(30) not null,
	Middle_Name varchar(30) not null,
	Last_Name varchar(30) not null,
	Age int not null,
	Phone_Number varchar(10) not null,
	Priority int(1) not null,
	Earliest_Arrival_Date date not null,
	Arrival_Date date,
	CHECK (Age > 0),
	CHECK (Priority > 0 and Priority < 4)) engine=innodb;

CREATE TABLE IF NOT EXISTS ACCOUNTS(
	Username varchar(20) primary key not null,
	Password varchar(20) not null,
	Patient_Id int not null,
	FOREIGN KEY (Patient_Id) REFERENCES PATIENTS(Patient_Id)) engine=innoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS SCHEDULE (
	Patient_Id int primary key not null,
	Tracking_Number varchar(15) not null,
	Status varchar(15) not null DEFAULT 'Scheduled',
	Arrival_Date date not null,
	FOREIGN KEY (Patient_Id) REFERENCES PATIENTS(Patient_Id),
	FOREIGN KEY (Tracking_Number) REFERENCES DOSES (Tracking_Number)) engine=innodb;
