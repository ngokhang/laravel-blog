<x-app-layout>
    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
            <h1 class="title text-gray-900">{{ $post->title }}</h1>
            @auth
                @if (auth()->user()->role == 'admin')
                    <div class="flex gap-5">
                        @if ($post->accepted == 0)
                            <form action="{{ route('admin.update', ['post' => $post->slug]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <x-primary-button
                                    class="bg-green-500 hover:effect-hover-block">{{ __('Accept this post') }}</x-primary-button>
                            </form>
                        @endif
                        @if ($post->deleted_at != null)
                            <form action="{{ route('admin.update', ['post' => $post->slug]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <x-primary-button
                                    class="bg-yellow-400 hover:effect-hover-block">{{ __('Restore this post') }}</x-primary-button>
                            </form>
                        @else
                            <form action="{{ route('admin.destroy', ['slug' => $post->slug]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <x-primary-button
                                    class="bg-red-600 hover:effect-hover-block">{{ __('Remove this post') }}</x-primary-button>
                            </form>
                        @endif
                    </div>
                @endif
            @endauth
            <div class="flex gap-5">
                <span>Author: </span>
                <a href="#" class="redirect-link hover:effect-hover-text">{{ $post->user->name }}</a> -
                <span>Posted at: {{ $post->created_at }}</span>
                @if ($post->user->id == Auth::user()->id || Auth::user()->role == 'admin')
                    <a href="{{ route('post.edit', ['post_id' => $post->id]) }}"
                        class="redirect-link hover:effect-hover-text">Edit this post</a>
                @endif
                @if ($post->accepted == 0)
                    <span class="text-red-400">Waiting admin</span>
                @else
                    <span class="text-green-400">Admin verified</span>
                @endif
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
                @if ($post->images != null)
                    <div class="article-img my-5 flex flex-col items-center justify-center">
                        <img class="w-1/2 rounded-md shadow-xl" src="{{ asset($post->images->path) }}"
                            alt="This is image">
                        <span class="block italic">Image</span>
                    </div>
                @endif
                {{ $post->content }}
            </article>
        </div>
    </div>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
            <h1 class="title text-gray-900">{{ __('Comments') }}</h1>
            @if (count($post->comments) > 0)
                <div class="space-y-6">
                    @foreach ($post->comments as $comment)
                        <div class="flex items-center gap-5">
                            <a href="#" class="text-xl text-black">{{ $comment->user->name }}</a>
                            @if ($post->user_id == $comment->user->id)
                                - <span class="text-xl text-red-500">Author</span>
                            @endif
                            <div class="ps-4">{{ $comment->created_at }}</div>
                            @if ($post->accepted == 1)
                                <a href="#" class="text-blue-300 hover:effect-hover-text btn-reply-cmt"
                                    data-target="comment-id-{{ $comment->id }}">Reply
                                    this comment</a>
                            @endif
                        </div>
                        <div class="space-y-6 border rounded-lg p-3">
                            <div class="space-y-6">
                                <div>
                                    <p class="text-base">{{ $comment->content }}</p>
                                </div>
                                <div class="replies-comment space-y-3 max-h-[150px] overflow-y-auto border rounded-lg">
                                    @if (count($comment->replies) > 0)
                                        @foreach ($comment->replies as $commentChild)
                                            <div class="comment ps-5">
                                                <a href="#"
                                                    class="text-xl text-black">{{ $commentChild->user->name }}</a>
                                                @if ($post->user_id == $commentChild->user->id)
                                                    - <span class="text-lg text-red-500">Author</span>
                                                @endif
                                                <span class="ps-4"> {{ $commentChild->created_at }}</span>
                                                <div class="text-base">
                                                    <p>{{ $commentChild->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <hr>
                                </div>
                            </div>
                            <div class="space-y-6 relpy-comment hidden animate-fadeIn"
                                data-target="comment-id-{{ $comment->id }}">
                                <x-alert-errors />
                                <form action="{{ route('reply.store', ['comment' => $comment]) }}" method="POST"
                                    class="space-y-6 w-full" id="form-reply-comment">
                                    @csrf
                                    <div>
                                        <x-input-label for="comment" :value="__('Comment')" />
                                        <textarea name="comment" id="comment" cols="30" rows="3"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                        <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-primary-button>{{ __('Reply') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center"><span class="text-base text-gray-900 font-bold italic">Not comment yet.</span>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
            @if ($post->accepted == 0)
                <h1 class="title text-gray-900">{{ __('Your comment') }}</h1>
                <div class="text-base">This post hasn't accepted by admin yet.</div>
            @else
                <h1 class="title text-gray-900">{{ __('Your comment') }}</h1>
                <div class="space-y-6">
                    <x-alert-errors />
                    <form action="{{ route('comment.store', ['post' => $post]) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="comment" :value="__('Comment')" />
                            <textarea name="comment" id="comment" cols="30" rows="5"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-primary-button>{{ __('Comment') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
