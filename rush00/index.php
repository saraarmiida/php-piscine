
<?php
	include('install.php');
	include('product.php');
	include('user.php');
	install_database_if_not_exists();
	session_start();
	$products = read_products();
	$categories = array_unique(array_map(function ($product) { return $product["category"]; }, $products));
	sort($categories);
	if ($_GET['category'])
	{
		$products = array_filter($products, function($var) {
			return $var['category'] == $_GET['category'];
		});
	}
	if  ($_GET['order'] == 'success') {
		echo "<script type='text/javascript'>alert('Order Successful!');</script>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online shop</title>
		<link href="style.css" rel="stylesheet">
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
					if ($_SESSION['logged_in_user']) {
						$user = ucfirst($_SESSION['logged_in_user']);
						echo "Welcome ".${user};
						if ($_SESSION['permission_level'] == '1') {
							echo <<<html
								<a href="../rush00/admin.php">Admin</a>
							html;
						}
						echo <<<html
								<a href="logout.php" class="login">Log out</a>
						html; 
						if ($_SESSION['permission_level'] == '0') {
							echo <<<html
								/ <a href="#deletemodal">Delete</a>
							html;
						}
					} else {
						echo <<<html
							<a href="#loginmodal" class="login">Login</a> /
							<a href="#createmodal">Register</a>
						html;
					}
				?>
				</div>
				<?php
					$amount = 0;
					$sum = 0;
					if ($_SESSION[basket])
					{
						$amount = count($_SESSION[basket]);
						foreach ($_SESSION[basket] as $key => $value) {
							$sum += $value[price];
						}
					}
					echo <<<html
						<a href="#basketmodal" class="basket">Basket $amount | $sum EUR </a>
					html;
				?>
		</div>
		<div class="sidenav">
			<a href="index.php">All</a>
			<?php
				foreach ($categories as $key => $value) {
					echo <<<html
						<a href="index.php?category=$value">${value}s</a>
					html;
				}
			?>
		</div>
		<ul class="products">
			<?php 
				foreach ($products as $key => $value) {
					echo <<<html
						<li>
							<a href="#productmodal$value[id]">
								<img src=$value[image_url] alt="" />
								<h4>$value[name]</h4>
								<p>$value[price] EUR</p>
							</a>
						</li>
					html;
				}
			?>
		</ul>
		<div class="modal" id="loginmodal">
			<div class="modal-content">
				<a href="#" class="close">+</a>
				<form method="POST" action="login.php" >
					<h2>Login</h2>
					Username:<input type="text" name="login" placeholder="Username" value=""/>
					Password:<input type="password" name="passwd" placeholder="Password" value=""/>
					<input type="submit" name="submit" value="OK" />
				</form>
			</div>
		</div>
		<div class="modal" id="createmodal">
			<div class="modal-content">
				<a href="#" class="close">+</a>
				<form method="POST" action="user.php">
					<h2>Create an account</h2>
					Username:<input type="text" name="login" placeholder="Username" value=""/>
					Password:<input type="password" name="passwd" placeholder="Password" value=""/>
					<input type="submit" name="submit" value="add" />
				</form>
			</div>
		</div>
		<div class="modal" id="basketmodal">
			<div class="modal-content">
				<a href="#" class="close">+</a>
				<h2>Your basket</h2>
				<div style="position: relative;" class="basket">
					<object type="text/html" data="basket.php"></object>
					<form method="POST" action="order.php">
						<input type="submit" name="submit" value="order" />
					</form>
				</div>
			</div>
		</div>
		<div class="modal" id="deletemodal">
			<div class="modal-content">
				<a href="#" class="close">+</a>
				<form method="POST" action="user.php">
					<h2>Delete account</h2>
					Username:<input type="text" name="login" placeholder="Username" value=""/>
					Password:<input type="password" name="passwd" placeholder="Password" value=""/>
					<input type="submit" name="submit" value="delete" />
				</form>
			</div>
		</div>
		<?php 
			foreach ($products as $key => $value) {
				$product_id = $value["id"];
				echo <<<html
				<div class="productmodal" id="productmodal$product_id">
					<div class="modal-content">
						<a href="#" class="close">+</a>
						<div class="product_page">
							<img src=$value[image_url] alt="" />
							<div class="product_info">
								<h4>$value[name]</h4>
								<p>$value[price] EUR</p>
								<form method="POST" action="basket.php" >
								<input type="hidden" name="product_id" value="$product_id" />
								<input type="submit" name="submit" value="add" />
								</form>
							</div>
						</div>
					</div>
				</div>
				html;
			}
		?>
	</body>
</html>