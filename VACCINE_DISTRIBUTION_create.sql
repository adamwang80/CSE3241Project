Create table if not exists BATCHES (
	Batch_id varchar(15) primary key,
	Quantity_Of_Dose int not null,
	Quantity_Available int not null,
	Manufacturer varchar(15) not null,
	Expire_Date date not null,
	CHECK (Quantity_Of_Dose > 0 AND Quantity_Available >= 0)) engine=innodb;

Create table if not exists DOSES (
	Tracking_Number varchar(15) primary key,
	Status ENUM ('unused', 'used') default 'unused',
	Batch_id varchar(15) not null,
	FOREIGN KEY (Batch_id) REFERENCES BATCHES (Batch_id)) engine=innodb;

Create table if not exists PATIENTS (
	Patient_id varchar(15) primary key,
	Fname varchar(15) not null,
	Minit varchar(1),
	Lname varchar(15) not null,
	Age int not null,
	Phone_Number varchar(15) not null,
	Arrival_Date date not null,
	Priority int not null,
	CHECK (Age >= 0),
	CHECK (Priority > 0 and Priority < 4)) engine=innodb;

Create table if not exists SCHEDULE (
	Patient varchar(15) not null,
	Tracking_Number varchar(15) not null,
	Status ENUM ('waiting', 'scheduled', 'finished') not null,
	PRIMARY KEY (Patient, Tracking_Number),
	FOREIGN KEY (Patient) REFERENCES PATIENTS (Patient_id),
	FOREIGN KEY (Tracking_Number) REFERENCES DOSES (Tracking_Number)) engine=innodb;

