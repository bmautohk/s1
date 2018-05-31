<?php
require_once 'Image/Barcode.php';
Image_Barcode::draw($_GET["barcode"], 'ean13', 'png');
?>