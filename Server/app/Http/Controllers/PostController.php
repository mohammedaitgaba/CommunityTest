<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function NewPost(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(),[
            'nom' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required','string'],
            'user_id' => ['required'],
        ]);
        
        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $Post = Post::create($input);

        $response = [
            'success' => true,
            'message' => "Post added succefully"
        ];
        return response()->json($response, 200);
    }
    public function getAllPosts(Post $Posts)
    {
        $Posts = Post::with('User')->get();
        return $Posts;
    }

}
