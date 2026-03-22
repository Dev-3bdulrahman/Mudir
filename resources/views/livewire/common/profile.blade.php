<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 p-10 overflow-hidden relative">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <i data-lucide="user-cog" class="w-32 h-32"></i>
        </div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('Account Settings') }}</h2>
            <p class="text-sm text-gray-500 font-medium mb-8 uppercase tracking-widest">{{ __('Manage your identity') }}</p>

            <form wire:submit.prevent="updateProfile" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Full Name') }}</label>
                    <input wire:model="name" type="text" class="w-full px-6 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner">
                    @error('name') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Email Address') }}</label>
                    <input wire:model="email" type="email" class="w-full px-6 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner">
                    @error('email') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-gray-50 dark:border-gray-800">
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-6">{{ __('Change Password (Optional)') }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('New Password') }}</label>
                            <input wire:model="password" type="password" class="w-full px-6 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner">
                            @error('password') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Confirm Password') }}</label>
                            <input wire:model="password_confirmation" type="password" class="w-full px-6 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner">
                        </div>
                    </div>
                </div>

                <div class="pt-10 flex justify-end">
                    <button type="submit" class="px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-xl shadow-blue-500/30 active:scale-95">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', () => {
        lucide.createIcons();
    });
</script>
