<?php 
include"dbms.inc.php";
session_start();
session_destroy();

header("location:../index.php"); //ricarica la index page

        ?>
