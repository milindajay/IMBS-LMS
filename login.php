<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Welcome to IMBS LMS';
$criticalCSS = <<<EOT
.login-form { @apply bg-white p-8 rounded-lg shadow-md max-w-md mx-auto mt-10; }
EOT;

include 'components/header.php';
?>

<div class="min-h-screen flex items-center justify-center">
    <div class="login-form">
        <div class="text-center mb-8">
            <img src="assets/images/imbslogo.png" alt="IMBS Logo" class="mx-auto w-48 mb-4">
            <h1 class="heading text-2xl text-green-800">Welcome to IMBS LMS</h1>
        </div>
        <form action="auth.php" method="POST" class="space-y-6">
            <div>
                <label class="text block text-sm text-gray-700">Username</label>
                <input type="text" name="username" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
            </div>
            <div>
                <label class="text block text-sm text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
            </div>
            <button type="submit"
                class="w-full bg-green-800 text-white rounded-md py-2 px-4 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Login
            </button>
        </form>
    </div>
</div>

<?php include 'components/footer.php'; ?>