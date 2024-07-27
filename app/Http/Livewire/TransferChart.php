<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Send;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;

class TransferChart extends Component
{

    public $firstRun = true;

    public $showDataLabels = false;

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'onBlockClick' => 'handleOnBlockClick',
    ];

    public function handleOnPointClick($point)
    {
        dd($point);
    }

    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnBlockClick($block)
    {
        dd($block);
    }

    public function render()
    {
        $columnChartModel=(new ColumnChartModel());
       // $send=Send::all();
        $send= Send::join('users', 'sends.sender_id', '=','users.id' )
          ->join('users AS agent', 'sends.user_id', '=','agent.id' )
          ->select(['agent.first_name as agent_fname',DB::raw('SUM(sends.charges) AS TOTAL_CHARGES')])
          ->groupBy('sends.user_id')
          ->get();
        $fee=[];

        foreach($send as $element){
            $columnChartModel
            ->addColumn($element->agent_fname, $element->TOTAL_CHARGES, '#f6ad55');
        }



        return view('livewire.transfer-chart')
            ->with([
                'columnChartModel' => $columnChartModel,

            ]);
    }




}
