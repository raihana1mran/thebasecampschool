<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TmaSubmission;

class TmaController extends Controller
{
    /**
     * Student submits their TMA answer file.
     */
    public function submit(Request $request, $productId)
    {
        $request->validate([
            'tma_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $user = auth()->user();
        $tma = \App\Models\Product::findOrFail($productId);

        // Check if deadline has crossed
        $deadlinePassed = $tma->deadline && \Carbon\Carbon::parse($tma->deadline)->isPast();
        if ($deadlinePassed) {
            $hasPaid = \App\Models\Payment::where('user_id', $user->id)
                ->where('type', 'TMA')
                ->where('payment_id', 'like', 'tma_late_' . $productId . '%')
                ->where('status', 'Success')
                ->exists();
            if (!$hasPaid) {
                return redirect()->back()->with('error', 'The submission deadline has passed. You must pay the late fee of ₹1,200 before submitting.');
            }
        }

        $file = $request->file('tma_file');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('tma_submissions/' . $user->id, 'public');

        TmaSubmission::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $productId],
            [
                'file_path'         => $path,
                'original_filename' => $originalName,
                'status'            => 'submitted',
                'submitted_at'      => now(),
                // Reset marks when re-submitting
                'tma_marks'         => null,
                'practical_marks'   => null,
                'admin_remarks'     => null,
            ]
        );

        return redirect()->route('tma')->with('success', "TMA submitted successfully! Your answer for this assignment has been received.");
    }
}
