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
        $send=Send::all();
        //$send= Send::join('users', 'sends.sender_id', '=','users.id' )
        //->join('users AS agent', 'sends.user_id', '=','agent.id' )
        //->select(['agent.first_name as agent_fname','agent.last_name','agent.email','agent.mobile_number','users.first_name','users.last_name','users.mobile_number','users.email as sender_email', 'sends.user_id','sends.bank_account','sends.charges','sends.amount_foregn_currency','sends.amount_rw','sends.currency','sends.local_currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status','sends.created_at as created_on','sends.class','sends.description','sends.reception_method']);
        foreach($send as $element){
            $columnChartModel
            ->addColumn($element->class, $element->charges, '#f6ad55');
        }



        return view('livewire.transfer-chart')
            ->with([
                'columnChartModel' => $columnChartModel,

            ]);
    }




}
