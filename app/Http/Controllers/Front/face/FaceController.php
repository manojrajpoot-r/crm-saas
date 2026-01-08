<?php

namespace App\Http\Controllers\Front\face;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FaceLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserFace;
class FaceController extends Controller
{
    public function faceRegister()
    {
        return view('front.auth.face-register');
    }


    public function storeCameraRegister(Request $request)
    {
        try {
             $request->validate([
                'image' => 'required'
            ]);

            $folder = public_path('uploads/face');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $imageData = $request->image; // data:image/png;base64,...
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);

            $fileName = time() . '.png';
            file_put_contents($folder . '/' . $fileName, $imageData);

            $user = UserFace::create([
                'user_id' => Auth::id(),
                'image' => $fileName,
            ]);
            $user->image = $fileName;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Face registered successfully',
                'redirect' => route('saas.dashboard')
            ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }


    }

    public function faceLoginPage()
    {
        return view('front.auth.face-login');
    }
    public function storeCameraLogin(Request $request)
    {
        try{
         $userId = $request->user_id;


            if (!$userId) {
                return response()->json(['error' => 'Face not recognized']);
            }

            Auth::loginUsingId($userId);

            return response()->json([
                'status' => 'success',
                'redirect' => route('dashboard')
            ]);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function facefetchdata()
    {
        $users = UserFace::with('user')->get();
        return response()->json($users);
    }

}
