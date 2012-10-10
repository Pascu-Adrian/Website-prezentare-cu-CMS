<?php
session_start();
echo 'Logout reusit. <a href="index.php">Click aici pentru a reveni</a>';
session_destroy();
?>