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
    <div class="main-container">
      <div class="placeholder"></div>

      <div class="row">
        <p>Search for Student by ID or name</p>
      </div>
      <div class="row">
        <input id="searchbar" type="text" placeholder="Student ID or name" />
        <button id="search-button">Search</button>
        <button onclick="window.location.href='scripts/logout.php'" style="width: 100px;">Logout</button>
      </div>

      <div class="placeholder"></div>
    </div>
  </body>
