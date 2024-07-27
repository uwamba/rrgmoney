<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Send;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;

class TransferReport extends LivewireDatatable
{
    public $model = Send::class;

    public $firstRun = true;

    public $showDataLabels = false;






    public function builder()
    {
        return Send::query()
        ->latest()
        ->join('users', 'sends.sender_id', '=','users.id' )
        ->join('users AS agent', 'sends.user_id', '=','agent.id' )
        ->select(['agent.first_name','agent.last_name','agent.address as agent_adress','agent.email','agent.mobile_number','users.first_name','users.last_name','users.mobile_number','users.email as sender_email', 'sends.user_id','sends.bank_account','sends.charges','sends.amount_foregn_currency','sends.amount_rw','sends.currency','sends.local_currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status','sends.created_at as created_on','sends.class','sends.description','sends.reception_method']);

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id'),
            DateColumn::name('created_at')
                ->label('Creation Date')
                ->filterable(),
            Column::callback(['agent.first_name', 'agent.last_name'], function ($firstName, $lastName) {
                    return $firstName . ' ' . $lastName;
                })->label('Agent Names')
                ->filterable()
                ->searchable()
                ->group('group1'),
            Column::name('agent.address')
                ->searchable()
                ->filterable()
                ->label('Agent Adress'),
            Column::callback(['users.first_name', 'users.last_name'], function ($firstName, $lastName) {
                    return $firstName . ' ' . $lastName;
                })->label('Receiver Names')
                ->group('group1')
                ->searchable()
                ->hideable(),

            Column::name('names')
                ->searchable()
                ->label('Sender Names'),
            NumberColumn::name('local_currency')
                ::name('amount_foregn_currency')
                ->label('Foreign Amount')
                ->enableSummary(),
            Column::name('currency')
                ->label('Currency'),

            NumberColumn::name('local_currency')
                ::name('amount_local_currency')
                ->label('Local Amount')
                ->enableSummary(),

            Column::name('local_currency')
                ->label('Local Currency'),


            NumberColumn::name('amount_rw')
                ->label('Amount in $')
                ->enableSummary(),
            NumberColumn::name('charges')
                ->label('Commission')
                ->enableSummary(),

        ];
    }
}
