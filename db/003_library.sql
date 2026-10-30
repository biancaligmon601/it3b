 ---#1 students table
CREATE TABLE students (
    --primarykey for the student table
    student_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,

    --student name
    student_first_name VARCHAR(50) NOT NULL,
    student_last_name VARCHAR(50) NOT NULL,

    --student course
    student_course VARCHAR(50) NOT NULL,    

    --student created at timestamp
    student_created_at TIMESTAMP  NOT NULL
        DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_general_ci;

-- #2 books table
CREATE TAVLE IF NOT EXISTS books(
    --primarykey for the books table
    book_id INT NOT NULL AUTO_INCREMENT ,

   --book details
    book_title VARCHAR(100) NOT NULL,
    book_author VARCHAR(100) NOT NULL,
    book category VARCHAR(50) NOT NULL,

    --book created at timestamp
    book_created_at TIMESTAMP  NOT NULL
        DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

--# borrow table
CREATE TABLE IF NOT EXISTS borrow(
    --primarykey for the borrow table
    borrow_id INT AUTO_INCREMENT PRIMARY KEY,

    --foreign references
    student_id INT NOT NULL,
    book_id INT NOT NULL,

    --borrow timestamp not null by default
    borrow_date TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    --borrow return date timestamp null by default
    borrow_return_date TIMESTAMP NULL 
    DEFAULT NULL,

    --borrow table constrainta and foreign keys
    CONSTRAINT fk_borrow_student 
        FOREIGN KEY (student_id) 
        REFERENCES students(student_id),
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_borrow_book
       FOREIGN KEY (book_id)
       REFERENCES books(book_id),
       ON UPDATE CASCADE
       ON DELETE RESTRICT

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

--Insert statement #1: Insert Students
INSERT INTO students(
    student_first_name,
    student_last_name,
    student_course
) VALUES
    ('Bianca', 'Ligmon', 'BSIT'),
    ('Binna', 'Cempron', 'BSBA'),
    ('Bixxa', 'Viodor', 'BEED'),
    ('Biyya', 'Daman', 'BSED');

--Insert statement #2: Insert Books
INSERT INTO books(
    book_title,
    book_author,
    book_category
) VALUES
    ('ILove Since 1882', 'Secret', 'Fiction'),
    ('To Kill a Mockingbird', 'Harper Lee', 'Fiction'),
    ('1984', 'George Orwell', 'Dystopian'),
    ('Pride and Prejudice', 'Jane Austen', 'Romance');
--Insert statement #3: Insert Borrow 
INSERT INTO borrow(
    student_id,
    book_id,
) VALUES
(1,2),
(2,1),
(3,3);