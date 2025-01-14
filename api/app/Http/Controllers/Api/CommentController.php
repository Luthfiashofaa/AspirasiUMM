<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /** 
     * index 
     * 
     * @return void 
     */
    public function index()
    {
        //get all posts 
        $comment = Comment::latest()->paginate(5);

        //return collection of posts as a resource 
        return new CommentResource(true, 'List Data Comment', $comment);
    }

    /** 
     * store 
     * 
     * @param  mixed $request 
     * @return void 
     */

     public function getComplaintComments($complaintId)
     {
         try {
             $comments = Comment::with('user')
                 ->where('pengaduan_id', $complaintId)
                 ->orderBy('created_at', 'desc')
                 ->get();
 
             return response()->json([
                 'success' => true,
                 'message' => 'Data comments retrieved successfully',
                 'data' => $comments
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to retrieve comments',
                 'error' => $e->getMessage()
             ], 500);
         }
     }
     
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengaduan_id'  => 'required|exists:complaints,id',
            'user_id'       => 'required|exists:users,nim',      
            'isi_komentar'  => 'required',                      
            'is_admin'      => 'required|boolean',          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comment = Comment::create([
            'pengaduan_id'  => $request->pengaduan_id,
            'user_id'       => $request->user_id,     
            'isi_komentar'  => $request->isi_komentar,
            'is_admin'      => $request->is_admin,    
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Comment Berhasil Ditambahkan!',
            'data' => $comment
        ], 201);
    }

    public function show($id) 
    { 
        //find post by ID 
        $comment = Comment::find($id); 
 
        //return single post as a resource 
        return new CommentResource(true, 'Detail Data Comment!', $comment); 
    } 

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [  
            'isi_komentar'  => 'required',                              
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $comment = Comment::find($id);

        $comment->update([
            'isi_komentar' => $request->isi_komentar
        ]);

        //return response
        return new CommentResource(true, 'Data Comment Berhasil Diubah!', $comment);
    }

    public function destroy($id)
    {

        //find post by ID
        $comment = Comment::find($id);


        //delete post
        $comment->delete();

        //return response
        return new CommentResource(true, 'Data Comment Berhasil Dihapus!', null);
    }
}
