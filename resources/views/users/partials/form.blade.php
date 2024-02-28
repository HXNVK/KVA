<div class="row">
    <div class="mb-3 col-2">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3 col-1">
        <label for="name" class="form-label">Kürzel</label>
        <input type="text" class="form-control" id="kuerzel" name="kuerzel" value="{{ $user->kuerzel }}" required>
    </div>

    <div class="mb-3 col-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>
</div>

@if (Auth::user()->hasRole('SuperAdmin') || Auth::user()->can('user-edit'))
    <div class="row">

        <div class="mb-3 col-3">
            <label for="new_password" class="form-label">{{ __('Password') }}</label>
            <input type="password" class="form-control" id="new_password" name="new_password" value="">
        </div>

        <div class="mb-3 col-3">
            <label for="new_password_confirm" class="form-label">{{ __('Retype password') }}</label>
            <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm"
                value="">
        </div>

    </div>

    <div class="row">
        <div class="m-3">
            <label class="label mr-2">Rollen</label><br>
            @foreach ($roles as $value)
                <label class="label mr-2">
                    <input type="checkbox" name="roles[]" class="name" value={{ $value }}
                        @if (in_array($value, $userRole)) checked @endif> {{ $value }}</label>
            @endforeach
        </div>
    </div>
@endif
<div class="row">
    <div class="m-3">
        <label class="label mr-2">Rechte</label><br>
        @foreach ($user->getAllPermissions()->sortBy('name') as $permission)
            {{ $permission->name }} -
        @endforeach
    </div>
</div>
