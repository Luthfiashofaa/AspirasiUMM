<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

//import model Post 
use App\Models\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
//import resource PostResource 
use App\Http\Resources\PostResource;
use App\Models\Faq;

class FaqController extends Controller
{
    /** 
     * index 
     * 
     * @return void 
     */
    public function index()
    {

        $posts = Faq::latest()->paginate(5);

        //return collection of posts as a resource 
        return new FaqResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules 
        $validator = Validator::make($request->all(), [
            'question'     => 'required',
            'answer'   => 'required',
        ]);

        //check if validation fails 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post 
        $post = Faq::create([
            'question'
            => $request->question,
            'answer'
            => $request->answer,
        ]);
        //return response 
        return new FaqResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    public function show($id) 
    { 
        //find post by ID 
        $post = Faq::find($id); 
 
        //return single post as a resource 
        return new FaqResource(true, 'Detail Data Post!', $post); 
    } 

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'question'     => 'required',
            'answer'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Faq::find($id);


            //update post without image
            $post->update([
                'question'     => $request->question,
                'answer'   => $request->answer,
            ]);


        //return response
        return new FaqResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    public function destroy($id)
    {

        //find post by ID
        $faq = Faq::find($id);


        //delete post
        $faq->delete();

        //return response
        return new FaqResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
