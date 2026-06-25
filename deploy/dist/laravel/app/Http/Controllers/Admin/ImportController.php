<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ImportController extends Controller
{
    public function wordpress()
    {
        return view('admin.import.wordpress');
    }

    public function wordpressApi(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        try {
            set_time_limit(300);

            $params = [
                'method' => 'api',
                '--url' => $request->url
            ];

            if ($request->consumer_key) {
                $params['--consumer_key'] = $request->consumer_key;
            }
            if ($request->consumer_secret) {
                $params['--consumer_secret'] = $request->consumer_secret;
            }
            if ($request->test) {
                $params['--test'] = true;
            }

            Artisan::call('import:wordpress', $params);
            
            $output = Artisan::output();
            
            return redirect()->back()->with('success', $output);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function wordpressCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        try {
            $path = $request->file('csv_file')->store('imports');
            
            $params = [
                'method' => 'csv',
                '--file' => storage_path('app/' . $path)
            ];

            if ($request->test) {
                $params['--test'] = true;
            }

            Artisan::call('import:wordpress', $params);
            
            $output = Artisan::output();
            
            return redirect()->back()->with('success', $output);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function wordpressSql(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_password' => 'required',
            'table_prefix' => 'required'
        ]);

        try {
            set_time_limit(300);

            $params = [
                'method' => 'sql',
                '--db_host' => $request->db_host,
                '--db_name' => $request->db_name,
                '--db_user' => $request->db_user,
                '--db_password' => $request->db_password,
                '--db_prefix' => $request->table_prefix,
            ];

            if ($request->test) {
                $params['--test'] = true;
            }

            Artisan::call('import:wordpress', $params);
            
            $output = Artisan::output();
            
            return redirect()->back()->with('success', $output);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}