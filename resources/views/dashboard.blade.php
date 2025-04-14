<x-app-layout>
 <div class="flex h-screen bg-gray-100">
  <!-- Sidebar content would be here in your existing layout -->

<!-- Profile Completion Modal -->
@if(auth()->check() && !auth()->user()->profile_completed)
<div id="profileCompletionModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-5xl">
        <div class="flex items-center mb-5">
            <div class="bg-blue-100 rounded-full p-2 mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Complete Your Profile</h3>
        </div>

        <p class="text-gray-600 mb-6">
            Welcome to Mara Savings! To get the most out of your savings experience, please take a moment to complete your profile details.
        </p>

        <form action="{{ route('profile.complete') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Profile Photo Section -->
            <div class="flex flex-col md:flex-row items-center gap-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex-shrink-0">
                    <div class="relative">
                        <div id="profile-preview" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-[#45a049]">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <label for="profile_photo" class="absolute -bottom-2 -right-2 bg-[#45a049] text-white p-1.5 rounded-full cursor-pointer shadow-md hover:bg-opacity-90 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-md font-medium text-gray-700 mb-1">Profile Photo</h4>
                    <p class="text-sm text-gray-500 mb-2">Upload a profile photo to personalize your account.</p>
                    <div class="text-xs text-gray-500">Recommended: Square image, at least 200x200 pixels. Maximum 2MB.</div>
                </div>
            </div>

            <!-- First row: Name, Username, Email -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Username</label>
                    <input type="text" name="username" value="{{ auth()->user()->username }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-md px-3 py-2 focus:outline-none" />
                    <p class="text-xs text-gray-500 mt-1">Username cannot be changed</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 rounded-md px-3 py-2 focus:outline-none" />
                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                </div>
            </div>

            <!-- Second row: Phone, National ID, Address -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input type="tel" name="phone_number" value="{{ auth()->user()->phone_number }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="+254 7XX XXX XXX" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">National ID</label>
                    <input type="text" name="national_id" value="{{ auth()->user()->national_id }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="address" value="{{ auth()->user()->address }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            <!-- Third row: Date of Birth, Occupation, Income Range -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('Y-m-d') : '' }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Occupation</label>
                    <input type="text" name="occupation" value="{{ auth()->user()->occupation }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. Software Developer, Teacher, etc." />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Monthly Income Range (KES)</label>
                    <select name="income_range" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Income Range</option>
                        <option value="0-50000" {{ auth()->user()->income_range == '0-50000' ? 'selected' : '' }}>0 - 50,000</option>
                        <option value="50001-100000" {{ auth()->user()->income_range == '50001-100000' ? 'selected' : '' }}>50,001 - 100,000</option>
                        <option value="100001-200000" {{ auth()->user()->income_range == '100001-200000' ? 'selected' : '' }}>100,001 - 200,000</option>
                        <option value="200001+" {{ auth()->user()->income_range == '200001+' ? 'selected' : '' }}>200,001+</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between gap-4 pt-2 mt-6 border-t border-gray-200">
                <a href="{{ route('skip-profile-completion') }}" class="text-gray-600 hover:text-gray-800 mt-4">
                    I'll complete this later
                </a>
                <button type="submit" class="bg-[#45a049] text-white px-6 py-2 rounded-md hover:bg-opacity-90 transition shadow-sm mt-4">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to preview the profile image before upload
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewDiv = document.getElementById('profile-preview');
                previewDiv.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="w-full h-full object-cover">`;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Prevent closing the modal by clicking outside (since this is important)
    document.getElementById('profileCompletionModal').addEventListener('click', function(e) {
        if (e.target === this) {
            // Slight shake animation to indicate it can't be dismissed
            const modalContent = this.querySelector('div');
            modalContent.classList.add('animate-shake');
            setTimeout(() => {
                modalContent.classList.remove('animate-shake');
            }, 500);
        }
    });

    // Add shake animation to the document styles if not already present
    if (!document.querySelector('style#shake-animation')) {
        const style = document.createElement('style');
        style.id = 'shake-animation';
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
            .animate-shake {
                animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            }
        `;
        document.head.appendChild(style);
    }
</script>
@endif
  <!-- Main Content -->
  <main class="flex-1 p-6" x-data="{
    activeTab: 'dashboard',
    savingsGoal: '{{ $data['savingsGoals'][0]['name'] ?? 'New Car' }}'
  }">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold text-[#45a049]">Mara Savings</h1>
      <div class="flex items-center space-x-4">
        <button @click="activeTab = 'dashboard'" class="px-3 py-2 rounded-md transition-colors" :class="activeTab === 'dashboard' ? 'bg-[#45a049] text-white' : 'text-gray-600 hover:bg-gray-200'">
          Dashboard
        </button>
        <button @click="activeTab = 'goals'" class="px-3 py-2 rounded-md transition-colors" :class="activeTab === 'goals' ? 'bg-[#45a049] text-white' : 'text-gray-600 hover:bg-gray-200'">
          Goals
        </button>
        <button @click="activeTab = 'transactions'" class="px-3 py-2 rounded-md transition-colors" :class="activeTab === 'transactions' ? 'bg-[#45a049] text-white' : 'text-gray-600 hover:bg-gray-200'">
          Transactions
        </button>
        <button @click="activeTab = 'reports'" class="px-3 py-2 rounded-md transition-colors" :class="activeTab === 'reports' ? 'bg-[#45a049] text-white' : 'text-gray-600 hover:bg-gray-200'">
          Reports
        </button>
      </div>
    </div>

    <!-- Stats Cards with Glass Effect -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
      <!-- Total Savings Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Total Savings</p>
          @if(Auth::user()->can('view any dashboard stats'))

@isset($data['accountBalanceSum'])
    <p class="text-3xl font-bold text-[#45a049]">Ksh{{ number_format($data['accountBalanceSum']) }}</p>
@else

    <p class="text-3xl font-bold text-gray-400">Not available</p>
@endisset

            @else
            @endif

          <div class="mt-2 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-[#45a049] rounded-full w-3/4"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">
    @if(Auth::user()->can('view any dashboard stats'))
        Summary of all accounts
    @elseif(isset($data['savingsAccountsCount']))
        Across your {{ $data['savingsAccountsCount'] }} accounts
    @else
        No account data available
    @endif
</p>

        </div>
      </div>

      <!-- Savings Goals Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Savings Goals</p>
          @if(Auth::user()->can('view any dashboard stats'))
            <p class="text-3xl font-bold text-[#45a049]">{{ $data['totalSavingsGoals'] }}</p>
          @else
          <p class="text-3xl font-bold text-[#45a049]">{{ $data['savingsGoalsCount'] ?? 0 }}</p>
          @endif
          <div class="mt-2 flex h-6 space-x-1">
            @if(Auth::user()->can('view any dashboard stats'))
              @for($i = 0; $i < min(5, $data['totalSavingsGoals']); $i++)
                <div class="w-1 h-{{ rand(2, 6) }} bg-[#45a049] rounded-full self-end"></div>
              @endfor
            @else
            @isset($data['goalProgress'])
    @foreach($data['goalProgress'] as $index => $goal)
        @if($index < 5)
            <div class="w-1 h-{{ min(6, ceil($goal['percentage'] / 20)) }} bg-[#45a049] rounded-full self-end"></div>
        @endif
    @endforeach
@endisset

            @endif
          </div>
          <p class="text-xs text-gray-500 mt-1">
            @if(Auth::user()->can('view any dashboard stats'))
              {{ floor($data['goalCompletionRate']) }}% completion rate
            @else
            {{ count(array_filter($data['goalProgress'] ?? [], function($goal) { return $goal['percentage'] >= 100; })) }} completed
            @endif
          </p>
        </div>
      </div>

      <!-- Transaction Stats Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Transactions</p>
          @if(Auth::user()->can('view any dashboard stats'))
            <p class="text-3xl font-bold text-[#45a049]">{{ $data['totalTransactions'] }}</p>
          @else
          <p class="text-3xl font-bold text-[#45a049]">{{ $data['transactionsCount'] ?? 0 }}</p>
          @endif
          <div class="mt-2 flex">
            <div class="h-4 w-4 rounded-full bg-[#45a049] -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-500 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-400 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-300 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-gray-400 -ml-1 border border-white flex items-center justify-center text-white text-xs">+</div>
          </div>
          <p class="text-xs text-gray-500 mt-1">
            @if(Auth::user()->can('view any dashboard stats'))
              {{ $data['pendingTransactions'] }} pending approval
            @else
            {{ $data['pendingTransactions'] ?? 0 }} pending transactions            @endif
          </p>
        </div>
      </div>

      <!-- Admin System Stats (only visible to admin users) -->
      @if(Auth::user()->can('view any dashboard stats'))
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Total Users</p>
          <p class="text-3xl font-bold text-[#45a049]">{{ $data['totalUsers'] }}</p>
          <div class="mt-2 grid grid-cols-7 gap-0.5">
            <div class="h-1 bg-green-300"></div>
            <div class="h-2 bg-green-400"></div>
            <div class="h-3 bg-green-500"></div>
            <div class="h-4 bg-[#45a049]"></div>
            <div class="h-3 bg-green-500"></div>
            <div class="h-2 bg-green-400"></div>
            <div class="h-1 bg-green-300"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">System overview</p>
        </div>
      </div>
      @else
      <!-- Monthly Budget Card (for regular users) -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Monthly Budget</p>
          <p class="text-3xl font-bold text-[#45a049]">$3,500</p>
          <div class="mt-2 relative h-4 w-full bg-gray-200 rounded-full overflow-hidden">
            <div class="absolute h-full bg-[#45a049] rounded-full w-2/3"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">67% used this month</p>
        </div>
      </div>
      @endif

      <!-- Additional cards based on user permissions -->
      @if(Auth::user()->can('view any dashboard stats'))
      <!-- Additional admin card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">System Health</p>
          <p class="text-3xl font-bold text-[#45a049]">98%</p>
          <div class="mt-2 flex justify-between items-center">
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">All systems operational</p>
        </div>
      </div>
      @else
      <!-- Savings Rate Card (for regular users) -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00
                -2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Savings Rate</p>
          <p class="text-3xl font-bold text-[#45a049]">5.5%</p>
          <div class="mt-2 flex justify-between items-center">
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">Annualized rate</p>
        </div>
        </div>
        @endif
    </div>
    <!-- Savings Goals Section -->

  </main>
    </div>
</x-app-layout>


