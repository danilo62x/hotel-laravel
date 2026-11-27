<footer class="surface-header border-t px-4 py-4 md:px-6 2xl:px-10" x-data>
    <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
        <p class="text-xs text-muted">© {{ date('Y') }} <span x-text="$t('brand')"></span>. <span x-text="$t('footer.rights')"></span></p>
        <div class="flex items-center gap-4 text-xs text-muted">
            <a href="#" class="hover:text-brand-500" x-text="$t('footer.privacy')"></a>
            <a href="#" class="hover:text-brand-500" x-text="$t('footer.terms')"></a>
        </div>
    </div>
</footer>
