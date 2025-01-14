<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Register Student';
$criticalCSS = <<<EOT
.register-form { @apply bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto mt-10; }
EOT;

include 'components/header.php';
?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="heading text-2xl text-green-800 mb-6">Register New Student</h2>

            <form action="process_registration.php" method="POST" class="space-y-6">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 text">Full
                                    Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" autocomplete="name" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6 text">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="nic" class="block text-sm/6 font-medium text-gray-900 text">National
                                    Identity Card No.</label>
                                <div class="mt-2">
                                    <input type="text" name="nic" id="nic" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6 text">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="telephone"
                                    class="block text-sm/6 font-medium text-gray-900 text">Telephone</label>
                                <div class="mt-2">
                                    <input type="text" name="telephone" id="telephone" autocomplete="telephone" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6 text">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="course"
                                    class="block text-sm/6 font-medium text-gray-900 text">Course</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="course" name="course" required
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6 text">
                                        <option value="Diploma in Business Studies">Diploma in Business Studies</option>
                                        <option value="Diploma in HR Management">Diploma in HR Management</option>
                                        <option value="Diploma in Psychology & Counselling">Diploma in Psychology &
                                            Counselling</option>
                                        <option value="Diploma in IT">Diploma in IT</option>
                                        <option value="Diploma in English">Diploma in English</option>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="address"
                                    class="block text-sm/6 font-medium text-gray-900 text">Address</label>
                                <div class="mt-2">
                                    <input type="text" name="address" id="address" autocomplete="address" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6 text">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit"
                        class="rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 text">Register
                        Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="messageModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modalIcon"
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="modal-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="closeModal"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showModal(title, message, isSuccess) {
    const modal = document.getElementById('messageModal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalIcon = document.getElementById('modalIcon');

    modalTitle.textContent = title;
    modalMessage.textContent = message;

    if (isSuccess) {
        modalIcon.innerHTML =
            '<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
        modalIcon.classList.add('bg-green-100');
        modalIcon.classList.remove('bg-red-100');
    } else {
        modalIcon.innerHTML =
            '<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>';
        modalIcon.classList.add('bg-red-100');
        modalIcon.classList.remove('bg-green-100');
    }

    modal.classList.remove('hidden');
}

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('messageModal').classList.add('hidden');
});

const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');
const error = urlParams.get('error');

if (message) {
    showModal('Success', message, true);
} else if (error) {
    showModal('Error', error, false);
}
</script>

<?php include 'components/footer.php'; ?>