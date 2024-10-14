<?php


// Check if the user is logged in
 if (!isset($_SESSION['user_id'])) {
     // If the user is not logged in, redirect to the index page
     header("Location: ../index.php");
     exit();
 }
 
// Assuming the user is already logged in and user_id is stored in the session
$user_id = $_SESSION['user_id'];

// Fetch the is_admin value from the database
$query = "SELECT is_admin FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$is_admin = $user['is_admin'];
$stmt->close();
?>

<ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="../index.php"
        >
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="ri-news-fill"></i>
          </div>
          <div class="sidebar-brand-text mx-3">News 360</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />
        
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt" style="font-size: 14px"></i>
            <span style="font-size: 14px">Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Admin Panel</div>
       
       
         <!-- Nav Item - Posts/Articles -->
        <li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseUtilities"
            aria-expanded="true"
            aria-controls="collapseUtilities"
          >
            <i class="ri-ball-pen-fill" style="font-size: 14px"></i>
            <span style="font-size: 14px">Articles</span>
          </a>
          <div
            id="collapseUtilities"
            class="collapse"
            aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Posts Section:</h6>
              <a class="collapse-item" href="add-post.php">Add Posts</a>

              <!-- Show the following sections only if is_admin = 1 -->
              <?php if ($is_admin == 1): ?>
              <a class="collapse-item" href="manage-post.php">Manage Posts</a>
               <?php endif; ?>
            </div>
          </div>
        </li>
         

        <!-- Show the following sections only if is_admin = 1 -->
        <?php if ($is_admin == 1): ?>
        <!-- Nav Item - Category Section -->
        <li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="true"
            aria-controls="collapseTwo"
          >
            <i class="ri-book-open-fill" style="font-size: 14px"></i>
            <span style="font-size: 14px">Category Section</span>
          </a>
          <div
            id="collapseTwo"
            class="collapse"
            aria-labelledby="headingTwo"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Category Section:</h6>
              <a class="collapse-item" href="add-category.php">Add Category</a>
              <a class="collapse-item" href="manage-category.php"
                >Manage Category</a
              >
            </div>
          </div>
        </li>
     
        <!-- Nav Item - User Sections -->
        <li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapsePages"
            aria-expanded="true"
            aria-controls="collapsePages"
          >
            <i class="ri-user-settings-fill" style="font-size: 14px"></i>
            <span style="font-size: 14px">Publishers</span>
          </a>
          <div
            id="collapsePages"
            class="collapse"
            aria-labelledby="headingPages"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Users Section:</h6>
              <a class="collapse-item" href="add-user.php">Add a Publisher</a>
              <a class="collapse-item" href="manage-user.php">Manage Publishers</a>
            </div>
          </div>
        </li>
       

        <!-- Divider -->
        <hr class="sidebar-divider" />
        <!-- Heading -->
        <div class="sidebar-heading">Addons</div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="comments.php">
            <i class="ri-message-2-fill" style="font-size: 14px"></i>
            <span style="font-size: 14px">Comments Section</span></a
          >
        </li>
        <?php endif; ?>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
          <a class="nav-link" href="forms/logout.php">
            <i class="ri-logout-box-fill" style="font-size: 14px"></i>
            <span style="font-size: 14px;">Log Out</span></a
          >
        </li>
        

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />
        <!-- Sidebar Toggler (Sidebar) -->

        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
</ul>