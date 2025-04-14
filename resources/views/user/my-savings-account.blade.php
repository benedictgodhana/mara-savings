<x-app-layout>
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ __('My Savings Account') }}
    </h2>

    <div class="flex gap-3">
        <!-- Deposit Button -->
        <button
            onclick="toggleDepositModal()"
            class="flex items-center gap-2 px-4 py-2 text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Deposit
        </button>

        <!-- Withdraw Button -->
        <button
            onclick="toggleWithdrawModal()"
            class="flex items-center gap-2 px-4 py-2 text-white bg-amber-500 rounded-md hover:bg-opacity-90 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
            Withdraw
        </button>
    </div>
</div>


    <div class="py-12">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <!-- Account Summary Section -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Current Balance</h3>
                    <p class="text-3xl font-bold text-[#45a049]">KES {{ number_format($account->balance) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Account Number</h3>
                    <p class="text-xl font-medium text-gray-800">{{ $account->account_number }}</p>
                    <p class="text-sm text-gray-500">{{ ucfirst($account->type) }} Account</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Interest Rate</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $account->interest_rate }}% <span class="text-sm font-normal text-gray-500">per annum</span></p>
                </div>
            </div>

            <!-- Transaction History Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h3>

                @if($transactions->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->type == 'deposit')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Deposit
                                                </span>
                                            @elseif($transaction->type == 'withdrawal')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Withdrawal
                                                </span>
                                            @elseif($transaction->type == 'interest')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Interest
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($transaction->type == 'deposit' || $transaction->type == 'interest')
                                                <span class="text-green-600 font-medium">+KES {{ number_format($transaction->amount) }}</span>
                                            @else
                                                <span class="text-red-600 font-medium">-KES {{ number_format($transaction->amount) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            KES {{ number_format($transaction->balance_after) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <p class="text-gray-600">No transactions found for this account.</p>
                @endif
            </div>

            <!-- Account Performance Chart -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Growth</h3>
                <div class="h-64">
                    <!-- Canvas for chart - would be populated with JS -->
                    <canvas id="balanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div id="depositModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-[#45a049] border-b pb-2">Deposit Funds</h3>
            <form action="{{ route('savings.deposit', $account->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Amount (KES)</label>
                    <input type="number" name="amount" step="0.01" min="1" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description (Optional)</label>
                    <input type="text" name="description" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" placeholder="E.g. Monthly savings" />
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleDepositModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-[#45a049] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Deposit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div id="withdrawModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-amber-500 border-b pb-2">Withdraw Funds</h3>
            <form action="{{ route('savings.withdraw', $account->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Amount (KES)</label>
                    <input type="number" name="amount" step="0.01" min="1" max="{{ $account->balance }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" />
                    <p class="text-sm text-gray-500 mt-1">Available balance: KES {{ number_format($account->balance) }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description (Optional)</label>
                    <input type="text" name="description" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="E.g. Emergency expense" />
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleWithdrawModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Withdraw</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDepositModal() {
            const modal = document.getElementById('depositModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function toggleWithdrawModal() {
            const modal = document.getElementById('withdrawModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        // Chart.js setup (assuming Chart.js is included)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('balanceChart').getContext('2d');

            // This would be populated with actual data from your backend
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData->pluck('date')) !!},
                    datasets: [{
                        label: 'Account Balance',
                        data: {!! json_encode($chartData->pluck('balance')) !!},
                        backgroundColor: 'rgba(69, 160, 73, 0.1)',
                        borderColor: '#45a049',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#45a049'
                    }]
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
