<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get username from database
require_once 'config/database.php';
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$username = htmlspecialchars($user['username']);
?>

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo on the left -->
            <div class="flex-shrink-0">
                <a href="index.php" class="flex items-center">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/imbslogo-mnIPjkKWNvXP0W8l0MUMbOBQNIVUG4.png"
                        alt="IMBS Logo" class="h-8 w-auto">
                </a>
            </div>

            <!-- Navigation links in center -->
            <div class="hidden md:block flex-1">
                <div class="flex justify-center">
                    <nav class="flex space-x-8">
                        <a href="index.php"
                            class="text text-gray-900 hover:text-green-800 px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['PHP_SELF'] == '/index.php') ? 'text-green-800' : ''; ?>">Dashboard</a>
                        <a href="register.php"
                            class="text text-gray-900 hover:text-green-800 px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['PHP_SELF'] == '/register.php') ? 'text-green-800' : ''; ?>">Register
                            Student</a>
                        <a href="search.php"
                            class="text text-gray-900 hover:text-green-800 px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['PHP_SELF'] == '/search.php') ? 'text-green-800' : ''; ?>">Search
                            Students</a>
                        <a href="reports.php"
                            class="text <?php echo ($_SERVER['PHP_SELF'] == '/reports.php') ? 'text-green-800' : 'text-gray-900 hover:text-green-800'; ?> px-3 py-2 rounded-md text-sm font-medium">Reports</a>
                    </nav>
                    </nav>
                </div>
            </div>

            <!-- Welcome message and Logout button on the right -->
            <div class="flex items-center space-x-4">
                <span class="text text-gray-700">Welcome, <?php echo $username; ?>!</span>
                <a href="logout.php"
                    class="text bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile menu button and menu -->
    <div class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="index.php"
                class="text block px-3 py-2 rounded-md text-base font-medium <?php echo ($_SERVER['PHP_SELF'] == '/index.php') ? 'text-green-800' : 'text-gray-900 hover:text-green-800'; ?>">Dashboard</a>
            <a href="register.php"
                class="text block px-3 py-2 rounded-md text-base font-medium <?php echo ($_SERVER['PHP_SELF'] == '/register.php') ? 'text-green-800' : 'text-gray-900 hover:text-green-800'; ?>">Register
                Student</a>
            <a href="search.php"
                class="text block px-3 py-2 rounded-md text-base font-medium <?php echo ($_SERVER['PHP_SELF'] == '/search.php') ? 'text-green-800' : 'text-gray-900 hover:text-green-800'; ?>">Search
                Students</a>
            <a href="reports.php"
                class="text block px-3 py-2 rounded-md text-base font-medium <?php echo ($_SERVER['PHP_SELF'] == '/reports.php') ? 'text-green-800' : 'text-gray-900 hover:text-green-800'; ?>">Reports</a>
        </div>
    </div>
</header>