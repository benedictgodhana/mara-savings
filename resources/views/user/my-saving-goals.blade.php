<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('My Savings Goals') }}
        </h2>

        <div class="flex gap-3">
            <!-- Create New Goal Button -->
            <button
                onclick="toggleNewGoalModal()"
                class="flex items-center gap-2 px-4 py-2 text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Goal
            </button>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <!-- Goals Summary Section -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Active Goals</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $activeGoals }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Saved</h3>
                    <p class="text-3xl font-bold text-[#45a049]">KES {{ number_format($totalSaved) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Completed Goals</h3>
                    <p class="text-3xl font-bold text-amber-500">{{ $completedGoals }}</p>
                </div>
            </div>

            <!-- Goals List Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">My Goals</h3>

                @if($goals->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($goals as $goal)
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $goal->name }}</h4>
                                    <div class="flex gap-2">
                                        <button onclick="toggleContributeModal({{ $goal->id }})" class="text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                        <button onclick="toggleEditGoalModal({{ $goal->id }})" class="text-gray-600 hover:text-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Goal Progress -->
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Progress</span>
                                        <span class="font-medium">{{ number_format($goal->current_amount / $goal->target_amount * 100, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-[#45a049] h-2.5 rounded-full" style="width: {{ min(100, $goal->current_amount / $goal->target_amount * 100) }}%"></div>
                                    </div>
                                </div>

                                <!-- Goal Details -->
                                <div class="text-sm grid grid-cols-2 gap-2 mb-4">
                                    <div>
                                        <p class="text-gray-500">Saved</p>
                                        <p class="font-medium text-gray-800">KES {{ number_format($goal->current_amount) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Target</p>
                                        <p class="font-medium text-gray-800">KES {{ number_format($goal->target_amount) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Start Date</p>
                                        <p class="font-medium text-gray-800">{{ $goal->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Target Date</p>
                                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($goal->target_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <!-- Goal Status Badge -->
                                @if($goal->current_amount >= $goal->target_amount)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @elseif(\Carbon\Carbon::parse($goal->target_date)->isPast())
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Overdue
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $goals->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">No savings goals yet</h3>
                        <p class="text-gray-500 mb-4">Create your first savings goal to start tracking your progress</p>
                        <button onclick="toggleNewGoalModal()" class="bg-[#45a049] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">Create First Goal</button>
                    </div>
                @endif
            </div>

            <!-- Goals Performance Chart -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Goals Progress Overview</h3>
                <div class="h-64">
                    <!-- Canvas for chart -->
                    <canvas id="goalsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- New Goal Modal -->
    <div id="newGoalModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-[#45a049] border-b pb-2">Create New Savings Goal</h3>
            <form action="{{ route('savings.goals.store') }}" method="POST">
                @csrf

                <input type="hidden" name="savings_account_id" value="{{ $savingsAccount->id }}">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Goal Name</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" placeholder="E.g. New Car, Vacation, Emergency Fund" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description (Optional)</label>
                    <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" placeholder="Add some details about your goal"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Amount (KES)</label>
                    <input type="number" name="target_amount" min="1" step="0.01" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Initial Contribution (KES)</label>
                    <input type="number" name="initial_amount" min="0" step="0.01" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" placeholder="0" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Date</label>
                    <input type="date" name="target_date" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleNewGoalModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-[#45a049] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Create Goal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contribute to Goal Modal -->
    <div id="contributeModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-blue-600 border-b pb-2">Contribute to Goal</h3>
            <form action="{{ route('savings.goals.contribute') }}" method="POST">
                @csrf
                <input type="hidden" name="goal_id" id="contributeGoalId">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Amount (KES)</label>
                    <input type="number" name="amount" step="0.01" min="1" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Source</label>
                    <select name="source" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="savings">From Savings Account</option>
                        <option value="external">External Fund</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleContributeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Contribute</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Goal Modal -->
    <div id="editGoalModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-gray-800 border-b pb-2">Edit Goal</h3>
            <form action="{{ route('savings.goals.update') }}" method="POST" id="editGoalForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="goal_id" id="editGoalId">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Goal Name</label>
                    <input type="text" name="name" id="editGoalName" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" id="editGoalDescription" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Amount (KES)</label>
                    <input type="number" name="target_amount" id="editGoalTargetAmount" min="1" step="0.01" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Date</label>
                    <input type="date" name="target_date" id="editGoalTargetDate" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent" />
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="confirmDeleteGoal()" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Delete Goal</button>

                    <div class="flex gap-3">
                        <button type="button" onclick="toggleEditGoalModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Goal Confirmation Modal -->
    <div id="deleteGoalModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-2 text-red-600">Delete Goal</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this goal? This action cannot be undone.</p>

            <form action="{{ route('savings.goals.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="goal_id" id="deleteGoalId">

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="toggleDeleteGoalModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleNewGoalModal() {
            const modal = document.getElementById('newGoalModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function toggleContributeModal(goalId = null) {
            const modal = document.getElementById('contributeModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');

            if (goalId) {
                document.getElementById('contributeGoalId').value = goalId;
            }
        }

        function toggleEditGoalModal(goalId = null) {
            const modal = document.getElementById('editGoalModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');

            if (goalId) {
                document.getElementById('editGoalId').value = goalId;
                // In a real implementation, you would fetch the goal details via AJAX
                // and populate the form fields with the goal data
                fetchGoalDetails(goalId);
            }
        }

        function confirmDeleteGoal() {
            toggleEditGoalModal();
            toggleDeleteGoalModal();
            const goalId = document.getElementById('editGoalId').value;
            document.getElementById('deleteGoalId').value = goalId;
        }

        function toggleDeleteGoalModal() {
            const modal = document.getElementById('deleteGoalModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function fetchGoalDetails(goalId) {
            // This would be an AJAX call to get goal details in a real implementation
            // For now, just assume we populate the fields with dummy data
            document.getElementById('editGoalName').value = 'Goal Name';
            document.getElementById('editGoalDescription').value = 'Goal Description';
            document.getElementById('editGoalTargetAmount').value = 10000;
            document.getElementById('editGoalTargetDate').value = '2025-12-31';
        }

        // Chart.js setup for goals (assuming Chart.js is included)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('goalsChart').getContext('2d');

            // This would be populated with actual data from your backend
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($goals->pluck('name')) !!},
                    datasets: [
                        {
                            label: 'Current Amount',
                            data: {!! json_encode($goals->pluck('current_amount')) !!},
                            backgroundColor: '#45a049',
                            borderColor: '#45a049',
                            borderWidth: 1
                        },
                        {
                            label: 'Target Amount',
                            data: {!! json_encode($goals->pluck('target_amount')) !!},
                            backgroundColor: 'rgba(69, 160, 73, 0.2)',
                            borderColor: '#45a049',
                            borderWidth: 1,
                            borderDash: [5, 5]
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
