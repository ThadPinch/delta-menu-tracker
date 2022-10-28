<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Job;
use App\Models\Flight;

class NewJob extends Controller
{
    public function newUpload(Request $request)
    {
        $validated = $request->validate([
            'csv' => 'required|mimes:csv'
        ]);

        if ($validated) {
            $fileName = $request->file('csv')->getClientOriginalName();
            if (Storage::disk('local')->exists('public/uploads/' . $fileName)) {
                return Inertia::render('NewJob', [
                    'result' => 'That file already exists',
                    'success' => false,
                ]);
            }
            $filePath = $request->file('csv')->storeAs('uploads', $fileName, 'public');
            $file = Storage::disk('local')->get('public/uploads/' . $fileName);
            $data = array_map('str_getcsv', explode("\n", $file));

            Storage::delete('public/uploads/' . $fileName);

            foreach ($data[0] as $key => $value) {
                $data[0][$key] = trim($value);
            }
            array_walk($data, function(&$a) use ($data) {
                $a = array_combine($data[0], $a);
            });
            array_shift($data);

            $return_arr = [];
            foreach($data as $row) {
                $row['Allocated'] = 0;
                array_push($return_arr, $row);
            }

            $name_arr = explode(' - ' , $fileName);
            $prefix_arr = explode('-', $name_arr[0]);
            $prefix = $prefix_arr[2] . '/' . $prefix_arr[1];
            $suffix = explode('.', $name_arr[1])[0];

            $job = new Job();
            $job->name = $prefix . ' - ' . $suffix;
            $job->csvFileName = $fileName;
            $job->save();

            foreach ($return_arr as $row) {
                $flight = new Flight();
                $flight->departure = $row['Departure'];
                $flight->menu_type = $row['Menu Type'];
                $flight->lot_number = $row['Lot Number'];
                $flight->title = $row['Title'];
                $flight->print_quantity = intval(str_replace(',','',$row['Print Qty']));
                $flight->packs = $row['Packs'];
                $flight->flight_number = $row['Flight #'];
                $flight->arrival = $row['Arrival'];
                $flight->shipper = $row['Shipper'];
                $flight->allocated = $row['Allocated'];
                $flight->job_id = $job->id;
                $flight->save();
            }

            return Inertia::render('NewJob', [
                'result' => 'File has been uploaded successfully.',
                'success' => true,
                'file' => $job->name,
            ]);
        } else {
            return Inertia::render('NewJob', [
                'result' => 'File must be a CSV.',
                'success' => false,
            ]);
        }
    }
}
