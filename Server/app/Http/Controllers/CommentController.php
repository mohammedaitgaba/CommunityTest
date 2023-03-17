<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    public function NewComment(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(),[
            'user_id' => ['required'],
            'post_id' => ['required'],
            'content' => ['required', 'string'],
        ]);
        
        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $Comment = Comment::create($input);

        $response = [
            'success' => true,
            'message' => "Comment added succefully"
        ];
        return response()->json($response, 200);
    }
    public function getAllComments(Comment $Comments)
    {
        $Comments = Comment::with('User')->get();
        if (!$Comments) {
            $response = [
                'success' => false,
                'message' => "No Comments"
            ];
            return response()->json($response, 400);
        }
        return $Comments;
    }
    public function GetCommentById($id){
        $Comment = Comment::find($id);
        if (!$Comment) {
            $response = [
                'success' => false,
                'message' => "Comment Not Found"
            ];
            return response()->json($response, 400);
        }
        return $Comment;
    }
    public function deleteComment($id)
    {
        $Comment = Comment::find($id);
        if (!$Comment) {
            $response = [
                'success' => false,
                'message' => "Comment Not Found"
            ];
            return response()->json($response, 400);
        }
        $Comment->delete();
        $response = [
            'success' => true,
            'message' => "Comment deleted succesfully"
        ];
        return response()->json($response, 200);
    }
    public function updateComment(Request $request, $id){
        
        $Comment = Comment::find($id);
        $input = $request->all();
        if (!$Comment) {
            $response = [
                'success' => false,
                'message' => "Comment Not Found"
            ];
            return response()->json($response, 400);
        }
        $Comment->content = $input['content'];
        $Comment->update();
        $response = [
            'success' => true,
            'message' => "Comment Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }
}
