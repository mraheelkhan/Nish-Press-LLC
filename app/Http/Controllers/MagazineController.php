<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagazinePostRequest;
use App\Http\Requests\MagazineUpdateRequest;
use App\Models\Magazine;
use Illuminate\Http\Request;
use Storage;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $magazines = Magazine::where('is_active', true)->get();
        return view('magazines.index', compact('magazines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('magazines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MagazinePostRequest $request)
    {
        $cover_image_file = $request->file('cover_image');
        $pdf_file = $request->file('pdf_filename');

        $filename_cover_image = str_replace(" ","", time().$cover_image_file->getClientOriginalName());
        $filename_pdf = str_replace(" ","", time().$pdf_file->getClientOriginalName());


        Storage::putFileAs(
            $filename_cover_image,
            $cover_image_file,
            $filename_cover_image
        );

        Storage::putFileAs(
            'pdf_files/'.$filename_pdf,
            $pdf_file,
            $filename_pdf
        );
        $array = [
            'pdf_filename' => $filename_pdf,
            'cover_image' => $filename_cover_image
        ];

        $validatedData = array_merge($request->validated() ,$array);

        Magazine::create($validatedData);
        return redirect()->route('magazines.index')->withSuccess('Your magazine has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function show(Magazine $magazine)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function edit(Magazine $magazine)
    {
        return view('magazines.edit', compact('magazine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function update(MagazineUpdateRequest $request, Magazine $magazine)
    {
        $cover_image_file = $request->file('cover_image');
        $pdf_file = $request->file('pdf_filename');

        $filename_cover_image = str_replace(" ","", time().$cover_image_file->getClientOriginalName());
        $filename_pdf = str_replace(" ","", time().$pdf_file->getClientOriginalName());


        Storage::putFileAs(
            $filename_cover_image,
            $cover_image_file,
            $filename_cover_image
        );

        Storage::putFileAs(
            'pdf_files/'.$filename_pdf,
            $pdf_file,
            $filename_pdf
        );
        $array = [
            'pdf_filename' => $filename_pdf,
            'cover_image' => $filename_cover_image
        ];

        $validatedData = array_merge($request->validated() ,$array);
        $magazine->update($validatedData);
        return redirect()->route('magazines.index')
                ->withSuccess('Magazine has successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magazine $magazine)
    {
        //
    }

    public function purchase(Request $request)
    {
        $magazine = Magazine::findOrFail($request->magazine_id);
        $magazine_price = $magazine->price;
        $stripeCharge = $request->user()->charge(
            $magazine_price, $request->paymentMethodId
        );

        return $request->paymentMethod;
    }
}
