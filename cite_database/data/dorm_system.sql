DROP TABLE IF EXISTS room_assignments;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS floors;
DROP TABLE IF EXISTS pavilions;


CREATE TABLE pavilions (
    pavilion_id INT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE floors (
    floor_id INT NOT NULL PRIMARY KEY,
    number INT NOT NULL,
    pavilion_id INT,
    FOREIGN KEY (pavilion_id) REFERENCES pavilions(pavilion_id)
);

CREATE TABLE rooms (
    room_id INT NOT NULL PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    floor_id INT,
    max_capacity INT DEFAULT 2,
    FOREIGN KEY (floor_id) REFERENCES floors(floor_id)
);

CREATE TABLE students (
    student_id bigint NOT NULL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    field_of_study VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    UNIQUE(email)
);

CREATE TABLE room_assignments (
    assignment_id INT NOT NULL PRIMARY KEY,
    student_id bigint,
    room_id INT,
    date_assigned DATE NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id),
    UNIQUE(student_id)
);