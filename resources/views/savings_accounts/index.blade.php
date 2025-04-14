<x-app-layout>
    <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Savings Accounts</h2>
            <button onclick="toggleModal('createModal')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + New Account
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Balance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Interest Rate (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($accounts as $account)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $account->account_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $account->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">KES {{ number_format($account->balance, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $account->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $account->type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $account->interest_rate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $account->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
    <button onclick="openModal('viewModal-{{ $account->id }}')" class="text-blue-600 hover:underline">View</button>
    <button onclick="openModal('editModal-{{ $account->id }}')" class="text-yellow-500 hover:underline">Edit</button>
    <form action="{{ route('savings-accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline">Delete</button>
    </form>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500">No savings accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create Modal --}}
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Create Savings Account</h3>
            <form action="{{ route('savings-accounts.store') }}" method="POST">
                @csrf

                <div class="mb-4">
    <label class="block text-gray-700">Select User</label>
    <select name="user_id" required class="w-full border rounded px-3 py-2 mt-1">
        <option value="">-- Select a User --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} </option>
        @endforeach
    </select>
</div>


                <div class="mb-4">
                    <label class="block text-gray-700">Balance</label>
                    <input type="number" name="balance" step="0.01" min="0" required class="w-full border rounded px-3 py-2 mt-1" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Status</label>
                    <select name="status" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="frozen">Frozen</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Type</label>
                    <select name="type" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="basic">Basic</option>
                        <option value="goal_based">Goal Based</option>
                        <option value="fixed_term">Fixed Term</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" step="0.01" min="0" required class="w-full border rounded px-3 py-2 mt-1" />
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="toggleModal('createModal')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>
    @foreach ($accounts as $account)
    <div id="viewModal-{{ $account->id }}" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 sm:p-6 flex">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg px-6 py-8 relative">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Savings Account Details</h3>

            <div class="space-y-3 text-sm sm:text-base text-gray-700">
                <p><span class="font-semibold">Account Number:</span> {{ $account->account_number }}</p>
                <p><span class="font-semibold">User Name:</span> {{ $account->user->name }}</p>
                <p><span class="font-semibold">Balance:</span> <span class="text-green-600 font-semibold">KES {{ number_format($account->balance, 2) }}</span></p>
                <p><span class="font-semibold">Status:</span> <span class="capitalize">{{ $account->status }}</span></p>
                <p><span class="font-semibold">Type:</span> {{ str_replace('_', ' ', ucfirst($account->type)) }}</p>
                <p><span class="font-semibold">Interest Rate:</span> {{ $account->interest_rate }}%</p>
                <p><span class="font-semibold">Created At:</span> {{ $account->created_at->format('Y-m-d') }}</p>
            </div>

            <div class="mt-8 flex justify-end">
                <button onclick="closeModal('viewModal-{{ $account->id }}')" class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded-lg transition">
                    Close
                </button>
            </div>
        </div>
    </div>
@endforeach

@foreach ($accounts as $account)
    <div id="editModal-{{ $account->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Edit Savings Account</h3>
            <form action="{{ route('savings-accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700">User</label>
                    <input type="text" value="{{ $account->user->name }}" readonly class="w-full border rounded px-3 py-2 mt-1 bg-gray-100 cursor-not-allowed" />
                </div>

                <!-- Hidden field for account_number -->
                <input type="hidden" name="account_number" value="{{ $account->account_number }}" />

                <div class="mb-4">
                    <label class="block text-gray-700">Balance</label>
                    <input type="number" name="balance" value="{{ $account->balance }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 mt-1" required />
                </div>



                <div class="mb-4">
                    <label class="block text-gray-700">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2 mt-1" required>
                        <option value="active" {{ $account->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $account->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="frozen" {{ $account->status == 'frozen' ? 'selected' : '' }}>Frozen</option>
                    </select>
                </div>


                <div class="mb-4">
    <label class="block text-gray-700">Account Type</label>
    <select name="type" class="w-full border rounded px-3 py-2 mt-1" required>
        <option value="basic" {{ $account->type == 'basic' ? 'selected' : '' }}>Basic</option>
        <option value="goal_based" {{ $account->type == 'goal_based' ? 'selected' : '' }}>Goal-Based</option>
        <option value="fixed_term" {{ $account->type == 'fixed_term' ? 'selected' : '' }}>Fixed-Term</option>
    </select>
</div>


                <div class="mb-4">
                    <label class="block text-gray-700">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" value="{{ $account->interest_rate }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 mt-1" required />
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('editModal-{{ $account->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
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
