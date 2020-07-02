<?php
	include_once('product.php');

	function add_to_basket($product_id) {
		session_start();
		if (!$_SESSION['basket']) {
			$_SESSION['basket'] = array();
		}
		$product = read_product($product_id);
		$_SESSION['basket'][] = $product;
	}

	function remove_from_basket($product_id) {
		if (!$_SESSION['basket'])
			return ;
		$key = array_search($product_id, array_column($_SESSION['basket'], 'id'));
		$removed = false;
		$new_basket = [];
		foreach ($_SESSION['basket'] as $key => $product) {
			if (!$removed && $product['id'] == $product_id)
			{
				$removed = true;
				continue ;
			}
			$new_basket[] = $product;
		}
		$_SESSION['basket'] = NULL;
		$_SESSION['basket'] = $new_basket;
		header('Location: ../rush00/basket.php');
	}

	function empty_basket() {
		session_start();
		if (!$_SESSION['basket'])
			return ;
		$_SESSION['basket'] = NULL;
	}

	function basket_sum() {
		$sum = 0;
		foreach ($_SESSION['basket'] as $key => $value) {
			$sum += $value['price'];
		}
		return ($sum);
	}

	function basket_products() {
		$basket_products = $_SESSION['basket'];
		$products_by_name = [];
		foreach ($basket_products as $key => $value) {
			$products_by_name[$value['name']][] = $value;
		}
		return ($products_by_name);
	}

	session_start();
	$_SESSION['basket'] = array_values($_SESSION['basket']);
	$basket_products = basket_products();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();
		if ($_POST['submit'] == 'remove' && $_POST['product_id']) {
			remove_from_basket($_POST['product_id']);
		}
		else if ($_POST['submit'] == 'add' && $_POST['product_id']) {
			add_to_basket($_POST['product_id']);
			header('Location: ../rush00/index.php');
		}
	}
?>

<!DOCTYPE html>
<html>
<body>
	<div>
	<ul>
	<?php
		foreach ($basket_products as $key => $product) {
			$name = $key;
			$price = $product[0]['price'];
			$count = count($product);
			$product_id = $product[0]['id'];
			echo <<<html
				<li style="list-style-type:none;"><b>$name</b> price: $price count: $count
				<form method="POST" action="basket.php">
					<input type="hidden" name="product_id" value="$product_id" />
					<input type="submit" name="submit" value="remove" onClick="window.location.reload();" />
				</form>
				</li>
			html;
		}
	?>
	</ul>
	</div>
	<div>
		<?php 
			if (count($basket_products) > 0) {
				$sum = basket_sum();
				echo "Total: $sum\n";
			} else {
				echo "Empty\n";
			}
		?>
	</div>
</body>
</html>