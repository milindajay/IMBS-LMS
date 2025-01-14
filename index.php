<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Dashboard';
$criticalCSS = <<<EOT
.dashboard-card { @apply bg-white p-6 rounded-lg shadow-md; }
EOT;

include 'components/header.php';
include 'components/nav.php';
?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="heading text-2xl text-green-800 mb-6">Welcome to IMBS LMS Dashboard</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="dashboard-card">
                    <h3 class="heading text-lg text-green-800 mb-2">Student Registration</h3>
                    <p class="text text-green-700 mb-4">Register new students to the system.</p>
                    <a href="register.php"
                        class="text bg-green-800 text-white px-4 py-2 rounded hover:bg-green-700">Register Student</a>
                </div>

                <div class="dashboard-card">
                    <h3 class="heading text-lg text-blue-800 mb-2">Search Students</h3>
                    <p class="text text-blue-700 mb-4">Search and manage existing student records.</p>
                    <a href="search.php" class="text bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-700">Search
                        Students</a>
                </div>

                <div class="dashboard-card">
                    <h3 class="heading text-lg text-purple-800 mb-2">Reports</h3>
                    <p class="text text-purple-700 mb-4">Generate and view various reports.</p>
                    <a href="#" class="text bg-purple-800 text-white px-4 py-2 rounded hover:bg-purple-700">View
                        Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>