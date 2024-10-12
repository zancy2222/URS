CREATE TABLE IF NOT EXISTS guest_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    event_name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    start_time TIME NOT NULL,
    end_time TIME,
    facility ENUM('EARTS', 'FUNCTION HALL', 'GYMNASIUM', 'QUADRANGLE', 'AVEC') NOT NULL,
    event_description TEXT,
    status ENUM('Approve', 'Pending', 'Reject', 'On Hold') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE guest_events 
ADD COLUMN letter_of_request VARCHAR(255) DEFAULT NULL,
ADD COLUMN facility_form_request VARCHAR(255) DEFAULT NULL,
ADD COLUMN contract_of_lease VARCHAR(255) DEFAULT NULL;

-- Create the `account_type` table for Admin, Student Leader, Office
CREATE TABLE account_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type VARCHAR(50) NOT NULL
);

-- Insert account types: Admin, Student Leader, Office
INSERT INTO account_type (account_type) VALUES 
('Admin'), 
('Student Leader'), 
('Office');

-- Create the `admin_account` table
CREATE TABLE admin_account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT NOT NULL,
    account_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id)
);

-- Insert admin accounts
INSERT INTO admin_account (account_type_id, account_name) VALUES 
(1, 'Campus Director'),
(1, 'CBS'),
(1, 'OSDS');

-- Create the `college_department` table for student leaders
CREATE TABLE college_department (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT NOT NULL,
    department_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id)
);

-- Insert college departments
INSERT INTO college_department (account_type_id, department_name) VALUES 
(2, 'College of Science'),
(2, 'College of Education'),
(2, 'College of Industrial Technology'),
(2, 'College of Engineering'),
(2, 'Institutional Organization');

-- Create the `org` table for organizations under each department
CREATE TABLE org (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    org_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (department_id) REFERENCES college_department(id)
);

-- Insert organizations for College of Science
INSERT INTO org (department_id, org_name) VALUES 
(1, 'COSSB'),
(1, 'TIPA'),
(1, 'BIOSA'),
(1, 'SMS'),
(1, 'BGP');

-- Insert organizations for College of Education
INSERT INTO org (department_id, org_name) VALUES 
(2, 'LBC'),
(2, 'EMC'),
(2, 'EEE'),
(2, 'GUTS'),
(2, 'SEES');

-- Insert organizations for College of Industrial Technology
INSERT INTO org (department_id, org_name) VALUES 
(3, 'D\'Gears'),
(3, 'D\'Wheels'),
(3, 'Anvil'),
(3, 'CITESS'),
(3, 'Techno Gazate');

-- Insert organizations for College of Engineering
INSERT INTO org (department_id, org_name) VALUES 
(4, 'FEC'),
(4, 'ACCESS'),
(4, 'EICEP'),
(4, 'PSM'),
(4, 'PICE');

-- Insert institutional organizations
INSERT INTO org (department_id, org_name) VALUES 
(5, 'USSG'),
(5, 'Alab Kultura'),
(5, 'SINAG URSM'),
(5, 'Rajah De Mayaw'),
(5, 'Hirayah Chorale');

-- Create the `office` table for Office users
CREATE TABLE office (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_name VARCHAR(100) NOT NULL
);

-- Insert Office
INSERT INTO office (office_name) VALUES ('GSO');

-- Create the `users` table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    account_type_id INT NOT NULL,
    admin_account_id INT DEFAULT NULL,
    department_id INT DEFAULT NULL,
    org_id INT DEFAULT NULL,
    office_id INT DEFAULT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id),
    FOREIGN KEY (admin_account_id) REFERENCES admin_account(id),
    FOREIGN KEY (department_id) REFERENCES college_department(id),
    FOREIGN KEY (org_id) REFERENCES org(id),
    FOREIGN KEY (office_id) REFERENCES office(id)
);

-- Create the `admin_events` table
CREATE TABLE admin_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    event_name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    facility VARCHAR(255) NOT NULL,
    event_description TEXT,
    letter_of_request VARCHAR(255),
    facility_form_request VARCHAR(255),
    contract_of_lease VARCHAR(255),
    email VARCHAR(255),
    FOREIGN KEY (admin_id) REFERENCES admin_account(id)
);

-- Add status column to admin_events table
ALTER TABLE admin_events 
ADD COLUMN status ENUM('Approve', 'Pending', 'Reject', 'On Hold') DEFAULT 'Pending';
