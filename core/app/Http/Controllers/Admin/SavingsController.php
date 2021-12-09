<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class SavingsController
{
    public function savingsPending(Request $request)
    {
        $type = $this->getType();
        if ($type === 'autosave')
        {
            $page_title = 'Auto-saving Pending';
        }

        if ($type === 'vaultsave')
        {
            $page_title = 'Vault-saving Pending';
        }

        if ($type === 'targetsave')
        {
            $page_title = 'Target-saving Pending';
        }
        $table = $type.'s';
        $sql = "SELECT * FROM {$table} WHERE status = ?";
        $savings = DB::select($sql, [1]);
        $empty_message = 'No history found.';
        return view('admin.savings.running', compact('page_title', 'empty_message', 'savings', 'type'));
    }

    public function savingsComplete()
    {
        $type = $this->getType();
        if ($type === 'autosave')
        {
            $page_title = 'Auto-saving Complete';
        }

        if ($type === 'vaultsave')
        {
            $page_title = 'Vault-saving Complete';
        }

        if ($type === 'targetsave')
        {
            $page_title = 'Target-saving Complete';
        }
        $table = $type.'s';
        $sql = "SELECT * FROM {$table} WHERE status = ?";
        $savings = DB::select($sql, [3]);
        $empty_message = 'No history found.';
        return view('admin.savings.complete', compact('page_title', 'empty_message', 'savings', 'type'));
    }

    public function savingsCanceled()
    {
        $type = $this->getType();
        if ($type === 'autosave')
        {
            $page_title = 'Auto-saving Canceled';
        }

        if ($type === 'vaultsave')
        {
            $page_title = 'Vault-saving Canceled';
        }

        if ($type === 'targetsave')
        {
            $page_title = 'Target-saving Canceled';
        }
        $table = $type.'s';
        $sql = "SELECT * FROM {$table} WHERE status = ?";
        $savings = DB::select($sql, [2]);
        $empty_message = 'No history found.';
        return view('admin.savings.canceled', compact('page_title', 'empty_message', 'savings', 'type'));
    }

    private function getType():string
    {
        return explode('.', Route::currentRouteName())[2];
    }
}
