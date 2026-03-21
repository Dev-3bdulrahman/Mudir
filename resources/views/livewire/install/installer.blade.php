<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    {{-- Header --}}
    <div class="bg-indigo-600 p-8 text-white text-center">
        <h2 class="text-3xl font-bold mb-2">معالج التثبيت</h2>
        <p class="opacity-80">إعداد النظام والتحقق من الترخيص</p>
        
        <div class="flex items-center justify-center gap-4 mt-8">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full {{ $step >= 1 ? 'bg-white text-indigo-600' : 'bg-indigo-500/50 text-white/50' }} flex items-center justify-center font-bold text-sm">1</div>
                <span class="text-[10px] mt-1 font-medium">المتطلبات</span>
            </div>
            <div class="w-8 h-px bg-white/20"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full {{ $step >= 2 ? 'bg-white text-indigo-600' : 'bg-indigo-500/50 text-white/50' }} flex items-center justify-center font-bold text-sm">2</div>
                <span class="text-[10px] mt-1 font-medium">البيانات</span>
            </div>
            <div class="w-8 h-px bg-white/20"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full {{ $step >= 3 ? 'bg-white text-indigo-600' : 'bg-indigo-500/50 text-white/50' }} flex items-center justify-center font-bold text-sm">3</div>
                <span class="text-[10px] mt-1 font-medium">التفعيل</span>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-8">
        @if($error_message)
            <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 text-red-700 text-sm text-right">
                {{ $error_message }}
            </div>
        @endif

        @if($step === 1)
            <div class="space-y-6 text-right">
                <h3 class="text-xl font-bold text-slate-800">فحص متطلبات النظام</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-700">إصدار PHP</p>
                                <p class="text-xs text-slate-500">مطلوب 8.2 أو أعلى</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-bold">{{ phpversion() }}</span>
                    </div>
                </div>
            </div>
        @elseif($step === 2)
            <div class="space-y-6 text-right">
                <h3 class="text-xl font-bold text-slate-800">بيانات التثبيت</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">اختر المنتج</label>
                        <select wire:model="selected_product_id" class="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all">
                            <option value="">-- اختر المنتج --</option>
                            @foreach($products as $product)
                                <option value="{{ $product['id'] }}">{{ is_array($product['name']) ? ($product['name'][app()->getLocale()] ?? array_shift($product['name'])) : $product['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">الاسم الكامل</label>
                            <input wire:model="name" type="text" class="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">البريد الإلكتروني</label>
                            <input wire:model="email" type="email" class="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">الدومين (Domain)</label>
                        <input wire:model="domain" type="text" readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-100 bg-slate-50 text-slate-400 outline-none font-mono">
                    </div>
                </div>
            </div>
        @elseif($step === 3)
            <div class="space-y-6 text-right">
                <h3 class="text-xl font-bold text-slate-800">تفعيل الترخيص</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">كلمة المرور</label>
                        <input wire:model="password" type="password" class="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        @elseif($step === 4)
            <div class="text-center py-8">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">تم التثبيت بنجاح!</h3>
                <p class="text-slate-600 mb-8">تم تفعيل المنتج وربطه بالدومين الخاص بك بنجاح.</p>
                <a href="/admin" class="inline-block bg-indigo-600 text-white px-12 py-4 rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">الذهاب للوحة التحكم</a>
            </div>
        @endif

        @if($step < 4)
            <div class="mt-10 flex flex-row-reverse gap-4">
                <button wire:click="nextStep" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 group shadow-lg shadow-indigo-100">
                    <span wire:loading.remove>{{ $step === 3 ? 'إنهاء وتفعيل' : 'المتابعة' }}</span>
                    <span wire:loading>جاري التثبيت...</span>
                </button>
                @if($step > 1)
                    <button wire:click="$set('step', {{ $step - 1 }})" class="text-slate-400 font-bold px-6 py-4 rounded-xl hover:bg-slate-50 transition-colors">رجوع</button>
                @endif
            </div>
        @endif
    </div>
</div>
