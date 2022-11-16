<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TemplateBuilderController extends Controller
{
    public function saveAssets(Request $request)
    {
        $file = $request->file;
        $filename = uniqid() . '.' . $request->file->getClientOriginalExtension();
        $file = Storage::disk('templates')->put('/', $file);

        return [
            'url' => url('/media/templates/' . $file)
        ];
    }

    public function saveTemplate(Request $request)
    {
        $template = EmailTemplate::find($request->template_id);
        $template->content = $request->content;
        $template->update();
        return ([ 'success' => "Template updated successfully" ]);
    }

    public function stream(Request $request)
    {
        $template = EmailTemplate::findOrFail($request->id);
      	return response($template->content, 200)
            ->header('Content-Type', 'text/html');
    }
}
