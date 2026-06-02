@props(['label', 'name'])



<h3 class="mb-4 font-semibold text-heading">{{ $label  }}</h3>
<ul class="w-48 bg-neutral-primary-soft border border-default rounded-base">
    <li class="w-full border-b border-default">
        <div class="flex items-center ps-3">
            <input id="list-radio-license" type="radio" value="" name="list-radio" class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
            <label for="list-radio-license" class="w-full py-3 select-none ms-2 text-sm font-medium text-heading">Driver License </label>
        </div>
    </li>
    <li class="w-full border-b border-default">
        <div class="flex items-center ps-3">
            <input id="list-radio-id" type="radio" value="" name="list-radio" class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
            <label for="list-radio-id" class="w-full py-3 select-none ms-2 text-sm font-medium text-heading">State ID</label>
        </div>
    </li>
</ul>

