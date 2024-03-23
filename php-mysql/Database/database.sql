CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100),
    salary DECIMAL(10, 2),
    department VARCHAR(50)
);

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `employees`
DROP COLUMN `department`,
ADD COLUMN `department_id` INT NULL,
ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`);
