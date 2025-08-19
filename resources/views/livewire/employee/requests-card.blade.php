<x-widgets.section title="{{ __('string.Request details') }}">
    @if ($request_id > 0)
        <livewire:request-card.steps-card :id="$request_id" />
        <livewire:request-card.info-card hasexport="{{ true }}" :request="$request">

            @if ($can_work)
                <div class="mt-6 space-y-4">

                    <div class="grid gap-2 md:grid-cols-3">
                        <x-form.label for="cancel_note">{{ __('string.cancel note title') }}</x-form.label>
                        <textarea id="cancel_note" placeholder="{{ __('string.placholder_cancel_note') }}" name="cancel_note"
                            wire:model="cancel_note"
                            class="col-span-2 block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600"></textarea>
                        <div>
                            @error('cancel_note')
                                <x-alert.alert type="danger" :message="$message" />
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-4 mt-4">

                        <x-button status="success" type="button"
                            wire:click="accept()">{{ __('string.accept') }}</x-button>
                        <x-button status="primary" type="button"
                            wire:click="cancel()">{{ __('string.askToedit') }}</x-button>
                        <x-button status="danger " type="button"
                            wire:click="reject()">{{ __('string.reject') }}</x-button>


                    </div>
                </div>
            @endif
    @endif
</x-widgets.section>
