<?php
	require('install.php');
	require('product.php');
	require('user.php');
	require('order.php');
	session_start();
	$products = read_products();
	$users = read_users();
	$orders = read_orders();
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="admin.css" rel="stylesheet" type="text/css">
		<script>
			function showElement(element) {
  				var orders = document.getElementById("orders");
				var products = document.getElementById("products");
				var users = document.getElementById("users");
  				if (element == "orders") {
    				orders.style.display = "block";
					products.style.display = "none";
					users.style.display = "none";
  				}
				else if (element == "products")
				{
					orders.style.display = "none";
					products.style.display = "block";
					users.style.display = "none";
				}
				else if (element == "users")
				{
					orders.style.display = "none";
					products.style.display = "none";
					users.style.display = "block";
				}
			}
		</script>
	</head>
	<body>
		<div class="topbar">
			<div class="shop_name"><h1>AnimalLife</h1></div>
			<div class="user_info">
				<?php
				// Check if we got error (only place currently where this hack is set is user creation).
				// Since we don't allow duplicate users.
				// Otherwise, if we have a logged_in_user, show different stuff depending on whether permission level
				// is 0 (common) or 1 (admin). Eg. link to admin page.
					if ($_GET['error'])
						echo $_GET['error'];
					$user = ucfirst($_SESSION['logged_in_user']);
					echo $user;
					echo <<<html
						<a href="../rush00/index.php">Home</a>
					html;
					echo <<<html
							<a href="logout.php" class="login">Log out</a>
					html;
				?>
			</div>
		</div>

		<ul class="sidenav">
			<li><a onclick="showElement('orders')">Orders</a></li>
			<li><a onclick="showElement('users')">Users</a></li>
			<li><a onclick="showElement('products')">Products</a></li>
		</ul>
		<div class="orders" id="orders" align="center">
			<table>
				<?php
					if ($orders) {
						foreach ($orders as $key => $value) {
							$order_id = $value[0]['order_id'];
							$user_id = $value[0]['user_id'];
							$sum = order_sum($order_id);
							echo <<<html
								<tr class="order">
									<form method="POST" action="order.php">
										<th>$order_id</th>
										<th>$user_id</th>
										<th>$sum</th>
										<input type="hidden" name="order_id" value="$order_id"/>
										<th><input type="submit" name="submit" value="delete"/></th>
									</form>
								</tr>
							html;
						}
					}
					else {
						echo "There are no orders";
					}
				?>
			</table>
		</div>
		<div class="users" id="users" align="center">
				<?php 
					if ($users) {
						foreach ($users as $key => $value) {
								$type = $value[permission_level] == 1 ? "admin" : "customer";
							echo <<<html
								<div class="user">
									<form method="POST" action="user.php">
										<p>user: $value[login] type: $type</p>
										<input type="hidden" name="login" value="$value[login]" />
										<input type="submit" name="submit" value="delete" />
									</form>
								</div>
							html;
						}
					}
					else {
						echo "There are no users";
					}
				?>
		</div>
		<div class="products" id="products" align="center">
			<table>
			<?php
				echo <<<html
				<form method="POST" action="product.php">
				<div class="form_info_new">
						<h3>Add new product</h3>
						<label for="name">Name:</label>		
						<input id="name" type="text" name="name" value="" placeholder="name"/></br>
						<label for="category">Category:</label>
						<input id="category" type="text" name="category" value="" placeholder="category"/></br>
						<label for="price">Price:</label>
						<input id="price" type="text" name="price" value="" placeholder="price"/></br>
						<label for="image_url">Image_url:</label>
						<input id="image_url" type="text" name="image_url" value="" placeholder="image url"/></br>
						<input type="submit" name="submit" value="add" />
				</div>
				</form>
				html;
					if ($products) {
						foreach ($products as $key => $value) {
							echo <<<html
								<tr class="item">
									<td><img src=$value[image_url] alt="" /></td>
									<td>
										<form method="POST" action="product.php">
											<div class="form_info">
												<label for="name">Name:</label>
												<input id="name" type="text" name="name" value="$value[name]"/></br>
												
												<label for="category">Category:</label>
												<input id="category" type="text" name="category" value="$value[category]"/></br>
												
												<label for="price">Price:</label>
												<input id="price" type="text" name="price" value="$value[price]"/></br>
												
												<label for="image_url">Image url:</label>
												<input id="image_url" type="text" name="image_url" value="$value[image_url]"/></br>
												<input id="id" type="hidden" name="id" value="$value[id]"/></br>
												<input type="submit" name="submit" value="update" /></br>
												<input type="submit" name="submit" value="delete" /></br>
											</div>
										</form>
									</td>
								</tr>
							html;
						}
					}
					else {
						echo "There are no products";
					}
			?>

			</table>
		</div>
	</body>
</html>