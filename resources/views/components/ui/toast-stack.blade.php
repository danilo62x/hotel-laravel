<div class="pointer-events-none fixed top-4 right-4 z-[100] flex flex-col gap-2" x-data>
    <template x-for="toast in $store.ui.toasts" :key="toast.id">
        <div class="pointer-events-auto flex w-80 items-start gap-3 rounded-lg border bg-white p-4 shadow-theme-md dark:bg-gray-dark"
            :class="{
                'border-success-200 dark:border-success-500/30': toast.type === 'success',
                'border-error-200 dark:border-error-500/30': toast.type === 'error',
                'border-warning-200 dark:border-warning-500/30': toast.type === 'warning',
                'border-blue-light-200 dark:border-blue-light-500/30': toast.type === 'info',
            }"
            x-transition>
            <span class="mt-0.5"
                :class="{
                    'text-success-500': toast.type === 'success',
                    'text-error-500': toast.type === 'error',
                    'text-warning-500': toast.type === 'warning',
                    'text-blue-light-500': toast.type === 'info',
                }">
                <template x-if="toast.type === 'success'"><x-icon name="check" :size="20" /></template>
                <template x-if="toast.type === 'error'"><x-icon name="x" :size="20" /></template>
                <template x-if="toast.type === 'warning'"><x-icon name="bell" :size="20" /></template>
                <template x-if="toast.type === 'info'"><x-icon name="bell" :size="20" /></template>
            </span>
            <div class="flex-1">
                <p class="text-sm font-medium text-heading" x-text="toast.message"></p>
            </div>
            <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" @click="$store.ui.dismissToast(toast.id)">
                <x-icon name="x" :size="16" />
            </button>
        </div>
    </template>
</div>
