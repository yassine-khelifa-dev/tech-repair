 {{-- Repair Details --}}
 <div class="bg-gray-900 rounded-xl p-6 shadow lg:col-span-2">
     <h2 class="text-lg font-semibold text-white mb-4">
         Repair Details
     </h2>

     <div class="space-y-4 text-gray-300">

         <div>
             <p class="font-medium text-white mb-1">
                 Technician Note
             </p>
             <p>
                 {{ $repair_ticket->technician_note ?? '-' }}
             </p>
         </div>

         <div>
             <p class="font-medium text-white mb-1">
                 Reported Issue
             </p>
             <p>
                 {{ $repair_ticket->issue_description ?? '-' }}
             </p>
         </div>

         <div>
             <p class="font-medium text-white mb-2">
                 Selected Options
             </p>

             <div class="flex flex-wrap gap-2">
                 @foreach ($repair_ticket->selectedOptions as $option)
                     <span class="px-3 py-1 rounded-full bg-blue-600/20 text-blue-300 border border-blue-500/30">
                         {{ $option->specAttribute->name }} :
                         {{ $option->value }}
                     </span>
                 @endforeach
             </div>
         </div>

     </div>

     <hr class="mt-5 mb-2">

     <div>
         @include('repair.logs.index', [
             'logs' => $repair_ticket->logs,
         ])
     </div>

     <hr class="mt-5 mb-2">

     @auth
         <div>
             @include('repair.logs._form')
         </div>
     @endauth

 </div>
