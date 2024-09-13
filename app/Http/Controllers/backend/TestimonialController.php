<?php

namespace App\Http\Controllers\backend;

use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialStoreRequest;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest('id')
        ->select(['id', 'client_name','client_name_slug', 'client_designation', 'client_message', 'client_image', 'updated_at'])->paginate(10);

        return view('backend.pages.testimonial.index', compact('testimonials'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.testimonial.create');    }

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function image_upload($request, $testimonialId)
{
    if ($request->hasFile('client_image')) {
        $testimonial = Testimonial::findOrFail($testimonialId);

        // Get the uploaded file
        $image = $request->file('client_image');

        // Generate a unique filename
        $imageName = time() . '-' . $image->getClientOriginalName();

        // Define the path to store the image
        $imagePath = $image->storeAs('upload', $imageName);

        // Save the path to the database (assuming you have a column `client_image` in the testimonials table)
        $testimonial->client_image = $imagePath;
        $testimonial->save();
    }
}

}