<?php

namespace Liffe\Compras\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Local\Active;

class ActiveApiController extends Controller
{

    public function actives()
    {
        $columns = [
            'afacvencd as encd',
            'afacvdesc as desc',
            'afacvstte as stte',
            'afacvcreg as uneg',
            'afacvcusr as resp',
        ];

        $local = Active::get($columns);

        $exclude = $local->pluck("encd");

        $exclude = str_replace(["[", "]"], ["(", ")"], $exclude);

        $query = "select 
                    afmaecodi as encd,
                    afmaedscr as desc,
                    afmaestat as stte, 
                    afmaeuneg as uneg,
                    afmaeresp as resp
                from afmae
                where afmaemtvo is null ";

        if($local){
            $query .= "and afmaecodi not in $exclude";
        }

        $mlocal = $local->toArray();
        $sai = DB::connection("informix")->select($query);
//        return $sai;
        return array_merge($mlocal, $sai);

//        return Active::get($columns)->toArray();
    }

    public function upload(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'model' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $file = $request->file;

        $valid = Gallery::where("afglrname", $file->getClientOriginalName())
            ->where("afglrmpid", $request->code)
            ->where("afglrctpo", $request->model)
            ->get();

        Log::info(json_encode($valid));

        if(count($valid)){
            return response("oks 2", 201);
        }else{
            //---
            $iOriginal = $request->file->store('actives');
            $image = Image::make(Storage::get($iOriginal));

            $image->resize(1500, 1500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put($iOriginal, (string)$image->encode());

            $image->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put('thumbnails/' . $iOriginal, (string)$image->encode());

            $gallery = new Gallery();
            $gallery->afglrcorr = Gallery::max('afglrcorr') + 1;
            $gallery->afglrname = $file->getClientOriginalName();
            $gallery->afglrsize = $file->getClientSize();
            $gallery->afglrmime = $file->getClientMimeType();
            $gallery->afglrextn = $file->getClientOriginalExtension();
            $gallery->afglrurls = $iOriginal;
            $gallery->afglrctpo = $request->model;
            $gallery->afglrntpo = $request->user;
            $gallery->afglrmpid = $request->code;
            $gallery->afglrmptp = "Liffe\Compras\App\Models\Local\Active";
            $gallery->save();

            return response("oks 2", 201);
        }

    }

    public function uploads(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'code' => 'required',
            'model' => 'required',
            'file' => 'required',
        ]);

        $file = $request->file;
//        $active = Active::find($request->code);

        $valid = Gallery::where("afglrname", $file->getClientOriginalName())
            ->where("afglrmpid", $request->code)
            ->where("afglrctpo", $request->model)
            ->get();

//        if($valid){
//            return "oks";
//        }else{
            /// --- Save Image
            $iOriginal = $request->file->store('actives');

            $gallery = new Gallery();
            $gallery->afglrcorr = Gallery::max('afglrcorr') + 1;
            $gallery->afglrname = $file->getClientOriginalName();
            $gallery->afglrsize = $file->getClientSize();
            $gallery->afglrmime = $file->getClientMimeType();
            $gallery->afglrextn = $file->getClientOriginalExtension();
            $gallery->afglrurls = $iOriginal;
            $gallery->afglrctpo = $request->model;
            $gallery->afglrntpo = Auth::id();
            $gallery->afglrmpid = $request->code;
            $gallery->afglrmptp = "Liffe\Actives\App\Models\Local\Active";
            $gallery->save();
//        }
//        return $active->gallery()->save($gallery);
    }

}
