@extends('layouts.admin')

@section('content')
    <h1 class="text-white">Page Brand :</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

<form action="{{  route('brand.store') }}" method="POST">
    @csrf
  <div class="space-y-12">


 <div class="border-b border-white/10 pb-12">
    <h2 class="text-base/7 font-semibold text-white">Create new a catgeory</h2>
    <p class="mt-1 text-sm/6 text-gray-400">Use a permanent address where you can receive mail.</p>

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-3">
        <div class="sm:col-span-3">
          <label for="name" class="block text-sm/6 font-medium text-white">Name</label>
          <div class="mt-2">
            <input id="name"
                value="{{ old('name', '') }}"
            type="text" name="name" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message}}</div>
            @enderror
        </div>
        </div>

        </div>
    </div>
</div>
<div class="mt-6 flex items-center justify-end gap-x-6">
<button type="button" class="text-sm/6 font-semibold text-white">Cancel</button>
<button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
</div>

</form>

@endsection
