@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8" x-data="{
        'input_type': 'text',
        'attribute_name': '',
        'list_size': 1,
        'code': '',
        'unit': '',
        'spec_options': [],
        remove(index) {
            if (this.list_size > 1) {
                this.spec_options.splice(index, 1);
                this.list_size--;
            }
        },
        init() {
            this.$watch('attribute_name', value => {
                this.code = value.toLowerCase().replaceAll(' ', '_')
            })
        }
    }">


      @include('device.spec-attributes._form')

    </div>
@endsection
