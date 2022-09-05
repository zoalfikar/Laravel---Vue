<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $user = $request->user();
        return SurveyResource::collection( Survey::where('user_id',$user->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData=array_merge($validatedData,['user_id' => Auth::id()]);
        if (isset($validatedData['image'])) {
            $relativePath = $this->saveImage($validatedData['image']);
            $validatedData['image'] = $relativePath ;
        }
        $result = Survey::create($validatedData);
        return new SurveyResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey ,Request $request)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403,'unauthoraized action.');
        }
        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveyRequest  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['image'])) {
            $relativePath = $this->saveImage($validatedData['image']);
            $validatedData['image'] = $relativePath ;

            if ($survey->image) {
                $absolutePath=public_path($survey->image);
                File::delete($absolutePath);
            }
        }

        $survey->update($validatedData);
        return new SurveyResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey , Request $request)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403,'unauthoraized action.');
        }
        $survey->delete();
        if ($survey->image) {
            $absolutePath=public_path($survey->image);
            File::delete($absolutePath);
        }
        return response('', 204);
    }
    private function saveImage($image)
    {
        if (preg_match('/^data:image\/(\w*);base64,/',$image,$type)) {
            $image = substr($image,strpos($image,',')+1);
            $type = strtolower($type[1]);
            if (!in_array($type,['jpg','jpeg','gif','png'])) {
                throw new Exception("invalid image type");
            }
            $image = str_replace('','+',$image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new Exception("base64_decode failed!");

            }
        } else {
            throw new Exception("did not match data URI with image data");
        }
        $dir = 'images/';
        $file = Str::random().'.'.$type;
        $absolutePath = public_path($dir);
        $relativePath=$dir.$file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath,8755,true);
        }
        file_put_contents($relativePath,$image);
        return  $relativePath;
    }
}
