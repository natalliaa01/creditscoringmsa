<x-guest-layout>
    {{-- Kontainer utama untuk halaman register dengan desain split-panel yang lebih profesional --}}
    <div class="flex flex-col md:flex-row w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden my-6 transform transition-all duration-300 hover:shadow-2xl">
        <div class="w-full md:w-1/2 p-5 md:p-7 lg:p-9 flex flex-col justify-center rounded-l-2xl">
            <div class="mb-6 flex justify-center">
                {{-- Menggunakan komponen logo aplikasi jika tersedia, atau gambar statis --}}
                <a href="/">
                    <img src="{{ asset('img/logo3.png') }}" alt="Logo Credit Scoring System" class="h-20 w-auto"> {{-- Logo sedikit lebih kecil untuk register --}}
                </a>
            </div>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-center mb-3 text-gray-800 leading-tight">Bergabung dengan Kami</h2>
            <p class="text-center text-gray-600 mb-6 text-sm">Buat akun baru untuk mengakses sistem credit scoring terdepan.</p>

            {{-- Error validasi --}}
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <x-label for="name" value="{{ __('Nama Lengkap') }}" class="mb-2 text-gray-700 font-medium" />
                    <div class="relative">
                        <x-input id="name" class="block w-full pl-12 pr-4 py-3 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class='bx bx-user text-xl'></i>
                        </span>
                    </div>
                </div>

                {{-- Email Address --}}
                <div>
                    <x-label for="email" value="{{ __('Alamat Email') }}" class="mb-2 text-gray-700 font-medium" />
                    <div class="relative">
                        <x-input id="email" class="block w-full pl-12 pr-4 py-3 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class='bx bx-envelope text-xl'></i>
                        </span>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <x-label for="password" value="{{ __('Kata Sandi') }}" class="mb-2 text-gray-700 font-medium" />
                    <div class="relative">
                        <x-input id="password" class="block w-full pl-12 pr-12 py-3 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition duration-200" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class='bx bx-lock-alt text-xl'></i>
                        </span>
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 focus:outline-none">
                            <i class='bx bx-show text-xl'></i>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-label for="password_confirmation" value="{{ __('Konfirmasi Kata Sandi') }}" class="mb-2 text-gray-700 font-medium" />
                    <div class="relative">
                        <x-input id="password_confirmation" class="block w-full pl-12 pr-12 py-3 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition duration-200" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class='bx bx-lock-alt text-xl'></i>
                        </span>
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 focus:outline-none">
                            <i class='bx bx-show text-xl'></i>
                        </button>
                    </div>
                </div>

                {{-- Terms and Privacy Policy --}}
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms" class="flex items-start">
                            <x-checkbox name="terms" id="terms" required class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                            <div class="ml-3">
                                <span class="text-sm text-gray-700">
                                    {!! __('Saya setuju dengan :terms_of_service dan :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-blue-600 hover:text-blue-800 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">'.__('Syarat Layanan').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-blue-600 hover:text-blue-800 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">'.__('Kebijakan Privasi').'</a>',
                                    ]) !!}
                                </span>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-center mt-6">
                    <x-button class="w-full py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-500 text-white font-semibold rounded-xl text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        {{ __('Daftar Sekarang') }}
                    </x-button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold underline transition duration-200">Masuk di sini</a>
            </div>
        </div>

        <div class="hidden md:flex w-1/2 items-center justify-center p-8 bg-green-50 rounded-r-2xl relative">
            <img src="{{ asset('img/shaka_utama.png') }}" alt="Ilustrasi Credit Scoring System" class="w-full max-w-md h-auto object-contain transform scale-95 transition-transform duration-300 hover:scale-100">
            <div class="absolute bottom-10 text-green-900 text-center px-4">
                <h3 class="text-2xl font-bold mb-2">Analisis Kredit yang Akurat</h3>
                <p class="text-sm opacity-90">Sistem penilaian kredit terdepan untuk keputusan finansial yang tepat.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = "<i class='bx bx-hide text-xl'></i>";
    } else {
        input.type = 'password';
        btn.innerHTML = "<i class='bx bx-show text-xl'></i>";
    }
}
</script>