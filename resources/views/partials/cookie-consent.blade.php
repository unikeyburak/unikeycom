{{-- KVKK / Cookie Consent Banner --}}
<div
    x-data="{
        show: false,
        init() {
            this.show = !localStorage.getItem('cookie_consent');
        },
        accept() {
            localStorage.setItem('cookie_consent', 'accepted');
            this.show = false;
        },
        reject() {
            localStorage.setItem('cookie_consent', 'rejected');
            this.show = false;
        }
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-[200] bg-gray-900 text-white shadow-2xl"
    role="dialog"
    aria-label="{{ __('Çerez Bildirimi') }}"
>
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">

            {{-- İkon + Metin --}}
            <div class="flex items-start gap-3 flex-1">
                <svg class="w-6 h-6 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <p class="text-sm text-gray-300 leading-relaxed">
                    {!! __('Size daha iyi hizmet sunabilmek için çerezler kullanıyoruz. Sitemizi kullanmaya devam ederek :policy kabul etmiş sayılırsınız.', ['policy' => '<a href="'.lroute('privacy').'" class="text-cyan-400 hover:text-cyan-300 underline underline-offset-2 transition-colors">'.e(__('Gizlilik Politikamızı')).'</a>']) !!}
                </p>
            </div>

            {{-- Butonlar --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <button
                    @click="reject()"
                    class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white border border-gray-600 hover:border-gray-400 rounded-lg transition-colors">
                    {{ __('Reddet') }}
                </button>
                <button
                    @click="accept()"
                    class="px-5 py-2 text-sm font-medium bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors">
                    {{ __('Kabul Et') }}
                </button>
            </div>

        </div>
    </div>
</div>
