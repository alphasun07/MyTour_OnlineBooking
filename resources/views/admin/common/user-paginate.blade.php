<div class="p-2" id="user-items-wrapper" style="overflow-y: auto;max-height: 70vh;">
    @foreach ($users as $user)
    <div onclick="clickUser($(this))" class="border w-100 user-items d-flex p-2 mb-2 {{ isset($user->id) && ((old('user_id') && old('user_id')==$user->id) || (!old('user_id') && isset($user_id) && $user_id==$user->id)) ? 'selected' : '' }}" data-dismiss="modal"><div class="user_id_div" style="min-width:15%;">{{ $user->id ?? '' }}</div><span class="username_span">{{ $user->name ?? '' }}</span></div>
    @endforeach
</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $users->links() }}
</div>