<?php 
  header('Content-Type:  application/pdf');
  readfile($_GET['pdf']);
?>