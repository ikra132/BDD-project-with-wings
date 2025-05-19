-- Insert data into pavilions 
INSERT INTO pavilions (pavilion_id, name) VALUES 
(1, 'A Pavilion'),
(2, 'B Pavilion'),
(3, 'C Pavilion'),
(4, 'D Pavilion');

-- Insert data into floors
INSERT INTO floors (floor_id, number, pavilion_id) VALUES 
(101, 1, 1),
(102, 2, 1),
(201, 1, 2),
(202, 2, 2),
(301, 1, 3),
(401, 1, 4);

-- Insert data into rooms
INSERT INTO rooms (room_id, room_number, floor_id, max_capacity) VALUES 
(1001, '101', 101, 2),
(1002, '102', 101, 2),
(1003, '103', 101, 3),
(2001, '201', 102, 2),
(2002, '202', 102, 2),
(3001, '301', 201, 2),
(4001, '401', 301, 2),
(5001, '501', 401, 2);

-- Insert Algerian female students
INSERT INTO students (student_id, full_name, email, field_of_study, password) VALUES
(232331254030, 'Fatima Zohra Boukadoum', 'fatima.boukadoum@univ-alger.dz', 'Medicine', SHA2('fatima456', 256)),
(232331254032, 'Amina Cherif', 'amina.cherif@univ-constantine.dz', 'Law', SHA2('amina2023', 256)),
(232331254034, 'Nadia Mekki', 'nadia.mekki@univ-batna.dz', 'Architecture', SHA2('nadia456', 256)),
(232331254036, 'Leila Saadi', 'leila.saadi@univ-tlemcen.dz', 'Chemistry', SHA2('leila123', 256)),
(232331254038, 'Soraya Hamidouche', 'soraya.hamidouche@univ-bejaia.dz', 'Biology', SHA2('soraya789', 256)),
(232331254040, 'Yasmina Khettab', 'yasmina.k@univ-oran.dz', 'Computer Science', SHA2('yasmina123', 256)),
(232331254042, 'Chenaf ikram', 'ikram.b@univ-blida.dz', 'Computer Science', SHA2('ikrama456', 256));


-- Assign female students to rooms
INSERT INTO room_assignments (assignment_id, student_id, room_id, date_assigned) VALUES
(1, 232331254030, 1001, '2024-09-01'),
(2, 232331254032, 1001, '2024-09-01'),
(3, 232331254034, 1002, '2024-09-01'),
(4, 232331254036, 1002, '2024-09-01'),
(5, 232331254038, 1003, '2024-09-01'),
(6, 232331254040, 1003, '2024-09-01'),
(7, 232331254042, 1003, '2024-09-01');