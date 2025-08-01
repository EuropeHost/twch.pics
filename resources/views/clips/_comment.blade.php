<div class="bg-gray-50 p-4 rounded-lg shadow-sm {{ $comment->parent_id ? 'ml-8 mt-4 border-l-2 border-gray-200 pl-4' : '' }}">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center space-x-2">
            @if ($comment->user->avatar)
            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="w-6 h-6 rounded-full" />
            @endif
            <strong class="text-sm text-gray-800">{{ $comment->user->name }}</strong>
            <span class="text-xs text-gray-500">
                {{ $comment->created_at->diffForHumans() }}
            </span>
        </div>
        <div>
            @auth
                @if (Auth::id() === $comment->user_id)
                <form action="{{ route('clips.comments.destroy', ['clip' => $comment->clip->id, 'comment' => $comment->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </form>
                @endif
            @endauth
        </div>
    </div>
    <p class="text-gray-700 text-sm mb-2">{{ $comment->content }}</p>

    {{-- Reply Form (Coming Soon) --}}
    {{--
    @auth
        <button type="button" class="text-blue-500 text-xs hover:underline mt-2"
            onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
        <form id="reply-form-{{ $comment->id }}"
            action="{{ route('clips.comments.store', $clip->id) }}" method="POST" class="hidden mt-2">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" rows="2" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Write your reply..." required></textarea>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs py-1 px-2 rounded mt-1">Post Reply</button>
        </form>
    @endauth
    --}}

    {{-- Display Replies (Recursively include this partial) --}}
    @if ($comment->replies->isNotEmpty())
    <div class="mt-4 space-y-4">
        @foreach ($comment->replies as $reply)
            @include('clips._comment', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>

{{-- Small JS to toggle reply forms (Coming Soon) --}}
{{--
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form) {
            form.classList.toggle('hidden');
        }
    }
</script>
--}}