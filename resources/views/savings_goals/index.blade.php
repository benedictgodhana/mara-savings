<x-app-layout>
    <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-[#45a049]">Savings Goals</h2>
            <button onclick="toggleModal('createModal')" class="bg-[#45a049] text-white px-4 py-2 rounded hover:bg-opacity-90 transition shadow-sm flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Goal
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 text-[#45a049] font-semibold bg-green-50 p-3 rounded border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($goals as $goal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $goal->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $goal->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">KES {{ number_format($goal->target_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">KES {{ number_format($goal->current_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $goal->target_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $goal->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $goal->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <button onclick="openModal('viewModal-{{ $goal->id }}')" class="text-[#45a049] hover:underline font-medium">View</button>
                                <button onclick="openModal('editModal-{{ $goal->id }}')" class="text-amber-500 hover:underline font-medium">Edit</button>
                                <form action="{{ route('savings-goals.destroy', $goal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this savings goal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center px-6 py-8 text-gray-500">No savings goals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create Modal --}}
    <div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-[#45a049] border-b pb-2">Create Savings Goal</h3>
            <form action="{{ route('savings-goals.store') }}" method="POST">
                @csrf

                

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <input type="text" name="description" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" placeholder="E.g. New Car, House Down Payment" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Amount</label>
                    <input type="number" name="target_amount" step="0.01" min="0" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Current Amount</label>
                    <input type="number" name="current_amount" step="0.01" min="0" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Date</label>
                    <input type="date" name="target_date" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('createModal')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-[#45a049] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Save</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($goals as $goal)
    <div id="viewModal-{{ $goal->id }}" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden items-center justify-center p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg px-6 py-8 relative">
            <h3 class="text-2xl font-bold text-[#45a049] mb-6 border-b pb-2">Savings Goal Details</h3>

            <div class="space-y-3 text-sm sm:text-base text-gray-700">
                <p><span class="font-semibold">User Name:</span> {{ $goal->user->name }}</p>
                <p><span class="font-semibold">Description:</span> {{ $goal->description }}</p>
                <p><span class="font-semibold">Target Amount:</span> <span class="text-[#45a049] font-semibold">KES {{ number_format($goal->target_amount, 2) }}</span></p>
                <p><span class="font-semibold">Current Amount:</span> <span class="text-[#45a049] font-semibold">KES {{ number_format($goal->current_amount, 2) }}</span></p>
                <p><span class="font-semibold">Progress:</span>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                        <div class="bg-[#45a049] h-2.5 rounded-full" style="width: {{ min(100, ($goal->current_amount / $goal->target_amount) * 100) }}%"></div>
                    </div>
                    <span class="text-sm text-gray-600">{{ number_format(($goal->current_amount / $goal->target_amount) * 100, 1) }}%</span>
                </p>
                <p><span class="font-semibold">Target Date:</span> {{ $goal->target_date }}</p>
                <p><span class="font-semibold">Status:</span> <span class="capitalize">{{ $goal->status }}</span></p>
                <p><span class="font-semibold">Created At:</span> {{ $goal->created_at->format('Y-m-d') }}</p>
            </div>

            <div class="mt-8 flex justify-end">
                <button onclick="closeModal('viewModal-{{ $goal->id }}')" class="bg-[#45a049] hover:bg-opacity-90 text-white px-4 py-2 rounded-md transition shadow-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($goals as $goal)
    <div id="editModal-{{ $goal->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-5 text-[#45a049] border-b pb-2">Edit Savings Goal</h3>
            <form action="{{ route('savings-goals.update', $goal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">User</label>
                    <input type="text" value="{{ $goal->user->name }}" readonly class="w-full border rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-600" />
                </div>

                <!-- Hidden field for account_number -->
                <input type="hidden" name="account_number" value="{{ $goal->account_number }}" />

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <input type="text" name="description" value="{{ $goal->description }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Amount</label>
                    <input type="number" name="target_amount" value="{{ $goal->target_amount }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Current Amount</label>
                    <input type="number" name="current_amount" value="{{ $goal->current_amount }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Target Date</label>
                    <input type="date" name="target_date" value="{{ $goal->target_date }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" required>
                        <option value="active" {{ $goal->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $goal->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="paused" {{ $goal->status == 'paused' ? 'selected' : '' }}>Paused</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('editModal-{{ $goal->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Cancel</button>
                    <button type="submit" class="bg-[#45a049] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    {{-- JS Modal Toggle --}}
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
