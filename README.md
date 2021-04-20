# CSE3241Project

Setting before use:
TABLES:
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
	Status varchar(15) not null DEFAULT 'Unused',
	Batch_id varchar(15) not null,
	FOREIGN KEY (Batch_id) REFERENCES BATCHES (Batch_id)) engine=innodb;

CREATE TABLE IF NOT EXISTS PATIENTS(
	Patient_Id int primary key not null auto_increment,
	First_Name varchar(30) not null,
	Middle_Name varchar(30) not null,
	Last_Name varchar(30) not null,
	Age int not null,
	Phone_Number varchar(10) not null,
	Earliest_Arrival_Date date not null,
	Priority int(1) not null,
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

LOAD DATA:
LOAD DATA INFILE 'ACCOUNTS.txt' INTO TABLE ACCOUNTS;
LOAD DATA INFILE 'BATCHES.txt' INTO TABLE BATCHES;
LOAD DATA INFILE 'DOSES.txt' INTO TABLE DOSES FIELDS TERMINATED BY ',' lines terminated by '\r\n';
LOAD DATA INFILE 'SCHEDULE.txt' INTO TABLE SCHEDULE lines terminated by '\r\n';
LOAD DATA INFILE 'PATIENTS.txt' INTO TABLE PATIENTS FIELDS TERMINATED BY ',' lines terminated by '\r\n';


TRIGGER:

delimiter $
create trigger add_in_schedule after insert on SCHEDULE
for each row 
begin
update PATIENTS set Arrival_Date = new.Arrival_Date where Patient_Id = New.Patient_Id;
update DOSES set Status = 'Scheduled' Where Tracking_Number = New.Tracking_Number;
update BATCHES set Quantity_Of_Available = Quantity_Of_Available - 1, Quantity_Of_Dosed = Quantity_Of_Dosed + 1 where Batch_id = (select Batch_id FROM DOSES WHERE Tracking_Number = New.Tracking_Number);
end;
$

delimiter $
create trigger confirm_dose after update on SCHEDULE
for each row
begin
if old.Status = 'Scheduled' and  new.Status = 'Dosed' then
update PATIENTS set Arrival_Date = old.Arrival_Date where Patient_Id = old.Patient_Id;
update DOSES set Status = 'Used' where Tracking_Number = old.Tracking_Number;
end if;
end;
$

procedure:

delimiter $
create procedure return_dose(in id int, in number varchar(15))
begin
update PATIENTS set Arrival_Date = NULL where Patient_Id = id;
update DOSES set Status = 'Unused' Where Tracking_Number = number;
update BATCHES set Quantity_Of_Available = Quantity_Of_Available + 1, Quantity_Of_Dosed = Quantity_Of_Dosed - 1 where Batch_id = (select Batch_id FROM DOSES WHERE Tracking_Number = number);
DELETE FROM SCHEDULE WHERE Patient_Id = id AND Tracking_Number = number;
end;
$

delimiter $
create procedure destroy_dose(in id int, in number varchar(15))
begin
update PATIENTS set Arrival_Date = NULL where Patient_Id = id;
update DOSES set Status = 'Expired' where Tracking_Number = number;
update BATCHES set Quantity_Of_Expired = Quantity_Of_Expired + 1, Quantity_Of_Dosed = Quantity_Of_Dosed - 1 where Batch_id = (select Batch_id FROM DOSES WHERE Tracking_Number = number);
DELETE FROM SCHEDULE WHERE Patient_Id = id AND Tracking_Number = number;
end;
$


delimiter $
create procedure daily_add_schedule()
begin
declare id int;
declare number varchar(15);
declare has_data int default 1;

declare result_id cursor for SELECT Patient_Id FROM PATIENTS WHERE Arrival_Date IS NULL AND Earliest_Arrival_Date <= CURDATE() ORDER BY Priority DESC, Age DESC;
declare result_number cursor for SELECT Tracking_Number FROM DOSES WHERE Status = 'Unused';
declare exit handler for not found set has_data = 0;


open result_id;
open result_number;

repeat
fetch result_id into id;
fetch result_number into number;
INSERT INTO SCHEDULE(Patient_Id, Tracking_Number, Status, Arrival_Date) VALUE (id, number, 'Scheduled', CURDATE());
until has_data = 0
end repeat;

close result_id;
close result_number;
end$


delimiter $
create procedure daily_clean_schedule()
begin
declare id int;
declare number varchar(15);
declare has_data int default 1;
declare result cursor for SELECT Patient_Id, Tracking_Number FROM SCHEDULE WHERE Status = 'Scheduled' AND Arrival_Date < CURDATE();
declare exit handler for not found set has_data = 0;

open result;

repeat
fetch result into id, number;
SELECT (SELECT Expire_Date FROM BATCHES AS B, DOSES AS D WHERE B.Batch_id = D.Batch_id AND D.Tracking_Number = number) INTO @expire_date;
if @expire_date >= CURDATE() then
call return_dose(id, number);
else
call destroy_dose(id, number);
end if;

until has_data = 0
end repeat;

close result;
end$


event:
create event clean_schedule 
ON SCHEDULE EVERY 1 DAY
STARTS '2021-04-19 17:43:00' ON COMPLETION PRESERVE ENABLE
DO CALL daily_clean_schedule;

create event add_schedule 
ON SCHEDULE EVERY 1 DAY
STARTS '2021-04-19 18:57:00' ON COMPLETION PRESERVE ENABLE
DO CALL daily_add_schedule;
