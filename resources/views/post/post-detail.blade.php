<x-app-layout>
    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
            <h1 class="title text-gray-900">{{ $post->title }}</h1>
            <div class="flex gap-5">
                <span>Author: </span>
                <a href="#" class="redirect-link hover:effect-hover-text">{{ $post->user->name }}</a> -
                <span>Posted at: {{ $post->created_at }}</span>
            </div>
            <div class="inline-block mt-3 ">
                @foreach ($post->categories as $category)
                    <a href="#"
                        class="inline-block bg-black border rounded  py-2 px-3 text-xs leading-[1.25] text-white font-medium hover:effect-hover-block">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <article class="mt-5 text-lg">
                @if ($post->img != null)
                    <div class="article-img my-5 flex justify-center">
                        <img class="w-1/2 rounded-md shadow-xl"
                            src="https://vcdn1-giaitri.vnecdn.net/2023/04/28/doraemon4-1682675790-8961-1682675801.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=EAxUAFcakJsi4GQW0mYsCQ"
                            alt="This is image">
                        <span class="text-xs leading-normal text-gray-500">{{ $post->img->title }}</span>
                    </div>
                @endif
                {{ $post->content }}
            </article>
        </div>
    </div>
</x-app-layout>
