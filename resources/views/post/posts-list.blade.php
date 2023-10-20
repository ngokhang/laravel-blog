<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your posts') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-4">
                <a href="{{ route('post.create') }}"
                    class="inline-block border rounded-md bg-slate-600 py-2 px-3 text-white hover:effect-hover-block">{{ __('Create new post') }}</a>
            </div>
        </div>

        @foreach ($postList as $post)
            <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('post.partials.post-item')
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex pb-5 justify-center">
        <x-paginate-link :postList="$postList" />
    </div>
</x-app-layout>
