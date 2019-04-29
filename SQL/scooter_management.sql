DROP DATABASE IF EXISTS scooter_management;
CREATE DATABASE scooter_management;
USE scooter_management;

CREATE TABLE ticket_status_code (
    t_status VARCHAR(5),
    t_status_description VARCHAR(20),
    PRIMARY KEY (t_status)
);

CREATE TABLE ticket_issue_code (
    t_issue VARCHAR(5),
    t_issue_description VARCHAR(20),
    PRIMARY KEY (t_issue)
);

CREATE TABLE location_region (
    location CHAR(5),
    region VARCHAR(10),
    PRIMARY KEY (location)
);

CREATE TABLE station (
    sa_id VARCHAR(5),
    sa_name VARCHAR(20) NOT NULL,
    location CHAR(5) NOT NULL,
    sa_capacity INTEGER NOT NULL,
    PRIMARY KEY (sa_id)
);

CREATE TABLE scooter (
    s_id VARCHAR(5),
    s_status_code VARCHAR(5) NOT NULL,
    s_model VARCHAR(10) NOT NULL,
    location CHAR(5) NOT NULL,
    sa_id VARCHAR(5),
    onboard_date DATE NOT NULL,
    PRIMARY KEY (s_id),
    FOREIGN KEY (sa_id)
        REFERENCES station (sa_id)
			ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE customer (
    c_id VARCHAR(5),
    c_password VARCHAR(32) NOT NULL,
    c_name VARCHAR(20) NOT NULL,
    phone VARCHAR(10),
    email VARCHAR(20),
    PRIMARY KEY (c_id)
);

CREATE TABLE department (
    d_id VARCHAR(5),
    d_name VARCHAR(20) NOT NULL,
    location CHAR(5) NOT NULL,
    PRIMARY KEY (d_id)
);

CREATE TABLE employee (
    e_id VARCHAR(5),
    e_password VARCHAR(32) NOT NULL,
    e_fname VARCHAR(15) NOT NULL,
    e_lname VARCHAR(15) NOT NULL,
    e_ssn CHAR(9) NOT NULL,
    address VARCHAR(50),
    e_gender CHAR,
    birthday DATE,
    job_type VARCHAR(15) NOT NULL,
    d_id VARCHAR(5) default 'd0000',
    PRIMARY KEY (e_id),
    UNIQUE (e_ssn),
    FOREIGN KEY (d_id)
        REFERENCES department (d_id)
			ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE field_operation (
    e_id VARCHAR(5),
    region VARCHAR(10) NOT NULL,
    workload INTEGER NOT NULL,
    PRIMARY KEY (e_id),
    FOREIGN KEY (e_id)
        REFERENCES employee (e_id)
			ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE delivery (
    e_id VARCHAR(5),
    capacity INTEGER NOT NULL,
    PRIMARY KEY (e_id),
    FOREIGN KEY (e_id)
        REFERENCES employee (e_id)
			ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE technician (
    e_id VARCHAR(5),
    specialty VARCHAR(5),
    workload INTEGER NOT NULL,
    PRIMARY KEY (e_id),
    FOREIGN KEY (e_id)
        REFERENCES employee (e_id)
			ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (specialty)
        REFERENCES ticket_issue_code (t_issue)
			ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE ticket (
    t_id INTEGER AUTO_INCREMENT,
    t_status VARCHAR(5) NOT NULL,
    t_issue VARCHAR(5) NOT NULL,
    t_message TEXT,
    e_id VARCHAR(5),
    d_id VARCHAR(5),
    s_id VARCHAR(5),
    c_id VARCHAR(5),
    created_date DATE,
    created_time TIME,
    closed_date DATE,
    closed_time TIME,
    PRIMARY KEY (t_id),
    FOREIGN KEY (e_id)
        REFERENCES employee (e_id)
			ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (d_id)
        REFERENCES department (d_id)
			ON UPDATE CASCADE,
    FOREIGN KEY (s_id)
        REFERENCES scooter (s_id)
			ON UPDATE CASCADE,
    FOREIGN KEY (c_id)
        REFERENCES customer (c_id)
			ON UPDATE CASCADE,
	FOREIGN KEY (t_status)
        REFERENCES ticket_status_code (t_status)
			ON UPDATE CASCADE,
	FOREIGN KEY (t_issue)
        REFERENCES ticket_issue_code (t_issue)
			ON UPDATE CASCADE
);



CREATE TABLE ticket_history (
    t_id INTEGER,
    e_id VARCHAR(5),
    operation_type VARCHAR(10),
    logtime TIMESTAMP, 
    PRIMARY KEY (t_id, e_id, operation_type),
    FOREIGN KEY (t_id)
        REFERENCES ticket (t_id)
			ON UPDATE CASCADE,
    FOREIGN KEY (e_id)
        REFERENCES employee (e_id)
			ON UPDATE CASCADE
);

INSERT INTO ticket_status_code VALUES
('00000','Created'),
('10000','Picking'),
('20000','Maintaining'),
('30000','Returning'),
('90000','Closed');

INSERT INTO ticket_issue_code VALUES
('00000','General'),
('10000','Battery'),
('20000','Software'),
('30000','Mechanical'),
('40000','Lock');

INSERT INTO location_region VALUES
('10000','Region_A'),
('20000','Region_B'),
('30000','Region_C');

INSERT INTO station VALUES
('sa001','Station A','10000',30),
('sa002','Station B','20000',50),
('sa003','Station C','30000',30),
('sa004','Station D','40000',50),
('sa005','Station E','50000',30),
('sa006','Station F','60000',50);

INSERT INTO scooter VALUES
('s0001','OK','Model S','10000','sa001','2010-01-01'),
('s0002','OK','Model X','20000','sa006','2010-01-01'),
('s0003','OK','Model 3','30000','sa005','2010-01-01'),
('s0004','OK','Model S','10000','sa001','2010-01-01'),
('s0005','OK','Model 3','30021',NULL,'2010-01-01'),
('s0006','OK','Model X','10001',NULL,'2010-01-01');

INSERT INTO customer VALUES
('c0001',MD5('000000'),'Mozart','4085555555','Mozart@abc.com'),
('c0002',MD5('000000'),'Einstein','6505551234','Einstein@abc.com'),
('c0003',MD5('000000'),'Gold','6505554321','Gold@abc.com'),
('c0004',MD5('000000'),'Kim','1234567890','Kim@abc.com'),
('c0005',MD5('000000'),'Zhao','0987654321','Zhao@abc.com');

INSERT INTO department VALUES
('d0000','Company','00000'),
('d0001','Operation','00001'),
('d0002','Logistic','00002'),
('d0003','Maintenance','00003');

INSERT INTO employee VALUES
('e0000',MD5('000000'),'Xiaoning','Zhao','111111118','66 abc, San Jose, CA','M','1900-01-01','Admin','d0000'),
('e0001',MD5('000000'),'Andy','Vile','111111111','7676 Bloomington, Sacramento, CA','M','1966-10-10','Manager','d0001'),
('e0002',MD5('000000'),'Tom','Smith','222222222','222 Howard, Sacramento, CA','M','1966-01-12','Manager','d0002'),
('e0003',MD5('000000'),'Jenny','Grace','333333333','1976 Boone Trace, Chicago, IL','F','1970-01-07','Manager','d0003'),
('e0004',MD5('000000'),'Kate','King','444444444','213 Delk Road, Seattle, WA','F','1968-04-17','IC','d0001'),
('e0005',MD5('000000'),'Sammy','King','555555555','450 Stone, Houston, TX','M','1977-06-21','IC','d0002'),
('e0006',MD5('000000'),'Jennifer','Wallace','666666666','134 Pelham, Milwaukee, WI','F','1980-05-21','IC','d0003');

INSERT INTO field_operation VALUES
('e0004','Region_A',10);

INSERT INTO delivery VALUES
('e0005',15);

INSERT INTO technician VALUES
('e0006','00000',5);

