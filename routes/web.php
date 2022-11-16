<?php

use App\Http\Controllers\CampaignEventsController;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\StreamsController;
use App\Http\Controllers\TemplateBuilderController;
use App\Http\Livewire\Components\LiveEmailDesignerComponent;
use App\Http\Livewire\ForgotPasswordComponent;
use App\Http\Livewire\LiveCampaignComponent;
use App\Http\Livewire\LiveCampaignConfigureComponent;
use App\Http\Livewire\LiveContractComponent;
use App\Http\Livewire\LiveContractCreateComponent;
use App\Http\Livewire\LiveDashboardComponent;
use App\Http\Livewire\LiveDocusignComponent;
use App\Http\Livewire\LiveEventsComponent;
use App\Http\Livewire\LiveInboxComponent;
use App\Http\Livewire\LiveLeadComponent;
use App\Http\Livewire\LiveLoginComponent;
use App\Http\Livewire\LiveProjectComponent;
use App\Http\Livewire\LiveProjectDetailComponent;
use App\Http\Livewire\LiveSegmentComponent;
use App\Http\Livewire\LiveSettingsComponent;
use App\Http\Livewire\LiveTagComponent;
use App\Http\Livewire\LiveUserComponent;
use App\Models\EmailCampaignEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', LiveLoginComponent::class)->name('login');
Route::get('/forgot/password', ForgotPasswordComponent::class)->name('forgot.password');
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::group(['middleware' => ['auth']], function(){
    Route::get('/', LiveDashboardComponent::class);
    Route::get('/users/{type}', LiveUserComponent::class);
    Route::get('/leads', LiveLeadComponent::class);
    Route::get('/segments', LiveSegmentComponent::class);
    Route::get('/campaigns', LiveCampaignComponent::class);
    Route::get('/campaigns/configure/{campaign}', LiveCampaignConfigureComponent::class);
    Route::get('/tags', LiveTagComponent::class);
    Route::get('/email/design', LiveEmailDesignerComponent::class);
    Route::get('/email/preview', function(Request $request){
        $event = EmailCampaignEvent::findOrFail($request->id);
        $event = json_decode($event->data);
        echo $event->body;
    });
    Route::post('/builder/assets/save', [TemplateBuilderController::class, 'saveAssets']);
    Route::post('/builder/template/save', [TemplateBuilderController::class, 'saveTemplate']);
    Route::get('/builder/template/stream', [TemplateBuilderController::class, 'stream']);

    Route::get('/documents/create', LiveDocusignComponent::class);
    Route::get('/projects', LiveProjectComponent::class);
    Route::get('/projects/{project}', LiveProjectDetailComponent::class);
    Route::get('/inbox', LiveInboxComponent::class);
    Route::get('/stream/attachment/{email}/{index}/{name?}', [StreamsController::class, 'attachment']);

    Route::get('/contracts/{project}', LiveContractComponent::class);
    Route::get('/contracts/create/{project?}', LiveContractCreateComponent::class);
    Route::get('/contract/status/{contract}', [EnvelopeController::class, 'getStatus']);
    Route::get('/contract/status/update/{contract}', [EnvelopeController::class, 'updateStatus']);

    Route::get('/settings', LiveSettingsComponent::class);
    Route::get('/tasks', LiveEventsComponent::class);

    Route::get('/events', [EventsController::class, 'list']);

});
    Route::get('/stream/{path}/{file}', [StreamsController::class, 'projectFiles']);


Route::get('/hash/{hash?}', function($hash = null){
    // return Lead::first();
    return \Hash::make($hash);
});

Route::get('/cron', [CampaignEventsController::class, 'handle']);
