<?php
include("scripts/auth_check.php");
check_auth();
?>
<!DOCTYPE html>

<head>
  <!-- page script and styles -->
  <link rel="stylesheet" href="frontend/styles.css" />
  <script src="frontend/searchpage.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<!-- Main content -->

<body>
  <div class="content searchpage-container">
    <div class="header">
      <h1 id="title">Student Database</h1>
      <div class="placeholder"></div>
      <button onclick="window.location.href='scripts/logout.php'">Logout</button>
    </div>

    <div class="placeholder"></div>

    <div class="row">
      <input id="searchbar" class="main-searchbar" type="text" placeholder="Student ID or name" />
      <button id="search-button">Search</button>
    </div>


    <div class="placeholder"></div>
    <div class="placeholder"></div>
  </div>
</body>