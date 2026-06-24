CREATE DATABASE volleyball_club;
USE volleyball_club;

CREATE TABLE Personnel (
	personnel_id INT PRIMARY KEY AUTO_INCREMENT, 	
	first_name VARCHAR(255),
	last_name VARCHAR(255),
    date_of_birth DATE,
    ssn CHAR(15) NOT NULL UNIQUE,
   	medicare CHAR(15) NOT NULL UNIQUE,
   	telephone_number CHAR(15),
   	address VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code CHAR(7), 	
    email VARCHAR(255),
	working_role ENUM('administrator', 'captain', 'coach', 'assistant coach', 'treasurer', 'secretary', 'general manager', 'deputy manager', 'other'),
    mandate ENUM('volunteer', 'salaried')
    );

CREATE TABLE Locations (
	location_id INT PRIMARY KEY AUTO_INCREMENT,	
    location_name VARCHAR(255),		
	address VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
   	postal_code CHAR(7),
    web_address VARCHAR(255),
    max_capacity INT,
	location_type ENUM('head', 'branch')
    );

CREATE TABLE works_at (
	personnel_id INT,		    
	location_id INT,
	start_date DATE,
    end_date DATE,
	status ENUM('active', 'inactive') DEFAULT 'inactive',
    PRIMARY KEY (personnel_id, location_id),
	FOREIGN KEY (personnel_id) REFERENCES 	Personnel(personnel_id) ON DELETE CASCADE,
	FOREIGN KEY (location_id) REFERENCES, 
	Locations(location_id) ON DELETE CASCADE 
    );

CREATE TABLE Locationphone (	
	phone_number CHAR(15),	
  	location_id INT,
	call_type ENUM('local', 'toll free') NOT NULL,
    PRIMARY KEY (phone_number, location_id),
    FOREIGN KEY (location_id) REFERENCES Locations(location_id)
    );

CREATE TABLE Familymembers (
	familymember_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
   	date_of_birth DATE,
    ssn CHAR(15) NOT NULL UNIQUE,
    medicare CHAR(15) NOT NULL UNIQUE, 	
   	telephone_number CHAR(15),
    address VARCHAR(255),
   	city VARCHAR(255),
    province VARCHAR(255),
    postal_code CHAR(7),
    email VARCHAR(255)
    );

CREATE TABLE registered_at (
	familymember_id INT,
   	location_id INT,
    start_date DATE,
    end_date DATE,
    PRIMARY KEY (familymember_id, location_id),
    FOREIGN KEY (familymember_id) REFERENCES Familymembers(familymember_id) ON DELETE CASCADE,
	FOREIGN KEY (location_id) REFERENCES Locations(location_id) ON DELETE CASCADE,
    );

CREATE TABLE Teams (
	teams_id INT PRIMARY KEY AUTO_INCREMENT,
	location_id INT,	
	team_type ENUM('boys', 'girls'),	
	FOREIGN KEY (location_id) REFERENCES Locations(location_id)  ON DELETE CASCADE
    );

CREATE TABLE Clubmembers (
	clubmember_id INT PRIMARY KEY AUTO_INCREMENT,	
	teams_id INT, 			
	first_name VARCHAR(255),
    last_name VARCHAR(255),
    date_of_birth DATE,
    height INT,
    weight INT,
    ssn CHAR(15) NOT NULL UNIQUE,
    medicare CHAR(15) NOT NULL UNIQUE, 
    telephone_number CHAR(15),
    address VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code CHAR(7),
    gender ENUM('male', 'female'),
	status ENUM('active', 'inactive') DEFAULT 'inactive',
	FOREIGN KEY (teams_id) REFERENCES Teams(teams_id) ON DELETE CASCADE
);

ALTER TABLE Clubmembers
ADD email VARCHAR(255),
ADD deactivation_date DATE;

CREATE TABLE associated_with (
	familymember_id INT,
	clubmember_id INT,
	relationship_type ENUM('father', 'mother', 'grandfather', 'grandmother', 'tutor', 'partner', 'friend', 'other'),    	PRIMARY KEY (familymember_id, clubmember_id),
	FOREIGN KEY (clubmember_id) REFERENCES Clubmembers(clubmember_id) ON DELETE CASCADE,
    FOREIGN KEY (familymember_id) REFERENCES Familymembers(familymember_id) ON DELETE CASCADE,
    );

CREATE TABLE Payment ( 
	clubmember_id INT,	
	payment_id INT AUTO_INCREMENT,
   	payment_amount INT,
    payment_date DATE,
    payment_method ENUM('cash', 'debit', 'credit card'),
    remaining_balance INT,
    membership_year INT,
    donation INT,
	status ENUM('active', 'inactive') DEFAULT 'inactive',
    PRIMARY KEY (payment_id, clubmember_id),
	FOREIGN KEY (clubmember_id) REFERENCES Clubmembers(clubmember_id) ON DELETE CASCADE
    );


INSERT INTO Clubmembers (clubmember_id, first_name, last_name, date_of_birth, height, weight, ssn, medicare, telephone_number, address, city, province, postal_code, gender, teams_id, status)
VALUES
(301, 'John', 'Doe', '2008-04-15', 175, 70, '123456789', '123456789012', '5141234567', '123 Main St', 'Montreal', 'QC', 'H3A 1B2', 'male', 15, 'active'),
(302, 'Jane', 'Smith', '2007-07-10', 165, 60, '234567890', '234567890123', '5142345678', '456 Elm St', 'Montreal', 'QC', 'H3B 2C3', 'female', 14, 'active'),
(303, 'Michael', 'Johnson', '2009-05-22', 180, 80, '345678901', '345678901234', '5143456789', '789 Pine St', 'Montreal', 'QC', 'H3C 3D4', 'male', 17, 'active'),
(304, 'Emily', 'Brown', '2010-02-20', 160, 55, '456789012', '456789012345', '5144567890', '321 Oak St', 'Montreal', 'QC', 'H3D 4E5', 'female', 18, 'active'),
(305, 'David', 'Williams', '2010-02-20', 185, 90, '567890123', '567890123456', '5145678901', '654 Maple St', 'Montreal', 'QC', 'H3E 5F6', 'male', 21, 'active'),
(306, 'Sarah', 'Miller', '2009-11-12', 170, 65, '678901234', '678901234567', '5146789012', '987 Birch St', 'Montreal', 'QC', 'H3F 6G7', 'female', 22, 'active'),
(307, 'Robert', 'Davis', '2011-03-18', 172, 78, '789012345', '789012345678', '5147890123', '159 Cedar St', 'Montreal', 'QC', 'H3G 7H8', 'male', 19, 'active'),
(308, 'Laura', 'Wilson', '2014-03-12', 168, 55, '890123456', '890123456789', '5148901234', '753 Walnut St', 'Montreal', 'QC', 'H3H 8I9', 'female', 20, 'inactive'),
(309, 'James', 'Anderson', '2014-06-30', 177, 72, '901234567', '901234567890', '5149012345', '852 Chestnut St', 'Montreal', 'QC', 'H3I 9J0', 'male', 21, 'inactive'),
(310, 'Olivia', 'Martinez', '2011-02-14', 165, 58, '12345678', '012345678901', '5140123456', '369 Redwood St', 'Montreal', 'QC', 'H3J 0K1', 'female', 22, 'active'),
(311, 'Daniel', 'Clark', '2012-04-10', 178, 75, '112233445', '112233445678', '5141122334', '123 Maple Ave', 'Montreal', 'QC', 'H3K 1L2', 'male', 23, 'active'),
(312, 'Emma', 'Roberts', '2012-07-22', 160, 54, '223344556', '223344556789', '5142233445', '456 Pine St', 'Montreal', 'QC', 'H3L 2M3', 'female', 20, 'active'),
(313, 'Sophia', 'Lopez', '2013-05-17', 162, 50, '334455667', '334455667890', '5143344556', '789 Cedar Rd', 'Montreal', 'QC', 'H3M 3N4', 'female', 14, 'active'),
(314, 'Ethan', 'Walker', '2010-03-25', 180, 80, '445566778', '445566778901', '5144455667', '321 Oak Blvd', 'Montreal', 'QC', 'H3N 4O5', 'male', 17, 'active'),
(315, 'Mia', 'Hall', '2011-08-10', 167, 60, '556677889', '556677889012', '5145566778', '654 Maple Rd', 'Montreal', 'QC', 'H3O 5P6', 'female', 20, 'active'),
(316, 'Lucas', 'Allen', '2007-11-19', 173, 68, '667788990', '667788990123', '5146677889', '987 Birch Ave', 'Montreal', 'QC', 'H3P 6Q7', 'male', 19, 'active'),
(317, 'Zoe', 'Young', '2014-06-12', 160, 57, '778899001', '778899001234', '5147788990', '159 Cedar Blvd', 'Montreal', 'QC', 'H3Q 7R8', 'female', 18, 'inactive'),
(318, 'James', 'King', '2011-10-15', 185, 85, '889900112', '889900112345', '5148899001', '753 Walnut Ave', 'Montreal', 'QC', 'H3R 8S9', 'male', 15, 'active'),
(319, 'Grace', 'Scott', '2007-09-30', 170, 63, '990011223', '990011223456', '5149900112', '852 Chestnut Rd', 'Montreal', 'QC', 'H3S 9T0', 'female', 22, 'active'),
(320, 'Oliver', 'Adams', '2010-01-06', 178, 75, '101122334', '101122334567', '5141011223', '369 Redwood Ave', 'Montreal', 'QC', 'H3T 0U1', 'male', 21, 'active');

INSERT INTO Personnel (personnel_id, first_name, last_name, date_of_birth, ssn, medicare, telephone_number, address, city, province, postal_code, email, mandate, working_role) 
VALUES 
(501, 'John', 'Doe', '1980-05-15', '123456789', 'A123456789', '514-555-1234', '123 Main St', 'Montreal', 'QC', 'H1A 2B3', 'jdoe@volley.com', 'salaried', 'general manager'),
(502, 'Emma', 'Smith', '1985-07-21', '234567890', 'B234567890', '514-555-5678', '456 Elm St', 'Montreal', 'QC', 'H2B 3C4', 'esmith@volley.com', 'salaried', 'deputy manager'),
(503, 'Robert', 'Johnson', '1990-11-03', '456123789', '456123789-EF', '438-345-6789', '789 Oak St', 'Laval', 'QC', 'H7N 3C4', 'robert.j@example.com', 'salaried', 'captain'),
(504, 'Emily', 'Brown', '1985-02-14', '321654987', '321654987-GH', '450-456-7890', '321 Pine Ave', 'Longueuil', 'QC', 'J4H 1Z9', 'emily.brown@example.com', 'volunteer', 'assistant coach'),
(505, 'Michael', 'Williams', '1993-06-25', '159753486', '159753486-IJ', '514-567-8901', '567 Cedar Rd', 'Montreal', 'QC', 'H2X 3Y5', 'michael.w@example.com', 'salaried', 'secretary'),
(506, 'Sarah', 'Taylor', '1978-09-12', '753159246', '753159246-KL', '514-678-9012', '678 Birch Blvd', 'Longueuil', 'QC', 'G1R 4T6', 'sarah.t@example.com', 'volunteer', 'coach'),
(507, 'David', 'Miller', '1982-04-30', '258369147', '258369147-MN', '438-789-0123', '890 Spruce Ln', 'Laval', 'QC', 'H7V 5W7', 'david.m@example.com', 'salaried', 'coach'),
(508, 'Laura', 'Wilson', '1995-12-10', '369147258', '369147258-OP', '450-890-1234', '234 Maple Ct', 'Longueuil', 'QC', 'J4V 2X8', 'laura.w@example.com', 'volunteer', 'administrator'),
(509, 'James', 'Anderson', '1987-08-05', '147258369', '147258369-QR', '514-901-2345', '345 Walnut Dr', 'Montreal', 'QC', 'H3G 2Z3', 'james.a@example.com', 'salaried', 'administrator'),
(510, 'Olivia', 'Martinez', '1992-01-17', '654321987', '654321987-ST', '514-012-3456', '456 Poplar St', 'Longueuil', 'QC', 'G1S 1B7', 'olivia.m@example.com', 'volunteer', 'coach'),
(511, 'Alice', 'White', '1988-03-22', '987654321', 'A987654321', '514-223-4567', '111 River St', 'Montreal', 'QC', 'H1C 3D4', 'alice.white@volley.com', 'salaried', 'other');
-- (512, 'Charlie', 'Green', '1983-09-15', '876543219', 'B876543219', '514-334-5678', '222 Lake Ave', 'Montreal', 'QC', 'H2D 4E5', 'charlie.green@volley.com', 'salaried', 'administrator'),
-- (513, 'Sophia', 'Black', '1991-11-05', '765432198', 'C765432198', '514-445-6789', '333 Forest Rd', 'Laval', 'QC', 'H7N 2X5', 'sophia.black@volley.com', 'volunteer', 'administrator'),
-- (514, 'Ethan', 'Brown', '1986-06-30', '684521989', 'D654321987', '514-556-7890', '444 Elm Blvd', 'Longueuil', 'QC', 'J4H 2Y6', 'ethan.brown@volley.com', 'salaried', 'administrator'),
-- (515, 'Mia', 'Davis', '1979-12-12', '543219876', 'E543219876', '514-667-8901', '555 Maple St', 'Montreal', 'QC', 'H3B 1W3', 'mia.davis@volley.com', 'volunteer', 'coach'),
-- (516, 'Lucas', 'Wilson', '1994-07-19', '432198765', 'F432198765', '514-778-9012', '666 Birch Ave', 'Montreal', 'QC', 'H1A 2P3', 'lucas.wilson@volley.com', 'salaried', 'captain'),
-- (517, 'Ella', 'Moore', '1981-02-28', '321987654', 'G321987654', '514-889-0123', '777 Cedar Ln', 'Laval', 'QC', 'H7V 3T6', 'ella.moore@volley.com', 'salaried', 'coach'),
-- (518, 'Noah', 'Taylor', '1987-04-23', '219876543', 'H219876543', '514-990-1234', '888 Walnut St', 'Longueuil', 'QC', 'J4V 4X8', 'noah.taylor@volley.com', 'volunteer', 'administrator'),
-- (519, 'Grace', 'Clark', '1990-10-10', '198765432', 'I198765432', '514-111-2345', '999 Pine Blvd', 'Montreal', 'QC', 'H2X 5Y5', 'grace.clark@volley.com', 'salaried', 'other'),
-- (520, 'Liam', 'Martin', '1984-08-08', '987612345', 'J987612345', '514-222-3456', '123 Oak Dr', 'Montreal', 'QC', 'H3G 6Z6', 'liam.martin@volley.com', 'salaried', 'administrator')
-- (521, 'Henry', 'Clarkson', '1980-02-14', '523456789', 'K523456789', '514-777-1111', '789 King St', 'Montreal', 'QC', 'H3A 1B3', 'henry.clarkson@volley.com', 'salaried', 'manager'),
-- (522, 'Isabella', 'Fisher', '1982-06-23', '534567890', 'L534567890', '514-888-2222', '456 Queen St', 'Montreal', 'QC', 'H2B 2C4', 'isabella.fisher@volley.com', 'salaried', 'manager'),
-- (523, 'Benjamin', 'Wright', '1979-11-30', '545678901', 'M545678901', '514-999-3333', '123 Duke Rd', 'Laval', 'QC', 'H7N 4D5', 'benjamin.wright@volley.com', 'salaried', 'manager'),
-- (524, 'Charlotte', 'Harris', '1985-04-18', '556789012', 'N556789012', '438-000-4444', '678 Prince St', 'Longueuil', 'QC', 'J4K 3E6', 'charlotte.harris@volley.com', 'salaried', 'manager'),
-- (525, 'Daniel', 'Evans', '1988-07-09', '567890123', 'O567890123', '514-111-5555', '234 Baron Ave', 'Montreal', 'QC', 'H1A 5F7', 'daniel.evans@volley.com', 'salaried', 'manager'),
-- (526, 'Amelia', 'Scott', '1983-10-01', '578901234', 'P578901234', '514-222-6666', '345 Earl St', 'Montreal', 'QC', 'H2B 6G8', 'amelia.scott@volley.com', 'salaried', 'manager'),
-- (527, 'Jack', 'Adams', '1991-12-15', '589012345', 'Q589012345', '514-333-7777', '567 Queen Mary Rd', 'Laval', 'QC', 'H7V 7H9', 'jack.adams@volley.com', 'salaried', 'manager')
-- (528, 'Ryan', 'Cooper', '1984-03-11', '590123456', 'R590123456', '514-444-8888', '123 Coach Rd', 'Montreal', 'QC', 'H3A 1C3', 'ryan.cooper@volley.com', 'volunteer', 'coach'),
-- (529, 'Ava', 'Lewis', '1990-06-25', '601234567', 'S601234567', '514-555-9999', '456 Trainer St', 'Laval', 'QC', 'H7N 4E5', 'ava.lewis@volley.com', 'volunteer', 'coach'),
-- (530, 'Mason', 'Hall', '1987-09-14', '612345678', 'T612345678', '514-666-0000', '789 Sports Ln', 'Longueuil', 'QC', 'J4K 5F6', 'mason.hall@volley.com', 'volunteer', 'coach'),
-- (531, 'Lily', 'Baker', '1985-11-03', '623456789', 'U623456789', '514-777-1112', '234 Volleyball Ave', 'Montreal', 'QC', 'H1A 6G7', 'lily.baker@volley.com', 'volunteer', 'coach'),
-- (532, 'Jacob', 'Young', '1992-02-28', '634567890', 'V634567890', '514-888-2223', '567 Athlete Rd', 'Laval', 'QC', 'H7V 8H8', 'jacob.young@volley.com', 'volunteer', 'coach')
-- (533, 'Henry', 'Scott', '1993-08-14', '645678901', 'W645678901', '514-999-3333', '321 Captain St', 'Montreal', 'QC', 'H3B 3C8', 'henry.scott@volley.com', 'salaried', 'captain'),
-- (534, 'Chloe', 'Adams', '1995-04-12', '656789012', 'X656789012', '514-222-4444', '654 Team Blvd', 'Laval', 'QC', 'H7N 9D7', 'chloe.adams@volley.com', 'salaried', 'captain'),
-- (535, 'Daniel', 'Harris', '1991-11-22', '667890123', 'Y667890123', '514-333-5555', '987 Leader Ave', 'Longueuil', 'QC', 'J4K 4A5', 'daniel.harris@volley.com', 'salaried', 'captain');

INSERT INTO Locations (location_id, location_name, address, city, province, postal_code, web_address, max_capacity, location_type)
VALUES
(10001, 'Montreal HQ', '123 Main St', 'Montreal', 'QC', 'H3A 1B2', 'www.montrealhq.ca', 500, 'head'),
(10002, 'Laval Branch', '456 Elm St', 'Laval', 'QC', 'H7N 4X5', 'www.lavalbr.ca', 200, 'branch'),
(10003, 'Montreal Branch 1', '321 Peel St', 'Montreal', 'QC', 'H3B 2Z4', 'www.montrealbranch1.ca', 250, 'branch'),
(10004, 'Montreal Branch 2', '654 Stanley St', 'Montreal', 'QC', 'H3C 2Y5', 'www.montrealbranch2.ca', 150, 'branch'),
(10005, 'Montreal Branch 3', '890 Sherbrooke St', 'Montreal', 'QC', 'H3D 1Y6', 'www.montrealbranch3.ca', 180, 'branch'),
(10006, 'Longueuil Branch', '567 Cedar St', 'Longueuil', 'QC', 'J4K 3Z3', 'www.longueuilbr.ca', 220, 'branch'),
(10007, 'Montreal Branch 4', '234 Atwater Ave', 'Montreal', 'QC', 'H3E 3G4', 'www.montrealbranch4.ca', 700, 'branch'),
(10008, 'Montreal Branch 5', '789 Crescent St', 'Montreal', 'QC', 'H3F 3N5', 'www.montrealbranch5.ca', 300, 'branch'),
(10009, 'Montreal Branch 6', '432 Bleury St', 'Montreal', 'QC', 'H3G 4X1', 'www.montrealbranch6.ca', 180, 'branch'),
(10010, 'Montreal Branch 7', '999 Saint-Laurent Blvd', 'Montreal', 'QC', 'H3H 5Y2', 'www.montrealbranch7.ca', 450, 'branch');

INSERT INTO works_at (personnel_id, location_id, start_date, end_date, status)
VALUES
(501, 10001, '2019-03-01', NULL, 'active'),
(502, 10001, '2020-06-15', '2023-08-31', 'inactive'),
(503, 10005, '2018-09-10', NULL, 'active'),
(504, 10002, '2021-01-20', NULL, 'active'),
(505, 10001, '2017-04-25', '2020-10-10', 'inactive'),
(506, 10006, '2020-07-05', NULL, 'active'),
(507, 10002, '2019-11-30', NULL, 'active'),
(508, 10006, '2022-02-14', NULL, 'active'),
(509, 10009, '2018-08-05', NULL, 'active'),
(510, 10010, '2023-03-12', NULL, 'active'),
(511, 10001, '2024-01-10', NULL, 'active');
-- (512, 10002, '2024-01-15', NULL, 'active'),
-- (513, 10003, '2024-01-20', NULL, 'active'),
-- (514, 10004, '2024-01-25', NULL, 'active'),
-- (515, 10001, '2024-02-01', NULL, 'active'),
-- (516, 10003, '2024-02-05', NULL, 'active'),
-- (517, 10006, '2024-02-10', NULL, 'active'),
-- (518, 10008, '2024-02-15', NULL, 'active'),
-- (519, 10009, '2024-02-20', NULL, 'active'),
-- (520, 10010, '2024-02-25', NULL, 'active'),
-- (521, 10004, '2024-02-20', NULL, 'active'),
-- (522, 10010, '2024-02-21', NULL, 'active'),
-- (523, 10005, '2024-02-22', NULL, 'active'),
-- (524, 10008, '2024-02-23', NULL, 'active'),
-- (525, 10003, '2024-02-24', NULL, 'active'),
-- (526, 10008, '2024-02-25', NULL, 'active'),
-- (527, 10009, '2024-02-26', NULL, 'active'),
-- (533, 10001, '2024-03-03', NULL, 'active'),
-- (534, 10005, '2024-03-04', NULL, 'active'),
-- (535, 10004, '2024-03-05', NULL, 'active');

INSERT INTO `Locationphone` (`phone_number`, `location_id`, `call_type`)
VALUES
  ('514-123-4567', 10001, 'local'),  -- Montreal HQ
  ('800-555-1234', 10001, 'toll free'),
  ('450-987-6543', 10002, 'local'),  -- Laval HQ
  ('888-555-2345', 10002, 'toll free'),
  ('514-234-5678', 10003, 'local'),  -- Montreal Branch 1
  ('800-555-3456', 10003, 'toll free'),
  ('514-345-6789', 10004, 'local'),  -- Montreal Branch 2
  ('877-555-4567', 10004, 'toll free'),
  ('514-456-7890', 10005, 'local'),  -- Montreal Branch 3
  ('800-555-5678', 10005, 'toll free'),
  ('450-567-8901', 10006, 'local'),  -- Longueuil HQ
  ('888-555-6789', 10006, 'toll free'),
  ('514-567-8902', 10007, 'local'),  -- Montreal Branch 4
  ('800-555-7890', 10007, 'toll free'),
  ('514-678-9012', 10008, 'local'),  -- Montreal Branch 5
  ('888-555-8901', 10008, 'toll free'),
  ('514-789-0123', 10009, 'local'),  -- Montreal Branch 6
  ('800-555-9012', 10009, 'toll free'),
  ('514-890-1234', 10010, 'local'),  -- Montreal Branch 7
  ('877-555-0123', 10010, 'toll free');


INSERT INTO Familymembers (
    familymember_id, first_name, last_name, date_of_birth, ssn, 
    telephone_number, address, city, province, postal_code, email, medicare
) VALUES
(30001, 'Jonathan', 'Doe', '1975-04-12', '432-45-6789', '514-123-4567', '123 Main St', 'Montreal', 'QC', 'H3A 1B2', 'john.doe@email.com', 'M1646889095'),
(30002, 'Jose', 'Smith', '1982-09-23', '234-56-7880', '514-234-5678', '456 Elm St', 'Montreal', 'QC', 'H3B 2C3', 'jane.smith@email.com', 'M0859326525'),
(30003, 'Mat', 'Johnson', '1990-07-15', '345-67-8991', '514-345-6789', '789 Pine St', 'Montreal', 'QC', 'H3C 3D4', 'michael.johnson@email.com', 'M9355965647'),
(30004, 'Emma', 'Brown', '1978-12-30', '456-78-9912', '514-456-7890', '321 Oak St', 'Montreal', 'QC', 'H3D 4E5', 'emily.brown@email.com', 'M4201848967'),
(30005, 'Sam', 'Williams', '1965-06-10', '567-89-0553', '514-567-8901', '654 Maple St', 'Montreal', 'QC', 'H3E 5F6', 'david.williams@email.com', 'M2941348201'),
(30006, 'Sophie', 'Miller', '1995-03-18', '678-90-1238', '514-678-9012', '987 Birch St', 'Montreal', 'QC', 'H3F 6G7', 'sarah.miller@email.com', 'M2101194413'),
(30007, 'Jonna', 'Davis', '1988-08-22', '789-01-2375', '514-789-0123', '159 Cedar St', 'Montreal', 'QC', 'H3G 7H8', 'robert.davis@email.com', 'M1681927770'),
(30008, 'Josh', 'Wilson', '1973-11-05', '890-77-3456', '514-890-1234', '753 Walnut St', 'Montreal', 'QC', 'H3H 8I9', 'laura.wilson@email.com', 'M2106055917'),
(30009, 'Joshua', 'Anderson', '1980-05-27', '901-76-4567', '514-901-2345', '852 Chestnut St', 'Montreal', 'QC', 'H3I 9J0', 'james.anderson@email.com', 'M5484496583'),
(30010, 'Jack', 'Martinez', '1992-02-14', '012-65-5678', '514-012-3456', '369 Redwood St', 'Montreal', 'QC', 'H3J 0K1', 'olivia.martinez@email.com', 'M1104315473'),
(30011, 'Sophia', 'Taylor', '1985-06-22', '123-45-6789', '514-111-2222', '125 Maple Ave', 'Montreal', 'QC', 'H3A 2B3', 'sophia.taylor@email.com', 'M9068087925'),
(30012, 'Ethan', 'Martinez', '1994-09-12', '234-56-7890', '514-223-3445', '233 Birch St', 'Montreal', 'QC', 'H3B 3C4', 'ethan.martinez@email.com', 'M2027493512'),
(30013, 'Mia', 'Roberts', '1998-03-05', '345-67-8901', '514-334-4556', '345 Oak Blvd', 'Montreal', 'QC', 'H3C 4D5', 'mia.roberts@email.com', 'M2933204092'),
(30014, 'Lucas', 'Wilson', '1987-08-30', '456-78-9012', '514-445-5667', '567 Cedar Dr', 'Montreal', 'QC', 'H3D 5E6', 'lucas.wilson@email.com', 'M8583540235'),
(30015, 'Amelia', 'King', '1992-11-02', '567-89-0123', '514-556-6778', '789 Pine Ln', 'Montreal', 'QC', 'H3E 6F7', 'amelia.king@email.com', 'M4118089204');


INSERT INTO registered_at (familymember_id, location_id, start_date, end_date) 
VALUES
(30001, 10005, '2025-01-01', '2025-12-31'),
(30002, 10009, '2025-02-01', '2025-07-31'),
(30003, 10003, '2025-03-15', '2025-09-30'),
(30004, 10006, '2025-04-01', '2025-10-31'),
(30005, 10008, '2025-05-01', '2025-11-30'),
(30006, 10001, '2025-06-10', '2025-12-31'),
(30007, 10010, '2025-07-05', '2025-08-15'),
(30008, 10004, '2025-08-01', '2025-10-31'),
(30009, 10002, '2025-09-20', '2025-12-15'),
(30010, 10007, '2025-10-01', '2025-12-31'),
(30011, 10002, '2025-01-01', '2025-12-31'),
(30012, 10004, '2025-02-01', '2025-07-31'),
(30013, 10006, '2025-03-15', '2025-09-30'),
(30014, 10007, '2025-04-01', '2025-10-31'),
(30015, 10003, '2025-05-01', '2025-11-30');

INSERT INTO Teams (teams_id, location_id, team_type) 
VALUES
(14, 10001, 'girls'),
(15, 10002, 'boys'),
(16, 10003, 'girls'),
(17, 10004, 'boys'),
(18, 10005, 'girls'),
(19, 10006, 'boys'),
(20, 10007, 'girls'),
(21, 10008, 'boys'),
(22, 10009, 'girls'),
(23, 10010, 'boys');

INSERT INTO associated_with (familymember_id, clubmember_id, relationship_type) 
VALUES
(30001, 301, 'father'),
(30001, 316, 'father'),
(30002, 302, 'mother'),
(30002, 317, 'mother'),
(30003, 303, 'father'),
(30003, 318, 'father'),
(30004, 304, 'mother'),
(30004, 319, 'mother'),
(30005, 305, 'father'),
(30005, 320, 'father'),
(30006, 306, 'mother'),
(30007, 307, 'father'),
(30008, 308, 'mother'),
(30009, 309, 'father'),
(30010, 310, 'mother'),
(30011, 311, 'grandmother'),
(30012, 312, 'grandfather'),
(30013, 313, 'tutor'),
(30014, 314, 'partner'),
(30015, 315, 'friend');

INSERT INTO Payment (clubmember_id, payment_id, payment_amount, payment_date, payment_method, remaining_balance, membership_year, donation, status) 
VALUES
(301, 1001, 120, '2024-01-01', 'credit card', 0, 2025, 20, 'active'),
(302, 1002, 135, '2024-01-02', 'cash', 0, 2025, 0, 'active'),
(303, 1003, 110, '2024-01-03', 'debit', 0, 2025, 10, 'active'),
(304, 1004, 120, '2024-01-04', 'cash', 0, 2025, 0, 'active'),
(305, 1005, 150, '2024-01-05', 'credit card', 0, 2025, 50, 'active'),
(306, 1006, 60, '2024-01-06', 'debit', 40, 2025, 0, 'inactive'),
(307, 1007, 135, '2024-01-07', 'cash', 0, 2025, 0, 'active'),
(308, 1008, 120, '2024-01-08', 'debit', 0, 2025, 0, 'inactive'),
(309, 1009, 130, '2024-01-09', 'credit card', 0, 2025, 30, 'inactive'),
(310, 1010, 85, '2024-01-10', 'cash', 15, 2025, 0, 'inactive'),
(311, 1011, 115, '2024-01-11', 'debit', 0, 2025, 15, 'active'),
(312, 1012, 70, '2024-01-12', 'credit card', 30, 2025, 0, 'inactive'),
(313, 1013, 125, '2024-01-13', 'debit', 0, 2025, 25, 'active'),
(314, 1014, 110, '2024-01-14', 'cash', 0, 2025, 0, 'active'),
(315, 1015, 145, '2024-01-15', 'credit card', 0, 2025, 45, 'active'),
(316, 1016, 135, '2024-01-16', 'cash', 0, 2025, 0, 'active'),
(317, 1017, 200, '2024-01-17', 'debit', 0, 2025, 100, 'inactive'),
(318, 1018, 90, '2024-01-18', 'credit card', 10, 2025, 0, 'inactive'),
(319, 1019, 135, '2024-01-19', 'debit', 0, 2025, 35, 'active'),
(320, 1020, 110, '2024-01-20', 'cash', 0, 2025, 0, 'active');