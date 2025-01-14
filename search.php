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

<div class="w-3/4 mx-auto py-6 sm:px-6 lg:px-8">
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

<script>
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
                resultsDiv.innerHTML = data.html || '<p class="text-gray-500">No results found.</p>';
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