<?php

namespace App\Http\Controllers;

use App\Models\MockTest;
use Illuminate\Http\Request;

class MockTestController extends Controller
{
    public function getMockTests()
    {
        $mockTests = MockTest::all()->map(function ($test) {
            $test->questions = collect($test->questions)->map(function ($q) {
                unset($q['correctAnswer'], $q['explanation']);
                return $q;
            })->toArray();
            return $test;
        });

        return response()->json([
            'success' => true,
            'count' => $mockTests->count(),
            'data' => $mockTests,
        ]);
    }

    public function getMockTest(Request $request, $id)
    {
        $test = MockTest::find($id);

        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'Mock test not found'
            ], 404);
        }

        if ($request->user() && $request->user()->role !== 'admin') {
            $test->questions = collect($test->questions)->map(function ($q) {
                unset($q['correctAnswer'], $q['explanation']);
                return $q;
            })->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => $test,
        ]);
    }

    public function createMockTest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Chapter-wise,Full Syllabus',
            'duration' => 'required|integer',
            'questions' => 'required|array',
            'subject' => 'nullable|string|max:255',
            'class_standard' => 'nullable|string|max:255',
        ]);

        $test = MockTest::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'duration' => $validated['duration'],
            'questions' => $validated['questions'],
            'subject' => $validated['subject'] ?? 'General',
            'class_standard' => $validated['class_standard'] ?? '12th',
            'created_by' => $request->user()->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $test,
            ], 201);
        }
        
        return back()->with('success', 'Mock test created successfully');
    }

    public function submitMockTest(Request $request, $id)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $test = MockTest::find($id);

        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'Mock test not found'
            ], 404);
        }

        $answers = $request->answers;
        $score = 0;
        $results = [];

        foreach ($test->questions as $index => $q) {
            $selectedAnswer = $answers[$index] ?? null;
            $isCorrect = $selectedAnswer === $q['correctAnswer'];
            
            if ($isCorrect) {
                $score++;
            }

            $results[] = [
                'questionIndex' => $index,
                'selectedAnswer' => $selectedAnswer,
                'correctAnswer' => $q['correctAnswer'],
                'explanation' => $q['explanation'],
                'isCorrect' => $isCorrect,
            ];
        }

        return response()->json([
            'success' => true,
            'score' => $score,
            'total' => count($test->questions),
            'results' => $results,
        ]);
    }

    public function deleteMockTest(Request $request, $id)
    {
        $test = MockTest::find($id);

        if (!$test) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Mock test not found'], 404);
            }
            return back()->with('error', 'Mock test not found');
        }

        $test->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Mock test deleted successfully'
            ]);
        }
        
        return back()->with('success', 'Mock test deleted successfully');
    }
}
