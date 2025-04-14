<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('My Transactions') }}
        </h2>

        <div class="flex gap-3">
            <!-- Export Transactions Button -->
            <button
                onclick="toggleExportModal()"
                class="flex items-center gap-2 px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-opacity-90 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <!-- Transactions Summary Section -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Deposits</h3>
                    <p class="text-3xl font-bold text-[#45a049]">KES {{ number_format($totalDeposits) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Withdrawals</h3>
                    <p class="text-3xl font-bold text-red-500">KES {{ number_format($totalWithdrawals) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Goal Contributions</h3>
                    <p class="text-3xl font-bold text-blue-600">KES {{ number_format($goalContributions) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Net Balance</h3>
                    <p class="text-3xl font-bold {{ $netBalance >= 0 ? 'text-[#45a049]' : 'text-red-500' }}">KES {{ number_format($netBalance) }}</p>
                </div>
            </div>

            <!-- Transactions Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Transactions</h3>

                <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Types</option>
                            <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                            <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                            <option value="goal_contribution" {{ request('type') == 'goal_contribution' ? 'selected' : '' }}>Goal Contribution</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">Apply Filters</button>
                    </div>
                </form>
            </div>

            <!-- Transactions List Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaction History</h3>

                @if($transactions->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $transaction->reference_number }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $transaction->type == 'deposit' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $transaction->type == 'withdrawal' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $transaction->type == 'goal_contribution' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm
                                            {{ $transaction->type == 'deposit' || $transaction->type == 'goal_contribution' ? 'text-[#45a049] font-medium' : 'text-red-500 font-medium' }}">
                                            {{ $transaction->type == 'withdrawal' ? '-' : '+' }} KES {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $transaction->status == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="toggleTransactionDetailsModal({{ $transaction->id }})" class="text-blue-600 hover:text-blue-800">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">No transactions yet</h3>
                        <p class="text-gray-500 mb-4">There are no transactions in your account history</p>
                    </div>
                @endif
            </div>

            <!-- Transaction Chart -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaction History Overview</h3>
                <div class="h-64">
                    <!-- Canvas for chart -->
                    <canvas id="transactionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details Modal -->
    <div id="transactionDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-gray-800 border-b pb-2">Transaction Details</h3>

            <div id="transactionDetails" class="space-y-4">
                <!-- Transaction details will be populated here -->
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="toggleTransactionDetailsModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Close</button>
            </div>
        </div>
    </div>

    <!-- Export Transactions Modal -->
    <div id="exportModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-blue-600 border-b pb-2">Export Transactions</h3>
            <form action="{{ route('transactions.export') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Date Range</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">From</label>
                            <input type="date" name="export_from_date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">To</label>
                            <input type="date" name="export_to_date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Transaction Type</label>
                    <select name="export_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="deposit">Deposits</option>
                        <option value="withdrawal">Withdrawals</option>
                        <option value="goal_contribution">Goal Contributions</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Format</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="export_format" value="csv" class="form-radio text-blue-600" checked>
                            <span class="ml-2">CSV</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="export_format" value="pdf" class="form-radio text-blue-600">
                            <span class="ml-2">PDF</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleExportModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Export</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    // Parse the transaction details passed from the controller
    const transactionDetails = @json($transactionDetailsJson);

    function toggleTransactionDetailsModal(transactionId = null) {
        const modal = document.getElementById('transactionDetailsModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');

        if (transactionId) {
            displayTransactionDetails(transactionId);
        }
    }

    function toggleExportModal() {
        const modal = document.getElementById('exportModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    function displayTransactionDetails(transactionId) {
        const detailsContainer = document.getElementById('transactionDetails');

        // Get the transaction details from the parsed data
        const data = transactionDetails[transactionId];

        if (!data) {
            detailsContainer.innerHTML = `
                <div class="text-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Transaction Not Found</h3>
                    <p class="text-gray-500">Could not find details for this transaction.</p>
                </div>
            `;
            return;
        }

        // Format the transaction details
        let statusClass = '';
        if (data.status === 'completed') statusClass = 'text-green-600';
        else if (data.status === 'pending') statusClass = 'text-yellow-600';
        else if (data.status === 'failed') statusClass = 'text-red-600';

        let amountClass = data.type === 'withdrawal' ? 'text-red-600' : 'text-[#45a049]';
        let amountPrefix = data.type === 'withdrawal' ? '-' : '+';

        // Format the date
        const date = new Date(data.created_at);
        const formattedDate = date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Build the HTML for transaction details
        const detailsHtml = `
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-sm text-gray-500">Reference</p>
                    <p class="font-medium">${data.reference_number}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date & Time</p>
                    <p class="font-medium">${formattedDate}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Amount</p>
                    <p class="font-medium ${amountClass}">${amountPrefix} KES ${parseFloat(data.amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Type</p>
                    <p class="font-medium capitalize">${data.type.replace('_', ' ')}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium ${statusClass} capitalize">${data.status}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Account</p>
                    <p class="font-medium">${data.account_name}</p>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Description</p>
                <p class="font-medium">${data.description}</p>
            </div>
            ${data.goal_name ? `
            <div class="mt-2">
                <p class="text-sm text-gray-500">Related Goal</p>
                <p class="font-medium">${data.goal_name}</p>
            </div>
            ` : `
            <div class="mt-2">
                <p class="text-sm text-gray-500">Related Goal</p>
                <p class="font-medium">None</p>
            </div>
            `}
        `;

        detailsContainer.innerHTML = detailsHtml;
    }

    // Chart.js setup for transactions
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('transactionsChart').getContext('2d');

        // This would be populated with actual data from your backend
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Deposits',
                        data: {!! json_encode($chartData['deposits'] ?? []) !!},
                        backgroundColor: 'rgba(69, 160, 73, 0.2)',
                        borderColor: '#45a049',
                        borderWidth: 2,
                        tension: 0.4
                    },
                    {
                        label: 'Withdrawals',
                        data: {!! json_encode($chartData['withdrawals'] ?? []) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: '#ef4444',
                        borderWidth: 2,
                        tension: 0.4
                    },
                    {
                        label: 'Goal Contributions',
                        data: {!! json_encode($chartData['contributions'] ?? []) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KES ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
</x-app-layout>
