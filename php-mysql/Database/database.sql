CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100),
    salary DECIMAL(10, 2),
    department VARCHAR(50)
);

INSERT INTO employees (first_name, last_name, email, salary, department) VALUES 
('John', 'Doe', 'john.doe@example.com', 50000, 'IT'),
('Jane', 'Doe', 'jane.doe@example.com', 52000, 'HR'),
('Jim', 'Beam', 'jim.beam@example.com', 55000, 'Marketing'),
('Jack', 'Daniels', 'jack.daniels@example.com', 53000, 'Sales'),
('Johnny', 'Walker', 'johnny.walker@example.com', 60000, 'Finance'),
('Jameson', 'Irish', 'jameson.irish@example.com', 58000, 'Development'),
('Jin', 'Bean', 'jin.bean@example.com', 48000, 'Support'),
('Jose', 'Cuervo', 'jose.cuervo@example.com', 49000, 'Administration'),
('Jerry', 'Can', 'jerry.can@example.com', 47000, 'Logistics'),
('Jill', 'Hill', 'jill.hill@example.com', 51000, 'Operations');
