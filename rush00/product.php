<?php
	include_once('database.php');

	function create_product($category, $name, $price, $image_url) {
		$conn = connect_to_database();
		$category = mysqli_real_escape_string($conn, $category);
		$name = mysqli_real_escape_string($conn, $name);
		$price = mysqli_real_escape_string($conn, $price);
		$image_url = mysqli_real_escape_string($conn, $image_url);
		mysqli_select_db ($conn , 'rush00');
		$query = "INSERT INTO products (category, name, price, image_url)
			VALUES ('$category', '$name', '$price', '$image_url');";
		$result = mysqli_query($conn, $query);
		if ($result)
		{
			echo "Added product $category $name\n";
			return (true);
		}
		else
			echo (mysqli_error($conn));
		close_connection($conn);
		return (false);
	}

	function read_products() {
		$conn = connect_to_database();
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT id, category, name, price, image_url FROM products;";
		$result = mysqli_query($conn, $query);
		close_connection($conn);
		if ($result)
			return ($result->fetch_all(MYSQLI_ASSOC));
		else
			return (false);
	}

	function read_product($id) {
		$conn = connect_to_database();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT id, category, name, price, image_url FROM products
				WHERE id='$id';";
		$result = mysqli_query($conn, $query);
		close_connection($conn);
		if ($result)
			return ($result->fetch_array(MYSQLI_ASSOC));
		else
			return (false);
	}

	function delete_product($id) {
		$conn = connect_to_database();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_select_db ($conn , 'rush00');
		$query = "DELETE FROM products WHERE id='$id';";
		$result = mysqli_query($conn, $query);
		if ($result)
			echo "Deleted product $id if existed\n";
		else
			echo die(mysqli_error($conn));
		close_connection($conn);
	}

	function update_product($id, $category, $name, $price, $image_url) {
		if (read_product($id)) {
			delete_product($id);
			create_product($category, $name, $price, $image_url);
		} else {
			echo "Product with id $id not found\n";
		}
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && strpos($_SERVER['REQUEST_URI'], 'product.php') !== false) {
		session_start();
		if (!($_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1'))
		{
			echo "ERROR\n";
			return ;
		}
		if ($_POST['submit'] == 'add') {
			if ($_POST['category'] && $_POST['name'] && $_POST['price'] && $_POST['image_url'])
				create_product($_POST['category'], $_POST['name'], $_POST['price'], $_POST['image_url']);
			else
				echo "ERROR\n";	
		}
		else if ($_POST['submit'] == 'update') {
			if ($_POST['category'] && $_POST['name'] && $_POST['price'] && $_POST['image_url'] && $_POST['id'])
				update_product( $_POST['id'], $_POST['category'], $_POST['name'], $_POST['price'], $_POST['image_url']);
			else
				echo "ERROR\n";	
		}
		else if ($_POST['submit'] == 'delete') {
			if ($_POST['id'])
				delete_product($_POST['id']);
			else
				echo "ERROR\n";	
		}
		header('Location: ../rush00/admin.php');
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && strpos($_SERVER['REQUEST_URI'], 'product.php') !== false) {
		session_start();
		if ($_GET['id'] && $_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1') {
			echo "<pre>";
			print_r(read_product($_GET['id']));
			echo "</pre>";
		}
		else if ($_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1')
		{
			echo "<pre>";
			print_r(read_products());
			echo "</pre>";
		}
	}

	// Validation & prints if this script is called from command line
	if (php_sapi_name() == "cli") {
		// args: add $category, $name, $price, $image_url
		if ($argv[1] == 'add' && $argv[2] && $argv[3] &&
				is_float(floatval($argv[4])) && filter_var($argv[5], FILTER_VALIDATE_URL))
		{
			if ($argv[3] && $argv[4])
				create_product($argv[2], $argv[3], $argv[4], $argv[5]);
			else
				echo "Invalid arguments\n";
		}
		// args: update $category, $name, $price, $image_url, $id
		else if ($argv[1] == 'update' && $argv[2] && $argv[3] &&
				is_float(floatval($argv[4])) && filter_var($argv[5], FILTER_VALIDATE_URL) && $argv[6])
		{
			if ($argv[3] && $argv[4])
			update_product($argv[6], $argv[2], $argv[3], $argv[4], $argv[5]);
			else
				echo "Invalid arguments\n";
		}
		else if ($argv[1] == 'delete')
		{
			if ($argv[2])
				delete_product($argv[2]);
			else
				echo "Invalid arguments\n";
		}
		else if ($argv[1] == 'read')
		{
			if ($argv[2])
			{
				if ($product = read_product($argv[2]))
					print_r($product);
				else
					echo "Could not fetch product\n";
			}
			else if ($product = read_products())
				print_r($product);
			else
				echo "Could not fetch products\n";
		}
		else
			echo "Invalid arguments\n";
	}
?>