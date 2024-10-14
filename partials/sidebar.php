<div class="col-lg-4">
    <div class="sidebar">
        <!-- Search Form -->
        <h3 class="sidebar-title">Search</h3>
        <div class="sidebar-item search-form">
            <form action="search-page.php" method="GET">
                <input type="text" name="search" placeholder="Search..." />
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <!-- End sidebar search form -->

        <!-- Categories Section -->
        <h3 class="sidebar-title">Categories</h3>
        <div class="sidebar-item categories">
    <ul>
        <?php
        // Fetch categories from the database
        $categories_query = "SELECT id, name, (SELECT COUNT(*) FROM posts WHERE posts.category_id = categories.id) AS post_count FROM categories";
        $categories_result = $conn->query($categories_query);
        
        if ($categories_result->num_rows > 0) {
            while ($category = $categories_result->fetch_assoc()) {
                echo '<li><a href="category-page.php?category_id=' . $category['id'] . '">' . $category['name'] . ' <span>(' . $category['post_count'] . ')</span></a></li>';
            }
        } else {
            echo '<li>No categories available</li>';
        }
        ?>
    </ul>
</div>

        <!-- End sidebar categories-->

        <!-- Recent Posts Section -->
        <h3 class="sidebar-title">Recent Posts</h3>
        <div class="sidebar-item recent-posts">
            <?php
            // Fetch recent posts from the database (limit to 5)
            $recent_posts_query = "SELECT id, title, thumbnail, created_at FROM posts ORDER BY created_at DESC LIMIT 5";
            $recent_posts_result = $conn->query($recent_posts_query);

            if ($recent_posts_result->num_rows > 0) {
                while ($post = $recent_posts_result->fetch_assoc()) {
                    // Limit the title to 7 words
                    $title_words = explode(' ', $post['title']);
                    $short_title = implode(' ', array_slice($title_words, 0, 7)) . (count($title_words) > 7 ? '...' : '');

                    echo '
                    <div class="post-item clearfix">
                        <img src="admin/assets/images/uploads/' . $post['thumbnail'] . '" alt="" />
                        <h4><a href="single-post.php?id=' . $post['id'] . '">' . $short_title . '</a></h4>
                        <time datetime="' . date('Y-m-d', strtotime($post['created_at'])) . '">' . date('M d, Y', strtotime($post['created_at'])) . '</time>
                    </div>';
                }
            } else {
                echo '<p>No recent posts available</p>';
            }
            ?>
        </div>
        <!-- End sidebar recent posts-->

        <!-- Tags Section -->
        <h3 class="sidebar-title">Tags</h3>
        <div class="sidebar-item tags">
            <ul>
                <?php
                // Fetch tags from the most recent posts (limit the number of posts if needed)
                $tags_query = "SELECT tags FROM posts WHERE tags IS NOT NULL ORDER BY created_at DESC LIMIT 10";
                $tags_result = $conn->query($tags_query);

                $all_tags = [];

                if ($tags_result->num_rows > 0) {
                    // Loop through the latest posts and gather tags
                    while ($row = $tags_result->fetch_assoc()) {
                        // Split tags by comma and add them to the $all_tags array
                        $tags = explode(',', $row['tags']);
                        $all_tags = array_merge($all_tags, $tags);
                    }

                    // Remove any duplicates and limit to 10 unique latest tags
                    $unique_tags = array_unique($all_tags);
                    $unique_tags = array_slice($unique_tags, 0, 10);

                    // Display each tag as a list item
                    foreach ($unique_tags as $tag) {
                        echo '<li><a href="#">' . trim($tag) . '</a></li>';
                    }
                } else {
                    echo '<li>No tags available</li>';
                }
                ?>
            </ul>
        </div>
        <!-- End sidebar tags-->
    </div>
    <!-- End sidebar -->
</div>
