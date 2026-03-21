<?php
/**
 * Shell component for Dynamic Dashboard.
 * Logic is fetched and injected by DynamicLogicService.
 */
app(\App\Services\DynamicLogicService::class)->evalLoad('App\Livewire\Admin\Dashboard');
