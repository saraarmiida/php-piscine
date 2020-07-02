<?php
	include_once('database.php');
	include_once('product.php');

	function create_order($user_id, $products, $order_id, $time) {
		$conn = connect_to_database();
		$user_id = mysqli_real_escape_string($conn, $user_id);
		$order_id = mysqli_real_escape_string($conn, $order_id);
		mysqli_select_db ($conn , 'rush00');
		foreach ($products as $key => $value) {
			$product_id = (int)$value['id'];
			$query = "INSERT INTO orders (product_id, user_id, order_id, timestamp)
			VALUES ('$product_id', '$user_id', '$order_id', '$time');";
			$result = mysqli_query($conn, $query);
			echo (mysqli_error($conn));
		}
		if ($result)
			return (true);
		else
			echo (mysqli_error($conn));
		close_connection($conn);
		return (false);
	}

	function read_orders() {
		$conn = connect_to_database();
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT product_id, user_id, order_id, timestamp FROM orders ORDER BY order_id;";
		$result = mysqli_query($conn, $query);
		echo (mysqli_error($conn));
		close_connection($conn);
		if ($result)
		{
			$orders = [];
			foreach ($result->fetch_all(MYSQLI_ASSOC) as $key => $value) {
				$orders[$value['order_id']][] = $value;
			}
			return ($orders);
		}
		else
			return (false);
	}

	function read_order($order_id) {
		$conn = connect_to_database();
		$order_id = mysqli_real_escape_string($conn, $order_id);
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT product_id, user_id, order_id, timestamp FROM orders
				WHERE order_id='$order_id';";
		$result = mysqli_query($conn, $query);
		close_connection($conn);
		if ($result)
			return ($result->fetch_all(MYSQLI_ASSOC));
		else
			return (false);
	}

	function delete_order($order_id) {
		$conn = connect_to_database();
		$order_id = mysqli_real_escape_string($conn, $order_id);
		mysqli_select_db ($conn , 'rush00');
		$query = "DELETE FROM orders WHERE order_id='$order_id';";
		$result = mysqli_query($conn, $query);
		if ($result)
			echo "Deleted orders from $order_id if existed\n";
		else
			echo die(mysqli_error($conn));
		close_connection($conn);
	}

	function update_order($products, $order_id) {
		if (read_order($order_id)) {
			delete_order($order_id);
			create_order($products, $order_id);
		} else {
			echo "Order with id $order_id not found\n";
		}
	}

	function order_sum($order_id) {
		$order = read_order($order_id);
		if (!$order)
			return (0);
		$sum = 0;
		foreach ($order as $value) {
			$product = read_product($value['product_id']);
			$sum += $product['price'];
		}
		return ($sum);
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		date_default_timezone_set('Europe/Helsinki');
		session_start();
		if (!($_SESSION['logged_in_user']))
		{
			echo "ERROR\n";
			header('Location: ../rush00/index.php#loginmodal');
			return ;
		}
		if ($_POST['submit'] == 'order') {
			// Creates a unique order id
			$order_id = time() . mt_rand() . $_SESSION['logged_in_user'];
			if (create_order($_SESSION['logged_in_user'], $_SESSION['basket'], $order_id, time()))
			{
				$_SESSION['basket'] = NULL;
				header('Location: ../rush00/index.php?order=success');
			}
			else
				echo "ERROR\n";	
		}
		else if ($_SESSION['permission_level'] == '1' && $_POST['submit'] == 'update') {
			if ($_POST['products'] && $_POST['order_id'])
				update_order($_POST['products'], $_POST['order_id']);
			else
				echo "ERROR\n";	
			header('Location: ../rush00/admin.php');
		}
		else if ($_SESSION['permission_level'] == '1' && $_POST['submit'] == 'delete') {
			if ($_POST['order_id'])
				delete_order($_POST['order_id']);
			else
				echo "ERROR\n";
			header('Location: ../rush00/admin.php');
		}
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		session_start();
		if ($_GET['order_id'] && $_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1' && strpos($_SERVER['REQUEST_URI'], 'order.php') !== false) {
			echo "<pre>";
			print_r(read_order($_GET['order_id']));
			$sum = order_sum($order_id);
			echo "SUM: $sum EUR\n";
			echo "</pre>";
		}
		else if ($_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1' && strpos($_SERVER['REQUEST_URI'], 'order.php') !== false)
		{
			echo "<pre>";
			foreach (read_orders() as $order_id => $element) {
				print_r($element);
				$sum = order_sum($order_id);
				echo "SUM: $sum EUR\n";
			}
			echo "</pre>";
		}
	}

?>