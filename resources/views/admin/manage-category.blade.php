<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <x-alert-errors />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-lg">Create</h1>
                    <form action="{{ route('category.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="new_name_category" :value="__('New name')" />
                            <x-text-input id="new_name_category" name="new_name_category" type="text"
                                class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="new_slug_category" :value="__('New slug')" />
                            <x-text-input id="new_slug_category" name="new_slug_category" type="text"
                                class="mt-1 block w-full" />
                        </div>
                        <x-primary-button>{{ __('Add') }}</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-lg">Edit</h1>
                    <form action="{{ route('category.update') }}" method="POST" class="space-y-6">
                        @method('PUT')
                        @csrf
                        <select name="category" id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-label for="new_name_category" :value="__('New name')" />
                        <x-text-input id="new_name_category" name="new_name_category" type="text"
                            class="mt-1 block w-full" />
                        <x-input-label for="new_slug_category" :value="__('New slug')" />
                        <x-text-input id="new_slug_category" name="new_slug_category" type="text"
                            class="mt-1 block w-full" />



                        <x-primary-button>{{ __('Edit') }}</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-lg">Delete</h1>
                    <form action="{{ route('category.delete') }}" method="POST" class="space-y-6">
                        @method('DELETE')
                        @csrf
                        @foreach ($categories as $category)
                            <div class="flex gap-6 items-center">
                                <x-text-input id="{{ $category->slug }}" name="category_slug[]" type="checkbox"
                                    class="mt-1" value="{{ $category->slug }}" />
                                <x-input-label for="{{ $category->slug }}" value="{{ $category->name }}" />
                            </div>
                        @endforeach
                        <x-primary-button>{{ __('Delete') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
