<?php

namespace App\Http\Controllers\backend;

use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialStoreRequest;
use App\Http\Requests\TestimonialUpdateRequest;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest('id')
            ->select(['id', 'client_name', 'client_name_slug', 'client_designation', 'client_message', 'client_image', 'updated_at'])->paginate(10);

        return view('backend.pages.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialStoreRequest $request)
    {
        // Create the testimonial
        $testimonial = Testimonial::create([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,
        ]);

        // Handle image upload
        $this->image_upload($request, $testimonial->id);

        return redirect()->route('testimonial.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $testimonial = Testimonial::where('client_name_slug', $slug)->first();
        return view('backend.pages.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialUpdateRequest $request, $slug)
    {
        $testimonial = Testimonial::where('client_name_slug', $slug)->first();
        $testimonial->update([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,
            'is_active' => $request->filled('is_active')
        ]);

        $this->image_upload($request, $testimonial->id);

        return redirect()->route('testimonial.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string  $slug)
    {

        $testimonial = Testimonial::where('client_name_slug', $slug)->first();

        $testimonial->delete();
        return redirect()->route('testimonial.index');
    }
    public function image_upload($request, $testimonialId)
    {
        if ($request->hasFile('client_image')) {
            $testimonial = Testimonial::findOrFail($testimonialId);
// Prepare File Name & Path
$img=$request->file('client_image');

$t=time();
$file_name=$img->getClientOriginalName();
$img_name="{$t}-{$file_name}";
$img_url="images/{$img_name}";


// Upload File
$img->move(public_path('images'),$img_name);
            // Get the uploaded file
            // $image = $request->file('client_image');

            // Generate a unique filename
            // $imageName = time() . '-' . $image->getClientOriginalName();

            // Define the path to store the image
            // $imagePath = $image->move(public_path('images'), $imageName);
            // Save the path to the database (assuming you have a column `client_image` in the testimonials table)
            $testimonial->client_image = $img_url;
            $testimonial->save();
        }
    }
}
