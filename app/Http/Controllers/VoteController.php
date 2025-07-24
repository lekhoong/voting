<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    // Show voting page
    public function index()
    {
        $fruits = ['Apple', 'Orange', 'Pineapple', 'Watermelon', 'Mango'];
    
        // Get the voting results to display on the same page
        $results = Vote::select('fruit', \DB::raw('SUM(score) as total_score'))
            ->groupBy('fruit')
            ->get();
    
        return view('index', compact('fruits', 'results'));
    }

    // Handle vote submission
    public function submit(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'votes' => 'required|array',
            'votes.*' => 'required|integer|min:1|max:5',
        ]);

        // Check if the user has already voted
        $existingVote = Vote::where('username', $request->username)->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'You have already voted!');
        }

        foreach ($request->votes as $fruit => $score) {
            Vote::create([
                'username' => $request->username,
                'fruit' => $fruit,
                'score' => $score,
            ]);
        }

        return redirect()->route('results');
    }

    // Show voting results
    // Show voting results
public function result()
{
    $fruits = ['Apple', 'Orange', 'Pineapple', 'Watermelon', 'Mango']; // Define the fruits array
    $results = Vote::select('fruit', \DB::raw('SUM(score) as total_score'))
        ->groupBy('fruit')
        ->get();

    return view('index', compact('results', 'fruits')); // Pass both fruits and results to the view
}

}
