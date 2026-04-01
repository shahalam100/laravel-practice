# Laravel Practice - User Detail CRUD

This repository contains a complete Laravel CRUD (Create, Read, Update, Delete) implementation for managing `UserDetail` records. This README serves as a tailored step-by-step revision guide for interviews based on the current codebase.

## 🚀 Step-by-Step Implementation Guide

### 1. Database Setup & Migration
A migration file was created for the `user_details` table with the following schema:
- `first_name` (string)
- `last_name` (string)
- `gender` (enum: male, female, other)
- `email` (string, unique)
- `password` (string, hashed securely)
- `skills` (text, stored as comma-separated string)
- `docs` (string, stores file path for uploads)
- `phone` (string)
- `country` (string)

**Command used:**
```bash
php artisan make:model UserDetail -m
```

### 2. Model Configuration
The `UserDetail` model allows mass assignment using the `$fillable` property to protect against mass-assignment vulnerabilities. This specifies exactly which database columns can be updated directly from form requests.

```php
// app/Models/UserDetail.php
protected $fillable = [
    'first_name', 'last_name', 'gender', 'email', 
    'password', 'skills', 'docs', 'phone', 'country'
];
```

### 3. Controller Logic (`UserDetailController.php`)

The `UserDetailController` is responsible for handling the logic of viewing, saving, and updating user details.

#### A. Strict Validation
Incoming data is strictly validated before touching the database:
- **Unique columns:** Email must be unique (`unique:user_details,email`). In updates, the current user ID is ignored so it doesn't fail validation on itself: `'email' => 'required|email|unique:user_details,email,' . $id`
- **Passwords:** Must be verified against a confirmation field (`confirmed`).
- **File Uploads:** Must adhere to specific MIME types and size constraints (`mimes:pdf,jpeg,png,jpg,gif|max:10240`).
- **Arrays (Checkboxes):** Arrays (like `skills`) are validated element by element (`'skills.*' => 'string|distinct'`).

#### B. Handling File Uploads
Uploaded files (documents/images) are intercepted and moved to the `public/uploads` directory.
```php
if($request->hasFile('docs')){
    $file = $request->file('docs');
    $fileName = $file->getClientOriginalExtension(); // Saving extension (Note: generate a unique name for production)
    $file->move(public_path('uploads'), $fileName);
}
```

#### C. Array to String Conversion (Checkboxes)
Multiple skills selected via HTML checkboxes arrive as an array in the Request. They are bound together as a comma-separated string before storing in the database:
```php
$skills = implode(',', $request->skills);
```

#### D. Password Hashing
Passwords are never stored in plain text. The `bcrypt()` function hashes the password.
```php
'password' => bcrypt($request->password)
```

#### E. Updating Data safely
When updating, `UserDetail::findOrFail($id)` is used. This automatically returns a `404 Not Found` response if the requested ID doesn't exist. Furthermore, passwords and files are conditionally checked and only updated if new ones are provided in the request form.

#### F. Deleting Data & Files completely
When a user is deleted, their associated uploaded files are securely removed from the application server filesystem using PHP's `unlink()` function. This prevents "orphan files" from taking up storage space over time. A `file_exists()` check confirms the document is actually there, it is unlinked, and only then is the `$user->delete()` operation executed on the database row to complete the deletion perfectly.

---

## 🎯 Important Interview Questions (Revision)

Review these common interview questions based on the exact logic implemented in this project:

1. **How do you handle file uploads in Laravel?**
   - First, ensure the form has `enctype="multipart/form-data"`.
   - Check if a file exists with `$request->hasFile('input_name')`.
   - Retrieve it with `$request->file('input_name')`.
   - Move it to a secure public or storage directory using `move(public_path('dir'), $filename)`.

2. **How do you save multiple HTML checkboxes (arrays) in a single database column?**
   - The form input should be named as an array (e.g., `name="skills[]"`).
   - In the controller, convert the array to a string using PHP's `implode(',', $request->skills)`.
   - *Alternative:* Cast the attribute as an `array` or `json` inside the Laravel Model, and Laravel will serialize/deserialize it automatically.

3. **How does Laravel's Unique Validation work during an Update?**
   - To prevent the system from flagging the user's *own* email as a duplicate while updating other fields, you append the User's primary key (ID) to the validation rule to ignore it: `'email' => 'unique:user_details,email,' . $id`.

4. **What is the difference between `find()` and `findOrFail()`?**
   - `find($id)` returns the model if found, or `null` if it isn't.
   - `findOrFail($id)` attempts to look up a record by its Primary Key. If the record isn't found, it throws a `ModelNotFoundException`, which automatically renders standard HTTP 404 error page.

5. **How are passwords stored securely?**
   - Passwords must be hashed using `bcrypt()` or Laravel's `Hash::make()` wrapper before saving to the database. They can then be compared securely during login using `Hash::check()`.
