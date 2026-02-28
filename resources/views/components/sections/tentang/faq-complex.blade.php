@props([
    'title' => 'Pusat <span class="text-primary italic">Informasi & Bantuan.</span>',
    'subtitle' => 'KESELURUHAN DETAIL',
    'categories' => []
])

@php
    $firstCatId = count($categories) > 0 ? $categories[0]['id'] : 'technical';
@endphp

<section id="complex-faq" {{ $attributes->merge(['class' => 'py-24 sm:py-32 bg-stone-50 relative overflow-hidden']) }}>
    <!-- Decorative Accents -->
    <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-primary/5 blur-[120px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-1/4 h-1/4 bg-accent/5 blur-[100px] rounded-full -translate-x-1/2 translate-y-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-20">
            <x-section-heading 
                :title="$title" 
                :subtitle="$subtitle" 
                align="left" 
            />
        </div>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20" 
             x-data="{ 
                activeCat: '{{ $firstCatId }}', 
                activeFaq: null,
                currentPage: 1,
                itemsPerPage: 5,
                counts: {
                    @foreach($categories as $cat)
                        '{{ $cat['id'] }}': {{ count($cat['faqs']) }},
                    @endforeach
                },
                get totalPages() { return Math.ceil(this.counts[this.activeCat] / this.itemsPerPage) },
                nextPage() { if(this.currentPage < this.totalPages) this.currentPage++ },
                prevPage() { if(this.currentPage > 1) this.currentPage-- },
                switchCat(catId) {
                    this.activeCat = catId;
                    this.currentPage = 1;
                    this.activeFaq = null;
                }
             }">
            
            <!-- LEFT COLUMN: Categories & Contact -->
            <div class="lg:w-1/3 flex flex-col h-full">
                <!-- Sidebar Category Navigation -->
                <div class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar gap-4 pb-4 lg:pb-0">
                    @foreach($categories as $cat)
                        <button 
                            @click="switchCat('{{ $cat['id'] }}')"
                            class="flex items-center gap-5 px-8 py-6 rounded-[2rem] border-2 transition-all duration-500 whitespace-nowrap lg:whitespace-normal group text-left min-w-[240px] lg:min-w-full"
                            :class="activeCat === '{{ $cat['id'] }}' ? 'bg-secondary border-secondary text-white shadow-2xl shadow-secondary/20' : 'bg-white border-transparent text-gray-500 hover:border-gray-200'"
                        >
                            <div 
                                class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 shrink-0"
                                :class="activeCat === '{{ $cat['id'] }}' ? 'bg-primary text-white' : 'bg-stone-50 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary'"
                            >
                                <i class="{{ $cat['icon'] }} text-xl"></i>
                            </div>
                            <div>
                                <span class="block font-black text-sm uppercase tracking-widest">{{ $cat['label'] }}</span>
                                <span class="text-[10px] opacity-60 font-medium" :class="activeCat === '{{ $cat['id'] }}' ? 'text-gray-300' : 'text-gray-400'">
                                    {{ count($cat['faqs']) }} Pertanyaan Umum
                                </span>
                            </div>
                        </button>
                    @endforeach
                </div>

                <!-- Quick Contact Card (Left Bottom) -->
                <div class="mt-12 p-10 bg-primary rounded-[3rem] relative overflow-hidden group min-h-[300px] flex flex-col justify-center">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <h4 class="text-white font-black text-2xl mb-4 relative z-10 leading-tight">Ada pertanyaan spesifik?</h4>
                    <p class="text-white/80 text-sm mb-8 relative z-10">Tim teknis kami siap membantu menjelaskan detail pengerjaan secara gratis.</p>
                    <a href="https://wa.me/6281234567890" class="inline-flex items-center justify-center gap-3 bg-white text-primary px-8 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-secondary hover:text-white transition-all duration-500 relative z-10 group/btn shadow-xl shadow-black/5">
                        Chat WhatsApp
                        <i class="ri-whatsapp-line text-lg group-hover/btn:rotate-12 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- RIGHT COLUMN: FAQ Content & Pagination -->
            <div class="lg:w-2/3 flex flex-col">
                <!-- MAIN FAQ CARD -->
                <div class="bg-white rounded-[3.5rem] p-6 sm:p-10 shadow-3xl shadow-black/5 border border-gray-100 flex-grow relative overflow-hidden">
                    @foreach($categories as $cat)
                        <div 
                            x-show="activeCat === '{{ $cat['id'] }}'" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="space-y-4"
                        >
                            @foreach($cat['faqs'] as $index => $faq)
                                @php $id = $cat['id'] . '-' . $index; @endphp
                                <div 
                                    class="group border-b border-gray-100 last:border-0"
                                    x-show="Math.ceil(({{ $index }} + 1) / itemsPerPage) === currentPage"
                                >
                                    <div class="transition-all duration-500">
                                        <button 
                                            @click="activeFaq === '{{ $id }}' ? activeFaq = null : activeFaq = '{{ $id }}'"
                                            class="w-full py-7 flex items-center justify-between text-left focus:outline-none"
                                        >
                                            <span 
                                                class="text-base sm:text-lg font-black transition-colors duration-300 pr-8"
                                                :class="activeFaq === '{{ $id }}' ? 'text-primary' : 'text-secondary group-hover:text-primary'"
                                            >
                                                {{ $faq['q'] }}
                                            </span>
                                            <div 
                                                class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500 shrink-0"
                                                :class="activeFaq === '{{ $id }}' ? 'bg-primary text-white rotate-90' : 'bg-stone-100 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary'"
                                            >
                                                <i :class="activeFaq === '{{ $id }}' ? 'ri-subtract-line' : 'ri-add-line'" class="text-lg"></i>
                                            </div>
                                        </button>

                                        <div 
                                            x-show="activeFaq === '{{ $id }}'" 
                                            x-collapse 
                                            x-cloak
                                        >
                                            <div class="pb-8">
                                                <p class="text-gray-500 text-sm sm:text-base leading-relaxed font-medium">
                                                    {{ $faq['a'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION BAR (Sejajar dengan Quick Contact Card) -->
                <div class="mt-12 flex items-center justify-between px-6">
                    <div class="flex items-center gap-4">
                        <button 
                            @click="prevPage()" 
                            class="w-14 h-14 rounded-full flex items-center justify-center border-2 transition-all duration-300 disabled:opacity-20 disabled:cursor-not-allowed group shadow-sm bg-white"
                            :class="currentPage > 1 ? 'border-secondary text-secondary hover:bg-secondary hover:text-white' : 'border-gray-200 text-gray-300'"
                            :disabled="currentPage === 1"
                        >
                            <i class="ri-arrow-left-s-line text-2xl group-hover:-translate-x-1 transition-transform"></i>
                        </button>
                        
                        <div class="flex items-center gap-2">
                            <template x-for="p in totalPages">
                                <button 
                                    @click="currentPage = p"
                                    class="w-3 h-3 rounded-full transition-all duration-500"
                                    :class="currentPage === p ? 'bg-primary w-8' : 'bg-gray-200 hover:bg-gray-300'"
                                ></button>
                            </template>
                        </div>

                        <button 
                            @click="nextPage()" 
                            class="w-14 h-14 rounded-full flex items-center justify-center border-2 transition-all duration-300 disabled:opacity-20 disabled:cursor-not-allowed group shadow-sm bg-white"
                            :class="currentPage < totalPages ? 'border-secondary text-secondary hover:bg-secondary hover:text-white' : 'border-gray-200 text-gray-300'"
                            :disabled="currentPage === totalPages"
                        >
                            <i class="ri-arrow-right-s-line text-2xl group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>

                    <div class="text-right">
                        <span class="text-gray-400 font-black text-[10px] uppercase tracking-widest block">Halaman</span>
                        <span class="text-secondary font-black text-2xl leading-none">
                            <span x-text="currentPage"></span>
                            <span class="text-gray-300 mx-1 text-lg">/</span>
                            <span class="text-gray-400 text-lg" x-text="totalPages"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
