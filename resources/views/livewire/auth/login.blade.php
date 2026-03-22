<div class="min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                AM
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Welcome Back') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Login to access the dashboard') }}</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <input wire:model="email" type="email" id="email" 
                           class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none"
                           placeholder="admin@example.com">
                </div>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </div>
                    <input wire:model="password" type="password" id="password" 
                           class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none"
                           placeholder="••••••••">
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input wire:model="remember" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                    <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ __('Remember Me') }}</span>
                </label>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">{{ __('Forgot Password?') }}</a>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                <span>{{ __('Login') }}</span>
                <i data-lucide="{{ app()->getLocale() == 'ar' ? 'arrow-left' : 'arrow-right' }}" class="w-5 h-5"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-50 text-center">
            <p class="text-sm text-gray-500">
                {{ __('Dont have an account?') }} 
                <a href="#" class="text-blue-600 font-bold hover:underline">{{ __('Contact Us') }}</a>
            </p>
        </div>
    </div>
</div>
