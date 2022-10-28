<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Job;
use App\Models\Flight;

class Fulfillment extends Controller
{

    public function fulfillJob(Request $request, $job) {
        $flights = Flight::where('job_id', $job)->get();
        // Check to see if the collection is empty
        if ($flights->isEmpty()) {
            return Inertia::render('Fulfillment', [
                'job' => $job,
                'content' => '',
                'message' => 'This job has no records associated with it.',
            ]);
        }

        return Inertia::render('Fulfillment', [
            'job' => $job,
            'content' => $flights,
        ]);
    }

    public function listJobs() {
        $file_arr = $this->getFiles();
        // Return the view with the files
        return Inertia::render('JobList', [
            'files' => $file_arr
        ]);
    }
    /*
     * Delete the job and all associated Flight records
     */
    public function deleteJob(Request $request, $job) {
        $job = Job::find($job);
        if (!$job) {
            return Inertia::render('JobList', [
                'message' => 'Job not found'
            ]);
        }
        $job->delete();
        $file_arr = $this->getFiles();
        return Inertia::render('JobList', [
            'files' => $file_arr,
            'message' => 'Job deleted'
        ]);
    }

    /*
     * Get the files for the job list render
     */
    private function getFiles() {
        $files = Job::all();
        $file_arr = [];
        foreach( $files as $file ) {
            $file_arr[] = [
                'id' => $file->id,
                'name' => $file->name,
                'csvFileName' => $file->csvFileName,
            ];
        }
        return $file_arr;
    }

    /*
     * Allocation
     */

    public function allocate (Request $request) {
        $request = $request->all();
        echo '<pre>';
        var_dump($request);
        echo '</pre>';
        die;

    }

    /*
     * Deallocation
     */

    public function deallocate (Request $request) {

    }

}
