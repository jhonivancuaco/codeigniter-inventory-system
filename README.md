# codeigniter-inventory-system

## GUIDELINES

### What is it?
- It is an Inventory Management System (IMS) Application that uses  CodeIgniter open source application development framework for PHP

### How to setup codeigniter?
- Install XAMPP or WAMP server to run codeigniter application in localhost
- Extract the zip file and add the extracted folder to your htdocs folder
- Change folder name to what you want
- Go to application/config/database.php
- Setup your database connection details
    - for example: database name, username, password

```
$db['default'] = array(
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'inventory',
);
```

- Open your browser and go to http://localhost/{folder_name}

### How it works?
- Open your browser and go to http://localhost/{folder_name}/{controller_name}/{controller_method_name}

- for example: http://localhost/inventory/page/login
    - folder name: inventory
    - controller name: page
    - controller method name: login