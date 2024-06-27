<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $posts = Post::all();
        //return view('posts.index', compact('posts'));
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('posts.create');
        return response()->json(['message' => 'Not applicable'], 405);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            //'body' => 'required',
            'content' => 'required',
        ]);

        try {
            $post = Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => Auth::id(), // Ensure the user_id is set to the authenticated user
                'status' => 0, // Default status
            ]);
    
            return response()->json($post, 201);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating post: '.$e->getMessage());
    
            return response()->json(['error' => 'An error occurred while creating the post.'], 500);
        }

        /*$post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(), // Ensure the user_id is set to the authenticated user
            'status' => 0, // Default status
        ]);*/

        /*$post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(), // Ensure the user_id is set to the authenticated user
            'status' => 0, // Default status
        ]); */

        //return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        //return $request->post();
        //return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        //return view('posts.show', compact('post'));
        //return view('posts.show', compact('post'));
        return response()->json($post);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        //return view('posts.edit', compact('post'));
        return response()->json(['message' => 'Not applicable'], 405);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            //'body' => 'required',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        //return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
        return response()->json(['message' => 'Post updated successfully.', 'post' => $post]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        //return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
