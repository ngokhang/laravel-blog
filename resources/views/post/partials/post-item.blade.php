<section>
    <div>
        <a href="{{ route('post.show', ['post_id' => $post->id]) }}"
            class="text-lg font-medium text-gray-900 hover:effect-hover-text">
            {{ $post->title }}
        </a>
        <p class="text-sm font-medium text-gray-500 ">
            {{ $post->description }}
            <span class="ps-5">{{ $post->created_at }}</span>
        </p>
        <div class=" mt-3 ">
            @foreach ($post->categories as $category)
                <a href="#"
                    class="inline-block bg-black border rounded  py-2 px-3 text-xs leading-[1.25] text-white font-medium hover:effect-hover-block">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
