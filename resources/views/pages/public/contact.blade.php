<x-layout.public :pageTitle="$pageTitle ?? null">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data>
        <div class="mb-10 text-center">
            <h1 class="text-title-md font-bold text-heading" x-text="$t('contact.title')"></h1>
            <p class="mx-auto mt-3 max-w-2xl text-muted" x-text="$t('contact.subtitle')"></p>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1.4fr_1fr]">
            {{-- Form --}}
            <div class="surface-card rounded-2xl border p-6 md:p-8"
                x-data="{ form: { name: '', email: '', phone: '', message: '' }, submit() {
                    $store.ui.notifySuccess(this.$t('contactForm.success'));
                    this.form = { name: '', email: '', phone: '', message: '' };
                } }">
                <h2 class="text-lg font-semibold text-heading" x-text="$t('contact.formTitle')"></h2>
                <form @submit.prevent="submit()" class="mt-5 space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <input x-model="form.name" type="text" required :placeholder="$t('contactForm.name')" class="focus-ring h-11 w-full rounded-lg border border-themed bg-gray-50 px-3 text-sm text-body dark:bg-gray-900" />
                        <input x-model="form.email" type="email" required :placeholder="$t('contactForm.email')" class="focus-ring h-11 w-full rounded-lg border border-themed bg-gray-50 px-3 text-sm text-body dark:bg-gray-900" />
                    </div>
                    <input x-model="form.phone" type="tel" :placeholder="$t('contactForm.phone')" class="focus-ring h-11 w-full rounded-lg border border-themed bg-gray-50 px-3 text-sm text-body dark:bg-gray-900" />
                    <textarea x-model="form.message" rows="5" required :placeholder="$t('contactForm.message')" class="focus-ring w-full rounded-lg border border-themed bg-gray-50 px-3 py-2.5 text-sm text-body dark:bg-gray-900"></textarea>
                    <button type="submit" class="flex h-11 items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white transition hover:bg-brand-600">
                        <x-icon name="send" :size="16" /> <span x-text="$t('contactForm.send')"></span>
                    </button>
                </form>
            </div>

            {{-- Info --}}
            <div class="space-y-4">
                <div class="surface-card rounded-2xl border p-6">
                    <h2 class="text-lg font-semibold text-heading" x-text="$t('contact.infoTitle')"></h2>
                    <ul class="mt-4 space-y-4 text-sm">
                        @foreach ([['map-pin', 'address'], ['phone', 'phone'], ['mail', 'email'], ['clock', 'hours']] as [$icon, $key])
                            <li class="flex items-start gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/15">
                                    <x-icon name="{{ $icon }}" :size="16" />
                                </span>
                                <div>
                                    <p class="font-medium text-heading" x-text="$t('contact.{{ $key }}')"></p>
                                    <p class="text-muted" x-text="$t('contact.{{ $key }}Value')"></p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="overflow-hidden rounded-2xl border border-themed">
                    <img src="{{ \App\Support\HtData::photoUrl('family-suite', 4, 700, 400) }}" alt="" class="h-48 w-full object-cover" />
                </div>
            </div>
        </div>
    </div>
</x-layout.public>
