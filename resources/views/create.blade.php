<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>

<h2>Create User</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- First Name -->
    <label>First Name:</label>
    <input type="text" name="first_name"><br><br>

    <!-- Last Name -->
    <label>Last Name:</label>
    <input type="text" name="last_name"><br><br>

    <!-- Gender -->
    <label>Gender:</label>
    <input type="radio" name="gender" value="male"> Male
    <input type="radio" name="gender" value="female"> Female
    <input type="radio" name="gender" value="other"> Other
    <br><br>

    <!-- Email -->
    <label>Email:</label>
    <input type="email" name="email"><br><br>

    <!-- Password -->
    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <label>Confirm Password</labe>
    <input type="password" name="password_confirmation" placeholder="Confirm Password"><br><br>

    <!-- Skills -->
    <label>Skills:</label>
    <input type="checkbox" name="skills[]" value="PHP"> PHP
    <input type="checkbox" name="skills[]" value="Laravel"> Laravel
    <input type="checkbox" name="skills[]" value="JavaScript"> JavaScript
    <input type="checkbox" name="skills[]" value="MySQL"> MySQL
    <br><br>

    <!-- File Upload -->
    <label>Documents:</label>
    <input type="file" name="docs"><br><br>

    <!-- Phone -->
    <label>Phone:</label>
    <input type="text" name="phone"><br><br>

    <!-- Country Dropdown -->
    <label>Country:</label>
    <select name="country">
        <option value="">Select Country</option>
        <option value="India">India</option>
        <option value="USA">USA</option>
        <option value="UK">UK</option>
        <option value="Canada">Canada</option>
        <option value="Australia">Australia</option>
    </select>
    <br><br>

    <!-- Submit -->
    <button type="submit">Submit</button>

</form>
</body>
</html>