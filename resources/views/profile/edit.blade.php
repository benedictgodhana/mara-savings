<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="relative h-48 bg-gradient-to-r from-[#45a049] to-emerald-500">
                    <!-- Edit Cover Photo Button -->
                    <button class="absolute top-4 right-4 bg-white bg-opacity-80 hover:bg-opacity-100 text-gray-700 p-2 rounded-full shadow-md transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>

                <div class="relative px-6 py-5 sm:px-8 border-b border-gray-200">
                    <!-- Profile Picture -->
                    <div class="absolute -top-16 left-6 sm:left-8">
                        <div class="relative">
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Edit Profile Picture Button -->
                            <button class="absolute bottom-0 right-0 bg-[#45a049] text-white p-1.5 rounded-full shadow-md hover:bg-opacity-90 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="ml-40 sm:ml-44 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                            <p class="text-gray-500">{{ '@' . auth()->user()->username }}</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            <a href="#" onclick="toggleEditMode()" class="inline-flex items-center px-4 py-2 bg-[#45a049] text-white rounded-md hover:bg-opacity-90 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button onclick="showTab('profile')" id="profile-tab" class="px-4 py-3 text-sm font-medium text-[#45a049] border-b-2 border-[#45a049]">
                    Profile Information
                </button>
                <button onclick="showTab('security')" id="security-tab" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                    Security Settings
                </button>
                <button onclick="showTab('preferences')" id="preferences-tab" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                    Preferences
                </button>
            </div>

            <!-- Profile Information (View Mode) -->
            <div id="profile-view-mode" class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Details Section -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Full Name</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->name ?: 'Not provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Email Address</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->email }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Phone Number</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->phone_number ?: 'Not provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Date of Birth</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('F d, Y') : 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Additional Details Section -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">National ID</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->national_id ?: 'Not provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Address</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->address ?: 'Not provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Occupation</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->occupation ?: 'Not provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Income Range</h4>
                                <p class="text-base text-gray-900">
                                    @switch(auth()->user()->income_range)
                                        @case('0-50000')
                                            KES 0 - 50,000
                                            @break
                                        @case('50001-100000')
                                            KES 50,001 - 100,000
                                            @break
                                        @case('100001-200000')
                                            KES 100,001 - 200,000
                                            @break
                                        @case('200001+')
                                            KES 200,001+
                                            @break
                                        @default
                                            Not provided
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Username</h4>
                                <p class="text-base text-gray-900">{{ '@' . auth()->user()->username }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Account Status</h4>
                                <p class="text-base">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Member Since</h4>
                                <p class="text-base text-gray-900">{{ auth()->user()->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information (Edit Mode) -->
            <div id="profile-edit-mode" class="bg-white overflow-hidden shadow-lg sm:rounded-lg hidden">
                <form action="{{ route('profile.update') }}" method="POST" class="px-4 py-5 sm:p-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-medium text-gray-900 mb-6">Edit Personal Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Details Section -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" readonly
                                    class="w-full border border-gray-300 bg-gray-100 rounded-md px-3 py-2 focus:outline-none" />
                                <p class="text-xs text-gray-500 mt-1">Email address cannot be changed</p>
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone_number" id="phone_number" value="{{ auth()->user()->phone_number }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent"
                                    placeholder="+254 7XX XXX XXX" />
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('Y-m-d') : '' }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>
                        </div>

                        <!-- Additional Details Section -->
                        <div class="space-y-6">
                            <div>
                                <label for="national_id" class="block text-sm font-medium text-gray-700 mb-1">National ID</label>
                                <input type="text" name="national_id" id="national_id" value="{{ auth()->user()->national_id }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" name="address" id="address" value="{{ auth()->user()->address }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div>
                                <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                <input type="text" name="occupation" id="occupation" value="{{ auth()->user()->occupation }}" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent"
                                    placeholder="e.g. Software Developer, Teacher, etc." />
                            </div>

                            <div>
                                <label for="income_range" class="block text-sm font-medium text-gray-700 mb-1">Monthly Income Range (KES)</label>
                                <select name="income_range" id="income_range" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent">
                                    <option value="">Select Income Range</option>
                                    <option value="0-50000" {{ auth()->user()->income_range == '0-50000' ? 'selected' : '' }}>0 - 50,000</option>
                                    <option value="50001-100000" {{ auth()->user()->income_range == '50001-100000' ? 'selected' : '' }}>50,001 - 100,000</option>
                                    <option value="100001-200000" {{ auth()->user()->income_range == '100001-200000' ? 'selected' : '' }}>100,001 - 200,000</option>
                                    <option value="200001+" {{ auth()->user()->income_range == '200001+' ? 'selected' : '' }}>200,001+</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="toggleEditMode()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Settings Tab Content (Hidden by default) -->
            <div id="security-content" class="bg-white overflow-hidden shadow-lg sm:rounded-lg hidden">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Security Settings</h3>

                    <!-- Change Password Section -->
                    <form action="{{ route('password.update') }}" method="POST" class="max-w-md">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" name="password" id="password" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent" />
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full px-4 py-2 text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Security Options -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Security Options</h4>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md">
                                <div>
                                    <h5 class="font-medium text-gray-900">Two-Factor Authentication</h5>
                                    <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                                </div>
                                <button class="px-3 py-1.5 text-sm text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition">
                                    Enable
                                </button>
                            </div>

                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md">
                                <div>
                                    <h5 class="font-medium text-gray-900">Login Notifications</h5>
                                    <p class="text-sm text-gray-500">Receive alerts when your account is accessed</p>
                                </div>
                                <button class="px-3 py-1.5 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                                    Disable
                                </button>
                            </div>

                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md">
                                <div>
                                    <h5 class="font-medium text-gray-900">Session Management</h5>
                                    <p class="text-sm text-gray-500">Manage active sessions and log out remotely</p>
                                </div>
                                <button class="px-3 py-1.5 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                                    Manage
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Preferences Tab Content (Hidden by default) -->
<div id="preferences-content" class="bg-white overflow-hidden shadow-lg sm:rounded-lg hidden">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">Preferences</h3>

        <!-- Notification Preferences -->
        <form action="{{ route('preferences.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h4 class="text-md font-medium text-gray-900 mb-4">Notification Settings</h4>

            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="email_notifications" name="email_notifications" type="checkbox"
                            {{ $user->preferences?->email_notifications ? 'checked' : '' }}
                            class="h-4 w-4 text-[#45a049] border-gray-300 rounded focus:ring-[#45a049]" />
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="email_notifications" class="font-medium text-gray-700">Email Notifications</label>
                        <p class="text-gray-500">Receive updates, goal reminders, and important announcements via email</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="sms_notifications" name="sms_notifications" type="checkbox"
                            {{ $user->preferences?->sms_notifications ? 'checked' : '' }}
                            class="h-4 w-4 text-[#45a049] border-gray-300 rounded focus:ring-[#45a049]" />
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="sms_notifications" class="font-medium text-gray-700">SMS Notifications</label>
                        <p class="text-gray-500">Receive important alerts and reminders via text message</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="marketing_communications" name="marketing_communications" type="checkbox"
                            {{ $user->preferences?->marketing_communications ? 'checked' : '' }}
                            class="h-4 w-4 text-[#45a049] border-gray-300 rounded focus:ring-[#45a049]" />
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="marketing_communications" class="font-medium text-gray-700">Marketing Communications</label>
                        <p class="text-gray-500">Receive tips, promotions, and financial advice tailored to your goals</p>
                    </div>
                </div>
            </div>

            <!-- Display Preferences -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-md font-medium text-gray-900 mb-4">Display Settings</h4>

                <div class="space-y-4">
                    <div>
                        <label for="currency_display" class="block text-sm font-medium text-gray-700 mb-1">Currency Display</label>
                        <select id="currency_display" name="currency_display"
                            class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent">
                            <option value="KES (Kenyan Shilling)" {{ $user->preferences?->currency_display == 'KES (Kenyan Shilling)' ? 'selected' : '' }}>
                                KES (Kenyan Shilling)
                            </option>
                            <option value="USD (US Dollar)" {{ $user->preferences?->currency_display == 'USD (US Dollar)' ? 'selected' : '' }}>
                                USD (US Dollar)
                            </option>
                            <option value="EUR (Euro)" {{ $user->preferences?->currency_display == 'EUR (Euro)' ? 'selected' : '' }}>
                                EUR (Euro)
                            </option>
                            <option value="GBP (British Pound)" {{ $user->preferences?->currency_display == 'GBP (British Pound)' ? 'selected' : '' }}>
                                GBP (British Pound)
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="date_format" class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
                        <select id="date_format" name="date_format"
                            class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#45a049] focus:border-transparent">
                            <option value="DD/MM/YYYY" {{ $user->preferences?->date_format == 'DD/MM/YYYY' ? 'selected' : '' }}>
                                DD/MM/YYYY
                            </option>
                            <option value="MM/DD/YYYY" {{ $user->preferences?->date_format == 'MM/DD/YYYY' ? 'selected' : '' }}>
                                MM/DD/YYYY
                            </option>
                            <option value="YYYY-MM-DD" {{ $user->preferences?->date_format == 'YYYY-MM-DD' ? 'selected' : '' }}>
                                YYYY-MM-DD
                            </option>
                        </select>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="dark_mode" name="dark_mode" type="checkbox"
                                {{ $user->preferences?->dark_mode ? 'checked' : '' }}
                                class="h-4 w-4 text-[#45a049] border-gray-300 rounded focus:ring-[#45a049]" />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="dark_mode" class="font-medium text-gray-700">Dark Mode</label>
                            <p class="text-gray-500">Switch to dark mode for reduced eye strain in low light</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between">
                    <button type="button" onclick="resetPreferences()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                        Reset to Defaults
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-[#45a049] rounded-md hover:bg-opacity-90 transition">
                        Save Preferences
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Hidden form for resetting preferences -->
<form id="reset-preferences-form" action="{{ route('preferences.reset') }}" method="POST" class="hidden">
    @csrf
    @method('POST')
</form>

<script>
    // Function to reset preferences
    function resetPreferences() {
        if (confirm('Are you sure you want to reset all preferences to their default values?')) {
            document.getElementById('reset-preferences-form').submit();
        }
    }
</script>

    <script>
        // Function to toggle between view and edit modes
        function toggleEditMode() {
            const viewMode = document.getElementById('profile-view-mode');
            const editMode = document.getElementById('profile-edit-mode');

            if (viewMode.classList.contains('hidden')) {
                viewMode.classList.remove('hidden');
                editMode.classList.add('hidden');
            } else {
                viewMode.classList.add('hidden');
                editMode.classList.remove('hidden');
            }
        }

        // Function to handle tab switching
        function showTab(tabName) {
            // Hide all tab contents
            document.getElementById('profile-view-mode').classList.add('hidden');
            document.getElementById('profile-edit-mode').classList.add('hidden');
            document.getElementById('security-content').classList.add('hidden');
            document.getElementById('preferences-content').classList.add('hidden');

            // Reset all tab buttons
            document.getElementById('profile-tab').classList.remove('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            document.getElementById('profile-tab').classList.add('text-gray-500');
            document.getElementById('security-tab').classList.remove('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            document.getElementById('security-tab').classList.add('text-gray-500');
            document.getElementById('preferences-tab').classList.remove('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            document.getElementById('preferences-tab').classList.add('text-gray-500');
            // Show the selected tab content
            if (tabName === 'profile') {
                document.getElementById('profile-view-mode').classList.remove('hidden');
                document.getElementById('profile-edit-mode').classList.remove('hidden');
                document.getElementById('profile-tab').classList.add('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            } else if (tabName === 'security') {
                document.getElementById('security-content').classList.remove('hidden');
                document.getElementById('security-tab').classList.add('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            } else if (tabName === 'preferences') {
                document.getElementById('preferences-content').classList.remove('hidden');
                document.getElementById('preferences-tab').classList.add('text-[#45a049]', 'border-b-2', 'border-[#45a049]');
            }
        }
    </script>
</x-app-layout>

