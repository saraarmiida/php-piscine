<?php
	include_once('database.php');

	// Create users table (unique constraint for id)
	function create_users_table_if_not_exists($conn) {
		$query = "SELECT id FROM users";
		$result = mysqli_query($conn, $query);
		
		if(empty($result)) {
			$query = "CREATE TABLE users (
						id int(11) AUTO_INCREMENT,
						login varchar(255) NOT NULL,
						passwd varchar(255) NOT NULL,
						permission_level int,
						PRIMARY KEY (id),
						CONSTRAINT uc_login UNIQUE (login)
						)";
			$result = mysqli_query($conn, $query);
		}
	}

	function create_products_if_not_exists($conn)  {
		$query = "SELECT id FROM products";
		$result = mysqli_query($conn, $query);
		
		if(empty($result)) {
			$query = "CREATE TABLE products (
						id int(11) AUTO_INCREMENT,
						category varchar(255) NOT NULL,
						name varchar(255) NOT NULL,
						price float,
						image_url varchar(2083) NOT NULL,
						PRIMARY KEY (id)
						)";
			$result = mysqli_query($conn, $query);
		}
	}

	function create_orders_if_not_exists($conn)  {
		$query = "SELECT id FROM orders";
		$result = mysqli_query($conn, $query);
		
		if(empty($result)) {
			$query = "CREATE TABLE orders (
						id int(11) AUTO_INCREMENT,
						user_id varchar(255) NOT NULL,
						product_id int(11) NOT NULL,
						order_id varchar(255) NOT NULL,
						timestamp int,
						PRIMARY KEY (id)
						)";
			$result = mysqli_query($conn, $query);
		}
	}

	function install_database_if_not_exists() {
		$conn = connect_to_database();
	
		$sql = "CREATE DATABASE IF NOT EXISTS rush00";
		if (mysqli_query($conn, $sql)) {
			mysqli_select_db ($conn , 'rush00');
			create_users_table_if_not_exists($conn);
			create_products_if_not_exists($conn);
			create_orders_if_not_exists($conn);
		} else {
			echo "Database Error: " . mysqli_error($conn);
		}
		close_connection($conn);
	}

	if (php_sapi_name() == "cli") {
		install_database_if_not_exists();
		echo "Installed database\n";
	}
?>
