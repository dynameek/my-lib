 <header class="bg-cool-blue">
<div class="site-icon">
    <h3><a href="./dashboard.php">BizBuzz</a></h3>
</div>
<div class="right">
    <ul>
        <li><a href="./new-listing.php">Add Listing</a></li>
        <li>: <?php
        	 echo $name = $_SESSION['admin_info']['firstname'];
          ?>
        </li>
		<li><a href="./logout.php">Log Out</a></li>
    </ul>
</div>
</header>