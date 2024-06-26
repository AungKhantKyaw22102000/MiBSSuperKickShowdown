<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    // direct gallery List route
    public function galleryList(){
        $galleries = Gallery::when(request('key'),function($query){
            $query->where('header','like','%'.request('key').'%');
        })->get();
        return view('admin.blog.blogList', compact('galleries'));
    }

    // gallery create route
    public function galleryCreatePage(){
        return view('admin.blog.create');
    }

    // direct gallery detail route
    public function galleryDetail($id){
        $gallery = Gallery::find($id);
        $comments = Comment::select('comments.*','users.name as user_name','users.image as user_image')
                    ->leftJoin('users','comments.user_id','users.id')
                    ->where('gallery_id', $id)->get();
        return view('admin.blog.detail', compact('gallery', 'comments'));
    }

    public function galleryUpdatePage($id){
        $data = Gallery::where('id',$id)->first();
        return view('admin.blog.update', compact('data'));
    }

    // gallery create
    public function galleryCreate(Request $request){
        $this->galleryValidationCheck($request, 'create');
        $gallery = $this->galleryRequestData($request);

        $photoFields = ['firstPhoto', 'secondPhoto', 'thirdPhoto'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $fileName = uniqid() . $request->file($field)->getClientOriginalName();
                $request->file($field)->storeAs('public/galleryPhoto', $fileName);
                $gallery[str_replace('Photo', '_photo', $field)] = $fileName;
            }
        }
        Gallery::create($gallery);
        return redirect()->route('admin#galleryList');
    }

    // delete gallery
    public function deleteGallery($id){
        $gallery = Gallery::find($id);

        if($gallery){
            Storage::delete('public/galleryPhoto/' . $gallery->first_photo);
            Storage::delete('public/galleryPhoto/' . $gallery->second_photo);
            Storage::delete('public/galleryPhoto/' . $gallery->third_photo);

            $gallery->delete();
        }
        return back()->with(['deleteSuccess'=>'Selected Galary is Delete Successfully...']);
    }

    // gallery update
    public function galleryUpdate(Request $request){
        $this->galleryValidationCheck($request, 'update');
        $gallery = $this->galleryRequestData($request);
        $existingGallery = Gallery::where('id', $request->galleryId)->first();
        $photoFields = ['firstPhoto', 'secondPhoto', 'thirdPhoto'];
        foreach ($photoFields as $field) {
            $dbField = str_replace('Photo', '_photo', $field);
            if ($request->hasFile($field)) {
                $oldImage = $existingGallery->$dbField;
                if ($oldImage != null) {
                    Storage::delete('public/galleryPhoto/' . $oldImage);
                }
                $fileName = uniqid() . $request->file($field)->getClientOriginalName();
                $request->file($field)->storeAs('public/galleryPhoto', $fileName);
                $gallery[$dbField] = $fileName;
            } else {
                $gallery[$dbField] = $existingGallery->$dbField;
            }
        }
        Gallery::where('id', $request->galleryId)->update($gallery);
        return redirect()->route('admin#galleryList')->with(['updateSuccess' => 'Gallery updated successfully.']);
    }

    // comment section
    public function commentCreate(Request $request){
        $comment = $this->commentRequestData($request);
        Comment::create($comment);
        return back();
    }

    // gallery validation check
    private function galleryValidationCheck($request, $action){
        $validationRule = [
            'headerName' => 'required|min:5|unique:galleries,header,'.$request->galleryId,
            'subHeader' => 'required|min:10',
            'briefing' => 'required',
            'mainText' => 'required',
        ];

        $photoRules = $action == 'create' ? 'required|mimes:jpg,jpeg,png,webp|file' : 'mimes:jpg,jpeg,png,webp|file';
        $validationRule['firstPhoto'] = $photoRules;
        $validationRule['secondPhoto'] = $photoRules;
        $validationRule['thirdPhoto'] = $photoRules;

        Validator::make($request->all(), $validationRule)->validate();
    }

    // gallery request data
    private function galleryRequestData($request){
        return [
            'header' => $request->headerName,
            'sub_header' => $request->subHeader,
            'briefing' => $request->briefing,
            'main_text' => $request->mainText,
        ];
    }

    // comment request data
    private function commentRequestData($request){
        return[
            'comment' => $request->commentMessage,
            'gallery_id' => $request->galleryId,
            'user_id' => $request->userId, 
        ];
    }
}
