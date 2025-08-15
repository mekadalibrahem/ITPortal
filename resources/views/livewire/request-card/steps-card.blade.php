{{-- <div class="flex overflow-x-auto pb-4">  --}}
<div class="flex items-start relative justify-between overflow-x-auto gap-4 my-4">

    <!-- Heading -->


    <livewire:request-card.step-card-item title="{{ __('string.create request step') }}" status='done' note='' :time="$request_list->created_at"
        connector="{{ false }}" />
    <!-- End Heading -->
    @forelse ($steps as  $step)
        <livewire:request-card.step-card-item :title="$step['title']" :status="$step['status']" :note="$step['note']" :time="$step['time']" />
    @empty
    @endforelse


    {{-- end --}}
   
    <livewire:request-card.step-card-item title="{{ __('string.end request step') }}" :status="$end_status"  :note="$request_list->status" :time="$request_list->end_at" />

</div>

{{-- </div> --}}
