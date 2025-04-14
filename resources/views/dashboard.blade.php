<x-app-layout>
 <div class="flex h-screen bg-gray-100">
  <!-- Sidebar content would be here in your existing layout -->

  <!-- Main Content -->
  <main class="flex-1 p-6" x-data="{
    activeTab: 'dashboard',
    savingsGoal: 'New Car'
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
          <p class="text-3xl font-bold text-[#45a049]">$12,850</p>
          <div class="mt-2 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-[#45a049] rounded-full w-3/4"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">+$1,250 this month</p>
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
          <p class="text-3xl font-bold text-[#45a049]">5</p>
          <div class="mt-2 flex h-6 space-x-1">
            <div class="w-1 h-2 bg-[#45a049] rounded-full self-end"></div>
            <div class="w-1 h-3 bg-[#45a049] rounded-full self-end"></div>
            <div class="w-1 h-6 bg-[#45a049] rounded-full self-end"></div>
            <div class="w-1 h-4 bg-[#45a049] rounded-full self-end"></div>
            <div class="w-1 h-5 bg-[#45a049] rounded-full self-end"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">2 goals completed</p>
        </div>
      </div>

      <!-- Monthly Budget Card -->
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

      <!-- Savings Rate Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Savings Rate</p>
          <p class="text-3xl font-bold text-[#45a049]">24%</p>
          <div class="mt-2 flex">
            <div class="h-4 w-4 rounded-full bg-[#45a049] -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-500 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-400 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-green-300 -ml-1 border border-white"></div>
            <div class="h-4 w-4 rounded-full bg-gray-400 -ml-1 border border-white flex items-center justify-center text-white text-xs">+8%</div>
          </div>
          <p class="text-xs text-gray-500 mt-1">+3% from last month</p>
        </div>
      </div>

      <!-- Projected Growth Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">1-Year Projection</p>
          <p class="text-3xl font-bold text-[#45a049]">$26,320</p>
          <div class="mt-2 flex justify-between items-center">
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
            <div class="w-full h-0.5 bg-gray-300"></div>
            <div class="w-2 h-2 bg-[#45a049] rounded-full"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">Based on current rate</p>
        </div>
      </div>

      <!-- Investment Options Card -->
      <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg p-4 rounded-lg shadow-lg border border-white border-opacity-20 overflow-hidden group hover:bg-opacity-30 transition duration-300">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 rounded-full bg-[#45a049] bg-opacity-20 flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#45a049]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
          </svg>
        </div>
        <div class="flex flex-col z-10 relative">
          <p class="text-gray-600 text-sm font-medium mb-1">Investment Options</p>
          <p class="text-3xl font-bold text-[#45a049]">8</p>
          <div class="mt-2 grid grid-cols-7 gap-0.5">
            <div class="h-1 bg-green-300"></div>
            <div class="h-2 bg-green-400"></div>
            <div class="h-3 bg-green-500"></div>
            <div class="h-4 bg-[#45a049]"></div>
            <div class="h-3 bg-green-500"></div>
            <div class="h-2 bg-green-400"></div>
            <div class="h-1 bg-green-300"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">3 new options available</p>
        </div>
      </div>
    </div>

    <!-- Content Sections -->
    <div x-show="activeTab === 'dashboard'">
      <!-- Goal Progress Tracker -->
      <div class="bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg p-4 shadow-md rounded flex flex-col md:flex-row items-center gap-4 mb-6 border border-white border-opacity-40">
        <div class="flex items-center gap-4 w-full md:w-auto">
          <div class="p-3 bg-[#45a049] text-white rounded-full shadow-md flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div>
            <p class="text-lg font-medium">Current Goal:</p>
            <p class="text-gray-600" x-text="savingsGoal">New Car</p>
          </div>
        </div>

        <!-- Progress Bar (desktop only) -->
        <div class="hidden md:block flex-1 w-full">
          <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-[#45a049] h-2.5 rounded-full w-2/3 relative">
              <div class="absolute -right-1 -top-1 w-4 h-4 bg-white rounded-full border-2 border-[#45a049] shadow-md"></div>
            </div>
          </div>
          <div class="flex justify-between text-xs text-gray-500 mt-1">
            <span>$8,500 saved</span>
            <span>$12,000 goal</span>
          </div>
        </div>

        <!-- Estimated time remaining -->
        <div class="hidden md:flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-sm font-medium">4 months remaining</span>
        </div>
      </div>

      <!-- Rest of your dashboard content would go here -->
    </div>

    <!-- Other Tab Content (Goals, Transactions, Reports) would go here -->

  </main>
</div>
</x-app-layout>
