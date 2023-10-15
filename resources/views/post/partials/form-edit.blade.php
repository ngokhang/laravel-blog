<x-app-layout>
    <div class="py-12 space-y-6">
        <x-alert-errors />

        <div class="container">
            <form action="{{ route('post.update', ['slug' => $post->slug]) }}"
                class="bg-white shadow sm:rounded-lg p-4 space-y-6" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <h3 class="text-xl font-bold">Edit post</h3>
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                        value="{{ $post->title }}" />
                    <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="slug" :value="__('Slug')" />
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                        value="{{ $post->slug }}" />
                </div>
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                        value="{{ $post->description }}" />
                    <x-input-error :messages="$errors->updatePassword->get('description')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="content" :value="__('Content')" />
                    <textarea name="content" id="content" cols="30" rows="10"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $post->content }}</textarea>
                    <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="image" :value="__('Image')" />
                    <input value="{{ $post->article_img }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        id="file_input" name="article_img" type="file">
                </div>
                <div class="space-y-1">
                    <x-input-label for="category_id" :value="__('Category')" />
                    <select id="category_id" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option disabled selected>Choose category</option>
                        @foreach ($categories as $category)
                            @if ($category->id == 1)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-primary-button>{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
