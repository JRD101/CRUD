CREATE TABLE employees (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    time_in TIME() NOT NULL,
    time_out TIME() NOT NULL
);