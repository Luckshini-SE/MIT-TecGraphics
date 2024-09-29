<?php
include('db_connection.php');
?>

<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="dashboard.php">
					<!-- <span class="align-middle">TecGraphics</span>-->
					<img src="assets/img/logo.png" alt="TecGraphics" class="img-fluid">
				</a>

				<ul class="sidebar-nav">
					
					<li class="sidebar-item active">
						<a class="sidebar-link" href="dashboard.php">
							<i class="align-middle" data-feather="sliders"></i> 
							<span class="align-middle">Dashboard</span>
						 </a>

					</li>

					<?php
					$select_section = mysqli_query($con, "SELECT p.icon, p.section FROM pages p, user_privilege u WHERE p.id = u.page AND p.active = 'yes' AND u.user_type = '{$_SESSION["logUserType"]}' GROUP BY p.section ORDER BY p.section_order");
					while($result_section = mysqli_fetch_array($select_section)){
					?>
					<li class="sidebar-item">
						<a data-bs-target="#<?php echo strtolower(preg_replace('/\s*/', '', $result_section['section'])).'smdiv'; ?>" data-bs-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle" data-feather="<?php echo $result_section['icon']; ?>"></i> <span class="align-middle"><?php echo $result_section['section']; ?></span> 
						</a>
						<ul id="<?php echo strtolower(preg_replace('/\s*/', '', $result_section['section'])).'smdiv'; ?>" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
							<?php
							$select_page = mysqli_query($con, "SELECT p.description, p.php_name FROM pages p, user_privilege u WHERE p.id = u.page AND p.section = '{$result_section['section']}' AND p.active = 'yes' AND u.user_type = '{$_SESSION["logUserType"]}' ORDER BY p.page_order");
							while($result_page = mysqli_fetch_array($select_page)){
							?>
							<li class="sidebar-item"><a class="sidebar-link" href="<?php echo $result_page['php_name']; ?>"><?php echo $result_page['description']; ?></a></li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>

				</ul>

				
			</div>
		</nav>
