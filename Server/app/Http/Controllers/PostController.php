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
        if (!$Posts) {
            $response = [
                'success' => false,
                'message' => "No Posts"
            ];
            return response()->json($response, 400);
        }
        return $Posts;
    }
    public function GetPostById($id){
        $Post = Post::find($id);
        if (!$Post) {
            $response = [
                'success' => false,
                'message' => "Post Not Found"
            ];
            return response()->json($response, 400);
        }
        return $Post;
    }
    public function deletePost($id)
    {
        $Post = Post::find($id);
        if (!$Post) {
            $response = [
                'success' => false,
                'message' => "Post Not Found"
            ];
            return response()->json($response, 400);
        }
        $Post->delete();
        $response = [
            'success' => true,
            'message' => "Post deleted succesfully"
        ];
        return response()->json($response, 200);
    }
    public function updatePost(Request $request, $id){
        
        $Post = Post::find($id);
        $input = $request->all();
        if (!$Post) {
            $response = [
                'success' => false,
                'message' => "Post Not Found"
            ];
            return response()->json($response, 400);
        }
        $Post->nom = $input['nom'];
        $Post->description = $input['description'];
        $Post->image = $input['image'];
        $Post->update();
        $response = [
            'success' => true,
            'message' => "Post Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }

}
