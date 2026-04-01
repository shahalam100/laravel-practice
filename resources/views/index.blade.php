<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>

<h2>User List</h2>

<!-- Success Message -->
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<!-- Add New Button -->
<a href="{{route('users.create')}}">Add New User</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Skills</th>
        <th>Docs</th>
        <th>Phone</th>
        <th>Country</th>
        <th>Action</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
        <td>{{ $user->gender }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->skills }}</td>

        <!-- File Display -->
        <td>
            @if($user->docs)
                <a href="{{ asset('uploads/'.$user->docs) }}" target="_blank">View</a>
            @else
                No File
            @endif
        </td>

        <td>{{ $user->phone }}</td>
        <td>{{ $user->country }}</td>

        <!-- Actions -->
        <td>
            <a href="{{ route('users.edit', $user->id) }}">Edit</a> |
            <a href="{{ route('users.delete', $user->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    @endforeach

</table>

</body>
</html>