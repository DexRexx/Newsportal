<?php

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to fetch user information
    $query = "SELECT username, avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($result->num_rows > 0) {
        $userprofile = $result->fetch_assoc();
        $profilename = $userprofile['username'];
        $avatar = "../assets/images/admin.jpg"; // Default avatar image
    } else {
        // Handle case where user data is not found (optional)
        $profilename = "Publisher";
        $avatar = "../assets/images/admin.jpg"; // Default avatar image
    }
} else {
    // Handle case where user is not logged in (optional)
    $profilename = "Guest";
    $avatar = "../assets/images/admin.png"; // Default avatar image
}
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="forms/results.php" method="GET">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for posts..." name="search" aria-label="Search" aria-describedby="basic-addon2" required />
        <div class="input-group-append" style="background: #222222c0">
            <button class="btn btn-primary" type="submit" name="submit" style="background: #222222c0; border: #222222c0">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
    </form>

    
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-none d-lg-inline text-gray-800 small"><?= htmlspecialchars($profilename); ?></span>
                <img style="height: 40px; width: 40px; border: 3px solid black" class="img-profile rounded-circle" src="<?= htmlspecialchars($avatar); ?>" />
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../home-page.php">
                    <i class="ri-contract-fill" style="font-size: 14px"></i>
                    Terms & Conditions
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../forms/logout.php" style="color: #fff; background: rgb(180, 10, 10)">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" style="font-size: 14px"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
