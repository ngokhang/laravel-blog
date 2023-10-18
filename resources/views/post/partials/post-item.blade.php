<section>
    <div>
        <a href="{{ route('post.show', ['post' => $post->slug]) }}"
            class="text-lg font-medium text-gray-900 hover:effect-hover-text">
            {{ $post->title }}
        </a>
        <p class="text-sm font-medium text-gray-500 ">
            {{ $post->description }}
            <span class="ps-5">{{ $post->created_at }}</span>
            @if ($post->accepted == 0)
                <span class="text-red-400"> - Waiting admin</span>
            @endif
            @if ($post->deleted_at != null)
                <span class="text-red-400"> - Deleted</span>
            @endif
        </p>
        <div class=" mt-3 flex gap-4">
            @foreach ($post->categories as $category)
                <a href="#"
                    class="inline-block bg-black border rounded  py-2 px-3 text-xs leading-[1.25] text-white font-medium hover:effect-hover-block">
                    {{ $category->name }}
                </a>
            @endforeach
            @if ($post->deleted_at != null)
                <form action="{{ route('admin.update', ['post' => $post->slug]) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <x-primary-button
                        class="bg-yellow-400 hover:effect-hover-block">{{ __('Restore this post') }}</x-primary-button>
                </form>
            @endif
        </div>
    </div>
</section>
