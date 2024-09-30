<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'svg_file' => 'required|file|mimes:svg',
        ]);

        $svgFile = $request->file('svg_file');
        $svgContent = file_get_contents($svgFile->getRealPath());

        $image = new Image();
        $image->svg = $svgContent;
        $image->save();

        return redirect()->back()->with('success', 'SVG image saved successfully.');
    }
}
