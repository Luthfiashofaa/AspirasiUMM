<?php 
 
namespace App\Http\Controllers\Api; 
 
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class ComplaintController extends Controller 
{     
    /** 
     * index 
     * 
     * @return void 
     */ 
    public function index() 
    { 
        //get all posts 
        $complaint = Complaint::latest()->paginate(5); 
 
        //return collection of posts as a resource 
        return new ComplaintResource(true, 'List Data Complaint', $complaint); 
    } 

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
        'user_id'       => 'required|exists:users,nim',       
        'judul'         => 'required|string',                 
        'deskripsi'     => 'required|string',                
        'status'        => 'required|string',            
        'kategori'      => 'required|string',            
    ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the comment
        $complaint= Complaint::create([
            'user_id'    => $request->user_id,   
            'judul'      => $request->judul,     
            'deskripsi'  => $request->deskripsi,  
            'status'     => $request->status,   
            'kategori'   => $request->kategori,   
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Data Comment Berhasil Ditambahkan!',
            'data' => $complaint
        ], 201);
    }

    public function show($id) 
    { 
        //find post by ID 
        $complaint = Complaint::find($id); 
 
        //return single post as a resource 
        return new ComplaintResource(true, 'Detail Data Complaint!', $complaint); 
    } 

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [       
            'judul'         => 'required|string',                 
            'deskripsi'     => 'required|string',                
            'status'        => 'required|string',            
            'kategori'      => 'required|string',            
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $complaint = Complaint::find($id);

        $complaint->update([ 
            'judul'      => $request->judul,     
            'deskripsi'  => $request->deskripsi,  
            'status'     => $request->status,   
            'kategori'   => $request->kategori,    
        ]);

        //return response
        return new ComplaintResource (true, 'Data Comment Berhasil Diubah!', $complaint);
    }

    public function destroy($id)
    {

        //find post by ID
        $complaint = Complaint::find($id);


        //delete post
        $complaint->delete();

        //return response
        return new ComplaintResource(true, 'Data Comment Berhasil Dihapus!', null);
    }
} 