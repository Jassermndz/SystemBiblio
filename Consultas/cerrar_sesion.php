<?php
session_start();
session_destroy();

header("Location: /SystemBiblio/index.html");
exit();
?>
