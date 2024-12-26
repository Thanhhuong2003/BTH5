<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showProfile()
{
    $show = true;  // hoặc false
    return view('profile', compact('show'));
}

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) 
        {    
            // Xóa ảnh cũ nếu có
        if ($user->avatar) 
        {
            Storage::delete($user->avatar);
        }

            // Lưu ảnh mới
        $path = $request->file('avatar')->store('avatars','public');
        $user->avatar = $path;
        }
        // Giả sử bạn lấy user từ database
$user = User::find(1); // hoặc bất kỳ cách nào bạn lấy user

if ($user) {
    // Ghi log thông tin user
    Log::info('User data before save:', $user->toArray());

    // Lưu user vào database
    $user->save();

    // Trả về thông báo thành công
    return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
} else {
    // Nếu không tìm thấy user, ghi log cảnh báo
    Log::warning('User not found.');
    return redirect()->route('profile.edit')->with('error', 'User not found.');
}
    }
}