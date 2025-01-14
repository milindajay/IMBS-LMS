<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Student Reports';
$useJQuery = true;
$criticalCSS = <<<EOT
.report-table { @apply min-w-full divide-y divide-gray-200; }
.report-th { @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider; }
.report-td { @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900; }
.sort-icon { @apply ml-1 w-3 h-3 inline-block; }
EOT;

include 'components/header.php';
?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-2xl font-semibold text-gray-900">Student Reports</h1>

        <div class="mt-4">
            <input type="text" id="searchInput" placeholder="Search students..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Active Students</h2>
            <div class="overflow-x-auto">
                <table id="activeStudentsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="nic">
                                NIC <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="name">
                                Name <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="course">
                                Course <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="created_at">
                                Registration Date <span class="sort-icon">▼</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Active students will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Deleted Students</h2>
            <div class="overflow-x-auto">
                <table id="deletedStudentsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="nic">
                                NIC <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="name">
                                Name <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="course">
                                Course <span class="sort-icon">▼</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                data-sort="created_at">
                                Registration Date <span class="sort-icon">▼</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Deleted students will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let activeStudents = [];
    let deletedStudents = [];

    // Fetch student data
    fetch('get_students.php')
        .then(response => response.json())
        .then(data => {
            activeStudents = data.active;
            deletedStudents = data.deleted;
            renderTables();
            setupSorting();
        })
        .catch(error => console.error('Error:', error));

    function renderTables() {
        renderTable('activeStudentsTable', activeStudents);
        renderTable('deletedStudentsTable', deletedStudents);
    }

    function renderTable(tableId, students) {
        const tableBody = document.querySelector(`#${tableId} tbody`);
        tableBody.innerHTML = students.map(student => `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${escapeHtml(student.nic)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${escapeHtml(student.name)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${escapeHtml(student.course)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(student.created_at).toLocaleDateString()}</td>
            </tr>
        `).join('');
    }

    function setupSorting() {
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.addEventListener('click', () => {
                const table = th.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const isAsc = th.classList.contains('asc');
                const sortKey = th.dataset.sort;
                const direction = isAsc ? -1 : 1;

                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.children[th.cellIndex].textContent;
                    const bValue = b.children[th.cellIndex].textContent;
                    return aValue.localeCompare(bValue) * direction;
                });

                tbody.append(...sortedRows);
                th.classList.toggle('asc');
                updateSortIcons(table, th);
            });
        });
    }

    function updateSortIcons(table, clickedTh) {
        table.querySelectorAll('th[data-sort]').forEach(th => {
            const icon = th.querySelector('.sort-icon');
            if (th === clickedTh) {
                icon.textContent = th.classList.contains('asc') ? '▲' : '▼';
            } else {
                icon.textContent = '▼';
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        filterTable('activeStudentsTable', activeStudents, searchTerm);
        filterTable('deletedStudentsTable', deletedStudents, searchTerm);
    });

    function filterTable(tableId, students, searchTerm) {
        const filteredStudents = students.filter(student =>
            student.name.toLowerCase().includes(searchTerm) ||
            student.nic.toLowerCase().includes(searchTerm) ||
            student.course.toLowerCase().includes(searchTerm)
        );
        renderTable(tableId, filteredStudents);
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});
</script>

<?php include 'components/footer.php'; ?>