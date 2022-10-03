<?php

namespace App\Http\Livewire;

use App\Models\Record;
use Livewire\Component;

class Dashboard extends Component
{

    public $search = '';
    public function render()
    {

        $openedRecords = Record::getSucceedRecords();
        $closedRecords = Record::getClosedRecords();
        return view('livewire.dashboard')->with('opened',$openedRecords)->with('cloesd',$closedRecords);
    }
}
