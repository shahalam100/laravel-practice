<!DOCTYPE html>

<head>
    <title>Edit User</title>
</head>

<html>
<body>

<h2?>Edit User</h2>

<form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- First Name -->
     <input type="text" name="first_name" value="{{$user->first_name}}"><br><br>
     
    <!-- Last Name -->
    <input type="text" name="last_name" value="{{ $user->last_name }}"><br><br>

    <!-- Gender -->
    <input type="radio" name="gender" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}> Male
    <input type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}> Female
    <input type="radio" name="gender" value="other" {{ $user->gender == 'other' ? 'checked' : '' }}> Other
    <br><br>

    <!-- Email -->
    <input type="email" name="email" value="{{ $user->email }}"><br><br>

    <!-- Password -->
    <input type="password" name="password" placeholder="Enter new password"><br><br>

    <!-- Skills -->
    @php
        $userSkills = explode(',', $user->skills);
    @endphp

    <input type="checkbox" name="skills[]" value="PHP" {{ in_array('PHP', $userSkills) ? 'checked' : '' }}> PHP
    <input type="checkbox" name="skills[]" value="Laravel" {{ in_array('Laravel', $userSkills) ? 'checked' : '' }}> Laravel
    <input type="checkbox" name="skills[]" value="JavaScript" {{ in_array('JavaScript', $userSkills) ? 'checked' : '' }}> JavaScript
    <input type="checkbox" name="skills[]" value="MySQL" {{ in_array('MySQL', $userSkills) ? 'checked' : '' }}> MySQL
    <br><br>

    <!-- Current File -->
    @if($user->docs)
        <a href="{{ asset('uploads/'.$user->docs) }}" target="_blank">View Current File</a><br><br>
    @endif

    <!-- Upload New File -->
    <input type="file" name="docs"><br><br>

    <!-- Phone -->
    <input type="text" name="phone" value="{{ $user->phone }}"><br><br>

    <!-- Country -->
    <select name="country">
        <option value="India" {{ $user->country == 'India' ? 'selected' : '' }}>India</option>
        <option value="USA" {{ $user->country == 'USA' ? 'selected' : '' }}>USA</option>
        <option value="UK" {{ $user->country == 'UK' ? 'selected' : '' }}>UK</option>
        <option value="Canada" {{ $user->country == 'Canada' ? 'selected' : '' }}>Canada</option>
        <option value="Australia" {{ $user->country == 'Australia' ? 'selected' : '' }}>Australia</option>
    </select>

    <br><br>

    <button type="submit">Update</button>

</form>

</body>
</html>
