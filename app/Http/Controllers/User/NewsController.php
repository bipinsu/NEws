<?php

namespace App\Http\Controllers\User;

use PDF;
use App\Models\News;
use App\Models\NavHeading;
use App\Exports\NewsExport;
use Illuminate\Http\Request;
use App\Models\NavSubHeading;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class NewsController extends Controller
{
    // Display a listing of the news.
    public function index(Request $request)
    {
        $selectedValue = $request->query('perPage', session('pagination_new', 10));

        $news = News::paginate($selectedValue);
        $nav_heading = NavHeading::all();
        $nav_sub_heading = NavSubHeading::all();

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['news' => $news])->render();
        }

        // Store the selected value in the session
        session(['pagination_new' => $selectedValue]);

        return view('users.news.index', compact('news', 'selectedValue', 'nav_heading', 'nav_sub_heading'));
    }

    // Show the form for creating new news.
    public function create()
    {
        return view('users.news.create');
    }

    // Store a newly created news in the database.
    public function store(Request $request)
    {
        $request->validate([
            'nav_headings_id' => 'required|exists:nav_headings,id',
            'nav_sub_headings_id' => 'required|exists:nav_sub_headings,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new news
        $news = News::create([
            'nav_headings_id' => $request->input('nav_headings_id'),
            'nav_sub_headings_id' => $request->input('nav_sub_headings_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Handle file uploads for multiple images
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('news_images', 'public');
            $news->images()->create(['image_path' => $imagePath]);
        }

        return redirect()->route('admin.news.index')->with('success', 'News created successfully!');
    }

    // Display the specified news.
    public function show(News $news)
    {
        return view('users.news.show', compact('news'));
    }

    // Show the form for editing the specified news.
    public function edit(News $news)
    {
        return view('users.news.edit', compact('news'));
    }

    // Update the specified news in the database.
    public function update(Request $request, News $news)
    {
        $request->validate([
            'nav_headings_id' => 'required|exists:nav_headings,id',
            'nav_sub_headings_id' => 'required|exists:nav_sub_headings,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update news
        $news->update([
            'nav_headings_id' => $request->input('nav_headings_id'),
            'nav_sub_headings_id' => $request->input('nav_sub_headings_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Handle file upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($news->image);

            // Upload new image
            $imagePath = $request->file('image')->store('news_images', 'public');

            // Update image path in the database
            $news->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully!');
    }

    // Remove the specified news from the database.
    public function destroy(News $news)
    {
        // Delete image file
        Storage::disk('public')->delete($news->image);

        // Delete news
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully!');
    }

    // Export PDF
    public function exportpdf(Request $request)
    {
        $selectedRowValues = $request->input('selectedRows');
        $selectedRows = explode(',', $selectedRowValues);

        $news = $selectedRowValues
            ? News::whereIn('id', $selectedRows)->get()
            : News::all();

        $data = [
            'title' => 'News',
            'date' => date('d/m/Y'),
            'news' => $news,
        ];

        $pdf = PDF::loadView('users.news.export-pdf', $data)->setPaper('A4');
        return $pdf->stream('News.pdf');
    }

    // Export CSV
    public function exportselectedcsv(Request $request)
    {
        $selectedRowValues = $request->input('selectedRows');
        $selectedRows = explode(',', $selectedRowValues);

        return (new NewsExport($selectedRows))->download('news.csv');
    }


    // Search permissions
    public function search(Request $request)
    {
        $search = $request->input('search');
        $selectedValue = $request->query('perPage', session('pagination_news', 10));
        $news = News::select()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('group_name', 'LIKE', "%{$search}%")
            ->paginate($selectedValue);

        if ($request->ajax()) {
            return view('vendor.pagination.custom', ['news' => $news])->render();
        }

        session(['pagination_news' => $selectedValue]);
        return view('admin.news.index', compact('newss', 'selectedValue'));
    }

    // Delete selected newss
    public function deleteSelected(Request $request)
    {
        $selectednews = $request->input('selectedRows');
        $selectedRows = explode(',', $selectednews);

        foreach ($selectedRows as $newsId) {
            $news = News::find($newsId);
            if ($news) {
                $news->delete();
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'Selected permissions have been deleted.');
    }
    public function getSubheadings($id)
    {
        $subheadings = NavSubHeading::where('nav_headings_id', $id)->get();

        return response()->json($subheadings);
    }
    public function getNews($id)
    {
        $news = News::with('images')->findOrFail($id);
   return response()->json($news);

    }
}
