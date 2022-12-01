<?php
   $link = mysqli_connect("localhost", "2021117446", "Database_2022", "SUGANG");

   //check connection
   if ($link == false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
   }
?>