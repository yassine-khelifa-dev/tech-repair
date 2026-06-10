 {{-- Customer Information --}}
 <div class="bg-gray-900 rounded-xl p-6 shadow">
     <h2 class="text-lg font-semibold text-white mb-4">
         Customer Information
     </h2>

     <div class="space-y-3 text-gray-300">
         <p>
             <span class="font-medium text-white">Full Name:</span>
             {{ $repair_ticket->customer->fullname }}
         </p>

         <p>
             <span class="font-medium text-white">Phone:</span>
             {{ $repair_ticket->customer->phone }}
         </p>

         <p>
             <span class="font-medium text-white">Email:</span>
             {{ $repair_ticket->customer->email ?: '-' }}
         </p>
     </div>
 </div>
