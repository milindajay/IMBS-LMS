<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Search Students';
$useJQuery = true;
$criticalCSS = <<<EOT
.search-results { 
    @apply absolute z-50 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base overflow-auto focus:outline-none sm:text-sm border border-gray-300; 
}
.suggestion-item { 
    @apply px-4 py-2 cursor-pointer hover:bg-gray-100 text-sm text-gray-700;
}
EOT;

include 'components/header.php';
?>

<div class="overflow-scroll w-3/4 mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="heading text-2xl text-green-800 mb-6">Search Students</h2>

            <form id="searchForm" class="flex-col items-center max-w-lg mx-auto mb-6">
                <div class="search-form flex items-center max-w-lg mx-auto mb-6">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5"
                            placeholder="Search by NIC or Name" required />
                    </div>
                    <button type="submit"
                        class="p-2.5 ml-2 text-sm font-medium text-white bg-green-700 rounded-lg border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>


                <div id="searchSuggestions" class="w-full mt-1 hidden z-100 border-0 rounded-lg bg-gray-100 p-3 pl-5">
                    <!-- Search suggestions will be populated here -->
                </div>
            </form>

            <div id="results" class="mt-6">
                <!-- Full search results will be loaded here -->
            </div>
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
                    <button type="button" id="confirmDelete"
                        class="hidden inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                    <button type="button" id="closeModal"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showModal(title, message, isSuccess, isConfirmation = false, onConfirm = null) {
    const modal = document.getElementById('messageModal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalIcon = document.getElementById('modalIcon');
    const confirmButton = document.getElementById('confirmDelete');
    const closeButton = document.getElementById('closeModal');

    modalTitle.textContent = title;
    modalMessage.textContent = message;

    if (isConfirmation) {
        modalIcon.innerHTML =
            '<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>';
        modalIcon.classList.add('bg-red-100');
        modalIcon.classList.remove('bg-green-100', 'bg-red-100');
        confirmButton.classList.remove('hidden');
        if (onConfirm) {
            confirmButton.onclick = onConfirm;
        }
    } else {
        if (isSuccess) {
            modalIcon.innerHTML =
                '<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>';
            modalIcon.classList.add('bg-green-100');
            modalIcon.classList.remove('bg-red-100');
        } else {
            modalIcon.innerHTML =
                '<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>';
            modalIcon.classList.add('bg-red-100');
            modalIcon.classList.remove('bg-green-100');
        }
        confirmButton.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    closeButton.onclick = () => {
        modal.classList.add('hidden');
        if (!isConfirmation && isSuccess) {
            window.location.reload();
        }
    };
}

async function deleteStudent(studentId) {
    try {
        const formData = new FormData();
        formData.append('id', studentId);

        const response = await fetch('delete.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.error) {
            throw new Error(data.error);
        }

        showModal('Success', data.message, true);
    } catch (error) {
        console.error('Delete error:', error);
        showModal('Error', error.message || 'An error occurred while deleting the student.', false);
    }
}

function updateSearchResults(html) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = html;

    const deleteButtons = resultsDiv.querySelectorAll('a[href^="delete.php"]');
    deleteButtons.forEach(button => {
        button.onclick = (e) => {
            e.preventDefault();
            const studentId = new URLSearchParams(button.href.split('?')[1]).get('id');
            const studentName = button.closest('tr').querySelector('td:nth-child(2)').textContent;

            showModal(
                'Confirm Deletion',
                `Are you sure you want to delete ${studentName}?`,
                false,
                true,
                () => deleteStudent(studentId)
            );
        };
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchSuggestions = document.getElementById('searchSuggestions');
    const resultsDiv = document.getElementById('results');
    let searchTimer;
    const minSearchLength = 4;
    let selectedNic = null;

    async function performSearch(query, isSuggestion = false) {
        try {
            const formData = new FormData();
            formData.append('query', query);
            if (isSuggestion) {
                formData.append('suggest', '1');
            }

            const response = await fetch('search_students.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.error) {
                throw new Error(data.error);
            }

            if (isSuggestion) {
                if (data.suggestions && data.suggestions.length > 0) {
                    const suggestionsList = document.createElement('ul');
                    suggestionsList.className = 'search-results';

                    data.suggestions.forEach(suggestion => {
                        const li = document.createElement('li');
                        li.className = 'suggestion-item';
                        li.textContent = suggestion.display;
                        li.dataset.nic = suggestion.nic;
                        suggestionsList.appendChild(li);
                    });

                    searchSuggestions.innerHTML = '';
                    searchSuggestions.appendChild(suggestionsList);
                    searchSuggestions.classList.remove('hidden');
                } else {
                    searchSuggestions.innerHTML =
                        '<p class="suggestion-item text-gray-500">No suggestions found.</p>';
                    searchSuggestions.classList.remove('hidden');
                }
            } else {
                updateSearchResults(data.html);
                searchSuggestions.classList.add('hidden');
            }
        } catch (error) {
            console.error('Search error:', error);
            if (isSuggestion) {
                searchSuggestions.innerHTML =
                    '<p class="suggestion-item text-red-500">Error loading suggestions.</p>';
            } else {
                resultsDiv.innerHTML =
                    '<p class="text-red-500">An error occurred while searching. Please try again.</p>';
            }
        }
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        const query = this.value.trim();

        if (query.length >= minSearchLength) {
            searchTimer = setTimeout(() => performSearch(query, true), 300);
        } else {
            searchSuggestions.classList.add('hidden');
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.suggestion-item')) {
            const nic = e.target.dataset.nic;
            searchInput.value = e.target.textContent;
            selectedNic = nic;
            performSearch(nic);
        } else if (!e.target.closest('#searchForm')) {
            searchSuggestions.classList.add('hidden');
        }
    });

    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = selectedNic || searchInput.value.trim();
        selectedNic = null;

        if (query.length >= minSearchLength) {
            performSearch(query);
        } else {
            resultsDiv.innerHTML =
                `<p class="text-red-500">Please enter at least ${minSearchLength} characters to search.</p>`;
        }
    });

    searchInput.addEventListener('focus', function() {
        if (this.value.length >= minSearchLength) {
            searchSuggestions.classList.remove('hidden');
        }
    });
});
</script>

<?php include 'components/footer.php'; ?>