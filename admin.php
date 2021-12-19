<?php
session_start();

if (!isset($_SESSION["id_user"])){
	echo "Es obligatorio identifiacarse!";
	exit();
}

if (intval($_SESSION["id_user"]) != 1){
	echo "No tienes permiso para estar aquí!";
	exit();
}

require("template.php");


$content = "";

$id_product = 0;
if (isset($_GET["id_product"]))
	$id_product = intval($_GET["id_product"]);

if ($id_product == 0){
	$content = <<<EOD
<form method="post" action="product_insert_req.php" id="product-form">
<h2>Inserción de nuevo producto</h2>
<p><label for="product">Product</label><input type="text" name="product" id="product" /></p>
<p><label for="description">Description</label><input type="text" name="description" id="description" /></p>
<p><label for="price">Price</label><input type="text" name="price" id="price" /></p>
<p><label for="reference">Reference</label><input type="text" name="reference" id="reference" /></p>
<p><label for="website">Website</label><input type="text" name="website" id="website" /></p>
<p><label for="id_group">ID Group</label><input type="text" name="id_group" id="id_group" /></p>
<p><label for="id_engine_version">ID Engine Version</label><input type="text" name="id_engine_version" id="id_engine_version" /></p>
<p><input type="submit" /></p>
</form>
EOD;
}
else{
	require("config.php");

	$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);
	
	$query = <<<EOD
SELECT * FROM products WHERE id_product={$id_product};
EOD;

	$res = $conn->query($query);

	if (!$res){
		echo "Error: Producto erróneo";
		exit();
	}

	if ($res->num_rows != 1){
		echo "Error: Producto no existe";
		exit();
	}

	$prod = $res->fetch_assoc();

	$content = <<<EOD
<form method="post" action="product_update_req.php" id="product-form">

<input type="hidden" name="id_product" value="{$prod["id_product"]}" />

<h2>Actualización producto</h2>
<p><label for="product">Product</label>
	<input type="text" name="product" id="product" value="{$prod["product"]}" /></p>
<p><label for="description">Description</label><input type="text" name="description" id="description"  value="{$prod["description"]}" /></p>
<p><label for="price">Price</label><input type="text" name="price" id="price"  value="{$prod["price"]}" /></p>
<p><label for="reference">Reference</label><input type="text" name="reference" id="reference"  value="{$prod["reference"]}" /></p>
<p><label for="website">Website</label><input type="text" name="website" id="website"  value="{$prod["website"]}" /></p>
<p><label for="id_group">ID Group</label><input type="text" name="id_group" id="id_group" value="{$prod["id_group"]}"  /></p>
<p><label for="id_engine_version">ID Engine Version</label><input type="text" name="id_engine_version" id="id_engine_version" value="{$prod["id_engine_version"]}"  /></p>
<p><input type="submit" /></p>
</form>
EOD;



}


showHeader("ENTIenda ADMIN");
showContent($content);
showFooter();             
