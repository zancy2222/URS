-- Create the main account_type table
CREATE TABLE account_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type VARCHAR(50) NOT NULL
);

-- Insert account types
INSERT INTO account_type (account_type) VALUES 
('Admin'),
('Student Leader'),
('Office');

-- Create a table for admin roles
CREATE TABLE admin_account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT,
    role VARCHAR(100) NOT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id) ON DELETE CASCADE
);

-- Insert admin roles
INSERT INTO admin_account (account_type_id, role) VALUES
((SELECT id FROM account_type WHERE account_type = 'Admin'), 'Campus Director'),
((SELECT id FROM account_type WHERE account_type = 'Admin'), 'CBS'),
((SELECT id FROM account_type WHERE account_type = 'Admin'), 'OSDS');

-- Create a table for student leader college departments
CREATE TABLE college_department (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT,
    department_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id) ON DELETE CASCADE
);

-- Insert college departments for student leaders
INSERT INTO college_department (account_type_id, department_name) VALUES
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), 'College of Science'),
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), 'College of Education'),
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), 'College of Industrial Technology'),
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), 'College of Engineering'),
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), 'Institutional Organization');

-- Create a table for student leader organizations (ORGs)
CREATE TABLE student_leader_org (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    org_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (department_id) REFERENCES college_department(id) ON DELETE CASCADE
);

-- Insert organizations for each college department
-- College of Science
INSERT INTO student_leader_org (department_id, org_name) VALUES
((SELECT id FROM college_department WHERE department_name = 'College of Science'), 'COSSB'),
((SELECT id FROM college_department WHERE department_name = 'College of Science'), 'TIPA'),
((SELECT id FROM college_department WHERE department_name = 'College of Science'), 'BIOSA'),
((SELECT id FROM college_department WHERE department_name = 'College of Science'), 'SMS'),
((SELECT id FROM college_department WHERE department_name = 'College of Science'), 'BGP');

-- College of Education
INSERT INTO student_leader_org (department_id, org_name) VALUES
((SELECT id FROM college_department WHERE department_name = 'College of Education'), 'LBC'),
((SELECT id FROM college_department WHERE department_name = 'College of Education'), 'EMC'),
((SELECT id FROM college_department WHERE department_name = 'College of Education'), 'EEE'),
((SELECT id FROM college_department WHERE department_name = 'College of Education'), 'GUTS'),
((SELECT id FROM college_department WHERE department_name = 'College of Education'), 'SEES');

-- College of Industrial Technology
INSERT INTO student_leader_org (department_id, org_name) VALUES
((SELECT id FROM college_department WHERE department_name = 'College of Industrial Technology'), 'D''Gears'),
((SELECT id FROM college_department WHERE department_name = 'College of Industrial Technology'), 'D''Wheels'),
((SELECT id FROM college_department WHERE department_name = 'College of Industrial Technology'), 'Anvil'),
((SELECT id FROM college_department WHERE department_name = 'College of Industrial Technology'), 'CITESS'),
((SELECT id FROM college_department WHERE department_name = 'College of Industrial Technology'), 'Techno Gazette');

-- College of Engineering
INSERT INTO student_leader_org (department_id, org_name) VALUES
((SELECT id FROM college_department WHERE department_name = 'College of Engineering'), 'FEC'),
((SELECT id FROM college_department WHERE department_name = 'College of Engineering'), 'ACCESS'),
((SELECT id FROM college_department WHERE department_name = 'College of Engineering'), 'EICEP'),
((SELECT id FROM college_department WHERE department_name = 'College of Engineering'), 'PSM'),
((SELECT id FROM college_department WHERE department_name = 'College of Engineering'), 'PICE');

-- Institutional Organization
INSERT INTO student_leader_org (department_id, org_name) VALUES
((SELECT id FROM college_department WHERE department_name = 'Institutional Organization'), 'USSG'),
((SELECT id FROM college_department WHERE department_name = 'Institutional Organization'), 'Alab Kultura'),
((SELECT id FROM college_department WHERE department_name = 'Institutional Organization'), 'SINAG URSM'),
((SELECT id FROM college_department WHERE department_name = 'Institutional Organization'), 'Rajah De Mayaw'),
((SELECT id FROM college_department WHERE department_name = 'Institutional Organization'), 'Hirayah Chorale');

-- Create a table for office accounts
CREATE TABLE office_account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT,
    office_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id) ON DELETE CASCADE
);

-- Insert office account
INSERT INTO office_account (account_type_id, office_name) VALUES
((SELECT id FROM account_type WHERE account_type = 'Office'), 'GSO');
-- Create a table for user passwords
CREATE TABLE user_passwords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_type_id INT,
    role_id INT, -- Can be admin, student leader, or office role
    password VARCHAR(255) NOT NULL,
    role_type ENUM('admin', 'student_leader', 'office'), -- Identify the role type (admin, student leader, or office)
    FOREIGN KEY (account_type_id) REFERENCES account_type(id) ON DELETE CASCADE
);
-- Insert passwords for admins
INSERT INTO user_passwords (account_type_id, role_id, password, role_type) VALUES
((SELECT id FROM account_type WHERE account_type = 'Admin'), (SELECT id FROM admin_account WHERE role = 'Campus Director'), 'adminpassword1', 'admin'),
((SELECT id FROM account_type WHERE account_type = 'Admin'), (SELECT id FROM admin_account WHERE role = 'CBS'), 'adminpassword2', 'admin');

-- Insert passwords for student leaders
INSERT INTO user_passwords (account_type_id, role_id, password, role_type) VALUES
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), (SELECT id FROM student_leader_org WHERE org_name = 'COSSB'), 'leaderpassword1', 'student_leader'),
((SELECT id FROM account_type WHERE account_type = 'Student Leader'), (SELECT id FROM student_leader_org WHERE org_name = 'LBC'), 'leaderpassword2', 'student_leader');

-- Insert passwords for office accounts
INSERT INTO user_passwords (account_type_id, role_id, password, role_type) VALUES
((SELECT id FROM account_type WHERE account_type = 'Office'), (SELECT id FROM office_account WHERE office_name = 'GSO'), 'officepassword1', 'office');
