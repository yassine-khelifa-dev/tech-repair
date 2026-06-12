 {{-- Device Information --}}
 <div class="bg-gray-900 rounded-xl p-6 shadow">
     <h2 class="text-lg font-semibold text-white mb-4">
         Device Information
     </h2>

     <div class="space-y-3 text-gray-300">
         <p>
             <span class="font-medium text-white">Brand:</span>
             {{ $repair_ticket->deviceModel->brand->name }}
         </p>

         <p>
             <span class="font-medium text-white">Model:</span>
             {{ $repair_ticket->deviceModel->name }}
         </p>

         <p>
             <span class="font-medium text-white">Serial Number:</span>
             {{ $repair_ticket->sn ?: '-' }}
         </p>
     </div>

     <x-forms.image-gallery :images="$repair_ticket->photos" title="Device Photos" />
 </div>
