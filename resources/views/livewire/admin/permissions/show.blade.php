<!--- show  Roles section  --->
<section class="bg-white container mx-auto md:w-5/5 lg:w-4/5   mt-8 rounded-lg  dark:bg-gray-900">
    <div class="w-full px-4 py-8 mx-auto ">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{__("string.Permissions")}} : </h2>
        @if ($status !== [])
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
        @endif


        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <!--- search --->
            <x-search wire="wire:model.live=input_search" />


        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-center">
                        <th scope="col" class="px-4 py-3">#</th>
                        <th scope="col" class="px-4 py-3">{{__("string.Name")}} </th>
                        <th scope="col" class="px-4 py-3"> {{__("string.Options")}} </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr class="border-b dark:border-gray-700" wire:key="{{ $permission->id }}">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $permission->id }}
                            </th>
                            <td class="px-4 py-3"> {{ $permission->name }} </td>
                            <td class="px-4 py-3 flex flex-row md:justify-center gap-2">
                                <x-button.primary wire:click="" type="button" class="w-min">
                                    <x-svg.arrow-up />
                                </x-button.primary>
                                <x-button.danger type="button" wire:click="delete({{ $permission->id }})"
                                    wire:confirm="are your sure delete this role" class="w-min">
                                    <x-svg.trash />


                                </x-button.danger>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>



        {{ $permissions->links('components.pagination') }}

    </div>
</section>
