<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Inertia\Inertia;
use App\Models\Job;
use App\Models\Flight;

class Fulfillment extends Controller
{

    public function fulfillJob(Request $request, $job, $message = null) {
        $flights = Flight::where('job_id', $job)->get();
        // Check to see if the collection is empty
        if ($flights->isEmpty()) {
            return Inertia::render('Fulfillment', [
                'job' => $job,
                'content' => '',
                'message' => 'This job has no records associated with it.',
            ]);
        }
        $percent = $this->getFlights($job);
        $jobName = Job::where('id', $job)->first()->name;

        return Inertia::render('Fulfillment', [
            'job' => $job,
            'jobName' => $jobName,
            'content' => $flights,
            'percent' => $percent,
            'message' => $message,
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
        $jobs = Job::all();
        // Get all the flights that belong to each job
        if ($jobs->isEmpty()) {
            return [];
        }
        $file_arr = [];
        foreach( $jobs as $job ) {
            $percent = intval($this->getFlights($job->id));
            $job_arr[] = [
                'id' => $job->id,
                'name' => $job->name,
                'csvFileName' => $job->csvFileName,
                'percent_allocated' => $percent,
            ];
        }
        return $job_arr;
    }

    /*
     * Get the flights for the jobs and the percent allocated
     */
    private function getFlights($job) {
        $packs = 0;
        $allocated = 0;
        $flights = Flight::where('job_id', $job)->get();
        foreach ($flights as $flight) {
            $packs += $flight->packs;
            $allocated += $flight->allocated;
        }
        return number_format(($allocated/$packs) * 100, 2);
    }

    /*
     * Allocation
     */

    public function allocate (Request $request) {

        $validation = $request->validate([
            'job' => 'required',
            'allocation' => 'required',
        ]);
        
        $flights = $this->adjustCount('allocation', $validation['job'], $validation['allocation']);

        return Redirect::route('fulfillment', ['id' =>  $validation['job'], 'allocated' => $validation['allocation']])
            ->with( 'message', $flights['message'])
            ->send();
    }

    /*
     * Deallocation
     */

    public function deallocate (Request $request) {

        $validation = $request->validate([
            'job' => 'required',
            'deallocation' => 'required',
        ]);
        $flights = $this->adjustCount('deallocation', $validation['job'], $validation['deallocation']);
        return Redirect::route('fulfillment', ['id' =>  $validation['job'], 'deallocated' => $validation['deallocation']])
            ->with(['job' =>$validation['job'],'content'=> $flights]);
    }

    /*
     * Adjust the count of the packs allocated
     */

    function adjustCount($type, $job, $lot_number) {
        $job_instance = Job::find($job);
        $flight = Flight::where('lot_number', $lot_number)
            ->where('job_id', $job)
            ->first();
        if ($flight) {
            if (!$flight->bin && $type == 'allocation') {
                $bin = $job_instance->bin;
                if (!$bin) {
                    $job_instance->bin = 1;
                    $job_instance->save();
                    $bin = 1;
                } else {
                    $bin++;
                    $job_instance->bin = $bin;
                    $job_instance->save();
                }
                $flight->bin = $bin;
            }
            $sameDepartures = Flight::where('departure', $flight->departure)
                ->where('job_id', $job)
                ->get();
            // Update the same departures to have the same bin
            foreach ($sameDepartures as $departure) {
                if (!$departure->bin) {
                    $departure->bin = $flight->bin;
                    $departure->save();
                }
            }
            // Increment the allocation
            switch ($type) {
                case 'allocation':
                    if (intval($flight->allocated) < intval($flight->packs)) {
                        $flight->allocated = $flight->allocated + 1;
                        $flight->save();
                        $type = 'allocated';
                    }
                    break;
                case 'deallocation':
                    if ($flight->allocated > 0) {
                        $flight->allocated = $flight->allocated - 1;
                        $flight->save();
                        $type = 'deallocated';
                    }
                    break;
            }
            $return_arr = [
                'flights' => Flight::where('job_id', $job)->get(),
                'message' => 'Lot ' . $type,
            ];
            return $return_arr;
        }
            $return_arr = [
                'flights' => Flight::where('job_id', $job)->get(),
                'message' => 'Lot not found',
            ];
            return $return_arr;
    }
}
